<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = Media::query();

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->q}%")
                  ->orWhere('alt_text', 'like', "%{$request->q}%")
                  ->orWhere('file_name', 'like', "%{$request->q}%");
            });
        }

        if ($request->filled('folder')) {
            $query->where('folder', $request->folder);
        }

        $mediaItems = $query->latest()->paginate(18)->withQueryString();
        $folders = Media::select('folder')->distinct()->pluck('folder');

        return view('admin.media.index', compact('mediaItems', 'folders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'files.*' => 'required|file|mimes:jpeg,png,jpg,webp,gif,svg,pdf|max:10240',
            'folder' => 'nullable|string|max:50',
        ]);

        $folder = $request->folder ?: 'uploads';
        $uploadedCount = 0;

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $originalName = $file->getClientOriginalName();
                $filename = time() . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs("media/{$folder}", $filename, 'public');

                Media::create([
                    'name' => pathinfo($originalName, PATHINFO_FILENAME),
                    'file_name' => $filename,
                    'file_path' => $path,
                    'file_size' => $file->getSize(),
                    'mime_type' => $file->getClientMimeType(),
                    'folder' => $folder,
                ]);

                $uploadedCount++;
            }
        }

        ActivityLog::record('upload_media', "Mengunggah {$uploadedCount} berkas media");

        return redirect()->back()->with('success', "{$uploadedCount} berkas media berhasil diunggah!");
    }

    public function update(Request $request, Media $medium)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'alt_text' => 'nullable|string|max:255',
            'caption' => 'nullable|string',
        ]);

        $medium->update($validated);

        return redirect()->back()->with('success', 'Informasi media diperbarui.');
    }

    public function destroy(Media $medium)
    {
        $name = $medium->name;
        $medium->delete();

        ActivityLog::record('delete_media', "Menghapus berkas media: {$name}");

        return redirect()->back()->with('success', 'Berkas media berhasil dihapus.');
    }
}
