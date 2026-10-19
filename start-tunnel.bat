@echo off
title Amanah Tin's Center - Cloudflare Tunnel
echo ========================================================
echo   Amanah Tin's Center - Cloudflare Tunnel Launcher
echo ========================================================
echo.

:: 1. Cek apakah cloudflared sudah terpasang
set "CF_CMD=cloudflared"
where cloudflared >nul 2>nul
if %ERRORLEVEL% neq 0 (
    if exist "C:\Program Files (x86)\cloudflared\cloudflared.exe" (
        set "CF_CMD=C:\Program Files (x86)\cloudflared\cloudflared.exe"
        set "PATH=%PATH%;C:\Program Files (x86)\cloudflared"
    ) else if exist "C:\Program Files\cloudflared\cloudflared.exe" (
        set "CF_CMD=C:\Program Files\cloudflared\cloudflared.exe"
        set "PATH=%PATH%;C:\Program Files\cloudflared"
    ) else (
        echo [!] 'cloudflared' belum terdeteksi di komputer Anda.
        echo.
        echo Anda dapat menginstalnya secara otomatis menggunakan winget.
        set /p INSTALL_CHOICE="Install cloudflared sekarang? (Y/N): "
        if /i "%INSTALL_CHOICE%"=="Y" (
            echo.
            echo Mengunduh dan memasang cloudflared melalui winget...
            winget install --id Cloudflare.cloudflared --accept-package-agreements --accept-source-agreements
            echo.
            echo [INFO] Pemasangan selesai. Silakan buka kembali file ini (start-tunnel.bat).
            pause
            exit /b
        ) else (
            echo Silakan unduh manual dari: https://github.com/cloudflare/cloudflared/releases
            pause
            exit /b
        )
    )
)

echo Pilih mode tunnel:
echo [1] Mode Vite Dev (Port 5173 - Frontend + Laravel Proxy) [REKOMENDASI SAAT CODING]
echo [2] Mode Laragon Apache (Port 80 - Virtual Host amanahtinscenter.test)
echo [3] Mode Backend Standalone (Port 8000 - API Laravel saja)
echo.
set /p MODE="Pilih nomor (1/2/3) [Default: 1]: "
if "%MODE%"=="" set MODE=1

if "%MODE%"=="1" (
    echo.
    echo -------------------------------------------------------------
    echo [1] Menghubungkan Cloudflare ke Frontend Vite (http://localhost:5173)
    echo PERHATIAN: Pastikan dua server lokal berikut sudah aktif:
    echo   - Terminal 1: cd backend ^&^& php artisan serve
    echo   - Terminal 2: cd frontend ^&^& npm run dev
    echo -------------------------------------------------------------
    echo.
    "%CF_CMD%" tunnel --url http://localhost:5173
) else if "%MODE%"=="2" (
    echo.
    echo -------------------------------------------------------------
    echo [2] Menghubungkan Cloudflare ke Laragon Apache (http://localhost:80)
    echo PERHATIAN:
    echo   - Pastikan Laragon Apache ^& MySQL sudah 'Start All'
    echo   - Jalankan 'cd frontend ^&^& npm run build' jika ada perubahan UI
    echo -------------------------------------------------------------
    echo.
    "%CF_CMD%" tunnel --url http://localhost:80 --http-host-header amanahtinscenter.test
) else if "%MODE%"=="3" (
    echo.
    echo -------------------------------------------------------------
    echo [3] Menghubungkan Cloudflare ke Laravel Backend API (http://localhost:8000)
    echo PERHATIAN: Pastikan 'php artisan serve' aktif di folder backend.
    echo -------------------------------------------------------------
    echo.
    "%CF_CMD%" tunnel --url http://localhost:8000
) else (
    echo Pilihan tidak valid.
)

pause
