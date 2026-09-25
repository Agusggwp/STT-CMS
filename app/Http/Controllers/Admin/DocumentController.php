<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::query();

        if ($request->filled('q')) {
            $query->where('title', 'like', "%{$request->q}%");
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $documents = $query->latest('published_at')->paginate(10)->withQueryString();

        return view('admin.documents.index', compact('documents'));
    }

    public function create()
    {
        return view('admin.documents.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'document_file' => 'required_without:file_path|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'file_path' => 'nullable|string',
            'published_at' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        $validated['published_at'] = $validated['published_at'] ?? now();

        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $size = $file->getSize();
            $path = $file->store('documents', 'public');
            $validated['file_path'] = $path;

            // Format size
            if ($size >= 1048576) {
                $validated['file_size'] = number_format($size / 1048576, 1) . ' MB';
            } else {
                $validated['file_size'] = number_format($size / 1024, 0) . ' KB';
            }
        }

        $doc = Document::create($validated);

        ActivityLog::record('create_document', "Mengunggah dokumen: {$doc->title}", $doc);

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil diunggah!');
    }

    public function edit(Document $document)
    {
        return view('admin.documents.edit', compact('document'));
    }

    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'document_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $size = $file->getSize();
            $path = $file->store('documents', 'public');
            $validated['file_path'] = $path;

            if ($size >= 1048576) {
                $validated['file_size'] = number_format($size / 1048576, 1) . ' MB';
            } else {
                $validated['file_size'] = number_format($size / 1024, 0) . ' KB';
            }
        }

        $document->update($validated);

        ActivityLog::record('update_document', "Memperbarui dokumen: {$document->title}", $document);

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil diperbarui!');
    }

    public function destroy(Document $document)
    {
        $title = $document->title;
        $document->delete();

        ActivityLog::record('delete_document', "Menghapus dokumen: {$title}");

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}
