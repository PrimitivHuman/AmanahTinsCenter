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
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        if ($request->has('category') && $request->category !== 'Semua') {
            $cat = $request->category;
            if ($cat === 'Parenting') {
                $query->where(function ($q) {
                    $q->where('category', 'Parenting')
                      ->orWhere('category', 'like', 'Parenting%');
                });
            } else {
                $query->where('category', $cat);
            }
        }

        if ($request->has('status') && in_array($request->status, ['published', 'draft'])) {
            $query->where('is_published', $request->status === 'published');
        }

        $articles = $query->latest()->paginate($request->get('per_page', 10));

        $stats = [
            'total' => Article::count(),
            'published' => Article::where('is_published', true)->count(),
            'draft' => Article::where('is_published', false)->count(),
            'total_views' => (int) Article::sum('views_count'),
        ];

        $response = $articles->toArray();
        $response['stats'] = $stats;

        return response()->json($response);
    }

    // Admin: Show for editing
    public function adminShow($id)
    {
        $article = Article::findOrFail($id);
        return response()->json($article);
    }

    /**
     * Admin: Upload article cover image
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
        ], [
            'image.required' => 'Silakan pilih berkas gambar yang akan diunggah.',
            'image.image' => 'Berkas harus berupa gambar valid.',
            'image.mimes' => 'Format gambar yang didukung adalah JPEG, PNG, JPG, WEBP, atau GIF.',
            'image.max' => 'Ukuran gambar maksimal adalah 5MB.',
        ]);

        $file = $request->file('image');
        $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('articles', $filename, 'public');
        $url = '/storage/' . $path;

        return response()->json([
            'message' => 'Gambar sampul berhasil diunggah',
            'url' => $url,
            'filename' => $filename,
            'size' => $file->getSize(),
        ]);
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
            'title' => 'sometimes|required|string|max:255',
            'category' => 'sometimes|required|string|max:100',
            'excerpt' => 'nullable|string',
            'content' => 'sometimes|required|string',
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
