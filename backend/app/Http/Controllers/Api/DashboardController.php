<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ClinicSetting;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    /**
     * Ringkasan dashboard admin.
     * Catatan: pendaftaran/konsultasi kini diarahkan ke WhatsApp, sehingga
     * statistik appointment tidak lagi disertakan.
     */
    public function stats()
    {
        $stats = Cache::remember('admin_dashboard_stats', 60, function () {
            return [
                'published_articles' => Article::where('is_published', true)->count(),
                'draft_articles' => Article::where('is_published', false)->count(),
                'total_team' => TeamMember::where('is_active', true)->count(),
                'total_views' => (int) Article::sum('views_count'),
            ];
        });

        $articleFields = ['id', 'title', 'category', 'author', 'image', 'views_count', 'is_published', 'created_at'];

        $popularArticles = Article::where('is_published', true)
            ->orderByDesc('views_count')
            ->limit(5)
            ->get($articleFields);

        $teamMembers = TeamMember::where('is_active', true)
            ->orderBy('order')
            ->limit(4)
            ->get(['id', 'name', 'role', 'specialization', 'image', 'experience_years', 'is_active']);

        $recentArticles = Article::latest()->limit(5)->get($articleFields);

        $setting = ClinicSetting::first();

        // Kesehatan konten
        $health = [
            'articles_without_image' => Article::whereNull('image')->orWhere('image', '')->count(),
            'team_without_photo' => $this->teamWithoutPhoto(),
        ];

        // Kelengkapan pengaturan klinik
        $requiredSettings = [
            'whatsapp' => 'Nomor WhatsApp',
            'address' => 'Alamat klinik',
            'weekday_hours' => 'Jam operasional (hari kerja)',
            'email' => 'Email klinik',
        ];
        $missingSettings = [];
        foreach ($requiredSettings as $field => $label) {
            if (!$setting || empty($setting->{$field})) {
                $missingSettings[] = $label;
            }
        }

        return response()->json([
            'stats' => $stats,
            'popular_articles' => $popularArticles,
            'team_members' => $teamMembers,
            'recent_articles' => $recentArticles,
            'health' => $health,
            'missing_settings' => $missingSettings,
            'whatsapp' => $setting?->whatsapp,
        ]);
    }

    private function teamWithoutPhoto(): int
    {
        $table = (new TeamMember())->getTable();
        $column = collect(['image', 'photo'])->first(
            fn ($c) => \Illuminate\Support\Facades\Schema::hasColumn($table, $c)
        );

        if (!$column) {
            return 0;
        }

        return TeamMember::where('is_active', true)
            ->where(fn ($q) => $q->whereNull($column)->orWhere($column, ''))
            ->count();
    }
}
