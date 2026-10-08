<template>
  <PublicLayout>

    <!-- ===== HERO SECTION ===== -->
    <section class="hero-section">
      <!-- decorative blobs -->
      <div class="blob blob-right"></div>
      <div class="blob blob-left"></div>

      <div class="container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb" aria-label="Breadcrumb">
          <router-link to="/" class="bc-link">
            <span class="material-symbols-outlined" style="font-size:14px">home</span>
            Beranda
          </router-link>
          <span class="material-symbols-outlined bc-sep" style="font-size:14px">chevron_right</span>
          <span class="bc-active">Tim Kami</span>
        </nav>

        <div class="hero-content">
          <div class="hero-badge">
            <span class="material-symbols-outlined" style="font-size:16px">verified_user</span>
            <span>Tenaga Ahli Berlisensi &amp; Berpengalaman</span>
          </div>
          <h1 class="hero-title">Mengenal Tim Terapis &amp; Tenaga Medis Kami</h1>
          <p class="hero-desc">
            Didukung oleh tim profesional terapis wicara, okupasi, sensori integrasi, dan psikolog anak yang berdedikasi penuh dengan pendekatan empatik, ramah anak, dan berbasis bukti ilmiah di Jagakarsa.
          </p>
        </div>
      </div>
    </section>

    <!-- ===== TEAM GRID SECTION ===== -->
    <section class="team-section">
      <div class="container">
        <!-- Section Header -->
        <div class="team-header">
          <div>
            <span class="team-eyebrow">Terapis Praktisi</span>
            <h2 class="team-title">Tim Terapis Berpengalaman Kami</h2>
            <p class="team-sub">
              Seluruh terapis Amanah Tin's Center mengantongi Surat Tanda Registrasi (STR) aktif dari Kementerian Kesehatan Republik Indonesia dengan sertifikasi keahlian spesifik.
            </p>
          </div>
          <div class="team-count-note">Seluruh 12 Tenaga Medis &amp; Terapis Bersertifikasi</div>
        </div>

        <!-- Cards Grid (12 members, 4 per row) -->
        <div class="team-grid">
          <div
            v-for="member in teamMembers"
            :key="member.name"
            class="member-card"
          >
            <!-- Photo with overlay badges -->
            <div class="member-photo-wrap">
              <img :src="member.photo" :alt="member.name" class="member-photo" />
              <span class="badge-specialty" :class="`badge-${member.color}`">
                <span class="material-symbols-outlined" style="font-size:14px">{{ member.icon }}</span>
                {{ member.specialty }}
              </span>
              <span class="badge-str">{{ member.str }}</span>
            </div>
            <!-- Info -->
            <h3 class="member-name">{{ member.name }}</h3>
            <p class="member-edu">{{ member.edu }}</p>
            <div class="member-focus">
              <span class="focus-label">Fokus Intervensi:</span>
              <div class="focus-tags">
                <span
                  v-for="tag in member.tags"
                  :key="tag"
                  class="focus-tag"
                  :class="`tag-${member.color}`"
                >{{ tag }}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Info footnote -->
        <div class="footnote">
          <div class="footnote-left">
            <span class="material-symbols-outlined" style="font-size:28px; color: var(--primary)">info</span>
            <p>Membutuhkan jadwal terapis spesifik atau ingin menyesuaikan hari terapi setelah jam sekolah? Tim administrasi klinik siap membantu mencocokkan jadwal.</p>
          </div>
          <router-link to="/jadwal-pendaftaran" class="footnote-link">Hubungi Admin Terapi →</router-link>
        </div>
      </div>
    </section>

    <!-- ===== STANDAR MUTU SECTION ===== -->
    <section class="standards-section">
      <div class="container">
        <div class="standards-header">
          <span class="standards-eyebrow">Komitmen Profesional Kami</span>
          <h2 class="standards-title">Standar Mutu Pelayanan Terapis ATC</h2>
          <p class="standards-sub">Kami menjaga integritas terapi demi rasa aman orang tua dan kenyamanan maksimal setiap buah hati.</p>
        </div>
        <div class="standards-grid">
          <div v-for="std in standards" :key="std.title" class="std-card">
            <div class="std-icon" :class="`std-icon--${std.color}`">
              <span class="material-symbols-outlined" style="font-size:24px">{{ std.icon }}</span>
            </div>
            <h3 class="std-title">{{ std.title }}</h3>
            <p class="std-desc">{{ std.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ===== CTA SECTION ===== -->
    <section class="cta-section" id="daftar">
      <div class="container">
        <div class="cta-card">
          <!-- decorative blobs -->
          <div class="cta-blob cta-blob-br"></div>
          <div class="cta-blob cta-blob-top"></div>

          <div class="cta-inner">
            <div class="cta-content">
              <div class="cta-badge">
                <span class="material-symbols-outlined" style="font-size:16px">support_agent</span>
                <span>Konsultasi &amp; Asesmen Awal Anak</span>
              </div>
              <h2 class="cta-title">Ingin Berkonsultasi Langsung dengan Tim Terapis Kami?</h2>
              <p class="cta-desc">
                Dapatkan pendampingan dan asesmen tumbuh kembang yang paling sesuai dengan kebutuhan buah hati Anda di klinik Amanah Tin's Center Jagakarsa.
              </p>
            </div>
            <div class="cta-actions">
              <a href="https://wa.me/6281234567890" target="_blank" rel="noopener" class="btn-wa">
                <span class="material-symbols-outlined" style="font-size:20px">chat</span>
                <span>Konsultasi via WhatsApp</span>
              </a>
              <router-link to="/jadwal-pendaftaran" class="btn-schedule">
                <span class="material-symbols-outlined" style="font-size:20px">event</span>
                <span>Jadwalkan Asesmen Awal</span>
              </router-link>
            </div>
          </div>

          <div class="cta-footer-info">
            <div class="cta-info-item">
              <span class="material-symbols-outlined" style="font-size:16px">place</span>
              <span>Jl. Raya Jagakarsa No. 12, Jagakarsa, Jakarta Selatan</span>
            </div>
            <div class="cta-info-item">
              <span class="material-symbols-outlined" style="font-size:16px">schedule</span>
              <span>Senin - Sabtu: 08.00 - 17.00 WIB</span>
            </div>
          </div>
        </div>
      </div>
    </section>

  </PublicLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import PublicLayout from '../layouts/PublicLayout.vue'
import api from '../services/api'

// Photos from blueprint (google AI-generated images)
const photos = {
  tw1: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDEqiyk6121gv8ChNiZuew6FvZqYM6PDAblTcYiCp2zrKejXMcq6F6UwgjGu7Iaa3e4rXhIrp_ywvJu9Kz9EhZiKd2459Um-Gc6zqJkmD5lhWLepwgqsb7evjTW02DHYySTvbEICSv5mKabSc6kIEwah6t2brhAK9Ha_QJuZU78_R80wE4TxyfldjEjEqtUW1cwa3Hj7QA3-OuMXKmQRyIu4-9fb9bGbMCfwDx090c',
  ot1: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCqzaTQVtPUaU-jjH7JUkPgscxWU1F6ORXYUDhxi6OwEhZoL2SBGnzy7hEbs44MRtKcZBbwsTnFzF2l3eMKjbUQa0Z9W4BlJC8f0wAWn_6L8BvLrPsxdq6emLK0b9Q6JavjVgzOahGIeLB17EaAciv7FNpjFAQaTcfJj3_WWeQNp1weADSSiald3o28J8AEyY4nyowmBtpig9BqakgYufsRxF22-KKVgSr1dkshnOA',
  si1: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBBtaiTyNRvVyTC0twGu_A_OOgQaPPquYuuzHBM9n1Ox2rtWbSz7r0KQFKvbiPmm2hWx1hQE7R-oFMCgBlZjscdh2-McSZ83oQESA-0NjvPh0UX2UWifpBhfmLjk_H-ZojRnCI7RX-XGhyP2tyTKJDyud5c34H2kj50-7UjoFyauJh1a_2swq37hsQVrcU3gDK0P-5t1Fdc1oqXQ_7tUKjQ0Gz6zW5PT2-nHWAR6JI',
  psi1: 'https://lh3.googleusercontent.com/aida-public/AB6AXuARq7DzRwA-rJhJLIXBolnUBS70HG4EgQhQ6siQc5wOCBPmojR_dvk2D22zt1H83m9tdj8kembmDE-mZ3sWEljXK44nSgZaTnrAqm7C4QW5u4NZcr6AQoBKHsRfV9MuqhXxEuwQjpA75jDPOvR_R4jriqhbU3OZDs7qd2wemWAz8AYy-UczwQfqO5mn9qT_vBHKBRZDijRsi9u7y982VOU1jEuHl9v60nnn8nTiPH8',
  tw2: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAg-SbuarFyTHFwy6n7-DdfmqAdLbXwp19-lc8XwUIbhZsiQI1cZOPZ0BQPr9OK_uL3j0TvLTjdM5nyR-iwSToe8rpDEMwJk27on-HGcWv-EjtIb42028qA_TTiPyhWKjJImEvQ-vBHiZUn480b3Q6EDQoZY1Y8K027i_OrlChJLl8jGnupN5u-cqoorF-P6twjvWEOuY_XrMOR3-UHV9sanWiKQ7S2Vz5A91gP804',
  ot2: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAl_DqJxWl_2en0JAK_7xZM1elQhN7KR1iNkTEhL4nb9YROBU07EDQtZ6Dpsyep4V8if73x-fGx1l5uUv9VISW7Wb7GqFQvXtFYYIiIDLNMgKSkvNYnS0pZ6jzIAkhhLq6SRdf7BGfLziP-1UYw2WdcvQi3af84xIoW0vBCIyxLTyfWzdkNOFqSgeJaFq7qiLcwmWrWD7bjtWLmMRRDdLqGbjzcS4gImINJHkVoEAk',
}

const teamMembers = [
  { name: 'Annisa Larasati, A.Md.TW',         edu: 'Lulusan Akademi Terapi Wicara (ATW) Jakarta',           specialty: 'Terapi Wicara (TW)',       icon: 'record_voice_over', color: 'blue',   str: 'STR Aktif • 6 Th Pengalaman', tags: ['Speech Delay', 'Artikulasi & Gagap', 'Oral Motor'],                    photo: photos.tw1 },
  { name: 'Dimas Bagaswara, S.Tr.Kes (OT)',   edu: 'Sarjana Terapan Terapi Okupasi Poltekkes Surakarta',   specialty: 'Terapi Okupasi (OT)',       icon: 'back_hand',         color: 'amber',  str: 'STR Aktif • 5 Th Pengalaman', tags: ['Motorik Halus', 'Kemandirian Diri (ADL)', 'Kekuatan Genggaman'],       photo: photos.ot1 },
  { name: 'Nurul Fauziah, A.Md.OT, C.SI',     edu: 'Certified Sensory Integration Practitioner',           specialty: 'Sensori Integrasi (SI)',    icon: 'spa',               color: 'green',  str: 'STR Aktif • 7 Th Pengalaman', tags: ['Sensori Vestibular', 'Regulasi Diri', 'Hipersensitif Taktil'],         photo: photos.si1 },
  { name: 'Clara Meisya, M.Psi., Psikolog',   edu: 'Magister Profesi Psikologi Klinis Anak UI',             specialty: 'Psikolog Anak',            icon: 'psychology',        color: 'blue',   str: 'SIPP Aktif • 8 Th Pengalaman', tags: ['Asesmen IQ & Bakat', 'Tantrum & Perilaku', 'Parenting Coaching'],     photo: photos.psi1 },
  { name: 'Fajar Pratama, S.Tr.Kes (TW)',     edu: 'Sarjana Terapan Terapi Wicara',                        specialty: 'Terapi Wicara (TW)',       icon: 'record_voice_over', color: 'blue',   str: 'STR Aktif • 4 Th Pengalaman', tags: ['Komunikasi Pragmatik', 'Bahasa Reseptif', 'Terapi Menelan'],           photo: photos.tw2 },
  { name: 'Rizka Tri Hapsari, A.Md.OT',       edu: 'Spesialisasi Okupasi Pediatrik & Perilaku',            specialty: 'Terapi Okupasi (OT)',       icon: 'back_hand',         color: 'amber',  str: 'STR Aktif • 5 Th Pengalaman', tags: ['Konsentrasi & Duduk Tenang', 'Koordinasi Visual', 'Motorik Kasar'],    photo: photos.ot2 },
  { name: 'Bayu Kurniawan, S.Tr.Kes (SI)',    edu: 'Praktisi Sensori Integrasi & Motorik Anak',             specialty: 'Sensori Integrasi (SI)',    icon: 'spa',               color: 'green',  str: 'STR Aktif • 6 Th Pengalaman', tags: ['Proprioseptif', 'Keseimbangan Tubuh', 'Praksis & Perencanaan Gerak'],  photo: photos.ot1 },
  { name: 'Dewi Sartika, A.Md.TW',            edu: 'Spesialisasi Artikulasi & Fonologi Anak',               specialty: 'Terapi Wicara (TW)',       icon: 'record_voice_over', color: 'blue',   str: 'STR Aktif • 5 Th Pengalaman', tags: ['Kelancaran Wicara', 'Pengucapan Fonem', 'Bahasa Ekspresif'],           photo: photos.tw1 },
  { name: 'Danang Prasetyo, M.Psi., Psikolog',edu: 'Psikolog Perkembangan & Kesiapan Sekolah',              specialty: 'Psikolog Anak',            icon: 'psychology',        color: 'blue',   str: 'SIPP Aktif • 7 Th Pengalaman', tags: ['Sosial Emosional', 'Kesiapan SD', 'Regulasi Emosi'],                  photo: photos.psi1 },
  { name: 'Intan Permatasari, A.Md.OT',       edu: 'Terapi Okupasi Sensori & Koordinasi',                   specialty: 'Terapi Okupasi (OT)',       icon: 'back_hand',         color: 'amber',  str: 'STR Aktif • 4 Th Pengalaman', tags: ['Pramenulis & Menulis', 'Bilateral Integration', 'Motor Planning'],      photo: photos.ot2 },
  { name: 'Hendra Wijaya, S.Tr.Kes (TW)',     edu: 'Praktisi AAC & Komunikasi Autisme',                     specialty: 'Terapi Wicara (TW)',       icon: 'record_voice_over', color: 'blue',   str: 'STR Aktif • 6 Th Pengalaman', tags: ['AAC & PECS', 'Interaksi Resiprokal', 'Autisme (ASD)'],                 photo: photos.tw2 },
  { name: 'Ratih Kusuma, A.Md.OT, C.SI',      edu: 'Praktisi Modulasi & Regulasi Sensori',                  specialty: 'Sensori Integrasi (SI)',    icon: 'spa',               color: 'green',  str: 'STR Aktif • 5 Th Pengalaman', tags: ['Toleransi Sensorik', 'Atensi & Fokus', 'Adaptasi Sensori'],            photo: photos.si1 },
]

const standards = [
  {
    icon: 'verified',
    color: 'blue',
    title: 'Kualifikasi Terverifikasi',
    desc: 'Seluruh terapis adalah lulusan perguruan tinggi terakreditasi dan memiliki Surat Tanda Registrasi (STR) aktif dari Kemkes RI.',
  },
  {
    icon: 'favorite',
    color: 'green',
    title: 'Pendekatan Penuh Kasih',
    desc: 'Metode terapi tanpa paksaan, ramah anak, dan bebas stigma. Terapi dirancang dalam kemasan bermain yang bermakna bagi anak.',
  },
  {
    icon: 'diversity_3',
    color: 'teal',
    title: 'Evaluasi Terpadu Multidisiplin',
    desc: 'Terapis wicara, okupasi, dan psikolog berkolaborasi menyelaraskan target kemajuan anak sehingga intervensi berjalan efektif.',
  },
  {
    icon: 'forum',
    color: 'amber',
    title: 'Diskusi Terbuka Orang Tua',
    desc: 'Setiap akhir sesi terapi disertai laporan evaluasi dan panduan stimulasi sederhana yang mudah dipraktikkan di rumah.',
  },
]
</script>

<style scoped>
/* ============================================================
   HERO
   ============================================================ */
.hero-section {
  position: relative;
  padding: 2.5rem 0 3rem;
  background: linear-gradient(to bottom, rgba(237,244,255,0.7), var(--background));
  overflow: hidden;
}
.blob {
  position: absolute;
  border-radius: 50%;
  pointer-events: none;
  z-index: 0;
  filter: blur(60px);
}
.blob-right {
  width: 280px; height: 280px;
  background: rgba(204, 239, 142, 0.4);
  top: -48px; right: 40px;
}
.blob-left {
  width: 320px; height: 320px;
  background: rgba(193, 232, 255, 0.4);
  top: 80px; left: 25%;
}
.hero-section .container { position: relative; z-index: 1; }

.breadcrumb {
  display: flex; align-items: center; gap: 0.5rem;
  font-size: 12px; color: var(--on-surface-variant);
  margin-bottom: 1.5rem;
}
.bc-link {
  display: flex; align-items: center; gap: 0.25rem;
  color: var(--on-surface-variant); text-decoration: none;
  transition: color 0.2s;
}
.bc-link:hover { color: var(--primary); }
.bc-sep { color: var(--on-surface-variant); }
.bc-active { color: var(--primary); font-weight: 600; }

.hero-content { max-width: 720px; display: flex; flex-direction: column; gap: 1rem; }

.hero-badge {
  display: inline-flex; align-items: center; gap: 0.5rem;
  background: var(--secondary-fixed);
  color: var(--on-secondary-fixed);
  padding: 0.375rem 1rem;
  border-radius: 9999px;
  font-size: 13px; font-weight: 600;
  width: fit-content;
  box-shadow: 0 2px 6px rgba(0,0,0,0.06);
}
.hero-title {
  font-family: var(--font-headline);
  font-size: 48px; font-weight: 700;
  letter-spacing: -0.02em; line-height: 1.2;
  color: var(--on-surface); margin: 0;
}
.hero-desc {
  font-size: 18px; line-height: 1.7;
  color: var(--on-surface-variant); margin: 0;
  max-width: 680px;
}

/* ============================================================
   TEAM SECTION
   ============================================================ */
.team-section { padding: var(--space-xl) 0; background: var(--background); }

.team-header {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  margin-bottom: 2.5rem;
  gap: 1rem;
  flex-wrap: wrap;
}
.team-eyebrow {
  display: inline-block;
  background: var(--surface-container-high);
  color: var(--primary);
  font-size: 12px; font-weight: 700;
  padding: 0.25rem 0.875rem;
  border-radius: 9999px;
  margin-bottom: 0.5rem;
}
.team-title {
  font-family: var(--font-headline);
  font-size: 36px; font-weight: 700;
  color: var(--on-surface); margin: 0 0 0.5rem;
  letter-spacing: -0.015em;
}
.team-sub { font-size: 16px; color: var(--on-surface-variant); max-width: 640px; line-height: 1.6; margin: 0; }
.team-count-note { font-size: 12px; color: var(--on-surface-variant); flex-shrink: 0; }

/* Grid: 4 cols desktop, 2 tablet, 1 mobile */
.team-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1.5rem;
}

/* Member Card */
.member-card {
  background: #fff;
  border: 1px solid rgba(191, 200, 206, 0.3);
  border-radius: var(--radius);
  overflow: hidden;
  padding: 1.25rem;
  display: flex;
  flex-direction: column;
  box-shadow: 0 8px 24px -4px rgba(58, 134, 168, 0.06);
  transition: all 0.3s ease;
  cursor: default;
}
.member-card:hover {
  box-shadow: 0 14px 32px -6px rgba(43, 61, 79, 0.08), 0 4px 12px -2px rgba(167, 201, 87, 0.12);
  transform: translateY(-2px);
}

/* Photo area */
.member-photo-wrap {
  position: relative;
  margin-bottom: 1rem;
}
.member-photo {
  width: 100%;
  height: 192px;
  object-fit: cover;
  border-radius: calc(var(--radius) - 4px);
  display: block;
}
.badge-specialty {
  position: absolute;
  top: 0.75rem; left: 0.75rem;
  display: flex; align-items: center; gap: 0.25rem;
  background: rgba(255,255,255,0.9);
  backdrop-filter: blur(4px);
  border-radius: 9999px;
  padding: 0.25rem 0.75rem;
  font-size: 12px; font-weight: 700;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
.badge-blue   { color: var(--primary); }
.badge-amber  { color: var(--tertiary); }
.badge-green  { color: var(--secondary); }
.badge-str {
  position: absolute;
  bottom: 0.75rem; right: 0.75rem;
  background: var(--secondary-fixed);
  color: var(--on-secondary-fixed);
  border-radius: 9999px;
  padding: 0.25rem 0.625rem;
  font-size: 12px; font-weight: 700;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Member info */
.member-name {
  font-family: var(--font-headline);
  font-size: 17px; font-weight: 700;
  color: var(--on-surface); margin: 0 0 0.25rem;
}
.member-edu {
  font-size: 12px; color: var(--on-surface-variant);
  margin: 0 0 0.75rem; line-height: 1.5;
}
.focus-label {
  display: block;
  font-size: 12px; font-weight: 600;
  color: var(--on-surface-variant);
  margin-bottom: 0.375rem;
}
.focus-tags { display: flex; flex-wrap: wrap; gap: 0.375rem; }
.focus-tag {
  font-size: 12px;
  padding: 0.125rem 0.625rem;
  border-radius: 9999px;
}
.tag-blue  { background: var(--surface-container-low); color: var(--primary); }
.tag-amber { background: rgba(255, 220, 191, 0.4); color: var(--tertiary); }
.tag-green { background: rgba(204, 239, 142, 0.5); color: var(--secondary); }

/* Footnote */
.footnote {
  margin-top: 2.5rem;
  background: var(--surface-container-low);
  border: 1px solid rgba(191,200,206,0.3);
  border-radius: var(--radius);
  padding: 1rem 1.5rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
  flex-wrap: wrap;
}
.footnote-left {
  display: flex; align-items: center; gap: 0.75rem; flex: 1;
}
.footnote-left p { font-size: 14px; color: var(--on-surface); line-height: 1.6; margin: 0; }
.footnote-link {
  font-size: 13px; font-weight: 700;
  color: var(--primary); text-decoration: none;
  white-space: nowrap;
}
.footnote-link:hover { text-decoration: underline; }

/* ============================================================
   STANDARDS SECTION
   ============================================================ */
.standards-section {
  padding: var(--space-xl) 0;
  background: rgba(237, 244, 255, 0.6);
  border-top: 1px solid rgba(191,200,206,0.2);
  border-bottom: 1px solid rgba(191,200,206,0.2);
}
.standards-header { text-align: center; max-width: 640px; margin: 0 auto 3rem; }
.standards-eyebrow {
  display: inline-block;
  background: var(--secondary-fixed);
  color: var(--on-secondary-fixed);
  font-size: 12px; font-weight: 700;
  padding: 0.25rem 0.875rem;
  border-radius: 9999px;
  margin-bottom: 0.75rem;
}
.standards-title {
  font-family: var(--font-headline);
  font-size: 36px; font-weight: 700;
  color: var(--on-surface);
  margin: 0 0 0.5rem;
}
.standards-sub { font-size: 16px; color: var(--on-surface-variant); margin: 0; }

.standards-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1.5rem;
}
.std-card {
  background: #fff;
  border: 1px solid rgba(191,200,206,0.3);
  border-radius: var(--radius);
  padding: 1.5rem;
  box-shadow: 0 8px 24px -4px rgba(58,134,168,0.06);
}
.std-icon {
  width: 48px; height: 48px;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 1.25rem;
}
.std-icon--blue  { background: var(--primary-fixed); color: var(--primary); }
.std-icon--green { background: var(--secondary-fixed); color: var(--secondary); }
.std-icon--teal  { background: var(--surface-container-high); color: var(--primary); }
.std-icon--amber { background: var(--tertiary-fixed); color: var(--tertiary); }
.std-title {
  font-family: var(--font-headline);
  font-size: 18px; font-weight: 700;
  color: var(--on-surface); margin: 0 0 0.5rem;
}
.std-desc { font-size: 14px; line-height: 1.6; color: var(--on-surface-variant); margin: 0; }

/* ============================================================
   CTA SECTION
   ============================================================ */
.cta-section { padding: var(--space-xl) 0; background: var(--background); }
.cta-card {
  background: linear-gradient(to right, var(--primary), var(--primary-container));
  color: #fff;
  border-radius: var(--radius);
  padding: 3.5rem;
  position: relative;
  overflow: hidden;
  box-shadow: 0 8px 24px rgba(0,0,0,0.12);
}
.cta-blob {
  position: absolute;
  border-radius: 50%;
  pointer-events: none;
}
.cta-blob-br {
  width: 320px; height: 320px;
  right: -80px; bottom: -80px;
  background: rgba(204, 239, 142, 0.2);
  filter: blur(48px);
}
.cta-blob-top {
  width: 240px; height: 240px;
  top: 0; right: 33%;
  background: rgba(255,255,255,0.1);
  filter: blur(40px);
}
.cta-inner {
  position: relative; z-index: 1;
  display: grid;
  grid-template-columns: 1fr auto;
  gap: 2rem;
  align-items: center;
  margin-bottom: 2rem;
}
.cta-badge {
  display: inline-flex; align-items: center; gap: 0.5rem;
  background: rgba(255,255,255,0.15);
  backdrop-filter: blur(4px);
  border-radius: 9999px;
  padding: 0.25rem 0.875rem;
  font-size: 12px; font-weight: 700;
  margin-bottom: 1rem;
  width: fit-content;
}
.cta-title {
  font-family: var(--font-headline);
  font-size: 36px; font-weight: 700;
  color: #fff; margin: 0 0 1rem;
  line-height: 1.25;
}
.cta-desc {
  font-size: 18px; line-height: 1.7;
  color: var(--primary-fixed);
  margin: 0; max-width: 640px;
}
.cta-actions {
  display: flex; flex-direction: column; gap: 0.75rem;
  flex-shrink: 0; min-width: 220px;
}
.btn-wa, .btn-schedule {
  display: flex; align-items: center; justify-content: center; gap: 0.5rem;
  padding: 0.875rem 1.5rem;
  border-radius: 9999px;
  font-size: 15px; font-weight: 700;
  text-decoration: none;
  transition: all 0.2s;
  white-space: nowrap;
}
.btn-wa {
  background: var(--secondary-fixed);
  color: var(--on-secondary-fixed);
  box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}
.btn-wa:hover { background: var(--secondary-fixed-dim); }
.btn-schedule {
  background: rgba(255,255,255,0.15);
  color: #fff;
  border: 1px solid rgba(255,255,255,0.3);
}
.btn-schedule:hover { background: rgba(255,255,255,0.25); }

.cta-footer-info {
  position: relative; z-index: 1;
  display: flex; flex-wrap: wrap; gap: 1.5rem;
  padding-top: 1.5rem;
  border-top: 1px solid rgba(255,255,255,0.2);
}
.cta-info-item {
  display: flex; align-items: center; gap: 0.5rem;
  font-size: 12px; color: var(--primary-fixed);
}

/* ============================================================
   RESPONSIVE
   ============================================================ */
@media (max-width: 1200px) {
  .team-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 1024px) {
  .hero-title { font-size: 36px; }
  .team-grid { grid-template-columns: repeat(2, 1fr); }
  .standards-grid { grid-template-columns: repeat(2, 1fr); }
  .cta-inner { grid-template-columns: 1fr; }
  .cta-actions { flex-direction: row; flex-wrap: wrap; }
}
@media (max-width: 640px) {
  .hero-title { font-size: 28px; }
  .team-grid { grid-template-columns: 1fr; }
  .standards-grid { grid-template-columns: 1fr; }
  .cta-card { padding: 2rem 1.5rem; }
  .cta-title { font-size: 26px; }
  .team-count-note { display: none; }
}
</style>
