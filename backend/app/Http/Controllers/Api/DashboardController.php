<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\TeamMember;
use App\Models\Appointment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats()
    {
        $totalArticles = Article::count();
        $totalTeam = TeamMember::where('is_active', true)->count();
        $totalAppointments = Appointment::count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();
        $confirmedAppointments = Appointment::where('status', 'confirmed')->count();
        $completedAppointments = Appointment::where('status', 'completed')->count();
        $totalViews = Article::sum('views_count');

        $recentAppointments = Appointment::latest()->limit(5)->get();
        $recentArticles = Article::latest()->limit(5)->get();

        return response()->json([
            'stats' => [
                'total_articles' => $totalArticles,
                'total_team' => $totalTeam,
                'total_appointments' => $totalAppointments,
                'pending_appointments' => $pendingAppointments,
                'confirmed_appointments' => $confirmedAppointments,
                'completed_appointments' => $completedAppointments,
                'total_views' => $totalViews,
            ],
            'recent_appointments' => $recentAppointments,
            'recent_articles' => $recentArticles,
        ]);
    }
}
