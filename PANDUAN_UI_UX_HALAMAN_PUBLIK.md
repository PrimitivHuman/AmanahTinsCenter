# Panduan Audit & Rencana Penyempurnaan UI/UX Halaman Publik
## Amanah Tin's Center - Klinik Tumbuh Kembang & Terapi Anak

---

## Daftar Isi
1. [Landasan Psikologi Pengguna & Profil Audiens](#1-landasan-psikologi-pengguna--profil-audiens)
2. [Audit UI/UX Mendalam per Halaman Publik](#2-audit-uiux-mendalam-per-halaman-publik)
   - [2.1 Header & Navigasi Bar (`TheNavbar.vue`)](#21-header--navigasi-bar-thenavbarvue)
   - [2.2 Halaman Beranda (`HomeView.vue`)](#22-halaman-beranda-homeviewvue)
   - [2.3 Katalog Layanan & Detail Layanan (`ServicesView.vue` & `ServiceDetailView.vue`)](#23-katalog-layanan--detail-layanan-servicesviewvue--servicedetailviewvue)
   - [2.4 Direktori Tim Medis (`TeamView.vue`)](#24-direktori-tim-medis-teamviewvue)
   - [2.5 Portal Artikel & Detail Bacaan (`ArticlesView.vue` & `ArticleDetailView.vue`)](#25-portal-artikel--detail-bacaan-articlesviewvue--articledetailviewvue)
   - [2.6 Jadwal & Pendaftaran (`ScheduleView.vue`)](#26-jadwal--pendaftaran-scheduleviewvue)
   - [2.7 Footer & Floating WhatsApp Widget (`TheFooter.vue`)](#27-footer--floating-whatsapp-widget-thefootervue)
3. [Fitur Unggulan Rekomendasi (High-Impact UI/UX Features)](#3-fitur-unggulan-rekomendasi-high-impact-uiux-features)
4. [Pedoman Desain Sistem, Aksesibilitas, & Estetika Visual](#4-pedoman-desain-sistem-aksesibilitas--estetika-visual)
5. [Roadmap & Tahapan Eksekusi Perbaikan (Action Plan)](#5-roadmap--tahapan-eksekusi-perbaikan-action-plan)

---

## 1. Landasan Psikologi Pengguna & Profil Audiens

Website klinik tumbuh kembang anak memiliki dinamika interaksi yang sangat emosional dibandingkan website komersial biasa.

### Persona Pengguna: "Ayah & Bunda Ananda (Usia 2–7 Tahun)"
- **Kondisi Emosional**: Sering kali berada dalam fase cemas (*anxiety*), bingung, atau takut terlambat menstimulasi (*"Apakah anak saya speech delay atau ADHD? Kenapa belum bicara padahal teman sebayanya sudah?"*).
- **Kebutuhan Utama**:
  1. **Rasa Aman & Empati**: Suasana klinik yang hangat, tidak menakutkan bagi anak (*non-stigma*), dan ramah keluarga.
  2. **Kredibilitas Klinis**: Kepastian bahwa terapis memiliki izin STR Kemenkes dan pendekatan berbasis bukti ilmiah (*evidence-based*).
  3. **Kemudahan Tanpa Hambatan (*Frictionless Action*)**: Proses konsultasi yang cepat tanpa formulir birokratis berbelit-belit.

```mermaid
journey
    title Perjalanan Emosional Orang Tua di Website ATC
    section Tahap 1: Pencarian
      Mencari info keterlambatan bicara/sensori: 3: Orang Tua
      Membuka Website ATC: 4: Orang Tua
    section Tahap 2: Evaluasi & Kepercayaan
      Melihat foto fasilitas & keramahan terapis: 5: Orang Tua
      Membaca testimoni orang tua lain: 5: Orang Tua
      Mencocokkan gejala anak dengan program terapi: 4: Orang Tua
    section Tahap 3: Keputusan
      Mengisi formulir jadwal / Chat WhatsApp: 5: Orang Tua
      Mendapatkan konfirmasi jadwal asesmen: 5: Orang Tua
```

---

## 2. Audit UI/UX Mendalam per Halaman Publik

### 2.1 Header, Navigasi Bar, & Floating WhatsApp ([TheNavbar.vue](file:///c:/laragon/www/AmanahTinsCenter/frontend/src/components/TheNavbar.vue) & [WhatsAppWidget.vue](file:///c:/laragon/www/AmanahTinsCenter/frontend/src/components/WhatsAppWidget.vue))

```
[ Logo ATC + Tagline ]     [ Beranda | Tentang | Layanan | Tim | Artikel | Jadwal | Kontak ]   [ Hamburger Mobile ]
```

#### ✅ Penyesuaian Desain yang Telah Diimplementasikan:
1. **Navbar Single-Tier Bersih & Lega**: Top clinical micro-bar ditiadakan sesuai preferensi desain agar header tetap minimalis, tinggi proporsional (80px normal, 72px saat scrolled), dan fokus pada konten utama.
2. **Pengembalian Menu "Kontak"**: Menu `Kontak` telah dikembalikan secara resmi ke jajaran navigasi desktop dan mobile drawer (`#kontak`), dilengkapi deteksi aktif otomatis berbasis posisi scroll (`activeSection`).
3. **Penyederhanaan Header**: Tombol *"Tanya WA"* dan *"Jadwalkan Konsultasi"* dihapus dari bilah navigasi kanan untuk menghilangkan kesan padat dan menghindari duplikasi fungsi tindakan.
4. **Transformasi Pop-Up Logo WhatsApp Menjadi Fitur "Tanya WA" Terpadu**:
   - Dibuat komponen interaktif [WhatsAppWidget.vue](file:///c:/laragon/www/AmanahTinsCenter/frontend/src/components/WhatsAppWidget.vue) di sudut kanan bawah.
   - Tombol floating tampil minimalis dan bersih **hanya Logo WhatsApp saja** dengan efek ripple halus (*pulsing wave*).
   - Membuka kartu dialog konsultasi ramah keluarga berisi:
     - Avatar resmi klinik ATC & status *Online (Respon Cepat)*.
     - Gelembung sapaan hangat dari Koordinator Layanan ATC.
     - **Pilihan Topik Pertanyaan Cepat**: Konsultasi Tumbuh Kembang, Tanya Terapi Wicara, Tanya Sensori Integrasi, Cek Jadwal Pasien Baru, dan Info Biaya.
     - Kotak pesan bebas dan tombol langsung kirim ke WhatsApp resmi klinik (+62 821-8889-9900 yang terintegrasi dinamis dengan API pengaturan klinik).


---

### 2.2 Halaman Beranda ([HomeView.vue](file:///c:/laragon/www/AmanahTinsCenter/frontend/src/views/HomeView.vue))

#### ✅ Penyesuaian yang Telah Diimplementasikan:
1. **Penggantian Avatar Inisial Menjadi Foto Asli**: Lingkaran teks `"TW"`, `"OT"`, `"SI"` pada hero trust section telah diganti dengan tumpukan foto asli (*stacked circular photo avatars*) orang tua dan anak ceria bersama badge `+400` serta nilai rating nyata `4.9/5.0`.
2. **Foto Asli Tim Medis & Terapis**: Seluruh kartu tim di halaman beranda kini menampilkan foto wajah terapis dan dokter spesialis anak beresolusi tinggi, lengkap dengan lencana gelar profesi (*Dokter Spesialis Anak, Kepala Terapis Wicara, Terapis Okupasi Senior, Praktisi C.SI*), status legalitas izin `STR/SIP Kemenkes Aktif`, tag fokus intervensi, dan tombol langsung konsultasi.
3. **Penambahan Section "Cerita Ayah & Bunda" (Testimoni & Kisah Nyata)**:
   - Dihadirkan section bukti sosial interaktif dengan ringkasan metrik klinik (*Rating 4.9/5.0, 400+ Keluarga, 98.4% Kemajuan, 100% STR Resmi*).
   - 3 kartu studi kasus perjalanan terapi nyata (Speech delay pada Ananda Kenzo, hipersensitif sensori pada Ananda Aisyah, dan motorik halus pada Ananda Arkan) dengan format komparasi: *Kondisi Awal* ➔ *Kutipan Orang Tua* ➔ *Daftar Kemajuan Teramati* ➔ *Durasi Terapi*.
   - Ditutup dengan bilah ajakan bertindak (*CTA strip*) terintegrasi WhatsApp resmi dan pendaftaran asesmen awal.
4. **Pembaruan Foto Fasilitas Ruang Terapi ("Tentang Kami")**: Mengganti foto lama yang memiliki mockup bilah website tiruan dengan foto fotografi interior ruang sensori & terapi pediatrik modern beresolusi tinggi (`/ruang-terapi-atc.jpg`), menampilkan ayunan sensori, matras warna-warni, rak permainan edukatif, dan pencahayaan hangat alami, lengkap dengan lencana *Fasilitas Terakreditasi & Higienis*.

---

### 2.3 Katalog Layanan & Detail Layanan ([ServicesView.vue](file:///c:/laragon/www/AmanahTinsCenter/frontend/src/views/ServicesView.vue) & [ServiceDetailView.vue](file:///c:/laragon/www/AmanahTinsCenter/frontend/src/views/ServiceDetailView.vue))

#### ❌ Masalah Saat Ini:
1. **Penyajian Masih Terlalu Teknis Klinis**: Orang tua awam lebih mengenali masalah berdasarkan perilaku harian anak (*"Anak sering tantrum kalau mendengar blender"*, *"Anak belum bisa menunjuk benda"*), bukan nama latin terapi.
2. **Detail Layanan Sangat Padat Teks (*Text Heavy*)**: Penjelasan indikasi dan tahapan berupa daftar teks panjang yang rentan membuat orang tua lelah membaca (*cognitive overload*).
3. **Tombol Paket Biaya Tidak Meneruskan Pilihan**: Pada kartu biaya (*Asesmen Awal*, *Paket 4x*, *Paket 8x*), tombol *"Pilih Paket"* belum membawa data paket tersebut ke halaman booking.

#### 💡 Rekomendasi Solusi:
- **Fitur Interaktif "Therapy Matcher" (Panduan Berbasis Gejala)**:
  Sediakan 4 kartu filter keluhan di bagian atas [ServicesView.vue](file:///c:/laragon/www/AmanahTinsCenter/frontend/src/views/ServicesView.vue):
  - *"Anak belum lancar bicara di usia 2 tahun?"* ➔ Rekomendasi: **Terapi Wicara**
  - *"Anak mudah kaget, hiperaktif, atau takut tekstur?"* ➔ Rekomendasi: **Sensori Integrasi**
  - *"Anak kesulitan memegang sendok atau mengancing baju?"* ➔ Rekomendasi: **Terapi Okupasi**
  - *"Anak sulit berkonsentrasi atau emosi meledak-ledak?"* ➔ Rekomendasi: **Psikologi Anak**
- **Infografis Alur 4 Tahap Terapi**: Tampilkan tahapan visual dengan ikon:
  `1. Asesmen Menyeluruh` ➔ `2. Penyusunan IEP (Individualized Education Program)` ➔ `3. Sesi Terapi Play-based` ➔ `4. Evaluasi & Panduan di Rumah`.
- **Pre-filled Data pada Pemilihan Paket**: Klik pada tombol paket biaya otomatis membuka pendaftaran dengan parameter paket terpilih (`/jadwal-pendaftaran?layanan=terapi-wicara&paket=paket-4-sesi`).

---

### 2.4 Direktori Tim Medis ([TeamView.vue](file:///c:/laragon/www/AmanahTinsCenter/frontend/src/views/TeamView.vue))

#### ✅ Penyesuaian Desain yang Telah Diimplementasikan:
1. **Bilah Tab Kategori & Pencarian Instan (Live Filter & Search)**:
   - Disediakan 5 tab filter spesialisasi dengan counter dinamis:
     - `Semua Praktisi (12)`
     - `Terapi Wicara (TW) (4)`
     - `Terapi Okupasi (OT) (3)`
     - `Sensori Integrasi (SI) (3)`
     - `Psikolog Anak (2)`
   - Dilengkapi bilah pencarian cerdas real-time (*search bar*) untuk mencari nama terapis, bidang keahlian, atau keluhan spesifik (misal: *Oral Motor, Autisme, Speech Delay, Pra-menulis*).
   - Tampilan *empty state* ramah pengguna jika pencarian tidak menemukan hasil, lengkap dengan tombol reset 1-klik.

2. **Kartu Interaktif & Informatif (Active Affordance)**:
   - **Efek Visual Aktif**: Efek hover interaktif (*lift up* `-4px`), bayangan elevasi halus, dan ring aksen warna border spesialisasi.
   - **Lencana Legalitas Resmi**: Badge `STR Aktif Kemenkes` / `SIPP Aktif HIMPSI` dengan indikator titik hijau (*live pulse*).
   - **Chip Jadwal Praktik**: Menampilkan ringkasan hari & jam praktik di klinik Jagakarsa langsung pada kartu.
   - **2 Tombol Aksi Cepat**:
     - Tombol *"Lihat Profil & Jadwal"*: Membuka dialog pop-up modal profil lengkap.
     - Tombol *"Jadwalkan"*: Membuka WhatsApp dengan pesan otomatis terisi nama terapis, spesialisasi, dan jadwal praktik.

3. **Modal Dialog Profil & Kredensial Lengkap (`<Teleport to="body">`)**:
   - Foto potret besar terapis dengan lencana ikon keahlian.
   - Detail Nomor Registrasi STR Kemenkes / SIPP HIMPSI resmi & lama pengalaman klinis.
   - Kotak sorotan hari dan jam praktik spesifik di klinik Jagakarsa.
   - **Filosofi & Pendekatan Terapi**: Kutipan personal pendekatan terapis saat menangani buah hati.
   - **Daftar Sertifikasi & Keahlian Klinis**: Daftar checklist kompetensi khusus (misal: *Oral Placement Therapy, PECS, Bobath/SI, Denver II, Handwriting Without Tears*).
   - Tombol reservasi langsung via WhatsApp dan navigasi ke formulir pendaftaran.
   - Penutupan modal yang intuitif: tombol silang, klik backdrop luar, maupun tombol keyboard `Escape`.

---

### 2.5 Portal Artikel & Detail Bacaan ([ArticlesView.vue](file:///c:/laragon/www/AmanahTinsCenter/frontend/src/views/ArticlesView.vue) & [ArticleDetailView.vue](file:///c:/laragon/www/AmanahTinsCenter/frontend/src/views/ArticleDetailView.vue))

#### ✅ Penyesuaian Desain yang Telah Diimplementasikan:
1. **Sticky Reading Progress Bar**:
   - Tersemat halus di bagian paling atas layar (`height: 4px`, bergradasi `#006384` ke `#00a2c7` hingga `#16a34a`) dengan pantulan cahaya (*glow* halus).
   - Menghitung persentase scroll pembacaan konten editorial secara akurat dan real-time (*0% - 100%*).
2. **Sticky Table of Contents (Daftar Isi Cepat)**:
   - Terintegrasi rapi pada widget paling atas di sidebar kanan (`position: sticky; top: 100px;`) yang mengikuti scroll pengguna.
   - Dilengkapi *scroll spy* otomatis: sub-bab yang sedang aktif dibaca disorot dengan warna primer dan panah penunjuk.
   - Setiap bab dapat diklik untuk melompat mulus (*smooth scroll*) dengan kompensasi offset tinggi navbar.
   - Disediakan *quick jump dropdown* khusus untuk pengguna smartphone/tablet di bagian atas artikel.
3. **Web Share API & Salin Link Interaktif**:
   - Mendukung integrasi Web Share API bawaan perangkat (Android, iOS, macOS, Windows) dengan tombol share satu-klik.
   - Tombol salin tautan dilengkapi notifikasi melayang (*Toast Notification*) modern tanpa `alert()` bawaan browser yang kaku.
   - Tombol bagikan via WhatsApp menyusun pesan pengantar ramah keluarga dan judul artikel secara otomatis.
4. **Penyimpanan Bookmark Nyata (`localStorage`)**:
   - Dibuat composable terpusat [useBookmarks.js](file:///c:/laragon/www/AmanahTinsCenter/frontend/src/composables/useBookmarks.js) dengan sinkronisasi multi-tab/window.
   - Orang tua dapat menyimpan artikel dari kartu katalog di [ArticlesView.vue](file:///c:/laragon/www/AmanahTinsCenter/frontend/src/views/ArticlesView.vue) maupun dari halaman detail [ArticleDetailView.vue](file:///c:/laragon/www/AmanahTinsCenter/frontend/src/views/ArticleDetailView.vue).
   - Disediakan tab filter khusus **"Tersimpan (X)"** pada katalog artikel dengan badge jumlah artikel tersimpan secara dinamis dan tampilan *empty state* ramah pengguna.

---

### 2.6 Jadwal & Pendaftaran ([ScheduleView.vue](file:///c:/laragon/www/AmanahTinsCenter/frontend/src/views/ScheduleView.vue)) — *Prioritas Utama UX*

> [!IMPORTANT]
> Halaman ini merupakan titik konversi paling krusial bagi seluruh klinik. Saat ini halaman ini hanya berisi panduan teks statis dan tombol link WhatsApp.

#### ❌ Hambatan UX Saat Ini (*Friction Points*):
- Orang tua yang menekan tombol WhatsApp tiba di ruang obrolan kosong.
- Mereka bingung harus memulai dari mana, canggung, atau merasa repot mengetik rincian kondisi anak dari nol.
- Data janji temu tidak tercatat secara digital di sistem database klinik.

#### 💡 Rekomendasi Solusi: Formulir Pendaftaran 2 Langkah Interaktif
Rancang antarmuka formulir bertahap yang ramah dan menyenangkan:

```
[ Langkah 1: Profil Buah Hati ]
- Nama Orang Tua & No. WhatsApp Aktif
- Nama Panggilan Anak & Usia (Contoh: 2 Tahun 6 Bulan)

[ Langkah 2: Kebutuhan & Waktu Terapi ]
- Pilihan Terapi (Wicara / Okupasi / Sensori / Psikologi)
- Pilihan Sesi Waktu (Pagi: 08.30-11.30 / Siang: 13.00-15.00 / Sore: 15.30-17.00)
- Catatan Gejala / Keluhan Singkat

[ Tombol Kirim ]
Opsi A: "Simpan Pendaftaran ke Database Klinik"
Opsi B: "Kirim & Lanjutkan Langsung ke WhatsApp" (Otomatis menyusun teks terformat)
```

**Contoh Pesan WhatsApp yang Otomatis Dihasilkan:**
> *"Halo Admin Amanah Tin's Center, saya Bunda Fitri ingin konfirmasi pendaftaran jadwal asesmen untuk ananda Kenzi (2 tahun 8 bulan) pada layanan Terapi Wicara untuk sesi Pagi. Mohon informasi ketersediaan jadwal terapis. Terima kasih."*

---

### 2.7 Footer & Floating WhatsApp Widget ([TheFooter.vue](file:///c:/laragon/www/AmanahTinsCenter/frontend/src/components/TheFooter.vue))

#### ❌ Masalah Saat Ini:
1. **Floating WhatsApp Terlalu Pasif**: Hanya tombol bulat/pil statis yang sering diabaikan pengunjung.
2. **Tautan Medsos Mati**: Ikon Instagram dan Facebook di footer masih menggunakan `href="#"`.

#### 💡 Rekomendasi Solusi:
- **Proactive Greeting Bubble pada Tombol WhatsApp**:
  Setelah pengunjung menelusuri halaman selama 6 detik, munculkan balon sapaan ramah di atas tombol:
  > *"Halo Ayah & Bunda! Ingin bertanya seputar tumbuh kembang ananda atau jadwal terapi? Tim terapis kami siap membantu di WhatsApp ya 👋"*
  *(Dilengkapi tombol silang kecil untuk menutup balon pesan)*.
- **Tautan Resmi Medsos & Google Maps**: Tautkan ke akun Instagram resmi klinik dan sematkan tombol langsung membuka rute Google Maps klinik Jagakarsa.

---

## 3. Fitur Unggulan Rekomendasi (High-Impact UI/UX Features)

Berikut adalah 4 fitur pembeda yang akan membuat antarmuka website klinik terasa jauh lebih modern, ramah, dan profesional dibandingkan klinik lain:

### 1. "Screening Mandiri Cepat (Red Flags Checker)"
Widget 3 langkah sederhana di mana orang tua memilih rentang usia anak (misal: 12-18 bulan, 18-24 bulan, 2-3 tahun) lalu sistem menampilkan 3 tanda bahaya perkembangan bahasa dan motorik. Jika ada tanda yang cocok, sistem menyarankan konsultasi.

### 2. "Interactive WhatsApp Generator"
Alat pembuat pesan konsultasi otomatis yang menghilangkan rasa canggung orang tua dalam memulai percakapan pertama ke klinik.

### 3. "Before & After Milestone Showcase"
Penyajian visual capaian milestone perkembangan anak (misal: *Kontak Mata Meningkat*, *Kosakata Bertambah*, *Regulasi Emosi Stabil*) berdasarkan studi kasus tanpa menampilkan privasi anak secara sensitif.

### 4. "Terapis Matcher & Jadwal Harian"
Tampilan interaktif ketersediaan sesi terapis per hari (Sesi Pagi, Siang, Sore) dengan status kuota transparan (*Tersedia / Terbatas*).

---

## 4. Pedoman Desain Sistem, Aksesibilitas, & Estetika Visual

Untuk menjaga tema *"Warm Child Development Sanctuary"*:

### Palet Warna Harmonis:
- **Teal / Ocean Sage (`#006384` / `#007d9b`)**: Memberikan kesan kredibel, higienis, dan terstandar medis.
- **Warm Amber / Honey (`#b37400` / `#fff2df`)**: Memberikan kehangatan emosional dan keramahan anak.
- **Soft Fern Green (`#2f6c00` / `#ebf8de`)**: Melambangkan pertumbuhan, kesehatan, dan harapan.
- **Cloud Neutral (`#f7f9fc` / `#f0f4f9`)**: Latar belakang yang nyaman di mata tanpa silau.

### Tipografi:
- **Headline & Display**: *Outfit* (Google Fonts) — modern, bersudut membulat ramah anak, dan terbaca jelas.
- **Body & Teks Bacaan**: *Nunito Sans* — memiliki keterbacaan tinggi (*high legibility*) bahkan untuk orang tua yang membaca sambil menggendong anak.

### Prinsip Aksesibilitas (WCAG 2.1 AA):
- Pastikan rasio kontras teks terhadap latar belakang minimal **4.5:1** (hindari teks abu-abu muda di atas warna putih).
- Setiap tombol memiliki area sentuh (*tap target*) minimal **44 x 44 piksel** agar mudah ditekan di smartphone.
- Berikan micro-interaction hover (efek mengangkat halus `transform: translateY(-3px)`) pada setiap kartu interaktif.

---

## 5. Roadmap & Tahapan Eksekusi Perbaikan (Action Plan)

| Urutan | Modul Halaman | Fokus Pekerjaan UI/UX | Status | Prioritas |
| :--- | :--- | :--- | :---: | :---: |
| **Tahap 1** | **Halaman Beranda** ([HomeView.vue](file:///c:/laragon/www/AmanahTinsCenter/frontend/src/views/HomeView.vue)) | Foto asli terapis, section Testimoni "Cerita Ayah & Bunda", avatar sosial, foto riil Tentang Kami. | **SELESAI ✅** | ⭐⭐⭐⭐⭐ |
| **Tahap 2** | **Katalog & Detail Layanan** ([ServicesView.vue](file:///c:/laragon/www/AmanahTinsCenter/frontend/src/views/ServicesView.vue) & [ServiceDetailView.vue](file:///c:/laragon/www/AmanahTinsCenter/frontend/src/views/ServiceDetailView.vue)) | Therapy Matcher keluhan harian, checklist deteksi interaktif, tabbed kurikulum bento, FAQ accordion, pre-fill booking. | **SELESAI ✅** | ⭐⭐⭐⭐ |
| **Tahap 3** | **Direktori Tim Medis** ([TeamView.vue](file:///c:/laragon/www/AmanahTinsCenter/frontend/src/views/TeamView.vue)) | Tab filter kategori terapis wicara/okupasi/sensori + modal profil STR & tombol booking langsung. | **SELESAI ✅** | ⭐⭐⭐⭐ |
| **Tahap 4** | **Jadwal & Pendaftaran** ([ScheduleView.vue](file:///c:/laragon/www/AmanahTinsCenter/frontend/src/views/ScheduleView.vue)) | Transformasi formulir booking interaktif langkah-demi-langkah + generator WhatsApp otomatis. | Menunggu | ⭐⭐⭐⭐⭐ |
| **Tahap 5** | **Portal Artikel & Detail Bacaan** ([ArticlesView.vue](file:///c:/laragon/www/AmanahTinsCenter/frontend/src/views/ArticlesView.vue)) | Reading progress bar, Table of Contents interaktif, Web Share API, bookmark localStorage. | **SELESAI ✅** | ⭐⭐⭐ |
