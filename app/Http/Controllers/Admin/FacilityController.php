<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function facility()
    {
        return view('admin.facility.index');
    }

    public function createFacility()
    {
        return view('admin.facility.create');
    }

    public function storeFacility(Request $request)
    {
        return back();
    }

    public function detailFacility($facility)
    {
        return view('admin.facility.detail', compact('facility'));
    }

    public function updateFacility(Request $request, $facility)
    {
        return back();
    }

    public function deleteFacility($facility)
    {
        return back();
    }
}
