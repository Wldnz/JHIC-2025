<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $transaction = [
            'total' => count(Transaction::get()),
            'success' => count(Transaction::where('status','=', 'success')->get()),
            'ongoing' => Transaction::where('status','=', 'ongoing')->get(),
            'fail' => count(Transaction::where('status','=', 'fail')->get()),
        ];
        $product = [
            'total' => count(Product::get()),
            'available' => 0,
            'almost-sold-out' => 0,
            'soldout' => 0,
        ];
        $account=[
            'total' => count(User::get()),
        ];
        $activity =[
            'total' => count(Activity::get())
        ];
        return view("admin.dashboard", [
            "title" => "Dashboard | Bina Tata Usaha", 
            "transaction" => $transaction,
            "product" => $product,
            "account" => $account,
            "activity" => $activity
        ]);
    }

    
    public function products(){
        return view('admin.products',[ "title" => "Management Products" ]);
    }

    public function transactions(){ 
        return view("admin.transactions", [ "title" => "Management Transactions" ]);
    }

    public function detailTransaction(Request $request, string $id){
        $transaction = Transaction::where('id', '=', $id)->first()->get();
        return view("admin.detailTransaction", [ "title" => "Detail Trasaction - $id (Edit Mode)", "transaction" => $transaction ]);
    }

    public function accounts(){
        return view("admin.accounts", [ "title" => "Management Accounts" ]);
    }

    public function profile(){
        return view("admin.profile", [ "title" => "Management Profile" ]);
    }
}
