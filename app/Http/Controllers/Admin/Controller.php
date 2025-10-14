<?php

namespace App\Http\Controllers\Admin;

use App\Models\Achievement;
use App\Models\Article;
use App\Models\Candidate;
use App\Models\Gallery;
use App\Models\PaymentMethod;
use App\Models\Portfolio;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Controller extends \App\Http\Controllers\Controller
{
    protected $openRegisMonth = 12;
    public function dashboard()
    {
        $registrationMonth = $this->openRegisMonth;
        $initiliazeGallery = Gallery::all();
        $summary =[];
        $stats = [];
        
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin') {
            $initiliazeTransactions = Transaction::all();
            $initiliazeAccounts = User::all();
            $initiliazeStudents = Student::all();
            $initiliazeCandidates = Candidate::all();
            $initiliazeAchievements = Achievement::all();
            $initiliazePortfolios = Portfolio::all();
    
            $currentYear = intval(date('Y'));
            $currentMonth = intval(date('m'));
            $registrationYear = [
                'first' => ($currentMonth >= $this->openRegisMonth) ? $currentYear + 1 : $currentYear - 1,
                'second' => ($currentMonth >= $this->openRegisMonth) ? $currentYear + 2 : $currentYear,
            ];
            $stats = [
                'transaction' => [
                    'total' => $initiliazeTransactions->count(),
                    'Menunggu' => $initiliazeTransactions->where('status', '=', 'pending')->count(),
                    'Berhasil' => $initiliazeTransactions->where('status', '=', 'success')->count(),
                    'Gagal' => $initiliazeTransactions->where('status', '=', 'expired')->count(),
                ],
                'account' => [
                    'total' => $initiliazeAccounts->count(),
                    'Calon Peserta Didik' => $initiliazeAccounts->where('role', '=', 'candidate')->count(),
                    'Pembuat Artikel' => $initiliazeAccounts->where('role', '=', 'article_creator')->count(),
                    'Adminitrasi' => $initiliazeAccounts->where('role', '=', 'admin')->count(),
                ],
                'student' => [
                    'total' => $initiliazeStudents->count(),
                    'total Prestasi' => $initiliazeAchievements->count(),
                    'total Portofolio' => $initiliazePortfolios->count(),
                ],
                'media' => [
                    'total Artikel' => Article::all()->count(),
                    'total Fasilitas' => $initiliazeGallery->count(),
                ]
            ];

            $summary = [
                'candidates' => Candidate::where('created_at', 'like', '%' . $registrationYear['first'] . '%')
                    ->orWhere('created_at', 'like', '%' . $registrationYear['second'] . '%')
                    ->select(['created_at'])->groupBy('created_at')->get(),
            ];
        }else if(Auth::user()->role == 'article_creator'){
            $stats = [
                'media' => [
                    'total Artikel' => Article::all()->count(),
                    'total Fasilitas' => $initiliazeGallery->count(),
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

    public function updateSettings(Request $request)
    {
        // handle update logic later
        return back();
    }
}
