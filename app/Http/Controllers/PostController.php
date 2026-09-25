<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $categories = PostCategory::withCount(['posts' => fn($q) => $q->published()])->get();

        $query = Post::with('category')->published();

        if ($request->filled('kategori')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->kategori));
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('summary', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $featuredPost = Post::published()->where('is_featured', true)->latest('published_at')->first();

        $posts = $query->orderBy('published_at', 'desc')->paginate(6)->withQueryString();

        return view('pages.posts.index', compact('posts', 'categories', 'featuredPost'));
    }

    public function show($slug)
    {
        $post = Post::with(['category', 'user'])->where('slug', $slug)->published()->firstOrFail();

        // Increment view count safely
        $post->increment('views_count');

        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->take(3)
            ->get();

        return view('pages.posts.show', compact('post', 'relatedPosts'));
    }
}
