<?php

namespace App\Http\Controllers\Admin;

use App\AlertType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAccountRequest;
use App\Http\Requests\Admin\UpdateAccountRequest;
use App\Models\Article;
use App\Models\Candidate;
use App\Models\CandidateDocument;
use App\Models\Major;
use App\Models\RegistrationDocument;
use App\Models\RegistrationPhase;
use App\Models\RegistrationSource;
use App\Models\User;
use App\Utilities\AlertDataGenerator;
use App\Utilities\StorageUtils;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;
use Yaza\LaravelGoogleDriveStorage\Gdrive;

class AccountController extends Controller
{
    protected $maxPage = 10;
    public function accounts(Request $request)
    {

        $search = $request->get('search', '');
        $search_role = $request->get('search_role', 'candidate');
        $page =  $request->get('page', 1);

        $initiliazeAccounts = User::all();

        $stats = [
            'total' => $initiliazeAccounts->count(),
            'candidate' => $initiliazeAccounts->where('role', '=','candidate')->count(),
            'article Creator' => $initiliazeAccounts->where('role', '=','article_creator')->count(),
            'admin' => $initiliazeAccounts->where('role', '=','admin')->count(),
            'owner' => $initiliazeAccounts->where('role', '=','super_admin')->count(),
        ];

        $accounts = User::query()
            ->select(['id', 'fullname', 'email', 'phone', 'role', 'created_at']);

        if ($search) {
            $accounts = $accounts
                ->where('fullname', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('phone', 'like', "%$search%");
        }

        if ($search_role) {
            $accounts = $accounts->where('role', '=', $search_role);
        }

        $total = $accounts->get()->count();
        $accounts = $accounts->limit($this->maxPage)
        ->offset(($page - 1) * $this->maxPage)
            ->get();

        return view('admin.accounts.index', compact('accounts','stats', 'search', 'search_role', 'page', 'total'));
    }

    public function createAccount()
    {
        $availableCitizenships = UpdateAccountRequest::$availableCitizenships;
        $availableReligions = UpdateAccountRequest::$availableReligions;
        $availableStatusFamilies = UpdateAccountRequest::$availableStatusFamilies;

        return view('admin.accounts.create', compact('availableCitizenships', 'availableReligions', 'availableStatusFamilies'));
    }

    public function storeAccount(StoreAccountRequest $request)
    {
        $validated = $request->validated();
        $password = fake()->password(8, 20);
        $account = User::create([
            'fullname' => $validated['fullname'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => $validated['role'],
            'password' => Hash::make($password),
            'remember_token' => Str::random(10),
        ]);

        if ($account) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::SUCCESS,
                "Berhasil membuat akun",
                "Berhasil membuat akun dengan nama lengkap {$validated['fullname']} dan email {$validated['email']}",
                $request->session()
            );
            return redirect()->route('admin.accounts');
        } else {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal membuat akun",
                "Gagal membuat akun dengan nama lengkap {$validated['fullname']} dan email {$validated['email']}",
                $request->session()
            );
            return back()->withInput($validated);
        }
    }

    public function detailAccount(User $account)
    {
        $candidate = null;
        $majors = null;
        $phases = null;
        $articles = null;
        $sources = null;
        $documents = null;
        if($account->role == 'candidate'){
            $candidate = Candidate::query()
            ->with([
                'candidatePhase',
                'registrationPhase',
                'registrationSource',
                'candidateMajors',
                'candidateGuardian',
                'candidateDocuments',
                'transactions'
            ])
            ->where('user_id', '=', $account->id)
            ->first();
            $majors = Major::all();
            $phases = RegistrationPhase::all();
            $sources = RegistrationSource::all(['id', 'name']);
            $documents = RegistrationDocument::all();
        }else if($account->role == 'article_creator'){
            $articles = Article::all()
            ->where('writter_user_id', '=', $account->id);
        }
        return view('admin.accounts.detail', compact('account', 'candidate', 'majors', 'phases', 'articles','sources', 'documents'));
    }

    public function downloadDocument(User $account, CandidateDocument $candidateDocument)
    {
        if ($candidateDocument->candidate->user_id != $account->id) {
            return response('', 200)
                ->header('Content-Type', 'application/octet-stream')
                ->header('Content-Disposition', 'attachment; filename="none"');
        }

        $data = StorageUtils::getCandidateDocument($candidateDocument);
        return response($data->file, 200, [
            'Content-Type' => $data->ext,
            'Content-Disposition' => "attachment; filename=\"{$data->filename}\""
        ]);
    }

    public function updateAccount(UpdateAccountRequest $request, User $account)
    {
        $validated = $request->validated();
        DB::beginTransaction();

        try {
            $isUpdated = $account->update([
                'fullname' => $validated['fullname'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'role' => $validated['role'],
            ]);

            if (!$isUpdated) {
                throw new Exception("Gagal mengupdate akun dengan nama lengkap \"{$account->fullname}\" dan email \"{$account->email}\"");
            }

            if ($validated['role'] != 'candidate' && $validated['role'] != 'student') {
                DB::commit();

                AlertDataGenerator::generateAsFlashToSession(
                    AlertType::SUCCESS,
                    "Berhasil mengupdate akun",
                    "Berhasil mengupdate akun dengan nama lengkap \"{$account->fullname}\" dan email \"{$account->email}\"",
                    $request->session()
                );
                return redirect()->route('admin.accounts');
            }

            $validated['role'] = 'candidate';
            $candidate = Candidate::find($validated['candidate_nisn']);

            if (!$candidate) {
                throw new Exception("Calon siswa dengan NISN \"{$validated['candidate_nisn']}\" tidak ditemukan");
            }

            $isUpdated = $candidate->update([
                'full_name' => $validated['fullname'],
                'short_name' => $validated['candidate_short_name'],
                'birthdate' => $validated['candidate_birth_date'],
                'birthplace' => $validated['candidate_birth_place'],
                'gender' => $validated['gender'],
                'citizenship' => $validated['citizenship'],
                'religion' => $validated['religion'],
                'address' => $validated['address'],
                'status_family' => $validated['status_family'],
                'order_family' => $validated['order_family'],
                'sum_siblings' => $validated['sum_siblings'],
                'sum_half_siblings' => $validated['sum_half_siblings'],
                'sum_adopted_siblings' => $validated['sum_adopted_siblings'],
                'phone' => $validated['phone'],
                'origin_school' => $validated['origin_school'],
                'origin_school_address' => $validated['origin_school_address'],
            ]);
            if (!$isUpdated) {
                throw new Exception("Gagal mengupdate data calon siswa");
            }

            $registrationSource = RegistrationSource::find($validated['registration_source']);
            if (!$registrationSource) {
                throw new Exception("Data asal pendaftaran tidak ditemukan");
            }

            $registrationPhase = RegistrationPhase::find($validated['phase']['id']);
            if (!$registrationPhase) {
                throw new Exception("Data gelombang pendaftaran tidak ditemukan");
            }

            $isUpdated = $candidate->candidatePhase->update([
                'selected_phase_id' => $registrationPhase->id,
                'selected_phase_name' => $registrationPhase->name,
                'registration_source_id' => $registrationSource->id,
                'registration_source' => $registrationSource->name,
                'enrolling_reason' => $validated['enrolling_reason'],
            ]);
            if (!$isUpdated) {
                throw new Exception("Gagal mengupdate data pilihan gelombang calon siswa");
            }

            $isUpdated = $candidate->candidateGuardian->update([
                'full_name' => $validated['candidate_guardian_name'],
                'birthdate' => $validated['candidate_guardian_birthdate'],
                'birthplace' => $validated['candidate_guardian_birthplace'],
                'education' => $validated['candidate_guardian_education'],
                'job' => $validated['candidate_guardian_job'],
                'monthly_income' => $validated['candidate_guardian_monthly_income'],
                'citizenship' => $validated['candidate_guardian_citizenship'],
                'religion' => $validated['candidate_guardian_religion'],
                'city' => $validated['candidate_guardian_city'],
                'district' => $validated['candidate_guardian_district'],
                'sub_district' => $validated['candidate_guardian_sub_district'],
                'rt_rw' => $validated['candidate_guardian_rt_rw'],
                'postal_code' => $validated['candidate_guardian_postal_code'],
                'address' => $validated['candidate_guardian_address'],
                'office_phone_number' => $validated['candidate_guardian_office_phone_number'],
                'home_phone_number' => $validated['candidate_guardian_home_phone_number'],
                'phone_number' => $validated['candidate_guardian_phone_number'],
            ]);
            if (!$isUpdated) {
                throw new Exception("Gagal mengupdate data pilihan gelombang calon siswa");
            }

            $candidateDocuments = CandidateDocument::query()
                ->where('candidate_nisn', $validated['candidate_nisn'])
                ->whereIn('id', array_keys($validated['documents']))
                ->get();

            foreach ($candidateDocuments as $candidateDocument) {
                $documentData = $request->validate([
                    "documents.{$candidateDocument->id}.file" => ["mimetypes:{$candidateDocument->mime_types}"]
                ]);
                StorageUtils::uploadCandidateDocument(
                    $candidateDocument,
                    $documentData['documents'][$candidateDocument->id]['file']->get()
                );
            }

            DB::commit();

            AlertDataGenerator::generateAsFlashToSession(
                AlertType::SUCCESS,
                "Berhasil mengupdate akun",
                "Berhasil mengupdate akun calon siswa dengan nama lengkap \"{$account->fullname}\" dan email \"{$account->email}\"",
                $request->session()
            );
            return redirect()->route('admin.accounts');

        } catch (Throwable $th) {
            DB::rollBack();

            logger()->error($th);
            report($th);

            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal mengupdate akun",
                $th->getMessage(),
                $request->session(),
            );

            return back()->withInput($request->all());
        }
    }

    public function deleteAccount(Request $request, User $account)
    {
        $isDeleted = $account->delete();

        if ($isDeleted) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::SUCCESS,
                "Berhasil menghapus akun",
                "Berhasil menghapus akun calon siswa dengan nama lengkap \"{$account->fullname}\" dan email \"{$account->email}\"",
                $request->session(),
            );
        } else {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menghapus akun",
                "Gagal menghapus akun calon siswa dengan nama lengkap \"{$account->fullname}\" dan email \"{$account->email}\"",
                $request->session(),
            );
        }

        return back();
    }

    public function resetPassword(User $account){
        return back();
    }
}
