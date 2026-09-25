<?php

namespace App\Http\Controllers;

use App\Models\WorkProgram;
use Illuminate\Http\Request;

class WorkProgramController extends Controller
{
    public function index(Request $request)
    {
        $query = WorkProgram::query();

        if ($request->filled('status') && in_array($request->status, ['rencana', 'berjalan', 'selesai'])) {
            $query->where('status', $request->status);
        }

        $programs = $query->orderBy('status', 'asc')->orderBy('created_at', 'desc')->get();

        $stats = [
            'total' => WorkProgram::count(),
            'berjalan' => WorkProgram::where('status', 'berjalan')->count(),
            'selesai' => WorkProgram::where('status', 'selesai')->count(),
            'rencana' => WorkProgram::where('status', 'rencana')->count(),
        ];

        return view('pages.work-programs', compact('programs', 'stats'));
    }
}
