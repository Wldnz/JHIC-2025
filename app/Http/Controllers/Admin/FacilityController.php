<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class FacilityController extends Controller
{

     protected $maxPage = 10;
    public function facility(Request $request)
    {
        $search = $request->get('search', '');
        $search_status = $request->get('search_status', '');
        $page =  $request->get('page', 1);

        $facilities = Gallery::select();
        $stats = [
            "total" => $facilities->get()->count(),
        ];
        if($search){
            $facilities = $facilities->where('candidate_full_name', '=', $search)
            ->orWhere('candidate_full_name', 'like', '%'.$search.'%');
        }
        if($search_status){
            $facilities = $facilities->where('status', '=', $search_status);
        }
        $total = $facilities->get()->count();
        $facilities = $facilities->limit($this->maxPage)
        ->offset(($page - 1) * $this->maxPage)
            ->get();

        
        return view('admin.facility.index',compact('facilities', 'search', 'search_status', 'page', 'total', 'stats'));
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
