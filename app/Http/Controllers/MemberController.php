<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::with('position')
            ->where('is_active', true)
            ->orderBy('order', 'asc')
            ->get();

        return view('pages.members', compact('members'));
    }
}
