<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Bersihkan HTML konten artikel dari tag dan atribut berbahaya (Stored XSS Defense-in-depth)
     */
    private function sanitizeHtml(?string $html): ?string
    {
        if (!$html) return $html;
        // Hapus tag berbahaya script, iframe, object, embed, applet, style
        $cleaned = preg_replace('/<(script|iframe|object|embed|applet|style)[^>]*>.*?<\/\\1>/is', '', $html);
        // Hapus inline event handlers (onclick, onerror, onload, onmouseover, dsb)
        $cleaned = preg_replace('/\s*on[a-z]+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $cleaned);
        // Netralkan pseudo-protokol pada tautan (javascript:, vbscript:)
        $cleaned = preg_replace('/href\s*=\s*["\']\s*(javascript|vbscript):[^"\']*["\']/i', 'href="#"', $cleaned);
        $cleaned = preg_replace('/src\s*=\s*["\']\s*(javascript|vbscript):[^"\']*["\']/i', 'src=""', $cleaned);
        return $cleaned;
    }

    /**
     * Hapus berkas gambar lama di disk public storage (hanya jika berada di direktori /storage/articles/)
     */
    private function deleteLocalImage(?string $url): void
    {
        if ($url && str_starts_with($url, '/storage/articles/')) {
            Storage::disk('public')->delete(substr($url, strlen('/storage/')));
        }
    }

    // Public: List articles (published only)
    public function index(Request $request)
    {
        $query = Article::where('is_published', true);

        if ($request->filled('category') && !in_array($request->category, ['Semua', 'Semua Topik', 'all'])) {
            $cat = $request->category;
            $aliases = [
                'Sensori & Motorik' => 'Sensori Integrasi',
                'Sensori Motorik' => 'Sensori Integrasi',
                'Parenting Positif' => 'Parenting',
                'Parenting & Pola Asuh' => 'Parenting',
                'Psikologi Anak' => 'Tumbuh Kembang',
            ];
            $query->where(function ($q) use ($cat, $aliases) {
                $q->where('category', $cat);
                if (isset($aliases[$cat])) {
                    $q->orWhere('category', $aliases[$cat]);
                }
                foreach ($aliases as $legacy => $canonical) {
                    if ($canonical === $cat) {
                        $q->orWhere('category', $legacy);
                    }
                }
            });
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
    // Keamanan: Pengunjung publik HANYA dapat membaca artikel yang sudah diterbitkan (is_published = true).
    // Admin yang terotentikasi dapat melihat pratinjau draf tanpa menaikkan views_count.
    public function show($slug)
    {
        $query = Article::where('slug', $slug);

        $isAdmin = auth('sanctum')->check();
        if (!$isAdmin) {
            $query->where('is_published', true);
        }

        $article = $query->firstOrFail();
        
        // Naikkan hitungan view HANYA untuk pengunjung umum (bukan admin)
        if (!$isAdmin) {
            $article->increment('views_count');
        }

        // Related articles (hanya yang sudah terbit)
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
     * Menggunakan hashName otomatis Laravel untuk mencegah eksploitasi ekstensi berkas klien.
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'image.required' => 'Silakan pilih berkas gambar yang akan diunggah.',
            'image.image' => 'Berkas harus berupa gambar valid.',
            'image.mimes' => 'Format gambar yang didukung adalah JPEG, PNG, JPG, atau WEBP.',
            'image.max' => 'Ukuran gambar maksimal adalah 5MB.',
        ]);

        $path = $request->file('image')->store('articles', 'public');
        $url = '/storage/' . $path;

        return response()->json([
            'message' => 'Gambar sampul berhasil diunggah',
            'url' => $url,
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

        $validated['content'] = $this->sanitizeHtml($validated['content']);
        if (!empty($validated['excerpt'])) {
            $validated['excerpt'] = strip_tags($validated['excerpt']);
        }

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

        if (isset($validated['content'])) {
            $validated['content'] = $this->sanitizeHtml($validated['content']);
        }
        if (isset($validated['excerpt'])) {
            $validated['excerpt'] = strip_tags($validated['excerpt']);
        }

        $oldImage = $article->image;
        $article->update($validated);

        // Bersihkan berkas gambar lama bila diganti
        if ($oldImage && isset($validated['image']) && $oldImage !== $validated['image']) {
            $this->deleteLocalImage($oldImage);
        }

        return response()->json([
            'message' => 'Artikel berhasil diperbarui',
            'data' => $article,
        ]);
    }

    // Admin: Delete article
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $this->deleteLocalImage($article->image);
        $article->delete();

        return response()->json([
            'message' => 'Artikel berhasil dihapus',
        ]);
    }
}

