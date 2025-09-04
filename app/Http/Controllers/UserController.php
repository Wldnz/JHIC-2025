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
            $user = Auth::user();
            $role = $user->getAttribute('role');
            if($role == 'siswa') return redirect()->route('dashboard');
            if($role == 'admin' || $role == 'superAdmin') return redirect()->route('admin.dashboard');
        }
        
        return redirect()->back()->withErrors([
            "message" => "Data yang diberikan tidak valid!"
        ])->onlyInput("nis");
    }

    public function logout(Request $request){
        // entah bener atau tidak
        $request->session()->regenerate(true);
        return view("login");
    }


    // Siswa Controller

    public function dashboard(){
        return view("dashboard", ["title" => "Dashboard | Bina Tata Usaha"]);
    }

    // Admin Controller
    public function dashboardAdmin(){
        return view("admin.dashboard", [ "title" => "Dashboard | Bina Tata Usaha" ]);
    }

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