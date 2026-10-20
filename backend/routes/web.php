<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SitemapController;

Route::get('/', function () {
    return view('welcome');
});

// Dynamic Sitemap XML untuk Google Search Console & Googlebot
Route::get('/sitemap.xml', [SitemapController::class, 'index']);

