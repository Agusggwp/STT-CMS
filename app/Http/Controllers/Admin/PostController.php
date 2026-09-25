<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('category', 'user');

        if ($request->filled('q')) {
            $query->where('title', 'like', "%{$request->q}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $posts = $query->latest()->paginate(10)->withQueryString();
        $categories = PostCategory::all();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = PostCategory::all();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:post_categories,id',
            'thumbnail' => 'nullable|image|max:3072',
            'thumbnail_url' => 'nullable|url',
            'summary' => 'nullable|string|max:500',
            'content' => 'required|string',
            'author_name' => 'nullable|string|max:100',
            'status' => 'required|in:published,draft',
            'is_featured' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:200',
            'meta_description' => 'nullable|string|max:300',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['published_at'] = $validated['published_at'] ?? now();
        $validated['author_name'] = $validated['author_name'] ?? auth()->user()->name;

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('posts', 'public');
            $validated['thumbnail'] = $path;
        } elseif (!empty($request->thumbnail_url)) {
            $validated['thumbnail'] = $request->thumbnail_url;
        }

        $post = Post::create($validated);

        ActivityLog::record('create_post', "Membuat berita baru: {$post->title}", $post);

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil dipublikasikan!');
    }

    public function edit(Post $post)
    {
        $categories = PostCategory::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:post_categories,id',
            'thumbnail' => 'nullable|image|max:3072',
            'thumbnail_url' => 'nullable|url',
            'summary' => 'nullable|string|max:500',
            'content' => 'required|string',
            'author_name' => 'nullable|string|max:100',
            'status' => 'required|in:published,draft',
            'is_featured' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:200',
            'meta_description' => 'nullable|string|max:300',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('posts', 'public');
            $validated['thumbnail'] = $path;
        } elseif (!empty($request->thumbnail_url)) {
            $validated['thumbnail'] = $request->thumbnail_url;
        }

        $post->update($validated);

        ActivityLog::record('update_post', "Memperbarui berita: {$post->title}", $post);

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy(Post $post)
    {
        $title = $post->title;
        $post->delete();

        ActivityLog::record('delete_post', "Menghapus berita: {$title}");

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil dihapus.');
    }
}
