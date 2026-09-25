<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Page::with(['sections' => fn($q) => $q->where('is_active', true)->orderBy('order', 'asc')])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('pages.dynamic', compact('page'));
    }
}
