<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\OrganizationalPosition;
use Illuminate\Http\Request;

class StructureController extends Controller
{
    public function index()
    {
        $positions = OrganizationalPosition::with(['members' => function ($q) {
            $q->where('is_active', true)->orderBy('order', 'asc');
        }])
            ->orderBy('level', 'asc')
            ->orderBy('order', 'asc')
            ->get();

        $ketua = Member::whereHas('position', fn($q) => $q->where('code', 'KETUA'))->first();
        $wakil = Member::whereHas('position', fn($q) => $q->where('code', 'WAKIL_KETUA'))->first();
        $sekretaris = Member::whereHas('position', fn($q) => $q->where('code', 'SEKRETARIS'))->first();
        $bendahara = Member::whereHas('position', fn($q) => $q->where('code', 'BENDAHARA'))->first();
        $koordinators = Member::whereHas('position', fn($q) => $q->where('level', 3))->orderBy('order', 'asc')->get();

        return view('pages.structure', compact('positions', 'ketua', 'wakil', 'sekretaris', 'bendahara', 'koordinators'));
    }
}
