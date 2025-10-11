<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProgramsController extends Controller
{
    public function programSilang()
    {
        return view('user.programs.program-silang');
    }

    public function bacaTulisQuran()
    {
        return view('user.programs.baca-tulis-quran');
    }

    public function bimbinganKonseling()
    {
        return view('user.programs.bimbingan-konseling');
    }

    public function biChannel()
    {
        return view('user.programs.bi-channel');
    }

    public function programKecakapanHidup()
    {
        return view('user.programs.program-kecakapan-hidup');
    }

    public function projectWorks()
    {
        return view('user.programs.project-works');
    }
}
