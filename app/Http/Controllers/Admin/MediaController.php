<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function media()
    {
        return view('admin.media.index');
    }

    public function createMedia()
    {
        return view('admin.media.create');
    }

    public function storeMedia(Request $request)
    {
        return back();
    }

    public function detailMedia($media)
    {
        return view('admin.media.detail', compact('media'));
    }

    public function updateMedia(Request $request, $media)
    {
        return back();
    }

    public function deleteMedia($media)
    {
        return back();
    }
}
