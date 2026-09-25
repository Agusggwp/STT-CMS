<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\OrganizationalPosition;
use Illuminate\Http\Request;

class StructureController extends Controller
{
    public function index()
    {
        $positions = OrganizationalPosition::orderBy('level', 'asc')
            ->orderBy('order', 'asc')
            ->get();

        $members = Member::with('position')
            ->where('is_active', true)
            ->orderBy('order', 'asc')
            ->get();

        $ketua = $members->first(fn($m) => $m->position?->code === 'KETUA');
        $wakil = $members->first(fn($m) => $m->position?->code === 'WAKIL_KETUA');
        $sekretaris = $members->first(fn($m) => $m->position?->code === 'SEKRETARIS');
        $bendahara = $members->first(fn($m) => $m->position?->code === 'BENDAHARA');
        $koordinators = $members->filter(fn($m) => $m->position?->level === 3);

        return view('pages.structure', compact('positions', 'ketua', 'wakil', 'sekretaris', 'bendahara', 'koordinators'));
    }
}
