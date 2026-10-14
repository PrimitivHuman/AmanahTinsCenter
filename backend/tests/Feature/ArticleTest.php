<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private string $adminToken;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'email' => 'admin@amanahtins.id',
            'password' => Hash::make('password123'),
        ]);

        $this->adminToken = $this->admin->createToken('admin-test-token')->plainTextToken;
    }

    public function test_public_visitor_can_list_published_articles_only(): void
    {
        Article::create([
            'title' => 'Artikel Terbit 1',
            'slug' => 'artikel-terbit-1',
            'category' => 'Terapi Wicara',
            'excerpt' => 'Ringkasan artikel 1',
            'content' => '<p>Konten artikel 1</p>',
            'is_published' => true,
        ]);

        Article::create([
            'title' => 'Artikel Draf Rahasia',
            'slug' => 'artikel-draf-rahasia',
            'category' => 'Sensori Integrasi',
            'excerpt' => 'Ringkasan draf',
            'content' => '<p>Konten draf yang belum boleh tayang</p>',
            'is_published' => false,
        ]);

        $response = $this->getJson('/api/articles');

        $response->assertStatus(200);
        $data = $response->json('data');

        $this->assertCount(1, $data);
        $this->assertEquals('artikel-terbit-1', $data[0]['slug']);
    }

    public function test_public_visitor_cannot_view_unpublished_draft_article(): void
    {
        Article::create([
            'title' => 'Artikel Draf Rahasia',
            'slug' => 'artikel-draf-rahasia',
            'category' => 'Sensori Integrasi',
            'excerpt' => 'Ringkasan draf',
            'content' => '<p>Konten draf</p>',
            'is_published' => false,
            'views_count' => 0,
        ]);

        $response = $this->getJson('/api/articles/artikel-draf-rahasia');

        $response->assertStatus(404);
    }

    public function test_public_viewing_published_article_increments_views_count(): void
    {
        $article = Article::create([
            'title' => 'Artikel Populer',
            'slug' => 'artikel-populer',
            'category' => 'Terapi Okupasi',
            'excerpt' => 'Ringkasan artikel populer',
            'content' => '<p>Konten lengkap artikel populer</p>',
            'is_published' => true,
            'views_count' => 5,
        ]);

        $response = $this->getJson('/api/articles/artikel-populer');

        $response->assertStatus(200);
        $this->assertEquals(6, $article->fresh()->views_count);
    }

    public function test_admin_can_view_draft_article_without_incrementing_views_count(): void
    {
        $draft = Article::create([
            'title' => 'Artikel Draf Internal',
            'slug' => 'artikel-draf-internal',
            'category' => 'Sensori Integrasi',
            'excerpt' => 'Ringkasan draf internal',
            'content' => '<p>Konten draf internal</p>',
            'is_published' => false,
            'views_count' => 0,
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->adminToken)
            ->getJson('/api/articles/artikel-draf-internal');

        $response->assertStatus(200)
            ->assertJsonPath('article.title', 'Artikel Draf Internal');

        // Views count must remain 0
        $this->assertEquals(0, $draft->fresh()->views_count);
    }

    public function test_admin_can_create_article_with_stored_xss_protection(): void
    {
        $payload = [
            'title' => 'Panduan Stimulasi Motorik Halus',
            'category' => 'Terapi Okupasi',
            'author' => 'Terapis ATC',
            'excerpt' => 'Ringkasan panduan stimulasi motorik halus',
            'content' => '<p>Aman</p><script>alert("XSS Attack!")</script><iframe src="evil.com"></iframe><b>Bagus</b>',
            'is_published' => true,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->adminToken)
            ->postJson('/api/admin/articles', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(['message' => 'Artikel berhasil diterbitkan']);

        $article = Article::where('title', 'Panduan Stimulasi Motorik Halus')->first();
        $this->assertNotNull($article);

        // Assert script and iframe tags have been stripped
        $this->assertStringNotContainsString('<script>', $article->content);
        $this->assertStringNotContainsString('alert("XSS Attack!")', $article->content);
        $this->assertStringNotContainsString('<iframe', $article->content);
        $this->assertStringContainsString('<p>Aman</p>', $article->content);
        $this->assertStringContainsString('<b>Bagus</b>', $article->content);
    }

    public function test_admin_can_update_article(): void
    {
        $article = Article::create([
            'title' => 'Judul Lama',
            'slug' => 'judul-lama',
            'category' => 'Terapi Wicara',
            'excerpt' => 'Ringkasan lama',
            'content' => '<p>Konten lama</p>',
            'is_published' => true,
        ]);

        $updatePayload = [
            'title' => 'Judul Baru yang Diperbarui',
            'slug' => 'judul-lama',
            'category' => 'Sensori Integrasi',
            'excerpt' => 'Ringkasan baru',
            'content' => '<p>Konten baru yang sudah diperbaiki</p>',
            'is_published' => true,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->adminToken)
            ->putJson('/api/admin/articles/' . $article->id, $updatePayload);

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Artikel berhasil diperbarui']);

        $this->assertEquals('Judul Baru yang Diperbarui', $article->fresh()->title);
        $this->assertEquals('Sensori Integrasi', $article->fresh()->category);
    }

    public function test_admin_can_delete_article(): void
    {
        $article = Article::create([
            'title' => 'Artikel untuk Dihapus',
            'slug' => 'artikel-untuk-dihapus',
            'category' => 'Parenting',
            'excerpt' => 'Ringkasan artikel',
            'content' => '<p>Konten artikel</p>',
            'is_published' => true,
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->adminToken)
            ->deleteJson('/api/admin/articles/' . $article->id);

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Artikel berhasil dihapus']);

        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }

    public function test_admin_can_upload_article_image(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('cover.jpg', 800, 600)->size(1024);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->adminToken)
            ->postJson('/api/admin/articles/upload-image', [
                'image' => $file,
            ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['message', 'url']);

        $url = $response->json('url');
        $this->assertStringStartsWith('/storage/articles/', $url);

        $storedPath = substr($url, strlen('/storage/'));
        Storage::disk('public')->assertExists($storedPath);
    }

    public function test_article_upload_image_rejects_non_image_files(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('malicious.php', 100, 'application/x-php');

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->adminToken)
            ->postJson('/api/admin/articles/upload-image', [
                'image' => $file,
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['image']);
    }
}
