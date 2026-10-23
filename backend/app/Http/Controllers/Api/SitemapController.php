<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate dynamic sitemap.xml yang menyertakan semua halaman statis
     * dan semua artikel yang sudah diterbitkan dari database.
     * Diakses oleh Googlebot untuk indexing otomatis.
     */
    public function index(): Response
    {
        $baseUrl = 'https://tinsgrowcenter.com';

        // Halaman statis website
        $staticPages = [
            ['loc' => '/',                    'priority' => '1.0', 'changefreq' => 'daily',   'lastmod' => '2026-10-14'],
            ['loc' => '/layanan',             'priority' => '0.9', 'changefreq' => 'weekly',  'lastmod' => '2026-10-14'],
            ['loc' => '/layanan/fisioterapi-anak',  'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => '2026-10-14'],
            ['loc' => '/layanan/terapi-wicara',     'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => '2026-10-14'],
            ['loc' => '/layanan/sensori-integrasi', 'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => '2026-10-14'],
            ['loc' => '/layanan/pedagogik',         'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => '2026-10-14'],
            ['loc' => '/layanan/terapi-okupasi',    'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => '2026-10-14'],
            ['loc' => '/layanan/psikologi-anak',    'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => '2026-10-14'],
            ['loc' => '/layanan/grup-terapi',       'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => '2026-10-23'],
            ['loc' => '/layanan/pra-vokasional',    'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => '2026-10-23'],
            ['loc' => '/layanan/kelas-persiapan-khusus', 'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => '2026-10-23'],
            ['loc' => '/tim-kami',            'priority' => '0.85','changefreq' => 'weekly',  'lastmod' => '2026-10-14'],
            ['loc' => '/jadwal-pendaftaran',  'priority' => '0.9', 'changefreq' => 'weekly',  'lastmod' => '2026-10-14'],
            ['loc' => '/artikel',             'priority' => '0.9', 'changefreq' => 'daily',   'lastmod' => '2026-10-14'],
            ['loc' => '/tentang-kami',        'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => '2026-10-14'],
        ];

        // Ambil semua artikel yang sudah diterbitkan dari database
        $articles = Article::where('is_published', true)
            ->select('slug', 'updated_at', 'published_at')
            ->latest()
            ->get();

        // Mulai bangun XML
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Tambahkan halaman statis
        $xml .= "\n  <!-- Halaman Statis Website -->\n";
        foreach ($staticPages as $page) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . e($baseUrl . $page['loc']) . "</loc>\n";
            $xml .= "    <lastmod>" . $page['lastmod'] . "</lastmod>\n";
            $xml .= "    <changefreq>" . $page['changefreq'] . "</changefreq>\n";
            $xml .= "    <priority>" . $page['priority'] . "</priority>\n";
            $xml .= "  </url>\n";
        }

        // Tambahkan semua artikel dinamis dari database
        if ($articles->isNotEmpty()) {
            $xml .= "\n  <!-- Artikel & Edukasi Parenting (Dinamis dari Database) -->\n";
            foreach ($articles as $article) {
                // Gunakan updated_at atau published_at sebagai lastmod
                $lastmod = optional($article->updated_at)->format('Y-m-d')
                    ?? optional($article->published_at)->format('Y-m-d')
                    ?? date('Y-m-d');

                $xml .= "  <url>\n";
                $xml .= "    <loc>" . e($baseUrl . '/artikel/' . $article->slug) . "</loc>\n";
                $xml .= "    <lastmod>" . $lastmod . "</lastmod>\n";
                $xml .= "    <changefreq>monthly</changefreq>\n";
                $xml .= "    <priority>0.75</priority>\n";
                $xml .= "  </url>\n";
            }
        }

        $xml .= "</urlset>\n";

        return response($xml, 200)
            ->header('Content-Type', 'application/xml; charset=utf-8')
            ->header('Cache-Control', 'public, max-age=3600'); // Cache 1 jam
    }
}
