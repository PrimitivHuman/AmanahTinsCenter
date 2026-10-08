<?php
/**
 * Amanah Tin's Center - Universal Root Router / Fallback
 * Automatically routes requests to Vue frontend/dist or Laravel backend/public
 */

$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($requestUri, PHP_URL_PATH);

// 1. API and Storage routes go to Laravel backend
if (str_starts_with($path, '/api') || str_starts_with($path, '/storage')) {
    require_once __DIR__ . '/backend/public/index.php';
    exit;
}

// 2. Static assets from frontend/dist
$distPath = __DIR__ . '/frontend/dist' . $path;
if (file_exists($distPath) && !is_dir($distPath)) {
    $ext = pathinfo($distPath, PATHINFO_EXTENSION);
    $mimes = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'svg' => 'image/svg+xml',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'webp' => 'image/webp',
        'woff2' => 'font/woff2',
        'woff' => 'font/woff',
        'ttf' => 'font/ttf',
        'json' => 'application/json',
    ];
    
    if (isset($mimes[$ext])) {
        header('Content-Type: ' . $mimes[$ext]);
    } else {
        header('Content-Type: ' . (mime_content_type($distPath) ?: 'application/octet-stream'));
    }
    
    readfile($distPath);
    exit;
}

// 3. All other routes fallback to Vue SPA index.html
if (file_exists(__DIR__ . '/frontend/dist/index.html')) {
    header('Content-Type: text/html; charset=UTF-8');
    readfile(__DIR__ . '/frontend/dist/index.html');
    exit;
}

echo "Amanah Tin's Center - Sedang mempersiapkan frontend...";
