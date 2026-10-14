<template>
  <PublicLayout>
    <main class="about-page">
      <!-- ==================== 1. HERO TITLE & BREADCRUMB ==================== -->
      <section class="about-hero-section">
        <div class="container">
          <!-- Breadcrumb -->
          <nav aria-label="Breadcrumb" class="breadcrumb-nav">
            <ol class="breadcrumb-list">
              <li>
                <router-link to="/" class="breadcrumb-link">
                  <span class="material-symbols-outlined breadcrumb-icon">home</span>
                  <span>Beranda</span>
                </router-link>
              </li>
              <li class="breadcrumb-separator">
                <span class="material-symbols-outlined">chevron_right</span>
              </li>
              <li aria-current="page" class="breadcrumb-current">Tentang Kami</li>
            </ol>
          </nav>

          <!-- Hero Headline & Stat Badge -->
          <div class="hero-content-row">
            <div class="hero-text-block">
              <span class="hero-badge">
                <span class="material-symbols-outlined">verified</span>
                <span>Pusat Edukasi & Terapi Terpercaya Sejak 2018</span>
              </span>
              <h1 class="hero-title">Tentang Kami</h1>
              <p class="hero-desc">
                Mengenal lebih dekat perjalanan, visi, misi, dan nilai-nilai luhur yang memandu kami dalam mendampingi langkah setiap buah hati menuju potensi optimalnya.
              </p>
            </div>

            <!-- 500+ Anak Stat Badge -->
            <div class="hero-stat-card">
              <div class="stat-icon-wrap">
                <span class="material-symbols-outlined">psychology</span>
              </div>
              <div>
                <p class="stat-card-title">500+ Anak Terdampingi</p>
                <p class="stat-card-sub">Pendekatan komprehensif & ramah anak</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ==================== 2. SHOWCASE FOTO FASILITAS KLINIK ==================== -->
      <section class="showcase-section">
        <div class="container">
          <div class="showcase-container-card">
            <div class="showcase-grid">
              <!-- Large Main Clinic Environment Image (Left) -->
              <div class="showcase-main-item">
                <img
                  src="/ruang-terapi-atc.jpg"
                  alt="Fasilitas Ruang Terapi Ramah Anak Amanah Tin's Center"
                  class="showcase-main-img"
                  loading="lazy"
                  decoding="async"
                />
                <div class="showcase-overlay-gradient"></div>

                <!-- Accreditation Badge Floating Overlay -->
                <div class="showcase-floating-badge">
                  <span class="pulse-dot"></span>
                  <span class="badge-text">Klinik Terakreditasi & Nyaman</span>
                </div>

                <!-- Context Caption Overlay -->
                <div class="showcase-caption-overlay">
                  <p class="caption-title">Ruang Sensori Integrasi & Terapi Wicara Berstandar</p>
                  <p class="caption-sub">
                    Dirancang khusus dengan material ramah anak guna membangun rasa aman, stimulasi motorik, dan kenyamanan interaksi terapeutik.
                  </p>
                </div>
              </div>

              <!-- Secondary Image Stack (Right) -->
              <div class="showcase-secondary-col">
                <!-- Secondary 1: Terapis Hangat -->
                <div class="showcase-sub-item">
                  <img
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuBxCcerp34ElrQCVyON58j1OscFg5MR9BsX7NdyFuGBoq6gB_FQOvA-lWaeVbV9BvTm2Qcsps-FJ-mncTnN1N9sM92Mv6vWdfqmtu8xL6IgBvEh0EXzr0H6q1rFlZ2O-ihMCyARgKGqHpAN7clyp9nJ1_2y3BJKkXyCLJn0gEnzqrmDFcKNnPQffyN7W6nwv4bm9bQppfRk6_SrOmP3AtjPzGcblTWq-o6urXk1s7I"
                    alt="Sesi Terapi Interaktif"
                    class="showcase-sub-img"
                    loading="lazy"
                    decoding="async"
                  />
                  <div class="sub-img-dim"></div>
                  <div class="sub-img-badge">
                    <span class="material-symbols-outlined">sentiment_very_satisfied</span>
                    <span>Terapis Hangat & Tersertifikasi</span>
                  </div>
                </div>

                <!-- Secondary 2: Kemitraan Orang Tua -->
                <div class="showcase-sub-item">
                  <img
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuA4gtk40GZi1NAmfUL5OIVkQd4vSYwYZR3sEKjDIs0FfoMv4LcutzmKXlSUAM8egPp_D_GhLUxZ-yI7ruxNIQGT_QnLRU8ICZ5TLjm4DIcSdmHdD83O9mLuA840DclKm0nJbdAZ67PiNrlFrbFPPBe0DDLXyaQhZ8oeYHlqB0GNKxLB-tE5ECfXAJHUtVAlRzA7JtFX2VfylDYCo2gf56tMbCACftxjHWOkLoPnsZE"
                    alt="Ruang Observasi dan Diskusi Keluarga"
                    class="showcase-sub-img"
                    loading="lazy"
                    decoding="async"
                  />
                  <div class="sub-img-dim"></div>
                  <div class="sub-img-badge">
                    <span class="material-symbols-outlined">family_restroom</span>
                    <span>Kemitraan Orang Tua & Anak</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ==================== 3. PROFIL PENDIRI & KISAH ==================== -->
      <section class="founders-section">
        <div class="container">
          <div class="founders-card-box">
            <!-- Soft decorative background glow -->
            <div class="founders-glow glow-top"></div>
            <div class="founders-glow glow-bottom"></div>

            <div class="founders-grid">
              <!-- Kolom Foto Pendiri (Left) -->
              <div class="founders-photo-col">
                <div class="founders-photo-wrap">
                  <div class="photo-frame">
                    <img
                      src="https://lh3.googleusercontent.com/aida-public/AB6AXuAG20WWfa82PFEV3OYgsQt0Bchnns6_zW43xro8OLR_9j2dBD71RQyHdwt77ZPA7Zn0W6wm_y-oTX9XOQ6FTjfdJoezkOT_JPS4GGAJLSlr0M4qfM7EtiyRbpoJv5mGVxbeqbToY0zclQRSBmIEsFRcZES7mvwJa78PdllsOgxQltUosqfgKS-RyOPhHEtqI0UA_9UyK1XcN3qZipayd9S9cKKojyPmG9orG5hrohE"
                      alt="Bapak Artin Ristriawan dan Ibu Hertin Nurfarida"
                      class="founders-img"
                      loading="lazy"
                      decoding="async"
                    />
                  </div>
                  <!-- Founder Capsule Badge -->
                  <div class="founders-capsule-badge">
                    <p class="capsule-title">Didirikan Oleh</p>
                    <p class="capsule-names">Bapak Artin Ristriawan & Ibu Hertin Nurfarida</p>
                  </div>
                </div>
              </div>

              <!-- Kolom Kisah Pendirian & Nilai (Right) -->
              <div class="founders-story-col">
                <div class="story-badge">
                  <span class="material-symbols-outlined">history_edu</span>
                  <span>Kisah di Balik Amanah Tin's Center</span>
                </div>
                <h2 class="story-title">Lahir dari Empati Tulus untuk Masa Depan Setiap Anak</h2>
                <p class="story-p-lead">
                  Amanah Tin's Center (ATC) didirikan oleh <strong>Bapak Artin Ristriawan</strong> dan <strong>Ibu Hertin Nurfarida</strong> atas dasar panggilan hati dan kepedulian mendalam terhadap tantangan tumbuh kembang yang dihadapi banyak keluarga di Indonesia.
                </p>
                <p class="story-p-body">
                  Melihat kekhawatiran para orang tua ketika menghadapi keterlambatan bicara (speech delay), gangguan pemrosesan sensori, hingga kendala fokus dan motorik, kami mendirikan klinik ini sebagai rumah tumbuh kembang yang aman, bebas dari stigma, dan berlandaskan kasih sayang. Kami percaya bahwa setiap anak dianugerahi keunikan serta tempo perkembangan masing-masing yang patut dihargai dan didukung dengan intervensi ilmiah yang tepat.
                </p>

                <!-- 2 Points Grid -->
                <div class="story-points-grid">
                  <div class="point-item">
                    <div class="point-icon-circle bg-secondary-fixed">
                      <span class="material-symbols-outlined">favorite</span>
                    </div>
                    <div>
                      <h4 class="point-title">Pendekatan Holistik</h4>
                      <p class="point-desc">Menyelaraskan emosi anak, metode terapi, dan keterlibatan orang tua.</p>
                    </div>
                  </div>

                  <div class="point-item">
                    <div class="point-icon-circle bg-primary-fixed">
                      <span class="material-symbols-outlined">school</span>
                    </div>
                    <div>
                      <h4 class="point-title">Klinisi Tersertifikasi</h4>
                      <p class="point-desc">Lulusan universitas ternama dengan sertifikasi profesi resmi.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ==================== 4. VISI & MISI UTAMA ==================== -->
      <section class="vision-mission-section">
        <div class="container">
          <div class="section-center-header">
            <span class="center-badge">
              <span class="material-symbols-outlined">flag</span>
              <span>Arah Perjalanan Kami</span>
            </span>
            <h2 class="center-title">Visi & Misi Utama</h2>
            <p class="center-sub">Komitmen berkelanjutan untuk menghadirkan layanan terapi pediatrik bermutu tinggi, terjangkau, dan humanis.</p>
          </div>

          <div class="vm-grid">
            <!-- Kartu Visi -->
            <div class="vm-card">
              <div class="corner-accent corner-primary"></div>
              <div>
                <div class="vm-icon-wrap icon-primary-box">
                  <span class="material-symbols-outlined">lightbulb</span>
                </div>
                <span class="vm-tag tag-primary">CITA-CITA LUHUR</span>
                <h3 class="vm-title">Visi Kami</h3>
                <p class="vm-desc">
                  Menjadi pusat terapi tumbuh kembang anak terdepan, terpercaya, dan berkarakter di Indonesia yang berorientasi pada pencapaian potensi terbaik setiap anak melalui pelayanan yang profesional, hangat, dan berbasis bukti klinis modern.
                </p>
              </div>
              <div class="vm-footer">
                <span class="material-symbols-outlined footer-icon-primary">stars</span>
                <span class="vm-footer-text">Berlandaskan integritas, inovasi metode, dan kasih sayang tulus.</span>
              </div>
            </div>

            <!-- Kartu Misi -->
            <div class="vm-card">
              <div class="corner-accent corner-secondary"></div>
              <div>
                <div class="vm-icon-wrap icon-secondary-box">
                  <span class="material-symbols-outlined">assignment_turned_in</span>
                </div>
                <span class="vm-tag tag-secondary">LANGKAH NYATA</span>
                <h3 class="vm-title">Misi Kami</h3>
                <ul class="mission-list">
                  <li class="mission-item">
                    <div class="check-circle">
                      <span class="material-symbols-outlined">check</span>
                    </div>
                    <p class="mission-text">
                      <strong>Pelayanan Berkualitas:</strong> Memberikan layanan terapi wicara, sensori integrasi, okupasi, dan psikologi anak yang berkesinambungan dan terstandarisasi.
                    </p>
                  </li>
                  <li class="mission-item">
                    <div class="check-circle">
                      <span class="material-symbols-outlined">check</span>
                    </div>
                    <p class="mission-text">
                      <strong>Dukungan Holistik:</strong> Mendorong stimulasi komprehensif yang mencakup fisik, emosi, kognitif, dan kemandirian sosial anak secara terpadu.
                    </p>
                  </li>
                  <li class="mission-item">
                    <div class="check-circle">
                      <span class="material-symbols-outlined">check</span>
                    </div>
                    <p class="mission-text">
                      <strong>Edukasi & Kemitraan:</strong> Membangun kolaborasi erat dengan orang tua dan guru melalui evaluasi berkala dan modul pendampingan harian di rumah.
                    </p>
                  </li>
                </ul>
              </div>
              <div class="vm-footer">
                <span class="material-symbols-outlined footer-icon-secondary">handshake</span>
                <span class="vm-footer-text">Tumbuh bersama keluarga untuk hasil terapi yang optimal.</span>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ==================== 5. NILAI-NILAI KAMI ==================== -->
      <section class="values-section">
        <div class="container">
          <div class="section-center-header">
            <span class="center-badge">
              <span class="material-symbols-outlined">workspace_premium</span>
              <span>Fondasi Kebajikan</span>
            </span>
            <h2 class="center-title">Nilai-Nilai Kami</h2>
            <p class="center-sub">Empat pilar nilai yang menuntun etika kerja tim klinisi dan terapis kami dalam setiap sesi terapi.</p>
          </div>

          <div class="values-cards-grid">
            <!-- Pillar 1: Amanah -->
            <div class="value-item-card">
              <div class="val-icon-circle bg-primary-soft">
                <span class="material-symbols-outlined">security</span>
              </div>
              <h3 class="val-name">Amanah</h3>
              <span class="val-sub sub-primary">(Kepercayaan)</span>
              <p class="val-desc">
                Menjaga integritas dan kepercayaan penuh yang dititipkan oleh orang tua dengan keterbukaan laporan dan evaluasi berkala yang jujur.
              </p>
            </div>

            <!-- Pillar 2: Profesional -->
            <div class="value-item-card">
              <div class="val-icon-circle bg-secondary-soft">
                <span class="material-symbols-outlined">verified_user</span>
              </div>
              <h3 class="val-name">Profesional</h3>
              <span class="val-sub sub-secondary">(Integritas)</span>
              <p class="val-desc">
                Menerapkan protokol klinis tervalidasi, sertifikasi berkelanjutan, serta pengawasan mutu berkala bagi seluruh praktisi terapi kami.
              </p>
            </div>

            <!-- Pillar 3: Peduli -->
            <div class="value-item-card">
              <div class="val-icon-circle bg-tertiary-soft">
                <span class="material-symbols-outlined">volunteer_activism</span>
              </div>
              <h3 class="val-name">Peduli</h3>
              <span class="val-sub sub-tertiary">(Empati)</span>
              <p class="val-desc">
                Mendengarkan dengan hati, memperlakukan anak laksana keluarga sendiri, dan memberikan ruang emosional yang ramah tanpa penghakiman.
              </p>
            </div>

            <!-- Pillar 4: Berkembang -->
            <div class="value-item-card">
              <div class="val-icon-circle bg-high-soft">
                <span class="material-symbols-outlined">trending_up</span>
              </div>
              <h3 class="val-name">Berkembang</h3>
              <span class="val-sub sub-primary">(Inovasi)</span>
              <p class="val-desc">
                Terus memperbarui instrumen sensori, teknologi penunjang terapi, dan modul edukasi orang tua yang adaptif mengikuti perkembangan zaman.
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- ==================== 6. BANNER KONSULTASI / CTA ==================== -->
      <section class="cta-banner-section" id="daftar">
        <div class="container">
          <div class="cta-banner-box">
            <div class="cta-left-content">
              <span class="cta-badge">
                <span class="material-symbols-outlined">chat</span>
                <span>Konsultasi Bebas Tekanan</span>
              </span>
              <h2 class="cta-title">Ingin Berkonsultasi Mengenai Tumbuh Kembang Anak Anda?</h2>
              <p class="cta-sub">
                Tim asesmen kami siap mendengar cerita Ayah dan Bunda serta membantu merancang jalur stimulasi yang tepat untuk ananda.
              </p>
            </div>

            <div class="cta-actions-wrap">
              <a :href="waLink()" target="_blank" rel="noopener noreferrer" class="btn-wa-sage">
                <span class="material-symbols-outlined">chat_bubble</span>
                <span>Hubungi WhatsApp Kami</span>
              </a>
              <router-link to="/jadwal-pendaftaran" class="btn-outline-schedule">
                <span class="material-symbols-outlined">calendar_month</span>
                <span>Lihat Jadwal Terapis</span>
              </router-link>
            </div>
          </div>
        </div>
      </section>
    </main>
  </PublicLayout>
</template>

<script setup>
import PublicLayout from '../layouts/PublicLayout.vue'
import { useClinicSettings } from '../composables/useClinicSettings'

const { waLink } = useClinicSettings()
</script>

<style scoped>
.about-page {
  width: 100%;
  background-color: var(--background);
}

/* ==================== 1. HERO TITLE & BREADCRUMB ==================== */
.about-hero-section {
  background: linear-gradient(to bottom, var(--surface-container-low), var(--surface-container-lowest), var(--background));
  padding-top: 2.5rem;
  padding-bottom: 3rem;
  border-bottom: 1px solid rgba(191, 200, 206, 0.2);
}

.breadcrumb-nav {
  margin-bottom: 1rem;
}

.breadcrumb-list {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  list-style: none;
  padding: 0;
  margin: 0;
  font-family: var(--font-body);
  font-size: 13px;
  font-weight: 600;
  color: var(--on-surface-variant);
}

.breadcrumb-link {
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
  color: var(--on-surface-variant);
  text-decoration: none;
  transition: color 0.2s ease;
}

.breadcrumb-link:hover {
  color: var(--primary);
}

.breadcrumb-icon {
  font-size: 16px;
}

.breadcrumb-separator {
  display: flex;
  align-items: center;
  color: var(--outline-variant);
}

.breadcrumb-separator .material-symbols-outlined {
  font-size: 16px;
}

.breadcrumb-current {
  font-weight: 700;
  color: var(--primary);
}

.hero-content-row {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: flex-start;
  gap: 1.5rem;
}

@media (min-width: 1024px) {
  .hero-content-row {
    flex-direction: row;
    align-items: flex-end;
  }
}

.hero-text-block {
  max-width: 780px;
}

.hero-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.35rem 0.9rem;
  border-radius: var(--radius-full);
  background-color: var(--surface-container-high);
  color: var(--primary);
  font-family: var(--font-body);
  font-size: 13px;
  font-weight: 600;
  border: 1px solid rgba(191, 200, 206, 0.3);
  margin-bottom: 0.75rem;
}

.hero-badge .material-symbols-outlined {
  font-size: 16px;
}

.hero-title {
  font-family: var(--font-headline);
  font-size: 2.25rem;
  font-weight: 700;
  color: var(--on-surface);
  line-height: 1.2;
  margin-bottom: 0.75rem;
}

@media (min-width: 768px) {
  .hero-title {
    font-size: 2.75rem;
  }
}

.hero-desc {
  font-size: 1.05rem;
  color: var(--on-surface-variant);
  line-height: 1.6;
  max-width: 650px;
}

.hero-stat-card {
  display: none;
  align-items: center;
  gap: 0.85rem;
  background-color: var(--surface-container-lowest);
  padding: 0.75rem 1.25rem;
  border-radius: 1rem;
  border: 1px solid rgba(191, 200, 206, 0.3);
  box-shadow: var(--shadow-soft);
  flex-shrink: 0;
}

@media (min-width: 1024px) {
  .hero-stat-card {
    display: flex;
  }
}

.stat-icon-wrap {
  width: 48px;
  height: 48px;
  border-radius: 0.75rem;
  background-color: var(--secondary-fixed);
  color: var(--secondary);
  display: flex;
  align-items: center;
  justify-content: center;
}

.stat-icon-wrap .material-symbols-outlined {
  font-size: 26px;
}

.stat-card-title {
  font-family: var(--font-headline);
  font-size: 16px;
  font-weight: 700;
  color: var(--on-surface);
  line-height: 1.2;
}

.stat-card-sub {
  font-size: 12px;
  color: var(--on-surface-variant);
}

/* ==================== 2. SHOWCASE FOTO FASILITAS ==================== */
.showcase-section {
  margin-top: -1.25rem;
  margin-bottom: 3.5rem;
}

.showcase-container-card {
  background-color: var(--surface-container-lowest);
  border-radius: 1.5rem;
  padding: 1.25rem;
  border: 1px solid rgba(191, 200, 206, 0.3);
  box-shadow: var(--shadow-soft);
}

@media (min-width: 768px) {
  .showcase-container-card {
    padding: 1.5rem;
  }
}

.showcase-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.25rem;
}

@media (min-width: 768px) {
  .showcase-grid {
    grid-template-columns: repeat(12, 1fr);
  }
}

.showcase-main-item {
  position: relative;
  border-radius: 1.25rem;
  overflow: hidden;
  min-height: 360px;
}

@media (min-width: 768px) {
  .showcase-main-item {
    grid-column: span 8;
    min-height: 440px;
  }
}

.showcase-main-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform 0.6s ease;
}

.showcase-main-item:hover .showcase-main-img {
  transform: scale(1.03);
}

.showcase-overlay-gradient {
  position: absolute;
  inset: 0;
  background: linear-gradient(to top, rgba(9, 29, 46, 0.75) 0%, rgba(9, 29, 46, 0.2) 50%, transparent 100%);
}

.showcase-floating-badge {
  position: absolute;
  top: 1.25rem;
  left: 1.25rem;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  background-color: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(8px);
  padding: 0.5rem 1rem;
  border-radius: var(--radius-full);
  border: 1px solid rgba(191, 200, 206, 0.3);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.pulse-dot {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background-color: var(--secondary);
  animation: pulseAnim 2s infinite;
}

@keyframes pulseAnim {
  0%, 100% { opacity: 1; transform: scale(1); }
  50% { opacity: 0.5; transform: scale(1.2); }
}

.badge-text {
  font-family: var(--font-headline);
  font-size: 13.5px;
  font-weight: 700;
  color: var(--primary);
}

.showcase-caption-overlay {
  position: absolute;
  bottom: 1.5rem;
  left: 1.5rem;
  right: 1.5rem;
  color: #ffffff;
}

.caption-title {
  font-family: var(--font-headline);
  font-size: 1.15rem;
  font-weight: 700;
  color: #ffffff;
  margin-bottom: 0.35rem;
}

.caption-sub {
  font-size: 13.5px;
  color: rgba(255, 255, 255, 0.9);
  line-height: 1.45;
  max-width: 600px;
}

/* Secondary Column */
.showcase-secondary-col {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
}

@media (min-width: 768px) {
  .showcase-secondary-col {
    grid-column: span 4;
  }
}

.showcase-sub-item {
  position: relative;
  border-radius: 1.25rem;
  overflow: hidden;
  flex: 1;
  min-height: 200px;
  border: 1px solid rgba(191, 200, 206, 0.2);
}

.showcase-sub-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform 0.6s ease;
}

.showcase-sub-item:hover .showcase-sub-img {
  transform: scale(1.04);
}

.sub-img-dim {
  position: absolute;
  inset: 0;
  background-color: rgba(9, 29, 46, 0.15);
}

.sub-img-badge {
  position: absolute;
  bottom: 0.85rem;
  left: 1rem;
  right: 1rem;
  background-color: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(8px);
  padding: 0.5rem 0.85rem;
  border-radius: 0.75rem;
  border: 1px solid rgba(191, 200, 206, 0.25);
  display: flex;
  align-items: center;
  gap: 0.45rem;
  font-family: var(--font-headline);
  font-size: 13px;
  font-weight: 700;
  color: var(--primary);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.sub-img-badge .material-symbols-outlined {
  font-size: 18px;
}

/* ==================== 3. PROFIL PENDIRI & KISAH ==================== */
.founders-section {
  margin-bottom: 3.5rem;
}

.founders-card-box {
  background-color: var(--surface-container-lowest);
  border-radius: 2rem;
  padding: 2rem;
  border: 1px solid rgba(191, 200, 206, 0.3);
  box-shadow: var(--shadow-soft);
  position: relative;
  overflow: hidden;
}

@media (min-width: 768px) {
  .founders-card-box {
    padding: 3rem;
  }
}

.founders-glow {
  position: absolute;
  width: 320px;
  height: 320px;
  border-radius: 50%;
  filter: blur(70px);
  pointer-events: none;
  opacity: 0.45;
}

.glow-top {
  right: -5rem;
  top: -5rem;
  background-color: var(--secondary-fixed);
}

.glow-bottom {
  left: -5rem;
  bottom: -5rem;
  background-color: var(--primary-fixed);
}

.founders-grid {
  position: relative;
  display: grid;
  grid-template-columns: 1fr;
  gap: 2.5rem;
  align-items: center;
  z-index: 2;
}

@media (min-width: 1024px) {
  .founders-grid {
    grid-template-columns: repeat(12, 1fr);
    gap: 3rem;
  }
}

.founders-photo-col {
  display: flex;
  flex-direction: column;
  align-items: center;
}

@media (min-width: 1024px) {
  .founders-photo-col {
    grid-column: span 5;
  }
}

.founders-photo-wrap {
  position: relative;
  width: 100%;
  max-width: 400px;
}

.photo-frame {
  border-radius: 1.5rem;
  overflow: hidden;
  border: 4px solid var(--surface-container-lowest);
  box-shadow: var(--shadow-lift);
}

.founders-img {
  width: 100%;
  height: 380px;
  object-fit: cover;
  display: block;
}

.founders-capsule-badge {
  position: absolute;
  bottom: -1.25rem;
  left: 50%;
  transform: translateX(-50%);
  background-color: var(--surface-container-lowest);
  padding: 0.65rem 1.5rem;
  border-radius: var(--radius-full);
  border: 1px solid rgba(191, 200, 206, 0.3);
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
  text-align: center;
  white-space: nowrap;
}

.capsule-title {
  font-family: var(--font-headline);
  font-size: 13.5px;
  font-weight: 700;
  color: var(--primary);
  line-height: 1.2;
}

.capsule-names {
  font-size: 13px;
  font-weight: 600;
  color: var(--on-surface);
}

/* Founders Story */
.founders-story-col {
  display: flex;
  flex-direction: column;
  justify-content: center;
}

@media (min-width: 1024px) {
  .founders-story-col {
    grid-column: span 7;
  }
}

.story-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.35rem 0.85rem;
  border-radius: var(--radius-full);
  background-color: var(--surface-container-high);
  color: var(--primary);
  font-size: 13px;
  font-weight: 600;
  width: fit-content;
  margin-bottom: 1rem;
}

.story-badge .material-symbols-outlined {
  font-size: 16px;
}

.story-title {
  font-family: var(--font-headline);
  font-size: 1.75rem;
  font-weight: 700;
  color: var(--on-surface);
  line-height: 1.25;
  margin-bottom: 1rem;
}

@media (min-width: 768px) {
  .story-title {
    font-size: 2.15rem;
  }
}

.story-p-lead {
  font-size: 15px;
  color: var(--on-surface-variant);
  line-height: 1.6;
  margin-bottom: 0.85rem;
}

.story-p-body {
  font-size: 14.5px;
  color: var(--on-surface-variant);
  line-height: 1.6;
  margin-bottom: 1.5rem;
}

.story-points-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.25rem;
  padding-top: 1rem;
  border-top: 1px solid rgba(191, 200, 206, 0.3);
}

@media (min-width: 640px) {
  .story-points-grid {
    grid-template-columns: 1fr 1fr;
  }
}

.point-item {
  display: flex;
  align-items: flex-start;
  gap: 0.75rem;
}

.point-icon-circle {
  width: 38px;
  height: 38px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  margin-top: 2px;
}

.bg-secondary-fixed {
  background-color: var(--secondary-fixed);
  color: var(--secondary);
}

.bg-primary-fixed {
  background-color: var(--primary-fixed);
  color: var(--primary);
}

.point-icon-circle .material-symbols-outlined {
  font-size: 20px;
}

.point-title {
  font-family: var(--font-headline);
  font-size: 15px;
  font-weight: 600;
  color: var(--on-surface);
  line-height: 1.2;
}

.point-desc {
  font-size: 13px;
  color: var(--on-surface-variant);
  margin-top: 0.2rem;
  line-height: 1.45;
}

/* ==================== 4. VISI & MISI UTAMA ==================== */
.vision-mission-section {
  margin-bottom: 3.5rem;
}

.section-center-header {
  text-align: center;
  max-width: 680px;
  margin: 0 auto 2.5rem;
}

.center-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.45rem;
  padding: 0.35rem 0.85rem;
  border-radius: var(--radius-full);
  background-color: var(--surface-container-high);
  color: var(--primary);
  font-size: 13px;
  font-weight: 600;
  border: 1px solid rgba(191, 200, 206, 0.25);
  margin-bottom: 0.5rem;
}

.center-badge .material-symbols-outlined {
  font-size: 16px;
}

.center-title {
  font-family: var(--font-headline);
  font-size: 1.85rem;
  font-weight: 700;
  color: var(--on-surface);
  line-height: 1.2;
}

@media (min-width: 768px) {
  .center-title {
    font-size: 2.25rem;
  }
}

.center-sub {
  font-size: 14.5px;
  color: var(--on-surface-variant);
  margin-top: 0.5rem;
  line-height: 1.5;
}

.vm-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 2rem;
}

@media (min-width: 768px) {
  .vm-grid {
    grid-template-columns: 1fr 1fr;
  }
}

.vm-card {
  background-color: var(--surface-container-lowest);
  border-radius: 1.5rem;
  padding: 2rem;
  border: 1px solid rgba(191, 200, 206, 0.3);
  box-shadow: var(--shadow-soft);
  position: relative;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}

@media (min-width: 768px) {
  .vm-card {
    padding: 2.5rem;
  }
}

.vm-card:hover {
  transform: translateY(-4px);
  box-shadow: var(--shadow-lift);
}

.corner-accent {
  position: absolute;
  top: 0;
  right: 0;
  width: 120px;
  height: 120px;
  border-bottom-left-radius: 100%;
  pointer-events: none;
}

.corner-primary {
  background-color: rgba(193, 232, 255, 0.4);
}

.corner-secondary {
  background-color: rgba(204, 239, 142, 0.4);
}

.vm-icon-wrap {
  width: 56px;
  height: 56px;
  border-radius: 1rem;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 1.5rem;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.icon-primary-box {
  background-color: var(--surface-container-high);
  color: var(--primary);
}

.icon-secondary-box {
  background-color: var(--secondary-fixed);
  color: var(--secondary);
}

.vm-icon-wrap .material-symbols-outlined {
  font-size: 28px;
}

.vm-tag {
  display: inline-block;
  font-family: var(--font-headline);
  font-size: 12px;
  font-weight: 700;
  letter-spacing: 0.05em;
  text-transform: uppercase;
}

.tag-primary {
  color: var(--primary);
}

.tag-secondary {
  color: var(--secondary);
}

.vm-title {
  font-family: var(--font-headline);
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--on-surface);
  margin-top: 0.2rem;
  margin-bottom: 1rem;
}

.vm-desc {
  font-size: 15px;
  color: var(--on-surface-variant);
  line-height: 1.6;
}

.mission-list {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.mission-item {
  display: flex;
  align-items: flex-start;
  gap: 0.75rem;
}

.check-circle {
  width: 24px;
  height: 24px;
  border-radius: 50%;
  background-color: var(--secondary-fixed);
  color: var(--secondary);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  margin-top: 2px;
}

.check-circle .material-symbols-outlined {
  font-size: 16px;
}

.mission-text {
  font-size: 14.5px;
  color: var(--on-surface-variant);
  line-height: 1.5;
}

.vm-footer {
  margin-top: 2rem;
  padding-top: 1.5rem;
  border-top: 1px solid rgba(191, 200, 206, 0.25);
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.footer-icon-primary {
  color: var(--primary);
  font-size: 24px;
}

.footer-icon-secondary {
  color: var(--secondary);
  font-size: 24px;
}

.vm-footer-text {
  font-size: 13.5px;
  font-weight: 600;
  color: var(--on-surface);
}

/* ==================== 5. NILAI-NILAI KAMI ==================== */
.values-section {
  margin-bottom: 3.5rem;
}

.values-cards-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.5rem;
}

@media (min-width: 640px) {
  .values-cards-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 1024px) {
  .values-cards-grid {
    grid-template-columns: repeat(4, 1fr);
  }
}

.value-item-card {
  background-color: var(--surface-container-lowest);
  border-radius: 1.25rem;
  padding: 1.75rem 1.25rem;
  border: 1px solid rgba(191, 200, 206, 0.3);
  box-shadow: var(--shadow-soft);
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.value-item-card:hover {
  transform: translateY(-4px);
  box-shadow: var(--shadow-lift);
}

.val-icon-circle {
  width: 64px;
  height: 64px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 1rem;
  transition: transform 0.25s ease;
}

.value-item-card:hover .val-icon-circle {
  transform: scale(1.08);
}

.val-icon-circle .material-symbols-outlined {
  font-size: 30px;
}

.bg-primary-soft {
  background-color: var(--surface-container-high);
  color: var(--primary);
}

.bg-secondary-soft {
  background-color: var(--secondary-fixed);
  color: var(--secondary);
}

.bg-tertiary-soft {
  background-color: var(--tertiary-fixed);
  color: var(--tertiary);
}

.bg-high-soft {
  background-color: var(--surface-container-highest);
  color: var(--primary);
}

.val-name {
  font-family: var(--font-headline);
  font-size: 17px;
  font-weight: 700;
  color: var(--on-surface);
  line-height: 1.2;
}

.val-sub {
  font-size: 12.5px;
  font-weight: 700;
  margin-bottom: 0.75rem;
}

.sub-primary {
  color: var(--primary);
}

.sub-secondary {
  color: var(--secondary);
}

.sub-tertiary {
  color: var(--tertiary);
}

.val-desc {
  font-size: 13.5px;
  color: var(--on-surface-variant);
  line-height: 1.5;
}

/* ==================== 6. CALL TO ACTION BANNER ==================== */
.cta-banner-section {
  margin-bottom: 4rem;
}

.cta-banner-box {
  background: linear-gradient(to right, var(--surface-container-high), var(--surface-container-low), rgba(204, 239, 142, 0.4));
  border-radius: 1.75rem;
  padding: 2.25rem 2rem;
  border: 1px solid rgba(191, 200, 206, 0.35);
  box-shadow: var(--shadow-soft);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-between;
  gap: 2rem;
}

@media (min-width: 1024px) {
  .cta-banner-box {
    flex-direction: row;
    padding: 3rem;
  }
}

.cta-left-content {
  max-width: 650px;
  text-align: center;
}

@media (min-width: 1024px) {
  .cta-left-content {
    text-align: left;
  }
}

.cta-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.45rem;
  padding: 0.35rem 0.85rem;
  border-radius: var(--radius-full);
  background-color: var(--surface-container-lowest);
  color: var(--secondary);
  font-size: 13px;
  font-weight: 700;
  margin-bottom: 0.75rem;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
}

.cta-badge .material-symbols-outlined {
  font-size: 16px;
}

.cta-title {
  font-family: var(--font-headline);
  font-size: 1.75rem;
  font-weight: 700;
  color: var(--on-surface);
  line-height: 1.25;
  margin-bottom: 0.75rem;
}

@media (min-width: 768px) {
  .cta-title {
    font-size: 2.15rem;
  }
}

.cta-sub {
  font-size: 15px;
  color: var(--on-surface-variant);
  line-height: 1.55;
}

.cta-actions-wrap {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1rem;
  flex-shrink: 0;
  width: 100%;
}

@media (min-width: 640px) {
  .cta-actions-wrap {
    flex-direction: row;
    width: auto;
  }
}

.btn-wa-sage {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.6rem;
  padding: 0.85rem 1.75rem;
  border-radius: var(--radius-full);
  background-color: var(--secondary);
  color: var(--on-secondary);
  font-family: var(--font-headline);
  font-size: 14.5px;
  font-weight: 600;
  text-decoration: none;
  box-shadow: 0 4px 12px rgba(75, 103, 22, 0.25);
  transition: all 0.2s ease;
  width: 100%;
}

@media (min-width: 640px) {
  .btn-wa-sage {
    width: auto;
  }
}

.btn-wa-sage:hover {
  background-color: var(--secondary-container);
  color: var(--on-secondary-fixed);
  transform: translateY(-2px);
}

.btn-wa-sage .material-symbols-outlined {
  font-size: 20px;
}

.btn-outline-schedule {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 0.85rem 1.75rem;
  border-radius: var(--radius-full);
  background-color: var(--surface-container-lowest);
  color: var(--primary);
  border: 1px solid rgba(191, 200, 206, 0.4);
  font-family: var(--font-headline);
  font-size: 14.5px;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.2s ease;
  width: 100%;
}

@media (min-width: 640px) {
  .btn-outline-schedule {
    width: auto;
  }
}

.btn-outline-schedule:hover {
  background-color: var(--surface-container-high);
  transform: translateY(-2px);
}

.btn-outline-schedule .material-symbols-outlined {
  font-size: 20px;
}
</style>
