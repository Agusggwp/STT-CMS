<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $leaders = Member::where('is_active', true)
            ->whereHas('position', function ($q) {
                $q->whereIn('level', [1, 2]);
            })
            ->orderBy('order', 'asc')
            ->get();

        return view('pages.about', compact('leaders'));
    }
}
