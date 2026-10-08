<template>
  <PublicLayout>

    <!-- ===== HERO CARD ===== -->
    <section class="hero-section">
      <div class="container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb" aria-label="Breadcrumb">
          <router-link to="/" class="bc-link">
            <span class="material-symbols-outlined" style="font-size:14px">home</span>
            Beranda
          </router-link>
          <span class="bc-sep">/</span>
          <span class="bc-active">Jadwal &amp; Pendaftaran</span>
        </nav>

        <div class="hero-card">
          <div class="hero-card-content">
            <div class="hero-badge">
              <span class="material-symbols-outlined" style="font-size:16px">event_available</span>
              Penerimaan Sesi Terapi Baru Aktif
            </div>
            <h1 class="hero-title">Jadwal &amp; Pendaftaran</h1>
            <p class="hero-desc">
              Mudah dan cepat untuk memulai perjalanan tumbuh kembang anak Anda bersama tim terapis klinis berizin dan berpengalaman di Jagakarsa, Jakarta Selatan.
            </p>
          </div>
          <div class="hero-blob"></div>
        </div>
      </div>
    </section>

    <!-- ===== MAIN TWO-COLUMN GRID ===== -->
    <section class="main-section">
      <div class="container">
        <div class="main-grid">

          <!-- ===== LEFT COLUMN: Cara Mendaftar ===== -->
          <div class="left-col">

            <!-- Cara Mendaftar Card -->
            <div class="steps-card">
              <div class="steps-card-header">
                <div class="steps-card-title-group">
                  <div class="steps-card-icon">
                    <span class="material-symbols-outlined" style="font-size:22px">format_list_numbered</span>
                  </div>
                  <div>
                    <h2 class="steps-card-title">Cara Mendaftar</h2>
                    <p class="steps-card-sub">3 langkah praktis tanpa antrean panjang</p>
                  </div>
                </div>
                <span class="steps-card-badge">Respon &lt; 15 Menit</span>
              </div>

              <!-- Timeline Steps -->
              <div class="timeline">
                <!-- Step 1 -->
                <div class="timeline-item">
                  <div class="timeline-number">1</div>
                  <div class="timeline-content">
                    <div class="timeline-row">
                      <h3 class="timeline-title">Hubungi Kami</h3>
                      <span class="material-symbols-outlined" style="font-size:22px; color: var(--primary)">chat</span>
                    </div>
                    <p class="timeline-desc">
                      Konsultasi awal secara santai melalui WhatsApp atau panggilan telepon. Ceritakan kebutuhan, observasi, dan riwayat perkembangan si kecil kepada koordinator layanan kami.
                    </p>
                    <div class="timeline-note">
                      <span class="material-symbols-outlined" style="font-size:16px; color: var(--secondary)">check_circle</span>
                      <span>Tersedia panduan asesmen awal gratis</span>
                    </div>
                  </div>
                </div>

                <!-- Step 2 -->
                <div class="timeline-item">
                  <div class="timeline-number">2</div>
                  <div class="timeline-content">
                    <div class="timeline-row">
                      <h3 class="timeline-title">Pilih Jadwal Sesi</h3>
                      <span class="material-symbols-outlined" style="font-size:22px; color: var(--primary)">calendar_month</span>
                    </div>
                    <p class="timeline-desc">
                      Tim kami akan membantu menyesuaikan jadwal terapeutik yang ideal: Sesi Pagi (08.30 - 11.30 WIB), Sesi Siang (13.00 - 15.00 WIB), atau Sesi Sore (15.30 - 17.00 WIB) sesuai kenyamanan anak.
                    </p>
                    <div class="session-pills">
                      <span class="session-pill">
                        <span class="material-symbols-outlined" style="font-size:12px">wb_sunny</span> Pagi (Aktif)
                      </span>
                      <span class="session-pill">
                        <span class="material-symbols-outlined" style="font-size:12px">light_mode</span> Siang (Aktif)
                      </span>
                      <span class="session-pill">
                        <span class="material-symbols-outlined" style="font-size:12px">routine</span> Sore (Terbatas)
                      </span>
                    </div>
                  </div>
                </div>

                <!-- Step 3 -->
                <div class="timeline-item">
                  <div class="timeline-number">3</div>
                  <div class="timeline-content">
                    <div class="timeline-row">
                      <h3 class="timeline-title">Konfirmasi &amp; Rekam Medis</h3>
                      <span class="material-symbols-outlined" style="font-size:22px; color: var(--primary)">assignment_turned_in</span>
                    </div>
                    <p class="timeline-desc">
                      Lakukan konfirmasi jadwal final dan pengisian formulir rekam medis awal secara digital atau langsung di resepsionis klinik Jagakarsa untuk penyusunan target terapi individual.
                    </p>
                    <div class="timeline-note">
                      <span class="material-symbols-outlined" style="font-size:16px; color: var(--secondary)">verified_user</span>
                      <span>Data privasi keluarga dijamin aman dan terenkripsi</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Trust Card -->
            <div class="trust-card">
              <div class="trust-icon">
                <span class="material-symbols-outlined" style="font-size:26px">sentiment_very_satisfied</span>
              </div>
              <div>
                <h4 class="trust-title">Lingkungan Terapi Non-Stigma &amp; Hangat</h4>
                <p class="trust-desc">
                  Ruang bermain sensori terstandar, alat evaluasi terakreditasi, dan komunikasi terbuka dengan orang tua pada setiap akhir sesi terapi.
                </p>
              </div>
            </div>
          </div>

          <!-- ===== RIGHT COLUMN: Hubungi Kami ===== -->
          <div class="right-col" id="daftar-form">
            <div class="contact-card">
              <!-- Header -->
              <div class="contact-card-header">
                <div class="contact-card-title-group">
                  <div class="contact-card-icon">
                    <span class="material-symbols-outlined" style="font-size:22px">support_agent</span>
                  </div>
                  <div>
                    <h2 class="contact-card-title">Hubungi Kami</h2>
                    <p class="contact-card-sub">Layanan Informasi &amp; Pendaftaran</p>
                  </div>
                </div>
                <div class="open-badge">
                  <span class="open-dot"></span>
                  Buka Sekarang
                </div>
              </div>

              <!-- Channel Matrix -->
              <div class="channels">
                <a href="https://wa.me/6281234567890" target="_blank" rel="noopener" class="channel-item">
                  <div class="channel-icon channel-icon--green">
                    <span class="material-symbols-outlined" style="font-size:20px">phone_iphone</span>
                  </div>
                  <div class="channel-info">
                    <span class="channel-label">WHATSAPP RESMI</span>
                    <span class="channel-value channel-value--primary">0812-3456-7890</span>
                  </div>
                  <span class="material-symbols-outlined channel-arrow" style="font-size:20px">arrow_forward</span>
                </a>

                <a href="tel:02112345678" class="channel-item">
                  <div class="channel-icon channel-icon--blue">
                    <span class="material-symbols-outlined" style="font-size:20px">call</span>
                  </div>
                  <div class="channel-info">
                    <span class="channel-label">TELEPON KLINIK</span>
                    <span class="channel-value">(021) 1234 5678</span>
                  </div>
                  <span class="material-symbols-outlined channel-arrow" style="font-size:20px">arrow_forward</span>
                </a>

                <a href="mailto:info@amanah-tinscenter.id" class="channel-item">
                  <div class="channel-icon channel-icon--teal">
                    <span class="material-symbols-outlined" style="font-size:20px">mail</span>
                  </div>
                  <div class="channel-info">
                    <span class="channel-label">SUREL KORESPONDENSI</span>
                    <span class="channel-value">info@amanah-tinscenter.id</span>
                  </div>
                  <span class="material-symbols-outlined channel-arrow" style="font-size:20px">arrow_forward</span>
                </a>

                <div class="channel-item channel-item--static">
                  <div class="channel-icon channel-icon--amber">
                    <span class="material-symbols-outlined" style="font-size:20px">location_on</span>
                  </div>
                  <div class="channel-info">
                    <span class="channel-label">ALAMAT KLINIK JAGAKARSA</span>
                    <span class="channel-value">Jl. Raya Jagakarsa No. 12, Jagakarsa, Jakarta Selatan 12620</span>
                    <span class="channel-note">
                      <span class="material-symbols-outlined" style="font-size:12px">directions_subway</span>
                      5 menit dari Stasiun Lenteng Agung (Akses Mudah)
                    </span>
                  </div>
                </div>

                <!-- Operating Hours -->
                <div class="hours-row">
                  <div class="hours-left">
                    <span class="material-symbols-outlined" style="font-size:22px; color: var(--primary)">schedule</span>
                    <div>
                      <span class="hours-label">Jam Kerja Operasional</span>
                      <span class="hours-value">Senin – Sabtu: 08.00 – 17.00 WIB</span>
                    </div>
                  </div>
                  <span class="hours-closed">Minggu: Tutup</span>
                </div>
              </div>

              <!-- CTA -->
              <div class="contact-cta">
                <a
                  href="https://wa.me/6281234567890?text=Halo%20Amanah%20Tin's%20Center,%20saya%20ingin%20mendaftarkan%20anak%20saya%20untuk%20jadwal%20terapi"
                  target="_blank"
                  rel="noopener"
                  class="btn-daftar"
                >
                  <span>Daftar Sekarang Melalui WhatsApp</span>
                  <span class="material-symbols-outlined" style="font-size:20px">send</span>
                </a>
                <p class="contact-cta-note">Tanpa biaya pendaftaran awal untuk screening konsultasi pertama.</p>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- ===== MOTIVATIONAL BANNER ===== -->
    <section class="motivational-section">
      <div class="container">
        <div class="motivational-card">
          <div class="motivational-blob-tr"></div>
          <div class="motivational-blob-bl"></div>

          <div class="motivational-inner">
            <!-- Left Text -->
            <div class="motivational-content">
              <div class="motivational-eyebrow">
                <span class="material-symbols-outlined" style="font-size:14px">favorite</span>
                <span>Pendampingan Tumbuh Kembang Penuh Kasih Sayang</span>
              </div>
              <h2 class="motivational-title">"Langkah kecil hari ini, untuk perubahan besar esok hari."</h2>
              <p class="motivational-desc">
                Setiap anak berhak mendapatkan stimulasi dan dukungan terbaik di usia emasnya. Bersama tim terapis wicara, okupasi, dan sensori integrasi Amanah Tin's Center, mari ciptakan masa depan yang mandiri dan bahagia.
              </p>
              <div class="motivational-actions">
                <a href="https://wa.me/6281234567890" target="_blank" rel="noopener" class="btn-wa-secondary">
                  <span class="material-symbols-outlined" style="font-size:20px">chat_bubble</span>
                  <span>Hubungi Tim Terapis via WhatsApp</span>
                </a>
                <router-link to="/tim-kami" class="btn-team-link">
                  <span>Pelajari Profil Terapis Kami</span>
                  <span class="material-symbols-outlined" style="font-size:16px">arrow_forward</span>
                </router-link>
              </div>
            </div>

            <!-- Right Image -->
            <div class="motivational-image-wrap">
              <div class="motivational-image-frame">
                <img
                  src="https://lh3.googleusercontent.com/aida-public/AB6AXuBW5aiE46CHrY7P30aLPhueJPHbKfo9L51mvGP_VQkrM1PMYKBTu9RO_xNt84_oFH2wun-shmI9OZv5ybYp4x7KPf1VTkgWEb_0VA4auC2Wpfgf_otPSDGE-8LV7nU-quujFnm-JZVwZTPIN6xXNM6czA8fbsGMm5Cp7rBgSHgF2WXJbZVc4ar4pyh19CjtiD6EuGoVAb84tnadvAGMTfBQ_5CfWsaBCEMbdQyadWs"
                  alt="Terapis mendampingi anak bermain dengan blok kayu edukatif"
                  class="motivational-img"
                />
                <div class="motivational-img-badge">
                  <div class="motivational-img-badge-icon">
                    <span class="material-symbols-outlined" style="font-size:20px">verified</span>
                  </div>
                  <div>
                    <p class="motivational-img-badge-label">Fasilitas Jagakarsa</p>
                    <p class="motivational-img-badge-value">Peralatan Terapi Sensori &amp; Okupasi Lengkap</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </PublicLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import PublicLayout from '../layouts/PublicLayout.vue'
</script>

<style scoped>
/* ============================================================
   HERO
   ============================================================ */
.hero-section { padding: 1.5rem 0 2rem; background: var(--background); }
.breadcrumb { display: flex; align-items: center; gap: 0.5rem; font-size: 12px; color: var(--on-surface-variant); margin-bottom: 1.25rem; }
.bc-link { display: flex; align-items: center; gap: 0.25rem; color: var(--on-surface-variant); text-decoration: none; transition: color 0.2s; }
.bc-link:hover { color: var(--primary); }
.bc-sep, .bc-active { color: var(--on-surface-variant); }
.bc-active { color: var(--primary); font-weight: 600; }

.hero-card {
  background: var(--surface-container-low);
  border: 1px solid rgba(191,200,206,0.3);
  border-radius: var(--radius);
  padding: 2rem 2.5rem;
  position: relative; overflow: hidden;
}
.hero-card-content { position: relative; z-index: 1; max-width: 640px; }
.hero-blob {
  position: absolute; right: -32px; bottom: -40px;
  width: 192px; height: 192px;
  background: rgba(193,232,255,0.3);
  border-radius: 50%; filter: blur(32px);
  pointer-events: none;
}
.hero-badge {
  display: inline-flex; align-items: center; gap: 0.375rem;
  background: var(--secondary-container);
  color: var(--on-secondary-fixed);
  padding: 0.25rem 0.875rem;
  border-radius: 9999px;
  font-size: 12px; font-weight: 600;
  margin-bottom: 0.75rem;
}
.hero-title {
  font-family: var(--font-headline);
  font-size: 36px; font-weight: 700; letter-spacing: -0.015em;
  color: var(--primary); margin: 0 0 0.5rem;
}
.hero-desc { font-size: 16px; line-height: 1.7; color: var(--on-surface-variant); margin: 0; }

/* ============================================================
   MAIN GRID
   ============================================================ */
.main-section { padding: 2rem 0 var(--space-xl); }
.main-grid {
  display: grid;
  grid-template-columns: 7fr 5fr;
  gap: 1.5rem;
  align-items: flex-start;
}
.left-col { display: flex; flex-direction: column; gap: 1.5rem; }
.right-col { position: sticky; top: 90px; }

/* ============================================================
   STEPS CARD
   ============================================================ */
.steps-card {
  background: #fff;
  border: 1px solid rgba(191,200,206,0.3);
  border-radius: var(--radius);
  padding: 2rem;
  box-shadow: 0 8px 24px -4px rgba(58,134,168,0.06);
}
.steps-card-header {
  display: flex; align-items: center; justify-content: space-between;
  padding-bottom: 1.25rem;
  border-bottom: 1px solid rgba(191,200,206,0.2);
  margin-bottom: 1.5rem; gap: 1rem; flex-wrap: wrap;
}
.steps-card-title-group { display: flex; align-items: center; gap: 0.75rem; }
.steps-card-icon {
  width: 40px; height: 40px; border-radius: 50%;
  background: var(--primary-fixed); color: var(--primary);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.steps-card-title { font-family: var(--font-headline); font-size: 24px; font-weight: 700; color: var(--on-surface); margin: 0; }
.steps-card-sub { font-size: 12px; color: var(--on-surface-variant); margin: 0; }
.steps-card-badge {
  background: var(--surface-container);
  color: var(--primary);
  font-size: 12px; font-weight: 600;
  padding: 0.25rem 0.75rem;
  border-radius: 9999px; flex-shrink: 0;
}

/* Timeline */
.timeline {
  display: flex; flex-direction: column; gap: 1.5rem;
  position: relative;
}
.timeline::before {
  content: '';
  position: absolute;
  left: 19px; top: 16px; bottom: 16px;
  width: 2px;
  background: rgba(191,200,206,0.3);
}
.timeline-item { display: flex; align-items: flex-start; gap: 1rem; position: relative; }
.timeline-number {
  width: 40px; height: 40px; border-radius: 50%;
  background: var(--primary); color: #fff;
  font-family: var(--font-headline); font-size: 18px; font-weight: 700;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0; z-index: 1;
  box-shadow: 0 2px 6px rgba(0,99,132,0.25);
  outline: 4px solid #fff;
}
.timeline-content {
  flex: 1;
  background: var(--surface-container-low);
  border: 1px solid rgba(191,200,206,0.2);
  border-radius: var(--radius);
  padding: 1.25rem;
  transition: border-color 0.2s;
}
.timeline-content:hover { border-color: rgba(0,99,132,0.4); }
.timeline-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem; }
.timeline-title { font-family: var(--font-headline); font-size: 18px; font-weight: 700; color: var(--primary); margin: 0; }
.timeline-desc { font-size: 14px; line-height: 1.6; color: var(--on-surface-variant); margin: 0; }
.timeline-note {
  display: flex; align-items: center; gap: 0.5rem;
  margin-top: 0.75rem;
  font-size: 12px; font-weight: 600; color: var(--secondary);
}
.session-pills { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 0.75rem; }
.session-pill {
  display: inline-flex; align-items: center; gap: 0.25rem;
  background: #fff;
  border: 1px solid rgba(191,200,206,0.3);
  color: var(--primary);
  font-size: 12px; font-weight: 600;
  padding: 0.25rem 0.625rem;
  border-radius: 9999px;
}

/* Trust Card */
.trust-card {
  background: #fff;
  border: 1px solid rgba(191,200,206,0.3);
  border-radius: var(--radius);
  padding: 1.5rem;
  box-shadow: 0 8px 24px -4px rgba(58,134,168,0.06);
  display: flex; align-items: center; gap: 1.25rem;
}
.trust-icon {
  width: 56px; height: 56px; border-radius: 50%;
  background: var(--secondary-container); color: var(--secondary);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.trust-title { font-family: var(--font-headline); font-size: 17px; font-weight: 700; color: var(--on-surface); margin: 0 0 0.375rem; }
.trust-desc { font-size: 14px; line-height: 1.6; color: var(--on-surface-variant); margin: 0; }

/* ============================================================
   CONTACT CARD (Right column)
   ============================================================ */
.contact-card {
  background: #fff;
  border: 1px solid rgba(191,200,206,0.3);
  border-radius: var(--radius);
  padding: 2rem;
  box-shadow: 0 8px 24px -4px rgba(58,134,168,0.06);
}
.contact-card-header {
  display: flex; align-items: center; justify-content: space-between;
  padding-bottom: 1.25rem;
  border-bottom: 1px solid rgba(191,200,206,0.2);
  margin-bottom: 1.5rem; gap: 1rem; flex-wrap: wrap;
}
.contact-card-title-group { display: flex; align-items: center; gap: 0.75rem; }
.contact-card-icon {
  width: 40px; height: 40px; border-radius: 50%;
  background: var(--surface-container-high); color: var(--primary);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.contact-card-title { font-family: var(--font-headline); font-size: 24px; font-weight: 700; color: var(--on-surface); margin: 0; }
.contact-card-sub { font-size: 12px; color: var(--on-surface-variant); margin: 0; }
.open-badge {
  display: inline-flex; align-items: center; gap: 0.375rem;
  background: rgba(204,239,142,0.8); color: var(--secondary);
  font-size: 12px; font-weight: 700;
  padding: 0.25rem 0.75rem; border-radius: 9999px;
  flex-shrink: 0;
}
.open-dot {
  width: 8px; height: 8px; border-radius: 50%;
  background: var(--secondary);
  animation: pulse 1.5s ease-in-out infinite;
}
@keyframes pulse { 0%,100% { opacity: 1; } 50% { opacity: 0.4; } }

/* Channels */
.channels { display: flex; flex-direction: column; gap: 0.75rem; }
.channel-item {
  display: flex; align-items: center; gap: 1rem;
  padding: 0.875rem;
  border-radius: var(--radius);
  background: var(--surface-container-low);
  border: 1px solid rgba(191,200,206,0.2);
  text-decoration: none;
  transition: all 0.2s;
}
a.channel-item:hover { background: var(--surface-variant); }
.channel-item--static { cursor: default; }
.channel-icon {
  width: 44px; height: 44px; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
  transition: transform 0.2s;
}
a.channel-item:hover .channel-icon { transform: scale(1.05); }
.channel-icon--green { background: var(--secondary-container); color: var(--secondary); }
.channel-icon--blue  { background: var(--primary-fixed); color: var(--primary); }
.channel-icon--teal  { background: var(--surface-container-high); color: var(--primary); }
.channel-icon--amber { background: var(--tertiary-fixed); color: var(--tertiary); }
.channel-info { flex: 1; display: flex; flex-direction: column; min-width: 0; }
.channel-label { font-size: 11px; font-weight: 600; color: var(--on-surface-variant); letter-spacing: 0.06em; text-transform: uppercase; }
.channel-value { font-size: 16px; font-weight: 600; color: var(--on-surface); }
.channel-value--primary { color: var(--primary); font-size: 18px; font-weight: 700; }
.channel-note { display: flex; align-items: center; gap: 0.25rem; font-size: 12px; color: var(--on-surface-variant); margin-top: 0.25rem; }
.channel-arrow { color: var(--outline); transition: color 0.2s; }
a.channel-item:hover .channel-arrow { color: var(--primary); }

/* Hours row */
.hours-row {
  display: flex; align-items: center; justify-content: space-between;
  padding: 1rem;
  border-radius: var(--radius);
  background: var(--surface-bright, #f7f9ff);
  border: 1px solid rgba(191,200,206,0.2);
  gap: 1rem; flex-wrap: wrap;
}
.hours-left { display: flex; align-items: center; gap: 0.625rem; }
.hours-label { font-size: 12px; color: var(--on-surface-variant); display: block; }
.hours-value { font-size: 14px; font-weight: 600; color: var(--on-surface); display: block; }
.hours-closed { font-size: 13px; color: var(--on-surface-variant); font-weight: 500; }

/* CTA Button */
.contact-cta {
  margin-top: 1.5rem;
  padding-top: 1.25rem;
  border-top: 1px solid rgba(191,200,206,0.2);
}
.btn-daftar {
  display: flex; align-items: center; justify-content: center; gap: 0.5rem;
  width: 100%;
  background: var(--primary); color: #fff;
  font-size: 15px; font-weight: 700;
  padding: 0.875rem 1.5rem;
  border-radius: 9999px;
  text-decoration: none;
  transition: all 0.2s;
  box-shadow: 0 2px 8px rgba(0,99,132,0.2);
}
.btn-daftar:hover { background: var(--primary-container); }
.contact-cta-note { text-align: center; font-size: 12px; color: var(--on-surface-variant); margin-top: 0.625rem; }

/* ============================================================
   MOTIVATIONAL BANNER
   ============================================================ */
.motivational-section { padding-bottom: var(--space-xl); }
.motivational-card {
  background: var(--surface-container-low);
  border: 1px solid rgba(191,200,206,0.3);
  border-radius: var(--radius);
  padding: 2.5rem;
  box-shadow: 0 8px 24px -4px rgba(58,134,168,0.06);
  position: relative; overflow: hidden;
}
.motivational-blob-tr {
  position: absolute; right: -64px; top: -64px;
  width: 256px; height: 256px;
  background: rgba(204,239,142,0.4);
  border-radius: 50%; filter: blur(48px); pointer-events: none;
}
.motivational-blob-bl {
  position: absolute; left: 33%; bottom: -80px;
  width: 288px; height: 288px;
  background: rgba(193,232,255,0.3);
  border-radius: 50%; filter: blur(48px); pointer-events: none;
}
.motivational-inner {
  display: grid; grid-template-columns: 7fr 5fr;
  gap: 2rem; align-items: center;
  position: relative; z-index: 1;
}
.motivational-content { display: flex; flex-direction: column; gap: 1rem; }
.motivational-eyebrow {
  display: inline-flex; align-items: center; gap: 0.375rem;
  background: #fff; color: var(--primary);
  border: 1px solid rgba(191,200,206,0.3);
  font-size: 12px; font-weight: 600;
  padding: 0.375rem 0.875rem; border-radius: 9999px;
  width: fit-content;
}
.motivational-title {
  font-family: var(--font-headline);
  font-size: 36px; font-weight: 700;
  color: var(--on-surface); line-height: 1.25;
  letter-spacing: -0.015em; margin: 0;
}
.motivational-desc { font-size: 18px; line-height: 1.7; color: var(--on-surface-variant); margin: 0; max-width: 560px; }
.motivational-actions { display: flex; flex-wrap: wrap; align-items: center; gap: 1rem; padding-top: 0.5rem; }

.btn-wa-secondary {
  display: inline-flex; align-items: center; gap: 0.5rem;
  background: var(--secondary); color: #fff;
  font-size: 15px; font-weight: 700;
  padding: 0.75rem 1.75rem; border-radius: 9999px;
  text-decoration: none; transition: all 0.2s;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
.btn-wa-secondary:hover { opacity: 0.9; }
.btn-team-link {
  display: inline-flex; align-items: center; gap: 0.25rem;
  font-size: 15px; font-weight: 700; color: var(--primary);
  text-decoration: none; transition: color 0.2s;
}
.btn-team-link:hover { color: var(--primary-container); }

/* Motivational image */
.motivational-image-wrap { position: relative; }
.motivational-image-frame {
  position: relative;
  border-radius: var(--radius);
  overflow: hidden;
  border: 4px solid #fff;
  box-shadow: 0 14px 32px -6px rgba(43,61,79,0.08);
}
.motivational-img { width: 100%; height: 288px; object-fit: cover; display: block; }
.motivational-img-badge {
  position: absolute; bottom: 1rem; left: 1rem; right: 1rem;
  background: rgba(255,255,255,0.9); backdrop-filter: blur(8px);
  border: 1px solid rgba(191,200,206,0.3);
  border-radius: var(--radius);
  padding: 0.875rem;
  display: flex; align-items: center; gap: 0.75rem;
}
.motivational-img-badge-icon {
  width: 40px; height: 40px; border-radius: 50%;
  background: var(--primary-fixed); color: var(--primary);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.motivational-img-badge-label { font-size: 12px; color: var(--on-surface-variant); margin: 0; }
.motivational-img-badge-value { font-size: 14px; font-weight: 700; color: var(--on-surface); margin: 0; }

/* ============================================================
   RESPONSIVE
   ============================================================ */
@media (max-width: 1024px) {
  .main-grid { grid-template-columns: 1fr; }
  .right-col { position: static; }
  .motivational-inner { grid-template-columns: 1fr; }
  .motivational-img { height: 220px; }
}
@media (max-width: 600px) {
  .hero-title { font-size: 26px; }
  .motivational-title { font-size: 24px; }
  .motivational-card, .steps-card, .contact-card { padding: 1.25rem; }
  .steps-card-header { flex-direction: column; align-items: flex-start; }
  .motivational-actions { flex-direction: column; align-items: flex-start; }
}
</style>
