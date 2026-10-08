<template>
  <PublicLayout>

    <!-- ===== SECTION 1: Hero & Breadcrumb Banner ===== -->
    <section class="hero-banner">
      <div class="container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb" aria-label="Breadcrumb">
          <router-link to="/" class="breadcrumb-link">
            <span class="material-symbols-outlined" style="font-size:16px">home</span>
            Beranda
          </router-link>
          <span class="breadcrumb-sep">›</span>
          <span class="breadcrumb-active">Layanan Kami</span>
        </nav>

        <!-- Hero Grid -->
        <div class="hero-grid">
          <!-- Left Content -->
          <div class="hero-content">
            <div class="hero-badge">
              <span class="material-symbols-outlined fill" style="font-size:18px">verified</span>
              <span>Terapis Berlisensi &amp; Bersertifikat Resmi Jagakarsa</span>
            </div>
            <h1 class="hero-title">
              Layanan Terapi Terpadu untuk <span class="hero-title-accent">Tumbuh Kembang Optimal</span> Buah Hati
            </h1>
            <p class="hero-desc">
              Berbagai layanan terapi klinis interaktif yang dirancang khusus untuk mendampingi setiap tahap perkembangan fisik, kognitif, sensorik, dan emosional anak dengan kasih sayang serta metode berbasis bukti.
            </p>
            <div class="hero-actions">
              <a href="#program" class="btn-primary hero-btn-primary">
                <span>Eksplorasi Program Terapi</span>
                <span class="material-symbols-outlined" style="font-size:18px">expand_more</span>
              </a>
              <a href="https://wa.me/6281234567890" class="btn-outline-secondary hero-btn-wa">
                <span class="material-symbols-outlined fill" style="font-size:20px; color: var(--secondary)">chat</span>
                <span>Konsultasi Awal WhatsApp</span>
              </a>
            </div>
          </div>

          <!-- Right: Image -->
          <div class="hero-image-col">
            <div class="hero-image-frame">
              <img
                :src="heroImage"
                alt="Terapis mendampingi anak dalam sesi terapi interaktif di Amanah Tin's Center"
                class="hero-img"
              />
              <div class="hero-badge-float">
                <div class="badge-float-icon">
                  <span class="material-symbols-outlined fill" style="font-size:22px">health_and_safety</span>
                </div>
                <div>
                  <div class="badge-float-title">100% Ramah Anak</div>
                  <div class="badge-float-sub">Fasilitas aman, bersih &amp; steril</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ===== SECTION 2: Trust Highlights Strip ===== -->
    <section class="trust-strip">
      <div class="container">
        <div class="trust-grid">
          <div v-for="trust in trustItems" :key="trust.label" class="trust-item">
            <div class="trust-icon" :class="trust.iconBg">
              <span class="material-symbols-outlined" style="font-size:24px">{{ trust.icon }}</span>
            </div>
            <div>
              <div class="trust-label">{{ trust.label }}</div>
              <div class="trust-sub">{{ trust.sub }}</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ===== SECTION 3: 4 Core Therapy Programs (2x2 Bento Cards) ===== -->
    <section class="programs-section" id="program">
      <div class="container">
        <div class="section-header">
          <span class="section-eyebrow">Spesialisasi Klinis</span>
          <h2 class="section-title">Program Terapi Tumbuh Kembang Komprehensif</h2>
          <p class="section-sub">
            Setiap anak menjalani asesmen mendalam sebelum program terapi dipersonalisasi sesuai kebutuhan perkembangan spesifik.
          </p>
        </div>

        <div class="programs-grid">
          <!-- Card 1: Terapi Wicara -->
          <div class="prog-card prog-card--blue">
            <div class="prog-card-top">
              <div class="prog-icon prog-icon--blue">
                <span class="material-symbols-outlined" style="font-size:32px">record_voice_over</span>
              </div>
              <span class="prog-badge prog-badge--blue">TW Program</span>
            </div>
            <h3 class="prog-name">Terapi Wicara (TW)</h3>
            <p class="prog-desc">
              Membantu memfasilitasi kemampuan anak dalam berbahasa reseptif dan ekspresif, stimulasi artikulasi bicara, pelafalan kata, serta mengatasi speech delay (keterlambatan bicara) dan gangguan kelancaran berbicara.
            </p>
            <div class="prog-focus">
              <div class="prog-focus-label">Fokus Terapi:</div>
              <div class="prog-tags">
                <span class="prog-tag">Speech Delay</span>
                <span class="prog-tag">Artikulasi &amp; Kejelasan</span>
                <span class="prog-tag">Kosa Kata &amp; Bahasa Reseptif</span>
                <span class="prog-tag">Oral Motor Stimulation</span>
              </div>
            </div>
            <div class="prog-footer">
              <span class="prog-duration">Sesi 45 - 60 Menit / Pertemuan</span>
              <router-link to="/layanan/terapi-wicara" class="prog-link prog-link--blue">
                <span>Selengkapnya</span>
                <span class="material-symbols-outlined" style="font-size:18px">arrow_forward</span>
              </router-link>
            </div>
          </div>

          <!-- Card 2: Terapi Okupasi -->
          <div class="prog-card prog-card--green">
            <div class="prog-card-top">
              <div class="prog-icon prog-icon--green">
                <span class="material-symbols-outlined" style="font-size:32px">front_hand</span>
              </div>
              <span class="prog-badge prog-badge--green">OT / BT Program</span>
            </div>
            <h3 class="prog-name">Terapi Okupasi (BT / OT)</h3>
            <p class="prog-desc">
              Melatih keterampilan motorik halus, motorik kasar, serta kemandirian fungsional harian anak (makan sendiri, berpakaian, memegang pensil/menulis, dan koordinasi mata-tangan) dengan metode bermain adaptif.
            </p>
            <div class="prog-focus">
              <div class="prog-focus-label">Fokus Terapi:</div>
              <div class="prog-tags">
                <span class="prog-tag">Motorik Halus (Fine Motor)</span>
                <span class="prog-tag">Kemandirian Harian (ADL)</span>
                <span class="prog-tag">Kesiapan Menulis (Pre-writing)</span>
                <span class="prog-tag">Koordinasi Bilateral</span>
              </div>
            </div>
            <div class="prog-footer">
              <span class="prog-duration">Sesi 45 - 60 Menit / Pertemuan</span>
              <router-link to="/layanan/terapi-okupasi" class="prog-link prog-link--green">
                <span>Selengkapnya</span>
                <span class="material-symbols-outlined" style="font-size:18px">arrow_forward</span>
              </router-link>
            </div>
          </div>

          <!-- Card 3: Sensori Integrasi -->
          <div class="prog-card prog-card--teal">
            <div class="prog-card-top">
              <div class="prog-icon prog-icon--teal">
                <span class="material-symbols-outlined" style="font-size:32px">balance</span>
              </div>
              <span class="prog-badge prog-badge--teal">SI Sensory</span>
            </div>
            <h3 class="prog-name">Terapi Sensori Integrasi (SI)</h3>
            <p class="prog-desc">
              Menstimulasi dan mengorganisasi sistem saraf pusat anak dalam menerima serta merespons input sensorik (keseimbangan vestibular, taktil, proprioseptif), membantu anak yang hiperaktif atau sensitif terhadap rangsangan.
            </p>
            <div class="prog-focus">
              <div class="prog-focus-label">Fokus Terapi:</div>
              <div class="prog-tags">
                <span class="prog-tag">Vestibular &amp; Keseimbangan</span>
                <span class="prog-tag">Regulasi Sensitivitas Taktil</span>
                <span class="prog-tag">Proprioseptif &amp; Kesadaran Tubuh</span>
                <span class="prog-tag">Fokus &amp; Konsentrasi</span>
              </div>
            </div>
            <div class="prog-footer">
              <span class="prog-duration">Sesi 45 - 60 Menit / Pertemuan</span>
              <router-link to="/layanan/sensori-integrasi" class="prog-link prog-link--blue">
                <span>Selengkapnya</span>
                <span class="material-symbols-outlined" style="font-size:18px">arrow_forward</span>
              </router-link>
            </div>
          </div>

          <!-- Card 4: Psikologi Anak -->
          <div class="prog-card prog-card--amber">
            <div class="prog-card-top">
              <div class="prog-icon prog-icon--amber">
                <span class="material-symbols-outlined" style="font-size:32px">psychology</span>
              </div>
              <span class="prog-badge prog-badge--amber">Psikologi Klinis</span>
            </div>
            <h3 class="prog-name">Psikologi &amp; Konseling Tumbuh Kembang</h3>
            <p class="prog-desc">
              Mendukung aspek emosional, perilaku, kognitif, serta interaksi sosial anak. Dilengkapi sesi konseling suportif bagi orang tua guna menciptakan pola pengasuhan yang selaras di rumah.
            </p>
            <div class="prog-focus">
              <div class="prog-focus-label">Fokus Terapi:</div>
              <div class="prog-tags">
                <span class="prog-tag">Manajemen Tantrum &amp; Emosi</span>
                <span class="prog-tag">Asesmen Kognitif &amp; IQ</span>
                <span class="prog-tag">Interaksi Sosial &amp; Peer Group</span>
                <span class="prog-tag">Parenting Coaching</span>
              </div>
            </div>
            <div class="prog-footer">
              <span class="prog-duration">Sesi 60 Menit / Konsultasi</span>
              <router-link to="/layanan/psikologi-anak" class="prog-link prog-link--amber">
                <span>Selengkapnya</span>
                <span class="material-symbols-outlined" style="font-size:18px">arrow_forward</span>
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ===== SECTION 4: Inspirational Quote ===== -->
    <section class="quote-section">
      <div class="container-narrow">
        <div class="quote-card">
          <div class="quote-icon-wrap">
            <span class="material-symbols-outlined fill" style="font-size:32px">favorite</span>
          </div>
          <blockquote class="quote-text">
            "Setiap anak memiliki potensi unik. Kami hadir untuk mendampingi langkah kecil mereka menuju lompatan besar di masa depan."
          </blockquote>
          <div class="quote-author">
            <div class="quote-author-name">Amanah Tin's Center</div>
            <div class="quote-author-sub">Didirikan oleh Bapak Artin Ristriawan &amp; Ibu Hertin Nurfarida</div>
          </div>
        </div>
      </div>
    </section>

    <!-- ===== SECTION 5: Step-by-Step Flow ===== -->
    <section class="steps-section">
      <div class="container">
        <div class="section-header">
          <span class="section-eyebrow">Alur Pendaftaran Mudah</span>
          <h2 class="section-title">4 Tahap Memulai Terapi Anak</h2>
        </div>
        <div class="steps-grid">
          <div v-for="(step, idx) in steps" :key="step.title" class="step-card">
            <div class="step-num">{{ idx + 1 }}</div>
            <h4 class="step-title">{{ step.title }}</h4>
            <p class="step-desc">{{ step.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ===== SECTION 6: CTA ===== -->
    <section class="cta-section" id="jadwalkan">
      <div class="container">
        <div class="cta-card">
          <div class="cta-content">
            <div class="cta-location-badge">
              <span class="material-symbols-outlined" style="font-size:16px">location_on</span>
              <span>Jagakarsa, Jakarta Selatan</span>
            </div>
            <h2 class="cta-title">Siap Mengetahui Kebutuhan Terapi Buah Hati Anda?</h2>
            <p class="cta-desc">
              Tim profesional Amanah Tin's Center siap mendengarkan cerita dan pertanyaan Anda. Dapatkan saran awal tanpa rasa cemas dan jadwalkan sesi asesmen perdana hari ini.
            </p>
          </div>
          <div class="cta-actions">
            <a href="https://wa.me/6281234567890" class="btn-wa">
              <span class="material-symbols-outlined fill" style="font-size:22px">chat</span>
              <span>Chat WhatsApp Admin</span>
            </a>
            <a href="tel:+6281234567890" class="btn-phone">
              <span class="material-symbols-outlined" style="font-size:20px">call</span>
              <span>0812-3456-7890</span>
            </a>
          </div>
        </div>
      </div>
    </section>

  </PublicLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import PublicLayout from '../layouts/PublicLayout.vue'

const heroImage = ref('https://lh3.googleusercontent.com/aida-public/AB6AXuAzVVD8gAdEvfYJoc9gY0-mWQJI6eSZL0C3BCWjStu8S_LoUYPpzvWFKO9-agaSgW15_4Q9K9-zFbd-YS3o3wv1oK3k27ibdeU-KipIjepwyGU963gF9WD-ZCqoW3iNIupXuDTA10bG3xpWmcGbLdMJN5jU3wtyi4N_Dt56FK6tcyPppyyfa-q6GZhhoCvJdgCokD0n6gmKlUDtYmurTXjEKlh06jyrGNSivzem73Y')

const trustItems = [
  { icon: 'school',           iconBg: 'trust-bg-blue',   label: 'Terapis Ahli',      sub: 'Lulusan universitas terkemuka' },
  { icon: 'calendar_clock',   iconBg: 'trust-bg-green',  label: 'Jadwal Fleksibel',  sub: 'Senin - Sabtu (08.00 - 17.00)' },
  { icon: 'diversity_1',      iconBg: 'trust-bg-indigo', label: 'One-on-One',        sub: 'Pendekatan personal terfokus' },
  { icon: 'clinical_notes',   iconBg: 'trust-bg-amber',  label: 'Evaluasi Berkala',  sub: 'Laporan kemajuan berkala' },
]

const steps = [
  { title: 'Konsultasi Awal',     desc: 'Orang tua menceritakan profil serta kendala perkembangan anak via WhatsApp atau telepon klinik.' },
  { title: 'Asesmen Klinis',      desc: 'Evaluasi langsung oleh tim terapis profesional untuk menentukan program terapi yang tepat sasaran.' },
  { title: 'Penjadwalan Rutin',   desc: 'Pilih hari dan jam terapi sesuai ritme aktivitas harian anak dan kemudahan orang tua.' },
  { title: 'Evaluasi Berkala',    desc: 'Pantau grafik kemajuan anak secara transparan dengan diskusi rutin bersama terapis.' },
]
</script>

<style scoped>
/* ============================================================
   HERO BANNER
   ============================================================ */
.hero-banner {
  background: linear-gradient(to bottom, var(--surface-container-low), var(--background));
  padding: 2rem 0 4rem;
}
.breadcrumb {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 12px;
  color: var(--on-surface-variant);
  margin-bottom: 1.5rem;
}
.breadcrumb-link {
  display: flex;
  align-items: center;
  gap: 0.25rem;
  color: var(--on-surface-variant);
  text-decoration: none;
  transition: color 0.2s;
}
.breadcrumb-link:hover { color: var(--primary); }
.breadcrumb-sep { color: var(--outline-variant); font-weight: 700; }
.breadcrumb-active { color: var(--primary); font-weight: 600; }

.hero-grid {
  display: grid;
  grid-template-columns: 7fr 5fr;
  gap: 3rem;
  align-items: center;
}
.hero-content { display: flex; flex-direction: column; gap: 1.25rem; }

.hero-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  background-color: var(--secondary-fixed);
  color: var(--on-secondary-fixed);
  padding: 0.375rem 0.875rem;
  border-radius: 9999px;
  font-size: 13px;
  font-weight: 600;
  width: fit-content;
}
.hero-title {
  font-family: var(--font-headline);
  font-size: 36px;
  font-weight: 700;
  line-height: 1.28;
  letter-spacing: -0.015em;
  color: var(--on-surface);
  margin: 0;
}
.hero-title-accent { color: var(--primary); }
.hero-desc {
  font-size: 18px;
  line-height: 1.7;
  color: var(--on-surface-variant);
  max-width: 640px;
  margin: 0;
}
.hero-actions {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  align-items: center;
  padding-top: 0.5rem;
}
.hero-btn-primary {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  background-color: var(--primary);
  color: #fff;
  font-weight: 700;
  font-size: 15px;
  padding: 0.85rem 1.75rem;
  border-radius: 9999px;
  text-decoration: none;
  transition: all 0.2s;
  box-shadow: 0 2px 8px rgba(5, 102, 135, 0.18);
}
.hero-btn-primary:hover { opacity: 0.9; box-shadow: 0 4px 14px rgba(5, 102, 135, 0.25); }
.hero-btn-wa {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  background-color: var(--surface-container-lowest, #fff);
  border: 1.5px solid var(--secondary);
  color: var(--secondary);
  font-weight: 700;
  font-size: 15px;
  padding: 0.85rem 1.5rem;
  border-radius: 9999px;
  text-decoration: none;
  transition: all 0.2s;
}
.hero-btn-wa:hover { background-color: var(--secondary-fixed); }

/* Hero image */
.hero-image-col { position: relative; }
.hero-image-frame {
  background: #fff;
  border-radius: var(--radius);
  border: 1px solid rgba(191, 200, 206, 0.3);
  padding: 0.75rem;
  box-shadow: 0 8px 24px -4px rgba(58, 134, 168, 0.08);
  position: relative;
}
.hero-img {
  width: 100%;
  height: 320px;
  object-fit: cover;
  border-radius: calc(var(--radius) - 4px);
  display: block;
}
.hero-badge-float {
  position: absolute;
  bottom: -1rem;
  left: -1rem;
  background: #fff;
  border: 1px solid rgba(191, 200, 206, 0.2);
  border-radius: var(--radius);
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  padding: 0.75rem 1rem;
  display: flex;
  align-items: center;
  gap: 0.75rem;
}
.badge-float-icon {
  width: 40px; height: 40px;
  border-radius: 50%;
  background-color: var(--secondary-fixed);
  color: var(--secondary);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.badge-float-title { font-size: 13px; font-weight: 700; color: var(--on-surface); }
.badge-float-sub { font-size: 12px; color: var(--on-surface-variant); }

/* ============================================================
   TRUST STRIP
   ============================================================ */
.trust-strip {
  background: #fff;
  border-top: 1px solid rgba(191, 200, 206, 0.2);
  border-bottom: 1px solid rgba(191, 200, 206, 0.2);
  padding: 1.5rem 0;
}
.trust-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1.5rem;
}
.trust-item {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 0.5rem;
}
.trust-icon {
  width: 48px; height: 48px;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.trust-bg-blue   { background-color: var(--surface-container-low); color: var(--primary); }
.trust-bg-green  { background-color: var(--secondary-fixed); color: var(--secondary); }
.trust-bg-indigo { background-color: var(--surface-variant); color: var(--primary); }
.trust-bg-amber  { background-color: var(--tertiary-fixed); color: var(--tertiary); }
.trust-label { font-size: 18px; font-weight: 700; color: var(--on-surface); font-family: var(--font-headline); }
.trust-sub { font-size: 12px; color: var(--on-surface-variant); }

/* ============================================================
   PROGRAMS SECTION
   ============================================================ */
.programs-section { padding: var(--space-xl) 0; }

.section-header { text-align: center; max-width: 720px; margin: 0 auto 3.5rem; }
.section-eyebrow {
  font-size: 13px; font-weight: 700; color: var(--primary);
  text-transform: uppercase; letter-spacing: 0.08em;
}
.section-title {
  font-family: var(--font-headline);
  font-size: 36px; font-weight: 700; letter-spacing: -0.015em;
  color: var(--on-surface); margin: 0.5rem 0 1rem;
}
.section-sub { font-size: 16px; color: var(--on-surface-variant); line-height: 1.6; }

.programs-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 2rem;
}

.prog-card {
  background: #fff;
  border-radius: var(--radius);
  padding: 2rem;
  border: 1px solid rgba(191, 200, 206, 0.3);
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  transition: all 0.3s ease;
  cursor: default;
}
.prog-card--blue:hover  { border-color: rgba(0, 99, 132, 0.4); box-shadow: 0 14px 32px -6px rgba(43,61,79,0.08); }
.prog-card--green:hover { border-color: rgba(75, 103, 22, 0.5); box-shadow: 0 14px 32px -6px rgba(43,61,79,0.08); }
.prog-card--teal:hover  { border-color: rgba(0, 99, 132, 0.3); box-shadow: 0 14px 32px -6px rgba(43,61,79,0.08); }
.prog-card--amber:hover { border-color: rgba(136, 78, 3, 0.5); box-shadow: 0 14px 32px -6px rgba(43,61,79,0.08); }

.prog-card-top {
  display: flex; align-items: flex-start;
  justify-content: space-between;
  margin-bottom: 1.5rem;
}
.prog-icon {
  width: 64px; height: 64px;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  box-shadow: 0 2px 6px rgba(0,0,0,0.06);
}
.prog-icon--blue  { background-color: var(--primary-fixed); color: var(--primary); }
.prog-icon--green { background-color: var(--secondary-fixed); color: var(--secondary); }
.prog-icon--teal  { background-color: var(--surface-container-high); color: var(--primary); }
.prog-icon--amber { background-color: var(--tertiary-fixed); color: var(--tertiary); }

.prog-badge {
  font-size: 13px; font-weight: 700;
  padding: 0.25rem 0.75rem;
  border-radius: 9999px;
}
.prog-badge--blue  { background-color: var(--surface-container-low); color: var(--primary); }
.prog-badge--green { background-color: var(--secondary-fixed); color: var(--secondary); opacity: 0.8; }
.prog-badge--teal  { background-color: var(--surface-container); color: var(--primary); }
.prog-badge--amber { background-color: var(--tertiary-fixed); color: var(--tertiary); opacity: 0.8; }

.prog-name {
  font-family: var(--font-headline);
  font-size: 24px; font-weight: 700;
  color: var(--on-surface);
  margin: 0 0 0.75rem;
  transition: color 0.2s;
}
.prog-card--blue:hover  .prog-name { color: var(--primary); }
.prog-card--green:hover .prog-name { color: var(--secondary); }
.prog-card--teal:hover  .prog-name { color: var(--primary); }
.prog-card--amber:hover .prog-name { color: var(--tertiary); }

.prog-desc {
  font-size: 16px; line-height: 1.7;
  color: var(--on-surface-variant);
  margin: 0 0 1.5rem;
}
.prog-focus { margin-bottom: 1.5rem; }
.prog-focus-label { font-size: 13px; font-weight: 700; color: var(--on-surface); margin-bottom: 0.5rem; }
.prog-tags { display: flex; flex-wrap: wrap; gap: 0.5rem; }
.prog-tag {
  font-size: 12px;
  background-color: var(--surface-container-low);
  color: var(--on-surface-variant);
  padding: 0.25rem 0.75rem;
  border-radius: 9999px;
}

.prog-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-top: 1.5rem;
  border-top: 1px solid rgba(191, 200, 206, 0.2);
}
.prog-duration { font-size: 12px; color: var(--on-surface-variant); }
.prog-link {
  font-size: 15px; font-weight: 700;
  display: flex; align-items: center; gap: 0.25rem;
  text-decoration: none;
  transition: transform 0.2s;
}
.prog-card:hover .prog-link { transform: translateX(4px); }
.prog-link--blue  { color: var(--primary); }
.prog-link--green { color: var(--secondary); }
.prog-link--amber { color: var(--tertiary); }

/* ============================================================
   QUOTE SECTION
   ============================================================ */
.quote-section { padding: var(--space-lg) 0; }
.container-narrow { max-width: 800px; margin: 0 auto; padding: 0 var(--gutter); }
.quote-card {
  background: linear-gradient(to right, var(--surface-container-low), var(--surface-bright, #f7f9ff), rgba(204, 239, 142, 0.2));
  border: 1px solid rgba(191, 200, 206, 0.3);
  border-radius: var(--radius-lg);
  padding: 4rem 3.5rem;
  text-align: center;
  position: relative;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}
.quote-icon-wrap {
  width: 64px; height: 64px;
  background: #fff;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  color: var(--primary);
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  margin: 0 auto 1.5rem;
}
.quote-text {
  font-family: var(--font-headline);
  font-size: 24px; font-weight: 600;
  color: var(--on-surface);
  line-height: 1.55;
  max-width: 680px;
  margin: 0 auto;
}
.quote-author { margin-top: 1.5rem; }
.quote-author-name { font-size: 15px; font-weight: 700; color: var(--primary); }
.quote-author-sub { font-size: 12px; color: var(--on-surface-variant); margin-top: 0.25rem; }

/* ============================================================
   STEPS SECTION
   ============================================================ */
.steps-section {
  padding: var(--space-xl) 0;
  background-color: rgba(237, 244, 255, 0.6);
}
.steps-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: var(--gutter);
}
.step-card {
  background: #fff;
  border: 1px solid rgba(191, 200, 206, 0.2);
  border-radius: var(--radius);
  padding: 1.5rem;
  position: relative;
  transition: box-shadow 0.2s;
}
.step-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.06); }
.step-num {
  width: 40px; height: 40px;
  border-radius: 50%;
  background-color: var(--primary);
  color: #fff;
  font-family: var(--font-headline);
  font-size: 16px; font-weight: 700;
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 1rem;
}
.step-title {
  font-family: var(--font-headline);
  font-size: 18px; font-weight: 700;
  color: var(--on-surface);
  margin: 0 0 0.5rem;
}
.step-desc {
  font-size: 14px; line-height: 1.6;
  color: var(--on-surface-variant);
  margin: 0;
}

/* ============================================================
   CTA SECTION
   ============================================================ */
.cta-section { padding: var(--space-xl) 0; }
.cta-card {
  background-color: var(--primary);
  color: #fff;
  border-radius: var(--radius);
  padding: 3.5rem;
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: space-between;
  gap: 2rem;
  box-shadow: 0 8px 24px rgba(0,0,0,0.1);
  overflow: hidden;
  position: relative;
}
.cta-card::before {
  content: '';
  position: absolute;
  top: -60px; right: -60px;
  width: 250px; height: 250px;
  border-radius: 50%;
  background: rgba(255,255,255,0.05);
}
.cta-content { max-width: 640px; }
.cta-location-badge {
  display: inline-flex; align-items: center; gap: 0.5rem;
  background: rgba(255,255,255,0.15);
  border-radius: 9999px;
  padding: 0.25rem 0.75rem;
  font-size: 12px;
  margin-bottom: 1rem;
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
  margin: 0;
}
.cta-actions {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  flex-shrink: 0;
  min-width: 220px;
}
.btn-wa, .btn-phone {
  display: flex; align-items: center; justify-content: center; gap: 0.5rem;
  padding: 1rem 2rem;
  border-radius: 9999px;
  font-size: 15px; font-weight: 700;
  text-decoration: none;
  transition: all 0.2s;
  white-space: nowrap;
}
.btn-wa {
  background-color: var(--secondary-fixed);
  color: var(--on-secondary-fixed, #131f00);
  box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}
.btn-wa:hover { background-color: var(--secondary-fixed-dim); }
.btn-phone {
  background-color: rgba(255,255,255,0.15);
  color: #fff;
  border: 1px solid rgba(255,255,255,0.3);
}
.btn-phone:hover { background-color: rgba(255,255,255,0.25); }

/* ============================================================
   RESPONSIVE
   ============================================================ */
@media (max-width: 1024px) {
  .programs-grid { grid-template-columns: 1fr; }
  .steps-grid { grid-template-columns: repeat(2, 1fr); }
  .trust-grid { grid-template-columns: repeat(2, 1fr); }
  .cta-card { flex-direction: column; text-align: center; padding: 2.5rem; }
  .cta-content { max-width: 100%; }
  .cta-actions { flex-direction: row; flex-wrap: wrap; justify-content: center; min-width: unset; width: 100%; }
}
@media (max-width: 768px) {
  .hero-grid { grid-template-columns: 1fr; }
  .hero-image-col { display: none; }
  .hero-title { font-size: 26px; }
  .hero-desc { font-size: 15px; }
  .programs-grid { gap: 1.25rem; }
  .steps-grid { grid-template-columns: 1fr; }
  .trust-grid { grid-template-columns: 1fr 1fr; }
  .quote-card { padding: 2.5rem 1.5rem; }
  .quote-text { font-size: 18px; }
  .cta-title { font-size: 26px; }
}
</style>
