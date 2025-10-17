<?php

namespace App\Http\Controllers\Admin;

use App\AlertType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAccountRequest;
use App\Http\Requests\Admin\UpdateAccountRequest;
use App\Mail\SendAccountResetPassword;
use App\Mail\SendNewAccountPassword;
use App\Models\Article;
use App\Models\Candidate;
use App\Models\CandidateDocument;
use App\Models\CandidateMajor;
use App\Models\Major;
use App\Models\RegistrationDocument;
use App\Models\RegistrationPhase;
use App\Models\RegistrationSource;
use App\Models\User;
use App\Utilities\AlertDataGenerator;
use App\Utilities\FileUploadUtils;
use App\Utilities\RoleLevelChecker;
use App\Utilities\StorageUtils;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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

        $accountStats = User::query()
            ->selectRaw("COUNT(*) AS total")
            ->selectRaw("COUNT(CASE WHEN role = 'candidate' THEN 1 END) AS candidate")
            ->selectRaw("COUNT(CASE WHEN role = 'article_creator' THEN 1 END) AS article_creator")
            ->selectRaw("COUNT(CASE WHEN role = 'admin' THEN 1 END) AS admin")
            ->selectRaw("COUNT(CASE WHEN role = 'super_admin' THEN 1 END) AS super_admin")
            ->first();

        $stats = [
            'total' => $accountStats->total,
            'candidate' => $accountStats->candidate,
            'article Creator' => $accountStats->article_creator,
            'admin' => $accountStats->admin,
            'owner' => $accountStats->super_admin,
        ];

        $accounts = User::query();

        if ($search) {
            $accounts = $accounts
                ->where('fullname', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('phone', 'like', "%$search%");
        }

        if ($search_role) {
            $accounts = $accounts->where('role', '=', $search_role);
        }

        $total = $accounts->count();
        $accounts = $accounts->limit($this->maxPage)
            ->offset(($page - 1) * $this->maxPage)
            ->get(['id', 'fullname', 'email', 'phone', 'role', 'created_at']);

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
        DB::beginTransaction();

        try {
            $account = User::create([
                'fullname' => $validated['fullname'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'role' => $validated['role'],
            ]);
            if (!$account) {
                throw new Exception("Gagal membuat akun dengan nama lengkap \"{$validated['fullname']}\" dan email \"{$validated['email']}\"");
            }

            $password = fake()->password(24, 32);

            $account->email_verified_at = now();
            $account->password = Hash::make($password);
            $account->remember_token = Str::random(10);

            $isUpdated = $account->save();
            if (!$isUpdated) {
                throw new Exception("Gagal membuat akun dengan nama lengkap \"{$validated['fullname']}\" dan email \"{$validated['email']}\" (Gagal saat update data)");
            }

            DB::commit();

            AlertDataGenerator::generateAsFlashToSession(
                AlertType::SUCCESS,
                "Berhasil membuat akun",
                "Berhasil membuat akun dengan nama lengkap \"{$validated['fullname']}\" dan email \"{$validated['email']}\"",
                $request->session()
            );

            Mail::to($account)
                ->queue(new SendNewAccountPassword(
                    $account,
                    $password
                ));

            return redirect()->route('admin.accounts');

        } catch (Throwable $th) {
            DB::rollBack();

            logger()->error($th);
            report($th);

            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal membuat akun",
                $th->getMessage(),
                $request->session()
            );

            return back()->withInput($validated);
        }
    }

    public function detailAccount(User $account)
    {
        if (
            $account->id != Auth::user()->id &&
            (
                !RoleLevelChecker::checkMinimumByRoleName(Auth::user(), 'admin') ||
                $account->role == 'super_admin'
            )
        ) {
            return redirect()->route(Auth::user()->role == 'article_creator' ? 'admin.dashboard' : 'admin.accounts');
        }

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
            $validated['role'] ??= null;
            $updatedData = [
                'fullname' => $validated['fullname'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'role' => $validated['role'] ?? Auth::user()->role,
            ];
            $isUpdated = $account->update($updatedData);

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
                return Auth::user()->id == $account->id ?
                    back() :
                    redirect()->route('admin.accounts');
            }

            $validated['role'] = 'candidate';
            $validated['candidate_nisn'] ??= null;

            $candidate = Candidate::find($validated['candidate_nisn']);
            $candidate->load([
                'registrationPhase',
                'candidatePhase',
                'candidateMajors',
                'candidateGuardian',
            ]);

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

            $splittedDocumentsData = FileUploadUtils::splitFileUploads($request, 'documents');

            $candidateDocuments = CandidateDocument::query()
                ->where('candidate_nisn', $validated['candidate_nisn'])
                ->get();

            foreach ($candidateDocuments as $candidateDocument) {
                $documentData = $request->validate([
                    "documents.{$candidateDocument->id}.file" => ["mimetypes:{$candidateDocument->mime_types}"],
                ]);
                if ($documentData) {
                    StorageUtils::uploadCandidateDocument(
                        $candidateDocument,
                        $documentData['documents'][$candidateDocument->id]['file']->get()
                    );
                }
                $candidateDocument->update([
                    'is_valid' => $validated['documents'][$candidateDocument->id]['is_valid']
                ]);
            }

            foreach ($splittedDocumentsData->addedFilesData as $newDocumentData) {
                $candidateDocument = StorageUtils::uploadNewCandidateDocument(
                    $candidate,
                    $newDocumentData['name'],
                    $newDocumentData['mime_types'],
                    $newDocumentData['file']->get(),
                    $newDocumentData['is_valid'],
                );

                if (!$candidateDocument) {
                    throw new Exception("Gagal mengupload dokumen ke cloud");
                }
            }

            $keepedCandidateMajorsId = [];
            logger($validated['majors']);
            foreach ($validated['majors'] as $majorData) {
                if (str_starts_with($majorData['id'], 'added_')) {
                    logger($majorData);
                    $major = Major::find($majorData['major_id']);
                    if (!$major) {
                        throw new Exception("Jurusan dengan id \"{$majorData['major_id']}\" tidak ditemukan");
                    }

                    $candidateMajor = CandidateMajor::create([
                        'candidate_nisn' => $candidate->nisn,
                        'user_id' => $candidate->user_id,
                        'major_id' => $major->id,
                        'major_long_name' => $major->long_name,
                        'major_short_name' => $major->short_name,
                    ]);
                    if (!$candidateMajor) {
                        throw new Exception("Gagal membuat data jurusan calon siswa");
                    }

                    $keepedCandidateMajorsId[] = $candidateMajor->id;
                    continue;
                }

                $keepedCandidateMajorsId[] = $majorData['id'];
            }

            $candidate->candidateMajors()
                ->whereNotIn('id', $keepedCandidateMajorsId)
                ->delete();

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

    public function resetPassword(Request $request, User $account)
    {
        $password = fake()->password(24, 32);

        $account->password = Hash::make($password);
        $account->remember_token = Str::random(10);

        $isUpdated = $account->save();
        if (!$isUpdated) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal mereset password",
                "Gagal mengupdate password dari akun",
                $request->session(),
            );
            return back();
        }

        Mail::to($account->email)
            ->queue(new SendAccountResetPassword(
                $account,
                $password
            ));

        AlertDataGenerator::generateAsFlashToSession(
            AlertType::SUCCESS,
            "Berhasil mereset password",
            "Berhasil mereset password akun dan password telah dikirimkan ke email \"{$account->email}\"",
            $request->session(),
        );

        return back();
    }
}
