# Dokumentasi Halaman Dashboard Admin
**Amanah Tin's Center** — Versi Mutakhir (Fokus Konten & Sekilas Tim Terapis)

| Item | Detail |
|---|---|
| Rute Halaman | `/admin/dashboard` (menu sidebar: "Dashboard Ringkasan") |
| Frontend View | `frontend/src/views/admin/DashboardView.vue` (Vue 3 `<script setup>`) |
| Layout Shell | `frontend/src/layouts/AdminLayout.vue` (Sidebar responsif + Topbar bersih + Slot) |
| Backend Controller | `backend/app/Http/Controllers/Api/DashboardController.php` → method `stats()` |
| Endpoint API | `GET /api/admin/stats` (terproteksi Laravel Sanctum) |
| Sentralisasi WA | `frontend/src/composables/useClinicSettings.js` (`useClinicSettings()`) |
| Hak Akses | Khusus Administrator terautentikasi |

---

## 1. Ringkasan & Konsep Utama

Halaman **Dashboard Ringkasan Admin** dirancang dengan tata letak dua pilar utama yang seimbang, modern, dan fokus pada operasional inti:
1. **Pusat Pengawasan Konten Edukasi**: Memantau artikel terbit, draft tersimpan, dan peringkat artikel yang paling banyak dibaca oleh orang tua (**Artikel Terpopuler**).
2. **Sekilas Tim Terapis**: Memantau profil terapis medis dan tenaga spesialis aktif yang melayani pasien di klinik (wicara, okupasi, sensori integrasi, fisioterapi).
3. **Kendali WhatsApp Pendaftaran**: Memantau nomor resmi klinik yang aktif terhubung dengan formulir dan tombol reservasi publik.

*Pembaruan Terkini:*
- Tombol *WhatsApp Klinik* pada Navbar/Topbar telah dihapus agar topbar lebih bersih dan rapi.
- Section *Aksi Cepat* dan *Pendaftaran via WhatsApp* telah dihapus.
- Ditambahkan section **Sekilas Tim Terapis** di kolom kanan yang menampilkan ringkasan anggota terapis aktif, foto, spesialisasi, dan pintasan pengelolaan tim.

---

## 2. Struktur Tampilan & Komponen

### 2.1 Banner Selamat Datang (Welcome Card)
- **Desain**: Gradien biru teal modern (`#005a78` → `#00769a` → `#1789ab`) dengan elemen pencahayaan aura melingkar.
- **Elemen Teks**:
  - Badge chip: `✨ Pusat Kendali Administrasi`
  - Sapaan dinamis: `Selamat Datang, {Nama Admin} 👋`
  - Deskripsi ringkas peranan sistem.
  - Metadata aktif: Tanggal hari ini format bahasa Indonesia (contoh: *Selasa, 13 Oktober 2026*) serta status *WhatsApp Reservasi Aktif*.
- **Tombol Aksi**:
  - `Tulis Artikel Baru` (Primary White Pill)
  - `Kelola Tim Terapis` (Ghost Pill)

### 2.2 Notifikasi & Peringatan Dinamis
- **Error State Alert**: Tampil otomatis jika koneksi internet atau server terganggu, lengkap dengan tombol `Coba Lagi`.
- **Warning Kelengkapan Pengaturan**: Memeriksa apakah nomor WhatsApp, alamat, jam kerja, atau email klinik belum diisi, dan menyediakan tautan langsung untuk melengkapinya.

### 2.3 Grid Kartu Statistik (4 Kartu Utama)
Dirancang dengan efek hover lembut (*lift on hover*), ikon modern berlatar warna pastel, dan indikator status:
| Kartu | Indikator Utama | Sub-Badge / Keterangan | Tombol Pintas |
|---|---|---|---|
| **Artikel Edukasi Terbit** | Jumlah artikel dengan `is_published = true` | Badge status draft jika ada (contoh: *2 Draft Tersimpan*) | `Kelola semua artikel →` |
| **Terapis Aktif Terdaftar** | Jumlah tim terapis dengan `is_active = true` | `Tenaga Ahli Medis` | `Kelola data tim terapis →` |
| **Total Pembaca Artikel** | Akumulasi `views_count` berformat ribuan (contoh: *14.850*) | `Akumulasi Interaksi` | Indikator tren minat edukasi |
| **WhatsApp Pendaftaran** | Nomor WhatsApp terformat rapi (`+62 821-8889-9900`) | Badge `Jalur Aktif` hijau | **Uji Chat** & **Ubah Nomor** |

---

## 3. Area Konten Utama (Tata Letak Vertikal: Atas & Bawah)

### 3.1 Section Atas — Artikel Terpopuler (Lebar Penuh)
- Menampilkan 5 materi edukasi yang paling banyak dibaca oleh orang tua pengunjung website dalam area lebar penuh (*full-width*).
- **Keunggulan Tata Letak Penuh**: Judul artikel panjang dapat terbaca leluasa tanpa terpotong, badge peringkat terlihat jelas, dan kolom data (kategori, pembaca, tombol edit) memiliki ruang bernapas yang proporsional.
- **Tampilan Desktop (≥ 768px)**: Tabel interaktif dengan badge peringkat (#1 Emas, #2 Perak, #3 Perunggu), thumbnail cover artikel, judul artikel dengan link edit, nama penulis, pill kategori, jumlah pembaca (dengan ikon mata), dan tombol aksi edit.
- **Tampilan Mobile (< 768px)**: Berubah menjadi daftar kartu (*Card List*) vertikal yang ramah layar sentuh tanpa perlu geser horizontal.

### 3.2 Section Bawah — Sekilas Tim Terapis (Grid Kartu Responsif)
- Ditempatkan tepat di bawah section artikel terpopuler, menyajikan profil tenaga spesialis aktif dalam format **grid multi-kolom responsif** (`auto-fill minmax 280px` di desktop, 2 kolom rapi di tablet, dan 1 kolom di ponsel):
  - **Header Section**: Dilengkapi judul, subjudul, dan tombol navigasi tunggal `Kelola Tim →` di sudut kanan atas.
  - **Foto / Avatar Anti-Spill**: Foto asli terapis berlisensi dibungkus dalam `.avatar-frame` berproteksi `overflow: hidden;` serta fallback otomatis `@error` ke icon avatar. Hal ini mencegah teks *alt image* bocor keluar kartu jika URL foto terganggu.
  - **Informasi Terapis**: Nama lengkap tenaga medis, pengalaman (badge tahun pengalaman), profesi utama, dan spesialisasi terapi dengan tooltip `:title`.
  - **Sentuhan Interaktif (Seluruh Kartu Tautan)**: Seluruh bidang kartu bertindak sebagai link navigasi ke `/admin/tim-kami` sehingga sangat nyaman diklik di desktop maupun ditap menggunakan jempol di ponsel/tablet.
  - **Footer Bersih & Ringkas**: Hanya menampilkan status akumulasi terapis aktif (contoh: *4 Terapis Medis Terdaftar*) tanpa tombol ganda/redundan.

---

## 4. Adaptasi Responsif (Desktop, Tablet, Mobile)

| Ukuran Layar | Breakpoint | Penyesuaian Tampilan |
|---|---|---|
| **Desktop Lebar** | > 1200px | Grid statistik 4 kolom sejajar.<br>Konten utama tersusun vertikal: Artikel Terpopuler di atas (tabel penuh), Sekilas Tim Terapis di bawah (grid 3–4 kolom kartu terapis). |
| **Tablet Lanskap / Laptop Kecil** | 1024px – 1200px | Grid statistik 2x2 kolom.<br>Konten utama vertikal: Artikel Terpopuler di atas, Sekilas Tim Terapis di bawah (grid proporsional minmax 260px). |
| **Tablet Portrait** | 768px – 1024px | Grid statistik 2x2 kolom.<br>Artikel terpopuler di atas, Sekilas Tim Terapis di bawah tertata tepat **2 kolom seimbang** (`grid-template-columns: repeat(2, 1fr)`). |
| **Ponsel / Layar Sentuh** | < 768px | - Sidebar tersembunyi secara bawaan dan dapat ditoggle melalui tombol menu navbar.<br>- Topbar navbar tampil bersih.<br>- Banner selamat datang menyesuaikan ukuran teks dan tombol aksi ditumpuk rapi.<br>- Statistik menjadi 1 kolom dengan tombol aksi sentuh yang nyaman.<br>- Tabel artikel terpopuler berganti menjadi **daftar kartu artikel** bebas geser horizontal.<br>- Header kartu menampilkan pill `Kelola Tim` yang pas di layar kecil.<br>- Sekilas tim terapis menjadi 1 kolom kartu vertikal dengan target sentuh penuh dan avatar 44px yang proporsional.<br>- Footer section terapis hanya menampilkan jumlah ringkasan terapis tanpa tombol ganda yang memadati layar. |

---

## 5. Ringkasan Perubahan Teknis

1. **`AdminLayout.vue`**:
   - Menghapus tombol *WhatsApp Klinik* dari `.topbar-right`.
   - Menghapus import `useClinicSettings` dan CSS `.quick-btn` yang sudah tidak digunakan.
2. **`DashboardController.php`**:
   - Menambahkan query `team_members` yang mengambil data anggota terapis aktif (`name`, `role`, `specialization`, `image`, `experience_years`, `is_active`) untuk disajikan langsung di response API `GET /api/admin/stats`.
3. **`DashboardView.vue`**:
   - Menghapus section *Aksi Cepat*.
   - Menghapus section *Pendaftaran via WhatsApp*.
   - Menambahkan section baru **Sekilas Tim Terapis**.
   - Menyusun section **Artikel Terpopuler (atas)** dan **Sekilas Tim Terapis (bawah)** secara vertikal.
   - Menghapus tombol redundan *Kelola Tim* di footer bawah section terapis, menyisakan indikator ringkasan jumlah terapis.
   - Mengubah elemen kartu terapis menjadi touch target penuh (`<router-link to="/admin/tim-kami">`), dilengkapi frame avatar anti-overflow dan event `@error` fallback.
   - Mengoptimalkan responsivitas tablet (2 kolom kartu teratur) dan ponsel (1 kolom kartu kompak dengan header ringkas).
