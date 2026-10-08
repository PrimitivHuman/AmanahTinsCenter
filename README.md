# Amanah Tin's Center - Website & Sistem Informasi Klinik Tumbuh Kembang Anak

Sistem informasi dan website resmi **Amanah Tin's Center** yang diimplementasikan secara komprehensif berdasarkan desain antarmuka blueprint di folder `stitch_blueprint_website_implementation`. Sistem ini memadukan **Frontend Vue 3** berestetika tinggi dan responsif dengan **Backend Laravel 11** serta basis data **MySQL**.

---

## 🚀 Arsitektur & Teknologi

- **Frontend**:
  - [Vue 3](https://vuejs.org/) (Composition API, `<script setup>`)
  - [Vite](https://vitejs.dev/) (Bundler performa tinggi)
  - [Vue Router 4](https://router.vuejs.org/) (SPA Routing dengan Auth Guards)
  - [Pinia](https://pinia.vuejs.org/) (State management untuk sesi admin)
  - [Axios](https://axios-http.com/) (HTTP Client dengan Interceptor Token)
  - [Google Fonts](https://fonts.google.com/) (*Outfit* untuk display & headline, *Nunito Sans* untuk body)
  - [Material Symbols Outlined](https://fonts.google.com/icons) (Ikonografi klinis terstandar)
  - Desain kustom berakar pada tema *Warm Child Development Sanctuary* (Warna Teals, Sage, Amber, dan Card Borders lembut).

- **Backend**:
  - [Laravel 11](https://laravel.com/) (RESTful API architecture)
  - [Laravel Sanctum](https://laravel.com/docs/sanctum) (Bearer Token API Authentication)
  - [MySQL 8.0](https://www.mysql.com/) (Laragon Database `amanah_tins_center`)
  - Eloquent ORM, Migrations, & Seeders

---

## 📂 Struktur Halaman & Fitur

### 1. Halaman Publik (Orang Tua & Pengunjung)
| Rute URL | Komponen Vue | Deskripsi |
| :--- | :--- | :--- |
| `/` | `HomeView.vue` | Beranda utama, 4 pilar terapi, keunggulan, tim terapis, testimoni, artikel unggulan, dan CTA pendaftaran. |
| `/tentang-kami` | `AboutView.vue` | Visi, misi, nilai-nilai klinik, sejarah pendirian, fasilitas ramah anak, dan komitmen profesional. |
| `/layanan` | `ServicesView.vue` | Katalog 4 pilar terapi: Terapi Wicara, Terapi Okupasi, Sensori Integrasi, dan Fisioterapi Pediatrik / Psikologi Anak. |
| `/layanan/:slug` | `ServiceDetailView.vue` | Rincian lengkap indikasi, proses asesmen awal, sesi terapi, dan tombol pendaftaran per layanan. |
| `/tim-kami` | `TeamView.vue` | Profil dokter anak, terapis wicara, okupasi, dan sertifikasi keahlian. |
| `/artikel` | `ArticlesView.vue` | Pusat artikel & tips stimulasi tumbuh kembang anak dengan filter kategori interaktif. |
| `/artikel/:slug` | `ArticleDetailView.vue` | Pembaca artikel lengkap, estimasi waktu baca, counter pembaca, dan artikel terkait. |
| `/jadwal-pendaftaran` | `ScheduleView.vue` | Formulir booking jadwal konsultasi, pemilihan sesi waktu, keluhan anak, dan info jam buka klinik. |

### 2. Portal Admin & Terapis
| Rute URL | Komponen Vue | Deskripsi |
| :--- | :--- | :--- |
| `/admin/login` | `admin/LoginView.vue` | Halaman login split-screen aman dengan pengisian instan kredensial demo. |
| `/admin/dashboard` | `admin/DashboardView.vue` | Metrik statistik real-time (Pendaftaran janji, terapis, artikel, pembaca), 5 pendaftaran terbaru, dan aksi cepat. |
| `/admin/jadwal` | `admin/ScheduleView.vue` | Manajemen janji konsultasi, filter status (Menunggu, Dikonfirmasi, Selesai, Dibatalkan), dan tombol langsung chat WhatsApp ke orang tua. |
| `/admin/artikel` | `admin/ArticlesView.vue` | Pengelolaan artikel tips, filter kategori, pencarian instan, toggle terbit/draf, dan hapus artikel. |
| `/admin/artikel/baru` | `admin/ArticleFormView.vue` | Form penulisan materi edukasi baru dengan helper tag HTML, pratinjau gambar sampul, dan opsi status terbit. |
| `/admin/artikel/:id/edit`| `admin/ArticleFormView.vue` | Mode edit untuk memperbarui konten dan metadata artikel yang ada. |
| `/admin/tim-kami` | `admin/TeamView.vue` | Manajemen tim tenaga medis, modal tambah & edit terapis, spesialisasi, dan status aktif. |
| `/admin/pengaturan` | `admin/SettingsView.vue` | Konfigurasi profil resmi klinik, nomor WhatsApp pendaftaran, jam operasional hari kerja & akhir pekan, serta media sosial. |

---

## 🔐 Kredensial Admin Bawaan

Kredensial berikut telah disematkan melalui database seeder:
- **Email:** `admin@amanahtinscenter.com`
- **Kata Sandi:** `admin123`

*(Terdapat juga tombol klik sekali di halaman `/admin/login` untuk mengisi otomatis kredensial pengujian)*

---

## 🛠️ Panduan Menjalankan Sistem

### Persyaratan:
- Laragon aktif (Apache/Nginx & MySQL running)
- PHP >= 8.2 (Terinstal di sistem: PHP 8.4)
- Node.js & npm

### 1. Menjalankan Backend Laravel
Buka terminal di folder backend:
```bash
cd c:\laragon\www\AmanahTinsCenter\backend

# Jalankan server API Laravel
php artisan serve
```
Backend API akan berjalan di: **`http://localhost:8000`**

### 2. Menjalankan Frontend Vue.js
Buka terminal di folder frontend:
```bash
cd c:\laragon\www\AmanahTinsCenter\frontend

# Jalankan server pengembangan Vite
npm run dev
```
Frontend Vue.js akan berjalan di: **`http://localhost:5173`**

### 3. Build Produksi (Opsional)
```bash
cd c:\laragon\www\AmanahTinsCenter\frontend
npm run build
```
Hasil kompilasi siap produksi akan tersedia di direktori `frontend/dist/`.

---

## 🗄️ Skema Database MySQL (`amanah_tins_center`)

1. **`users`**: Akun login administrator dengan enkripsi bcrypt dan Laravel Sanctum token.
2. **`articles`**: Menyimpan artikel tips edukasi anak (`title`, `slug`, `category`, `excerpt`, `content`, `author`, `image`, `read_time`, `is_published`, `views_count`).
3. **`team_members`**: Profil tenaga medis klinik (`name`, `role`, `specialization`, `bio`, `experience_years`, `certifications`, `image`, `is_active`, `order`).
4. **`appointments`**: Data pendaftaran janji konsultasi (`parent_name`, `child_name`, `child_age`, `phone`, `email`, `service_type`, `preferred_date`, `preferred_time`, `notes`, `status`, `admin_notes`).
5. **`clinic_settings`**: Informasi resmi klinik (`clinic_name`, `tagline`, `phone`, `whatsapp`, `email`, `address`, `maps_url`, `weekday_hours`, `weekend_hours`, `instagram`, `facebook`, `youtube`, `about_summary`).
