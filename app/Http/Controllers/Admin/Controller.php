<?php

namespace App\Http\Controllers\Admin;

use App\AlertType;
use App\Http\Requests\Admin\UpdateSettingsRequest;
use App\Models\Achievement;
use App\Models\Article;
use App\Models\Candidate;
use App\Models\Gallery;
use App\Models\PaymentMethod;
use App\Models\Portfolio;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\User;
use App\Utilities\AlertDataGenerator;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Controller extends \App\Http\Controllers\Controller
{
    protected $openRegisMonth = 12;
    public function dashboard()
    {
        $registrationMonth = $this->openRegisMonth;
        $initiliazeGallery = Gallery::query();
        $summary =[];
        $stats = [];

        if (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin') {
            $initilializedStats = DB::table(DB::raw('DUAL'))
                // Transactions  Section
                ->selectRaw("(SELECT COUNT(*) FROM transactions) AS transaction_total")
                ->selectRaw("(SELECT COUNT(CASE WHEN status = 'pending' THEN 1 END) FROM transactions) AS transaction_pending")
                ->selectRaw("(SELECT COUNT(CASE WHEN status = 'settlement' THEN 1 END) FROM transactions) AS transaction_success")
                ->selectRaw("(SELECT COUNT(CASE WHEN status = 'failure' THEN 1 END) FROM transactions) AS transaction_failed")
                // Account Section
                ->selectRaw("(SELECT COUNT(*) FROM users) AS account_total")
                ->selectRaw("(SELECT COUNT(CASE WHEN role = 'candidate' THEN 1 END) FROM users) AS account_candidate")
                ->selectRaw("(SELECT COUNT(CASE WHEN role = 'article_creator' THEN 1 END) FROM users) AS account_article_creator")
                ->selectRaw("(SELECT COUNT(CASE WHEN role = 'admin' THEN 1 END) FROM users) AS account_admin")
                // Students Section
                ->selectRaw("(SELECT COUNT(*) FROM students) AS student_total")
                ->selectRaw("(SELECT COUNT(*) FROM achievements) AS achievement_total")
                ->selectRaw("(SELECT COUNT(*) FROM portfolios) AS portfolio_total")
                // Media Section
                ->selectRaw("(SELECT COUNT(*) FROM articles) AS article_total")
                ->selectRaw("(SELECT COUNT(*) FROM galleries) AS facility_total")
                // Get
                ->first();

            $stats = [
                'transaction' => [
                    'total' => $initilializedStats->transaction_total,
                    'Menunggu' => $initilializedStats->transaction_pending,
                    'Berhasil' => $initilializedStats->transaction_success,
                    'Gagal' => $initilializedStats->transaction_failed,
                ],
                'account' => [
                    'total' => $initilializedStats->account_total,
                    'Calon Peserta Didik' => $initilializedStats->account_candidate,
                    'Pembuat Artikel' => $initilializedStats->account_article_creator,
                    'Adminitrasi' => $initilializedStats->account_admin,
                ],
                'student' => [
                    'total' => $initilializedStats->student_total,
                    'total Prestasi' => $initilializedStats->achievement_total,
                    'total Portofolio' => $initilializedStats->portfolio_total,
                ],
                'media' => [
                    'total Artikel' => $initilializedStats->article_total,
                    'total Fasilitas' => $initilializedStats->facility_total,
                ]
            ];

            $summary = [
                'candidates' => Candidate::query()
                    ->whereRaw("created_at BETWEEN MAKEDATE(YEAR(DATE_SUB(NOW(), INTERVAL 12 MONTH)), 1) AND MAKEDATE(YEAR(DATE_SUB(NOW(), INTERVAL 12 MONTH))+1, 1)")
                    ->groupBy("created_at")
                    ->get(['created_at']),
            ];
        }else if(Auth::user()->role == 'article_creator'){
            $initilializedStats = DB::table(DB::raw('DUAL'))
                // Media Section
                ->selectRaw("(SELECT COUNT(*) FROM articles) AS article_total")
                ->selectRaw("(SELECT COUNT(*) FROM galleries) AS facility_total")
                // Get
                ->first();

            $stats = [
                'media' => [
                    'total Artikel' => $initilializedStats->article_total,
                    'total Fasilitas' => $initilializedStats->facility_total,
                ]
            ];
        }

        return view('admin.dashboard', compact('stats', 'summary', 'registrationMonth'));
    }

    public function settings()
    {
        $payments = PaymentMethod::all();
        return view('admin.settings.index', compact('payments'));
    }

    public function updateSettings(UpdateSettingsRequest $request)
    {
        $validated = $request->validated();

        if ($validated["payment_methods"] && count($validated["payment_methods"]) > 0) {
            $bindingMarkers = [];
            $enabledPaymentMethodsCodeName = [];

            foreach ($validated["payment_methods"] as $paymentMethodCodeName => $value) {
                $enabledPaymentMethodsCodeName[] = $paymentMethodCodeName;
                $bindingMarkers[] = "?";
            }

            $bindingMarkersAsString = implode(',', $bindingMarkers);

            PaymentMethod::query()
                ->setBindings($enabledPaymentMethodsCodeName)
                ->update([
                    'is_enabled' => DB::raw("CASE WHEN code_name IN ($bindingMarkersAsString) THEN 1 ELSE 0 END"),
                    'updated_at' => DB::raw("NOW()"),
                ]);
        }

        AlertDataGenerator::generateAsFlashToSession(
            AlertType::SUCCESS,
            "Berhasil mengupdate pengaturan",
            "Berhasil mengupdate pengaturan payment method, dll.",
            $request->session(),
        );

        return back();
    }
}
