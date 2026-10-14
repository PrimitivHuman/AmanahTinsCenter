<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Rate limiter untuk proteksi brute force login admin (5 percobaan per menit per email & IP)
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;
            return Limit::perMinute(5)->by($email . '|' . $request->ip())->response(function () {
                return response()->json([
                    'message' => 'Terlalu banyak percobaan masuk yang gagal. Silakan tunggu 1 menit sebelum mencoba lagi demi keamanan akun Anda.',
                ], 429);
            });
        });
    }
}
