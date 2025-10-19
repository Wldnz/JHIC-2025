<?php

namespace App\Http\Controllers\Candidate;

use App\AlertType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Candidate\SaveStage1Request;
use App\Http\Requests\Candidate\SaveStage2Request;
use App\Http\Requests\Candidate\SaveStage3Request;
use App\Http\Requests\Candidate\SaveStage4Request;
use App\Http\Requests\Candidate\SaveStage5Request;
use App\Models\Candidate;
use App\Models\CandidateDocument;
use App\Models\CandidateMajor;
use App\Models\CandidatePhase;
use App\Models\Major;
use App\Models\PaymentMethod;
use App\Models\RegistrationDocument;
use App\Models\RegistrationPhase;
use App\Models\RegistrationSource;
use App\Models\Transaction;
use App\Utilities\AlertDataGenerator;
use App\Utilities\StorageUtils;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\SerializableClosure\SerializableClosure;
use Throwable;

class StageController extends Controller
{
    public function stage1()
    {
        $formTransactionCount = Auth::user()->transactions()
            ->where('type', '=', 'form')
            ->where('status', '=', 'settlement')
            ->limit(1)
            ->count();

        $payments = PaymentMethod::query()
            ->where('is_enabled', '=', true)
            ->get();

        $candidate = Candidate::with('candidateMajors')
            ->where('user_id', '=', Auth::user()->id)
            ->first();

        $majors = Major::all();
        $isPaid = $formTransactionCount > 0;

        return view('candidate.stage.stage-1', compact( 'payments', 'majors', 'isPaid', 'candidate'));
    }

    public function saveStage1(SaveStage1Request $request)
    {
        $validated = $request->validated();
        DB::beginTransaction();

        try {
            // Candidate creation logic

            $user = Auth::user();
            $candidate = $user->candidate()->first();

            if (!$candidate) {
                $candidate = Candidate::factory()->create([
                    'nisn' => $validated['nisn'],
                    'user_id' => $user->id,
                    'full_name' => $user->fullname,
                ]);
                if (!$candidate) {
                    throw new Exception("Gagal membuat data calon siswa");
                }
            }

            $majors = Major::find($validated['majors']);
            $candidateMajors = $candidate->candidateMajors()->limit(2)->get();
            $existingCandidateMajorIds = [];

            foreach ($validated['majors'] as $majorId) {
                $major = $majors->find($majorId);
                if (!$major) {
                    throw new Exception("Major dengan ID \"{$majorId}\" tidak ditemukan");
                }

                $candidateMajor = $candidateMajors
                    ->where('major_id', '=', $majorId)
                    ->first();

                if (!$candidateMajor) {
                    $candidateMajor = CandidateMajor::create([
                        'candidate_nisn' => $candidate->nisn,
                        'user_id' => $user->id,
                        'major_id' => $major->id,
                        'major_long_name' => $major->long_name,
                        'major_short_name' => $major->short_name,
                    ]);
                }

                $existingCandidateMajorIds[] = $candidateMajor->id;

                if (!$candidateMajor) {
                    throw new Exception("Gagal membuat data jurusan pilihan calon siswa");
                }
            }

            $candidate->candidateMajors()
                ->whereNotIn('id', $existingCandidateMajorIds)
                ->delete();

            // Validation Transaction logic

            $formTransactionCount = Auth::user()->transactions()
                ->where('type', '=', 'form')
                ->where('status', '=', 'settlement')
                ->limit(1)
                ->count();

            if ($formTransactionCount > 0) {
                DB::commit();
                return redirect()->route('candidate.stage.stage1-saved');
            }

            $paymentMethod = PaymentMethod::query()
                ->where('code_name', '=', $validated['payment_method'])
                ->first();

            if (!$paymentMethod) {
                throw new Exception("Metode pembayaran dengan code \"{$validated['payment_method']}\" tidak ditemukan");
            }

            // Transaction logic

            $snapId = "WEBBIPSB-TRX " . Str::uuid()->toString();
            $transaction = Transaction::create([
                'candidate_nisn' => null,
                'user_id' => $user->id,
                'candidate_full_name' => $user->fullname,
                'user_email' => $user->email,
                'payment_method_id' => $paymentMethod->id,
                'payment_method_display_name' => $paymentMethod->display_name,
                'total_cost' => 252_000,
                'expired_at' => now()->addMinutes(10),
                'status' => 'pending',
                'type' => 'form',
            ]);

            if (!$transaction) {
                throw new Exception("Gagal membuat transaksi");
            }

            $explodedUserName = explode(" ", $user->fullname, 2);
            $mdtResponse = \Midtrans\Snap::createTransaction([
                'payment_method' => $paymentMethod,
                'transaction_details' => [
                    'order_id' => $snapId,
                    // 'gross_amount' => $transaction->total_cost,
                    'gross_amount' => 10,
                ],
                'customer_details' => [
                    'first_name' => $explodedUserName[0],
                    'last_name' => $explodedUserName[1] ?? '',
                    'email' => $user->email,
                    'phone' => $user->phone,
                ],
                'callbacks' => [
                    'finish' => route('candidate.stage.stage1-saved'),
                    'error' => back()->getTargetUrl(),
                ],
            ]);

            $mdtRedirectUrl = $mdtResponse->redirect_url;
            if (!$mdtRedirectUrl) {
                throw new Exception("Redirect url dari midtrans tidak ditemukan");
            }

            $isUpdated = $transaction->update([
                'snap_id' => $snapId,
                'snap_url' => $mdtRedirectUrl
            ]);
            if (!$isUpdated) {
                throw new Exception("Terjadi kesalahan saat mengupdate snap url di transaksi");
            }

            DB::commit();

            return redirect($mdtRedirectUrl);

        } catch (Throwable $th) {
            DB::rollback();
            report($th);
            logger()->error($th);

            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menyimpan data",
                $th->getMessage(),
                $request->session(),
                false,
            );

            return back()->withInput($request->all());

        }
    }

    public function stage1Saved(Request $request)
    {
        return view('candidate.stage.stage-1-saved');
    }

    public function stage2()
    {
        $formTransactionCount = Auth::user()->transactions()
            ->where('type', '=', 'form')
            ->where('status', '=', 'settlement')
            ->count();
        $candidate = Auth::user()->candidate()->first();

        if ($formTransactionCount <= 0 || !$candidate) {
            return redirect()->route('candidate.stage.stage1');
        }

        $formDocument = RegistrationDocument::query()
            ->where('type', '=', 'form')
            ->orderBy('updated_at', 'desc')
            ->first(['download_file_url', 'mime_types', 'name']);

        $isUploud = $candidate->candidateDocuments()
                ->where('type', '=', 'form')
                ->where('name', '=', "Formulir Biodata")
                ->first();
        $isUploud = $isUploud != null;

        return view('candidate.stage.stage-2', compact('formDocument', 'isUploud'));
    }

    public function saveStage2(SaveStage2Request $request)
    {
        $validated = $request->validated();
        $user = Auth::user();

        $formTransactionCount = $user->transactions()
            ->where('type', '=', 'form')
            ->where('status', '=', 'settlement')
            ->count();
        $candidate = Auth::user()->candidate()->first();

        if ($formTransactionCount <= 0 || !$candidate) {
            return redirect()->route('candidate.stage.stage1');
        }

        DB::beginTransaction();

        try {
            $formDocument = $candidate->candidateDocuments()
                ->where('type', '=', 'form')
                ->where('name', '=', "Formulir Biodata")
                ->first();

            if ($formDocument) {
                $isUploaded = StorageUtils::uploadCandidateDocument(
                    $formDocument,
                    $validated['biodata_form']->get(),
                );
                if (!$isUploaded) {
                    throw new Exception("Gagal menyimpan dokumen biodata calon siswa");
                }

                $isUpdated = $formDocument->update([
                    'is_valid' => false,
                ]);
                if (!$isUpdated) {
                    throw new Exception("Gagal memperbarui data dokumen biodata calon siswa");
                }

                DB::commit();
                return redirect()->route('candidate.stage.stage2-saved');
            }

            $formDocument = StorageUtils::uploadNewCandidateDocument(
                $candidate,
                "Formulir Biodata",
                'application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                $validated['biodata_form']->get(),
                false,
                'form',
            );

            if (!$formDocument) {
                throw new Exception("Gagal menyimpan dokumen biodata calon siswa");
            }

            DB::commit();
            return redirect()->route('candidate.stage.stage2-saved');

        } catch (Throwable $th) {
            DB::rollback();
            report($th);
            logger()->error($th);

            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menyimpan data",
                $th->getMessage(),
                $request->session(),
                false,
            );

            return back()->withInput($validated);

        }
    }

    public function stage2Saved(Request $request)
    {
        return view('candidate.stage.stage-2-saved');
    }

    public function stage3()
    {
        $candidate = Auth::user()->candidate()->first();
        $formDocument = $candidate->candidateDocuments()
            ->where('type', '=', 'form')
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$candidate || !$formDocument) {
            return redirect()->route('candidate.stage.stage2');
        }

        $candidatePhase = $candidate->candidatePhase()->first();
        $phases = RegistrationPhase::all();
        $sources = RegistrationSource::all();
        $isSelectedPhase = $candidatePhase != null;

        return view('candidate.stage.stage-3', compact('phases', 'sources', 'isSelectedPhase', 'candidatePhase'));
    }

    public function saveStage3(SaveStage3Request $request)
    {
        // Validation logic

        $validated = $request->validated();

        $candidate = Auth::user()->candidate()->first();
        $formDocument = $candidate->candidateDocuments()
            ->where('type', '=', 'form')
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$candidate || !$formDocument) {
            return redirect()->route('candidate.stage.stage2');
        }

        // Process Logic

        $registrationPhase = RegistrationPhase::find($validated['phase_id']);
        if (!$registrationPhase) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menyimpan data",
                "Gelombang pendaftaran dengan ID \"{$validated['phase_id']}\" tidak ditemukan",
                $request->session()
            );
            return back()->withInput($validated);
        }

        $registrationSource = RegistrationSource::find($validated['registration_source']);
        if (!$registrationPhase) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menyimpan data",
                "Sumber pendaftaran dengan ID \"{$validated['registration_source']}\" tidak ditemukan",
                $request->session()
            );
            return back()->withInput($validated);
        }

        $candidatePhase = CandidatePhase::updateOrCreate([
            'candidate_nisn' => $candidate->nisn,
            'user_id' => Auth::user()->id,
        ], [
            'selected_phase_id' => $registrationPhase->id,
            'selected_phase_name' => $registrationPhase->name,
            'registration_source_id' =>$registrationSource->id,
            'registration_source' => $registrationSource->name,
            'enrolling_reason' => $validated['enrolling_reason'],
        ]);

        if ($candidatePhase) {
            return redirect()->route('candidate.stage.stage3-saved');
        } else {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menyimpan data",
                "Gagal menyimpan data pemilihan gelombang pendaftaran",
                $request->session()
            );
            return back()->withInput($validated);
        }
    }

    public function stage3Saved(Request $request)
    {
        return view('candidate.stage.stage-3-saved');
    }

    public function stage4()
    {
        $formTransactionCount = Auth::user()->transactions()
            ->where('type', '=', 'form')
            ->where('status', '=', 'settlement')
            ->count();
        $candidate = Auth::user()->candidate()->first();
        $candidatePhase = $candidate->candidatePhase()->first();

        if ($formTransactionCount <= 0 || !$candidate || !$candidatePhase) {
            return redirect()->route('candidate.stage.stage3');
        }

        $usmTransactionCount = Auth::user()->transactions()
            ->where('type', '=', 'usm')
            ->where('status', '=', 'settlement')
            ->count();

        $isPaid = $usmTransactionCount > 0;
        $payments = PaymentMethod::where('is_enabled', '=', '1')->get();

        return view('candidate.stage.stage-4', compact( 'payments','isPaid'));
    }

    public function saveStage4(SaveStage4Request $request)
    {
        // Validation Logic

        $validated = $request->validated();

        $formTransactionCount = Auth::user()->transactions()
            ->where('type', '=', 'form')
            ->where('status', '=', 'settlement')
            ->count();
        $candidate = Auth::user()->candidate()->first();
        $candidatePhase = $candidate->candidatePhase()->first();

        if ($formTransactionCount <= 0 || !$candidate || !$candidatePhase) {
            return redirect()->route('candidate.stage.stage3');
        }

        $usmTransactionCount = Auth::user()->transactions()
            ->where('type', '=', 'usm')
            ->where('status', '=', 'settlement')
            ->count();

        if ($usmTransactionCount > 0) {
            return redirect()->route('candidate.stage.stage5');
        }

        // Process Logic

        DB::beginTransaction();

        try {
            $paymentMethod = PaymentMethod::query()
                ->where('code_name', '=', $validated['payment_method'])
                ->first();

            if (!$paymentMethod) {
                throw new Exception("Metode pembayaran dengan code \"{$validated['payment_method']}\" tidak ditemukan");
            }

            $user = Auth::user();
            $snapId = "WEBBIPSB-TRX " . Str::uuid()->toString();
            $transaction = Transaction::create([
                'candidate_nisn' => null,
                'user_id' => $user->id,
                'candidate_full_name' => $user->fullname,
                'user_email' => $user->email,
                'payment_method_id' => $paymentMethod->id,
                'payment_method_display_name' => $paymentMethod->display_name,
                'total_cost' => 5_032_000,
                'expired_at' => now()->addMinutes(10),
                'status' => 'pending',
                'type' => 'usm',
            ]);

            if (!$transaction) {
                throw new Exception("Gagal membuat transaksi");
            }

            $explodedUserName = explode(" ", $user->fullname, 2);
            $mdtResponse = \Midtrans\Snap::createTransaction([
                'payment_method' => $paymentMethod,
                'transaction_details' => [
                    'order_id' => $snapId,
                    // 'gross_amount' => $transaction->total_cost,
                    'gross_amount' => 10,
                ],
                'customer_details' => [
                    'first_name' => $explodedUserName[0],
                    'last_name' => $explodedUserName[1] ?? '',
                    'email' => $user->email,
                    'phone' => $user->phone,
                ],
                'callbacks' => [
                    'finish' => route('candidate.stage.stage4-saved'),
                    'error' => back()->getTargetUrl(),
                ],
            ]);

            $mdtRedirectUrl = $mdtResponse->redirect_url;
            if (!$mdtRedirectUrl) {
                throw new Exception("Redirect url dari midtrans tidak ditemukan");
            }

            $isUpdated = $transaction->update([
                'snap_id' => $snapId,
                'snap_url' => $mdtRedirectUrl
            ]);
            if (!$isUpdated) {
                throw new Exception("Terjadi kesalahan saat mengupdate snap url di transaksi");
            }

            DB::commit();

            return redirect($mdtRedirectUrl);

        } catch (Throwable $th) {
            DB::rollback();
            report($th);
            logger()->error($th);

            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menyimpan data",
                $th->getMessage(),
                $request->session(),
                false,
            );

            return back()->withInput($validated);

        }
    }

    public function stage4Saved()
    {
        return view('candidate.stage.stage-4-saved');
    }

    public function stage5()
    {
        $requiredTransactionCount = Auth::user()->transactions()
            ->whereIn('type', ['form', 'usm'])
            ->where('status', '=', 'settlement')
            ->limit(2)
            ->count();
        $candidate = Auth::user()->candidate()->first();
        $candidatePhase = $candidate->candidatePhase()->first();

        if ($requiredTransactionCount < 2 || !$candidate || !$candidatePhase) {
            return redirect()->route('candidate.stage.stage4');
        }

        $candidateDocuments = $candidate->candidateDocuments()
            ->where('type', '=', 'usm')
            ->get();
        $registrationDocuments = RegistrationDocument::query()
            ->where('type', '=', 'usm')
            ->get();
        $candidateDocumentNames = $candidateDocuments
            ->pluck('name')
            ->toArray();

        $isAllUplouds = true;

        foreach ($registrationDocuments as $registrationDocument) {
            if (in_array($registrationDocument->name, $candidateDocumentNames)) {
                continue;
            }
            $isAllUplouds = false;
            break;
        }

        $documents = $registrationDocuments;
        $candidateDocuments = $candidateDocuments->toArray();

        return view('candidate.stage.stage-5', compact('documents', 'isAllUplouds', 'candidateDocuments'));
    }

    public function saveStage5(SaveStage5Request $request)
    {
        // Validation Logic

        $validated = $request->validated();

        $requiredTransactionCount = Auth::user()->transactions()
            ->where('type', '=', 'form')
            ->orWhere('type', '=', 'usm')
            ->where('status', '=', 'settlement')
            ->limit(2)
            ->count();
        $candidate = Auth::user()->candidate()->first();
        $candidatePhase = $candidate->candidatePhase()->first();

        if ($requiredTransactionCount < 2 || !$candidate || !$candidatePhase) {
            return redirect()->route('candidate.stage.stage4');
        }

        // Process Logic

        $uploadsFolderPath = "uploads/candidate-documents/{$candidate->nisn}";
        $candidateDocumentPaths = [];

        foreach ($request->allFiles() as $fileKey => $fileValue) {
            $uploadedPath = $fileValue->store($uploadsFolderPath);
            $candidateDocumentPaths[$fileKey] = $uploadedPath;
        }

        $registrationDocuments = RegistrationDocument::query()
            ->where('type', '=', 'usm')
            ->get();

        Queue::push(new SerializableClosure(function () use (
            $registrationDocuments,
            $candidate,
            $candidateDocumentPaths,
        ) {
            $candidateDocumentIdsToResetValid = [];

            foreach ($registrationDocuments as $registrationDocument) {
                if (!array_key_exists($registrationDocument->id, $candidateDocumentPaths)) {
                    continue;
                }

                $candidateDocument = CandidateDocument::query()
                    ->where('candidate_nisn', '=', $candidate->nisn)
                    ->where('name', '=', $registrationDocument->name)
                    ->where('type', '=', 'usm')
                    ->first();

                if ($candidateDocument) {
                    $isUpdated = StorageUtils::uploadCandidateDocument(
                        $candidateDocument,
                        Storage::disk('local')->get($candidateDocumentPaths[$registrationDocument->id])
                    );
                    if (!$isUpdated) {
                        throw new Exception("Gagal menyimpan data file \"{$registrationDocument->name}\"");
                    }

                    $candidateDocumentIdsToResetValid[] = $candidateDocument->id;
                    continue;
                }

                $candidateDocument = StorageUtils::uploadNewCandidateDocument(
                    $candidate,
                    $registrationDocument->name,
                    $registrationDocument->mime_types,
                    Storage::disk('local')->get($candidateDocumentPaths[$registrationDocument->id]),
                    false,
                    'usm',
                );
                if (!$candidateDocument) {
                    throw new Exception("Gagal menyimpan data file \"{$registrationDocument->name}\"");
                }

                $isUploaded = StorageUtils::uploadCandidateDocument(
                    $candidateDocument,
                    Storage::disk('local')->get($candidateDocumentPaths[$registrationDocument->id])
                );
                if (!$isUploaded) {
                    throw new Exception("Gagal menyimpan data file \"{$registrationDocument->name}\"");
                }
            }

            if ($candidateDocumentIdsToResetValid && count($candidateDocumentIdsToResetValid) > 0) {
                CandidateDocument::query()
                    ->where('candidate_nisn', '=', $candidate->nisn)
                    ->whereIn('id', $candidateDocumentIdsToResetValid)
                    ->update(['is_valid' => false]);
            }

            Storage::disk('local')->deleteDirectory("uploads/candidate-documents/{$candidate->nisn}");
        }));

        AlertDataGenerator::generateAsFlashToSession(
            AlertType::INFO,
            "Silahkan menunggu",
            "Data Anda sedang diproses. Silahkan refresh setiap 30 - 60 detik untuk mengecek apakah dokumen-dokumen Anda sudah terupload.",
            $request->session(),
        );

        return back()->withInput($validated);
    }

    public function stage5Saved(Request $request)
    {
        return view('candidate.stage.stage-5-saved');
    }
}
