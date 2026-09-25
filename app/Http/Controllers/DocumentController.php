<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $categories = Document::select('category')->distinct()->pluck('category');

        $query = Document::query();

        if ($request->filled('kategori')) {
            $query->where('category', $request->kategori);
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $documents = $query->orderBy('published_at', 'desc')->paginate(10)->withQueryString();

        return view('pages.documents', compact('documents', 'categories'));
    }

    public function download($slug)
    {
        $document = Document::where('slug', $slug)->firstOrFail();
        $document->increment('downloads_count');

        $filePath = public_path('storage/' . $document->file_path);
        if (file_exists($filePath)) {
            return response()->download($filePath, $document->title . '.pdf');
        }

        return redirect()->back()->with('error', 'Berkas dokumen belum tersedia atau sedang dalam pembaruan.');
    }
}
