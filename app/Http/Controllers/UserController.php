<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function loginPage(Request $request){
       return view('login');
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'nis' => ['required'],
            'password' => ['required']
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }
        
        return redirect()->back()->withErrors([
            "message" => "Data yang diberikan tidak valid!"
        ])->onlyInput("nis");
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect()->route('login');
    }


    // Siswa Controller

    public function dashboard(){
        return view("dashboard", ["title" => "Dashboard | Bina Tata Usaha"]);
    }
    
    // Admin Controller

    public function managementProduct(){

    }

    public function managementProductDetail(){
        
    }

    public function managementProductAdd(){

    }

    public function managementTransaction(){

    }

    public function managementTransactionDetail(){
        
    }

    public function managementTransactionAdd(){

    }

    public function managementAccountPage(){

    }

    public function managementAccountEdit(){

    }

    public function managementAccountAdd(){

    }
   
}