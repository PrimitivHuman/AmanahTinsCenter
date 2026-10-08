<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    // Public: List articles (published only)
    public function index(Request $request)
    {
        $query = Article::where('is_published', true);

        if ($request->has('category') && $request->category !== 'Semua') {
            $query->where('category', $request->category);
        }

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $articles = $query->latest()->paginate($request->get('per_page', 9));

        return response()->json($articles);
    }

    // Public: Show single article by slug
    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        
        // Increment views
        $article->increment('views_count');

        // Related articles
        $related = Article::where('id', '!=', $article->id)
            ->where('category', $article->category)
            ->where('is_published', true)
            ->limit(3)
            ->get();

        if ($related->isEmpty()) {
            $related = Article::where('id', '!=', $article->id)
                ->where('is_published', true)
                ->limit(3)
                ->get();
        }

        return response()->json([
            'article' => $article,
            'related' => $related,
        ]);
    }

    // Admin: List all articles (including unpublished)
    public function adminIndex(Request $request)
    {
        $query = Article::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->has('category') && $request->category !== 'Semua') {
            $query->where('category', $request->category);
        }

        $articles = $query->latest()->paginate($request->get('per_page', 10));

        return response()->json($articles);
    }

    // Admin: Show for editing
    public function adminShow($id)
    {
        $article = Article::findOrFail($id);
        return response()->json($article);
    }

    // Admin: Create article
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'author' => 'nullable|string|max:150',
            'image' => 'nullable|string',
            'read_time' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        if (empty($validated['author'])) {
            $validated['author'] = "Tim Ahli Amanah Tin's Center";
        }

        $article = Article::create($validated);

        return response()->json([
            'message' => 'Artikel berhasil diterbitkan',
            'data' => $article,
        ], 201);
    }

    // Admin: Update article
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'author' => 'nullable|string|max:150',
            'image' => 'nullable|string',
            'read_time' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        $article->update($validated);

        return response()->json([
            'message' => 'Artikel berhasil diperbarui',
            'data' => $article,
        ]);
    }

    // Admin: Delete article
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return response()->json([
            'message' => 'Artikel berhasil dihapus',
        ]);
    }
}
