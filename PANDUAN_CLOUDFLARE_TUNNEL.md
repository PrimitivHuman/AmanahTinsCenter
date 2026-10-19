# Panduan Lengkap Menghubungkan Project ke Cloudflare Tunnel

Dokumen ini menjelaskan langkah demi langkah untuk menghubungkan **Amanah Tin's Center** ke internet publik menggunakan **Cloudflare Tunnel (`cloudflared`)**.

---

## ⚡ Ringkasan Penyesuaian yang Sudah Dilakukan

1. **Konfigurasi Vite (`frontend/vite.config.js`)**:
   - Telah ditambahkan `host: true` dan `allowedHosts: true`.
   - Proxy bawaan Vite sudah otomatis meneruskan rute `/api` dan `/storage` ke backend Laravel (`http://127.0.0.1:8000`).
   - Karena itu, **cukup satu tunnel yang mengarah ke port frontend (5173)**, seluruh fitur website, login admin, API, dan upload gambar sudah otomatis berfungsi tanpa kendala CORS.

2. **Skrip Otomatis (`start-tunnel.bat`)**:
   - Dibuatkan file launcher praktis di root project untuk mendeteksi instalasi `cloudflared` dan menjalankan tunnel dengan 1 klik.

---

## 🚀 Opsi 1: Quick Tunnel (Instan, Gratis, Tanpa Akun / Tanpa Domain)

Sangat cocok untuk presentasi, demo ke klien melalui smartphone, atau testing jarak jauh.

### Langkah 1: Pasang `cloudflared` di Windows
Buka terminal PowerShell atau CMD, lalu jalankan perintah:
```powershell
winget install --id Cloudflare.cloudflared
```
*(Setelah instalasi selesai, tutup dan buka kembali terminal agar perintah `cloudflared` terbaca di sistem).*

### Langkah 2: Jalankan Service Lokal Project

**Terminal 1 (Backend Laravel):**
```bash
cd c:\laragon\www\AmanahTinsCenter\backend
php artisan serve
```
*(Berjalan di `http://127.0.0.1:8000`)*

**Terminal 2 (Frontend Vue):**
```bash
cd c:\laragon\www\AmanahTinsCenter\frontend
npm run dev
```
*(Berjalan di `http://localhost:5173`)*

### Langkah 3: Jalankan Tunnel
Buka **Terminal 3**, lalu jalankan:
```bash
cloudflared tunnel --url http://localhost:5173
```
*Atau cukup klik dua kali file:* `start-tunnel.bat` *di root project dan pilih opsi 1.*

Terminal akan menampilkan link publik HTTPS, contohnya:
```text
+--------------------------------------------------------------------------------------------+
|  Your quick Tunnel has been created! Visit it at (it may take some time to be reachable):  |
|  https://bebe-terapis-klinik-sample.trycloudflare.com                                      |
+--------------------------------------------------------------------------------------------+
```

Salin URL `https://xxxx.trycloudflare.com` tersebut dan buka di browser atau handphone.

---

## 🌐 Opsi 2: Named Tunnel (Menggunakan Domain Kustom Sendiri)

Jika Anda memiliki domain sendiri yang terhubung di Cloudflare (misal: `klinik.domainanda.com`):

### Langkah 1: Login di Cloudflare Dashboard
1. Buka [Cloudflare Zero Trust Dashboard](https://one.dash.cloudflare.com/).
2. Masuk ke menu **Networks** > **Tunnels**.
3. Klik tombol **Add a tunnel** -> Pilih **Cloudflared** -> Beri nama tunnel (misal: `amanah-tins-tunnel`).
4. Pilih sistem operasi **Windows** dan arsitektur **64-bit**.
5. Salin baris perintah instalasi konektor yang disediakan Cloudflare, contohnya:
   ```powershell
   cloudflared.exe service install eyJhIjoiYmE5N... (token Anda)
   ```
6. Jalankan perintah tersebut di PowerShell (Run as Administrator).

### Langkah 2: Konfigurasi Public Hostname di Dashboard
Di halaman berikutnya pada dashboard Cloudflare:
- **Subdomain**: `klinik` (atau kosongkan jika domain utama)
- **Domain**: pilih domain Anda, misal `domainanda.com`
- **Type**: `HTTP`
- **URL**: 
  - Jika menggunakan dev server: `localhost:5173`
  - Jika menggunakan Laragon Apache virtual host: `localhost:80` (dengan opsi *HTTP Host Header* diisi `amanahtinscenter.test` pada menu *Additional Application Settings*)

Klik **Save tunnel**. Website kini dapat diakses permanen melalui `https://klinik.domainanda.com`!

---

## 💡 Troubleshooting & Tips

1. **Gambar / File Upload tidak tampil:**
   Pastikan symlink storage Laravel sudah dibuat dengan menjalankan:
   ```bash
   cd backend
   php artisan storage:link
   ```
2. **Koneksi Database saat diakses dari luar:**
   Database MySQL tetap berjalan di lokal Anda (`127.0.0.1:3306`). Laravel di server lokal akan tetap membaca database lokal tanpa perlu membuka port database ke internet.
3. **Menghentikan Tunnel:**
   Tekan `Ctrl + C` di jendela terminal tempat `cloudflared` berjalan.
