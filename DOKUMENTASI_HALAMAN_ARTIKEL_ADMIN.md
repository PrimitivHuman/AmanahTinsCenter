# Dokumentasi Halaman Kelola Artikel & Tips (Admin)
**Amanah Tin's Center** — Manajemen Edukasi Orang Tua Terpadu

| Item | Detail |
|---|---|
| Rute Halaman | `/admin/artikel` (Menu Sidebar: "Kelola Artikel & Tips") |
| Frontend View | `frontend/src/views/admin/ArticlesView.vue` (Vue 3 `<script setup>`) |
| Layout Shell | `frontend/src/layouts/AdminLayout.vue` |
| Backend Controller | `backend/app/Http/Controllers/Api/ArticleController.php` (`adminIndex()`, `update()`, `destroy()`) |
| Endpoint API | `GET /api/admin/articles`, `PUT /api/admin/articles/{id}`, `DELETE /api/admin/articles/{id}` |
| Hak Akses | Khusus Administrator terautentikasi (Laravel Sanctum) |

---

## 1. Ikhtisar & Tujuan Halaman

Halaman **Kelola Artikel & Tips** berfungsi sebagai pusat manajemen konten edukasi tumbuh kembang anak untuk orang tua di website Amanah Tin's Center. Melalui halaman ini, administrator dapat memantau performa bacaan artikel, memfilter materi berdasarkan status atau spesialisasi terapi, menerbitkan/mengarsipkan materi edukasi, serta mengedit atau menghapus artikel secara terstruktur.

---

## 2. Fitur & Komponen Utama

### 2.1 Header & Aksi Cepat
- **Tag Subjudul**: `Pusat Edukasi Orang Tua`
- **Judul Utama**: `Manajemen Artikel & Tips Edukasi`
- **Tombol Aksi**: `+ Tulis Artikel Baru` (Mengarahkan ke formulir editor `/admin/artikel/baru`)

### 2.2 Ringkasan Metrik Konten (4 Stat Cards)
Ditempatkan di bagian atas untuk memberikan gambaran instan terhadap status penerbitan:
1. **Total Artikel Terdata**: Jumlah seluruh materi artikel di database. Mengklik kartu ini akan mereset filter status ke *Semua Konten*.
2. **Artikel Diterbitkan**: Jumlah artikel dengan status `is_published = true`. Mengklik kartu ini langsung memfilter daftar ke artikel yang tayang publik.
3. **Draf Belum Terbit**: Jumlah artikel yang masih disimpan sebagai draf (`is_published = false`). Mengklik kartu ini memfilter daftar artikel draf.
4. **Total Pembaca Artikel**: Akumulasi total tayangan (`views_count`) artikel di website publik.

### 2.3 Toolbar Filter & Pencarian Cepat
- **Tab Status Artikel**: Tab bergaya pill modern (*Semua*, *Terbit*, *Draf*) dilengkapi indikator titik warna (*status dot*) dan badge counter jumlah data.
- **Pencarian Cepat Debounced**: Mencari judul, excerpt ringkas, nama penulis, dan topik secara *real-time* (debounce 350ms) dengan tombol pembersih (*Clear X*).
- **Filter Kategori Terapi (Anti-Cutoff & Responsive Wrapping)**: Chips pilihan spesialisasi (*Semua Kategori*, *Terapi Wicara*, *Sensori Integrasi*, *Terapi Okupasi*, *Fisioterapi Pediatrik*, *Tumbuh Kembang*, *Parenting & Pola Asuh*) dengan indikator titik warna (*colored dots*) untuk tiap terapi. Di tampilan mobile/tablet, chips otomatis tersusun ke baris baru (*flex-wrap: wrap*) sehingga tidak ada teks kategori yang terpotong dan tidak memerlukan geser horizontal.
- **Tombol Reset Filter**: Muncul otomatis ketika ada pencarian, kategori, atau filter status yang aktif untuk memudahkan admin kembali ke tampilan awal.

### 2.4 Tampilan Konten (Desktop & Mobile Adaptive)
- **Desktop Table View (≥ 768px)**:
  - **Cover Thumbnail & Excerpt**: Gambar thumbnail berproteksi `@error` fallback ke ikon cover, dilengkapi judul artikel, kutipan excerpt, tanggal pembuatan/pembaruan, dan perkiraan waktu baca.
  - **Badge Kategori**: Warna aksen disesuaikan dengan jenis terapi (Biru, Hijau, Teal, Ungu, Amber).
  - **Penulis**: Ikon `person` dan nama penulis/tenaga spesialis.
  - **Pembaca**: Ikon mata dan jumlah pembaca berformat ribuan.
  - **Toggle Status Publikasi**: Tombol pill interaktif (*Terbit* / *Draf*) yang dapat di-klik langsung untuk mengubah status tanpa harus membuka formulir edit, dilengkapi spinner mikro saat proses request API berlangsung.
  - **Aksi Cepat**: Tombol *Lihat Publik* (membuka halaman artikel publik di tab baru), *Edit* (ke formulir editor), dan *Hapus* (membuka modal konfirmasi).
- **Mobile Card List View (< 768px)**:
  - Mengubah tabel menjadi daftar kartu vertikal (*Card List*) yang nyaman untuk layar sentuh tanpa perlu geser horizontal (*no horizontal overflow*).
  - Elemen teks dibatasi dengan `min-width: 0; word-break: break-word;`.
  - Tombol aksi mobile dirancang proporsional dan mudah disentuh jari (*thumb-friendly*).

### 2.5 Feedback & Dialog Konfirmasi Terpadu
- **Modal Konfirmasi Hapus**: Dialog konfirmasi modern berlatar *backdrop blur* menggantikan `window.confirm()` bawaan browser.
- **Toast Feedback**: Notifikasi mengambang (*floating toast*) dengan animasi halus yang memberi tahu keberhasilan perubahan status atau penghapusan artikel selama 3 detik.
- **Empty State & Loading**: Animasi pemuatan halus serta tampilan *empty state* yang informatif jika filter tidak menemukan artikel.

---

## 3. Adaptasi Responsif Layar

| Tipe Layar | Resolusi | Karakteristik Tampilan |
|---|---|---|
| **Desktop Lebar** | > 1024px | 4 Stat Cards berjajar horizontal, toolbar 2 baris seimbang, tabel penuh dengan ruang teks leluasa. |
| **Tablet / Laptop Ringkas** | 768px – 1024px | Stat Cards otomatis menyesuaikan menjadi 2x2 kolom, tabel tetap menyajikan info penting dengan padding proporsional. |
| **Ponsel / Layar Sentuh** | < 768px | Stat Cards menjadi 1 kolom vertikal, chip kategori dapat digeser mendatar (*smooth horizontal scroll*), tabel beralih menjadi **Card List** mandiri, aksi tombol ramah sentuhan. |
| **Ponsel Kecil** | ≤ 480px | Cover thumbnail kartu mobile menjadi banner atas 140px, tombol aksi menyebar merata (*flex 1*) untuk kenyamanan jempol. |

---

## 4. Halaman Formulir Tambah & Edit Artikel (`ArticleFormView.vue`)

| Item | Detail |
|---|---|
| Rute Tambah Artikel | `/admin/artikel/baru` |
| Rute Edit Artikel | `/admin/artikel/:id/edit` |
| Frontend View | `frontend/src/views/admin/ArticleFormView.vue` |
| Halaman Publik Terhubung | `/artikel/:slug` (`frontend/src/views/ArticleDetailView.vue`) |

### 4.1 Fitur Utama Editor Artikel
1. **Mode Dual Tab (Editor Formulir vs Pratinjau Tampilan Publik)**:
   - Tab **Editor Formulir**: Form komprehensif untuk menulis konten, mengatur metadata, memilih gambar, dan status publikasi.
   - Tab **Pratinjau Tampilan Publik**: Merender simulasi langsung dari tampilan artikel persis seperti yang akan dilihat oleh pengunjung di website publik (`/artikel/:slug`), termasuk hero image, badges, baris penulis, lead excerpt, format tipografi, dan kotak aksi konsultasi.
2. **Auto Slug Generator & Pratinjau URL**:
   - Slug URL terbuat otomatis dari judul artikel saat pertama kali ditulis.
   - Tersedia tombol kunci/buka (*lock/unlock*) untuk kustomisasi slug URL manual, serta tampilan pratinjau tautan publik: `https://amanah-tins-center.id/artikel/{slug}`.
3. **Rich Visual Content Toolbar**:
   - Toolbar terpadu yang menyisipkan tag formatting HTML secara instan ke kursor penulis:
     - **Heading**: Judul Bagian (`H2`), Sub Bagian (`H3`).
     - **Format Teks**: Tebal (`<b>`), Miring (`<i>`), Garis Bawah (`<u>`).
     - **Daftar**: Poin List (`<ul><li>`), Penomoran Urut (`<ol><li>`).
     - **Elemen Khusus**: Kotak Sorotan / Edukasi Card (`<div class="callout-card">`), Kutipan Ahli / Blockquote (`<blockquote>`), Tautan Web (`<a>`), Garis Pemisah (`<hr>`).
4. **Sistem Unggah Gambar Sampul Adaptif (Rasio Standar 16:9)**:
   - **Upload File Langsung dari Perangkat**: Admin dapat mengunggah berkas foto (JPG, PNG, WEBP, GIF hingga 5MB) melalui area *drag-and-drop* atau dialog pemilih berkas komputer/ponsel.
   - **Smart Crop HTML5 Canvas 16:9**: Foto yang diunggah secara otomatis dipotong ke rasio resmi 16:9 (1280x720 WebP) berbobot ringan, sehingga gambar dijamin tidak terdistorsi dan tidak terpotong saat ditampilkan di halaman publik.
   - **Kontrol Penyesuaian Fokus (Focal Point Alignment)**:
     - ⬆️ **Atas (*Top*)**: Memprioritaskan bagian atas foto (sangat penting untuk foto orang/anak agar kepala tidak terpotong).
     - ⏺️ **Tengah (*Center*)**: Posisi simetris seimbang (default).
     - ⬇️ **Bawah (*Bottom*)**: Memprioritaskan bagian bawah foto (misal aktivitas di atas meja atau karpet terapi).
   - **Dual Pratinjau Interaktif**: Toggle simulasi langsung antara **Banner Detail (16:9 Hero)** dan **Kartu Katalog (16:9 Card)**.
   - **Penyimpanan Lokal Aman**: Gambar diunggah ke backend melalui endpoint `POST /api/admin/articles/upload-image` dan tersimpan di `storage/app/public/articles/`.
   - **Opsi Alternatif**: Tersedia accordion untuk memasukkan tautan URL eksternal atau memilih dari 4 koleksi preset foto terapi klinik yang terverifikasi aktif.
5. **Penghitung Kata & Auto Estimasi Waktu Baca**:
   - Indikator dinamis yang menghitung jumlah kata artikel secara *real-time*.
   - Mengisi otomatis saran waktu baca (misal: "3 Menit Baca", "5 Menit Baca") dengan rasio rata-rata 180 kata per menit.
6. **Toast Feedback & Validasi Bersih**:
   - Pesan feedback modern menggantikan dialog browser bawaan (`alert()`), memberikan konfirmasi visual instan saat artikel berhasil diterbitkan, disimpan sebagai draf, atau diperbarui.

---

## 5. Sinkronisasi dengan Halaman Publik (`/artikel/:slug`)

1. **Pengambilan Data Dinamis dari Backend**:
   - `frontend/src/views/ArticleDetailView.vue` telah diintegrasikan dengan endpoint `GET /api/articles/{slug}`.
   - Menampilkan judul dinamis, thumbnail dinamis, nama penulis, estimasi waktu baca, lead excerpt, serta konten HTML (`v-html="activeArticle.content"`).
2. **Tipografi & Gaya CSS Khusus Konten (`.article-dynamic-body`)**:
   - Menata otomatis tag HTML (`<h2>`, `<h3>`, `<p>`, `<ul>`, `<ol>`, `<blockquote>`, `.callout-card`, `<img>`, `<a>`) agar serasi dengan identitas visual Amanah Tin's Center (Teal `#006384`, Olive Green `#4b6716`, font Outfit & Nunito Sans).
3. **Daftar Artikel Terkait Dinamis**:
   - Mengambil artikel terkait (`related`) dari database berdasarkan spesialisasi kategori yang sama.
4. **Fallback Aman (Graceful Fallback)**:
   - Jika pengguna membuka artikel demo bawaan atau koneksi database offline, template tetap menampilkan konten edukasi percontohan secara mulus tanpa kegagalan render.

---

## 6. Riwayat Pembaruan Teknis

1. **`backend/app/Http/Controllers/Api/ArticleController.php` & `routes/api.php`**:
   - Menambahkan endpoint `POST /api/admin/articles/upload-image` untuk menangani upload gambar sampul ke disk `public/articles`.
   - Menambahkan filter pencarian multi-kolom (`title`, `excerpt`, `author`, `category`).
   - Menambahkan filter status (`published` / `draft`).
   - Mengembalikan ringkasan statistik metrik (`stats`) di dalam response `adminIndex`.
   - Menyesuaikan validasi `update()` menjadi `sometimes|required` sehingga toggle status (`is_published`) dapat dilakukan secara parsial.
2. **`frontend/src/views/admin/ArticlesView.vue`**:
   - Menerapkan desain UI/UX baru dengan 4 kartu metrik interaktif.
   - Mengimplementasikan toolbar gabungan status tab + search bar + category chips + tombol reset.
   - Dual view engine: Desktop Table View (≥ 768px) dan Mobile Card List View (< 768px).
   - Dialog modal konfirmasi hapus artikel dan toast feedback.
   - Perlindungan thumbnail `@error` fallback ke ikon cover.
3. **`frontend/src/views/admin/ArticleFormView.vue`**:
   - Perombakan total form tambah & edit artikel menjadi antarmuka modern terpadu.
   - Menghadirkan Dual-tab: *Editor Formulir* dan *Pratinjau Tampilan Publik (Live Preview)*.
   - **Section Gambar Sampul Adaptif 16:9**: Area upload berkas langsung (drag & drop), pemrosesan canvas smart crop 16:9, kontrol penyesuaian posisi fokus (*top / center / bottom*), dan dual-mode preview (Banner Detail vs Kartu Katalog).
   - Rich toolbar format HTML, preset foto terapi, word counter, auto read-time, dan slug editor.
4. **`frontend/src/views/ArticleDetailView.vue` & `frontend/src/views/ArticlesView.vue`**:
   - Mengintegrasikan pemanggilan API dinamis `GET /api/articles/{slug}` di halaman detail artikel publik.
   - Menambahkan CSS styling tipografi `.article-dynamic-body` untuk merender konten editor admin secara presisi di website publik.
   - Menyelaraskan kartu thumbnail di katalog publik `/artikel` agar memuat gambar artikel yang disimpan dari admin.

