<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExtracurricularsController extends Controller
{
    public function index()
    {
        return view('user.extracurriculars.index');
    }

    public function merpatiPutih()
    {
        return view('user.extracurriculars.merpati-putih');
    }

    public function futsal()
    {
        return view('user.extracurriculars.futsal');
    }

    public function basketball()
    {
        return view('user.extracurriculars.basketball');
    }

    public function paduanSuara()
    {
        return view('user.extracurriculars.paduan-suara');
    }

    public function bicoustic()
    {
        return view('user.extracurriculars.bicoustic');
    }

    public function tariTradisional()
    {
        return view('user.extracurriculars.tari-tradisional');
    }

    public function biChannel()
    {
        return view('user.extracurriculars.bi-channel');
    }

    public function englishClub()
    {
        return view('user.extracurriculars.english-club');
    }

    public function paskibra()
    {
        return view('user.extracurriculars.paskibra');
    }
}
