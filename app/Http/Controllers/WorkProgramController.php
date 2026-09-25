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

        $counts = WorkProgram::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $stats = [
            'total' => $counts->sum(),
            'berjalan' => $counts->get('berjalan', 0),
            'selesai' => $counts->get('selesai', 0),
            'rencana' => $counts->get('rencana', 0),
        ];

        return view('pages.work-programs', compact('programs', 'stats'));
    }
}
