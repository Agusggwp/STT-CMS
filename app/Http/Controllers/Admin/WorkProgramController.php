<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\WorkProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WorkProgramController extends Controller
{
    public function index(Request $request)
    {
        $query = WorkProgram::query();

        if ($request->filled('q')) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $programs = $query->latest()->paginate(10)->withQueryString();

        return view('admin.work-programs.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.work-programs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'objectives' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'pic_name' => 'nullable|string|max:150',
            'status' => 'required|in:rencana,berjalan,selesai',
            'documentation_notes' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(5);

        $program = WorkProgram::create($validated);

        ActivityLog::record('create_program', "Membuat program kerja: {$program->name}", $program);

        return redirect()->route('admin.work-programs.index')->with('success', 'Program kerja berhasil ditambahkan!');
    }

    public function edit(WorkProgram $workProgram)
    {
        return view('admin.work-programs.edit', compact('workProgram'));
    }

    public function update(Request $request, WorkProgram $workProgram)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'objectives' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'pic_name' => 'nullable|string|max:150',
            'status' => 'required|in:rencana,berjalan,selesai',
            'documentation_notes' => 'nullable|string',
        ]);

        $workProgram->update($validated);

        ActivityLog::record('update_program', "Memperbarui program kerja: {$workProgram->name}", $workProgram);

        return redirect()->route('admin.work-programs.index')->with('success', 'Program kerja berhasil diperbarui!');
    }

    public function destroy(WorkProgram $workProgram)
    {
        $name = $workProgram->name;
        $workProgram->delete();

        ActivityLog::record('delete_program', "Menghapus program kerja: {$name}");

        return redirect()->route('admin.work-programs.index')->with('success', 'Program kerja berhasil dihapus.');
    }
}
