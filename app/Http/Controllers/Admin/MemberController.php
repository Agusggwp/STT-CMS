<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Member;
use App\Models\OrganizationalPosition;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::with('position');

        if ($request->filled('q')) {
            $query->where('name', 'like', "%{$request->q}%")
                  ->orWhere('position_title', 'like', "%{$request->q}%");
        }

        $members = $query->orderBy('order', 'asc')->paginate(15)->withQueryString();

        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        $positions = OrganizationalPosition::orderBy('level')->orderBy('order')->get();
        return view('admin.members.create', compact('positions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'position_id' => 'nullable|exists:organizational_positions,id',
            'position_title' => 'required|string|max:150',
            'period' => 'required|string|max:50',
            'photo' => 'nullable|image|max:3072',
            'photo_url' => 'nullable|url',
            'bio' => 'nullable|string',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:100',
            'instagram' => 'nullable|string|max:150',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? (Member::max('order') + 1);

        if ($request->filled('instagram')) {
            $validated['social_links'] = ['instagram' => $request->instagram];
        }

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('members', 'public');
            $validated['photo'] = $path;
        } elseif (!empty($request->photo_url)) {
            $validated['photo'] = $request->photo_url;
        }

        $member = Member::create($validated);

        ActivityLog::record('create_member', "Menambahkan pengurus: {$member->name}", $member);

        return redirect()->route('admin.members.index')->with('success', 'Pengurus berhasil ditambahkan!');
    }

    public function edit(Member $member)
    {
        $positions = OrganizationalPosition::orderBy('level')->orderBy('order')->get();
        return view('admin.members.edit', compact('member', 'positions'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'position_id' => 'nullable|exists:organizational_positions,id',
            'position_title' => 'required|string|max:150',
            'period' => 'required|string|max:50',
            'photo' => 'nullable|image|max:3072',
            'photo_url' => 'nullable|url',
            'bio' => 'nullable|string',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:100',
            'instagram' => 'nullable|string|max:150',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->filled('instagram')) {
            $validated['social_links'] = ['instagram' => $request->instagram];
        }

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('members', 'public');
            $validated['photo'] = $path;
        } elseif (!empty($request->photo_url)) {
            $validated['photo'] = $request->photo_url;
        }

        $member->update($validated);

        ActivityLog::record('update_member', "Memperbarui pengurus: {$member->name}", $member);

        return redirect()->route('admin.members.index')->with('success', 'Data pengurus berhasil diperbarui!');
    }

    public function destroy(Member $member)
    {
        $name = $member->name;
        $member->delete();

        ActivityLog::record('delete_member', "Menghapus pengurus: {$name}");

        return redirect()->route('admin.members.index')->with('success', 'Pengurus berhasil dihapus.');
    }
}
