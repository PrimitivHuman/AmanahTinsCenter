<template>
  <PublicLayout>
    <!-- ==================== 1. HERO SECTION ==================== -->
    <section class="hero-section" id="beranda">
      <div class="container">
        <div class="hero-grid">
          <!-- Left: Hero Text -->
          <div class="hero-text fade-in-up">
            <!-- Badge -->
            <div class="hero-badge">
              <span class="material-symbols-outlined icon-fill">favorite</span>
              <span>Klinik Tumbuh Kembang Ramah Anak & Keluarga</span>
            </div>
            
            <!-- Headline -->
            <div class="hero-headline">
              <span class="headline-sub">Setiap Anak Berhak</span>
              <h1 class="headline-main">Berkembang Secara Optimal</h1>
            </div>
            
            <!-- Subheadline -->
            <p class="hero-desc">
              Amanah Tin's Center hadir untuk mendampingi tumbuh kembang buah hati dengan metode terapi terukur, profesional, holistik, dan penuh kasih sayang dalam suasana yang hangat dan bersahabat.
            </p>
            
            <!-- CTAs -->
            <div class="hero-ctas">
              <router-link to="/jadwal-pendaftaran" class="btn-primary-hero">
                <span>Jadwalkan Konsultasi</span>
                <span class="material-symbols-outlined">calendar_month</span>
              </router-link>
            </div>
            
            <!-- Trust Badges & Clinical Endorsement (Foto Asli Avatar Bukti Sosial) -->
            <div class="hero-trust">
              <div class="trust-avatars">
                <img
                  src="https://lh3.googleusercontent.com/aida-public/AB6AXuDndS1MEqhUoM1jUcloTszQuiVyvZQQTdkWTSuBfJTiomzP1PM9XqIRCM9jqFGt1cW7d3Leb19e2RyIVFI-ZAZVTtp0cqgL1J5nVzOeM9xb3jMOsV1syIVqmGBEzTpxgNh7DR4Bmof0JjfqdICLKa4vueP7V49v6bJx6jBVOILCbqk-mUAQWiGEt6MTKP0dWcxjtDpTGkGPMvUKtluVegL-I7DXLjkf67qRXyeHcC4"
                  alt="Orang Tua ATC"
                  class="trust-avatar-img"
                  title="Bunda Sarah & Ananda Kenzo"
                />
                <img
                  src="https://lh3.googleusercontent.com/aida-public/AB6AXuBVAjj2_99GAssxWy4C6hTn27yt7kYZe2i0qsUsgpGRLAq1dsRAzKGQN9PngQD-eLgAv_j19Tc3Y1D2ZOwLi17idZKvk6tEW5EYD5j4V8Oe2WTWmHgj3NaktVCavHdsCMDaZc0kG5owNajF4MGnh7xHWInfth-r3HLBjrJLLF9X1s1PkwXpVZ-HNaJ4IhQ-ZtKXIBikWwNr1SHDHiavrHJb5bQYR-fQgncvJVq9oPU"
                  alt="Anak Ceria ATC"
                  class="trust-avatar-img"
                  title="Ananda Aisyah"
                />
                <img
                  src="https://lh3.googleusercontent.com/aida-public/AB6AXuDEqiyk6121gv8ChNiZuew6FvZqYM6PDAblTcYiCp2zrKejXMcq6F6UwgjGu7Iaa3e4rXhIrp_ywvJu9Kz9EhZiKd2459Um-Gc6zqJkmD5lhWLepwgqsb7evjTW02DHYySTvbEICSv5mKabSc6kIEwah6t2brhAK9Ha_QJuZU78_R80wE4TxyfldjEjEqtUW1cwa3Hj7QA3-OuMXKmQRyIu4-9fb9bGbMCfwDx090c"
                  alt="Terapis ATC"
                  class="trust-avatar-img"
                  title="Terapis Annisa bersama Ananda"
                />
                <div class="trust-avatar-badge" title="Lebih dari 400 keluarga terlayani">+400</div>
              </div>
              <div class="trust-content">
                <div class="stars">
                  <span v-for="i in 5" :key="i" class="material-symbols-outlined star icon-fill">star</span>
                  <span class="star-rating-val">4.9/5.0</span>
                </div>
                <span class="trust-desc">Dipercaya 400+ orang tua di Jagakarsa & sekitarnya</span>
              </div>
            </div>
          </div>

          <!-- Right: Hero Media -->
          <div class="hero-media-wrap">
            <div class="hero-backdrop-blob"></div>
            <div class="hero-image-card">
              <img
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBSomNiaRch3AG4p8CFoFGVtFLAkrg-N8gEtBcoTao1QojSHQ7L-W-vTrweEtaSa424MxTXmSrsRrwJv8eyCWMkH2pUJRG_H8aZbmsl3VV9Nhec_O5jUwNse-qUJ4gIQTGsRYcAk3kHyIklcxIuCrCYGGZRoTOPdifAmBtyIGV9pIGKaOduHdIY6v2MMFMfShJPubKVQxhXLVhj5Sp9I0NISp-fURn8bOJL7FqZpqI"
                alt="Terapis mendampingi anak dalam sesi terapi"
                class="hero-img"
              />
              <!-- Floating Supportive Pill Badge -->
              <div class="hero-float-badge">
                <div class="float-badge-left">
                  <div class="float-badge-icon">
                    <span class="material-symbols-outlined">verified</span>
                  </div>
                  <div>
                    <h4 class="float-badge-title">Terapis Bersertifikasi</h4>
                    <p class="float-badge-sub">Lulusan terapis wicara & okupasi profesional</p>
                  </div>
                </div>
                <span class="float-badge-pct">100% Edukatif</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ==================== 2. FOUR PILLARS VALUE PROPOSITION ==================== -->
    <section class="pillars-section">
      <div class="container">
        <div class="pillars-grid">
          <div v-for="p in pillars" :key="p.title" class="pillar-card">
            <div class="pillar-icon" :class="p.bg">
              <span class="material-symbols-outlined">{{ p.icon }}</span>
            </div>
            <h3 class="pillar-title">{{ p.title }}</h3>
            <p class="pillar-desc">{{ p.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ==================== 3. ABOUT SECTION (MENGENAL AMANAH TIN'S CENTER) ==================== -->
    <section class="about-section" id="tentang-kami">
      <div class="container">
        <div class="about-container-box">
          <div class="about-grid">
            <!-- Left Text -->
            <div class="about-text-col">
              <span class="section-badge-label">TENTANG KAMI</span>
              <h2 class="about-title">Mengenal Amanah Tin's Center</h2>
              <p class="about-desc">
                Amanah Tin's Center (ATC) adalah pusat terapi tumbuh kembang anak yang didirikan oleh <strong>Bapak Artin Ristriawan</strong> dan <strong>Ibu Hertin Nurfarida</strong>. Kami lahir dari tekad tulus untuk memberikan layanan terapi yang profesional, holistik, terjangkau, dan berorientasi penuh pada potensi terbaik setiap anak.
              </p>
              <p class="about-desc">
                Kami percaya keterbukaan kemitraan antara terapis dan orang tua adalah kunci keberhasilan stimulasi motorik, sensorik, dan wicara.
              </p>
              
              <!-- Stats Row -->
              <div class="about-stats-row">
                <div class="about-stat-box">
                  <span class="stat-num stat-primary">10+ Thn</span>
                  <span class="stat-label">Pengalaman Pendiri</span>
                </div>
                <div class="about-stat-box">
                  <span class="stat-num stat-secondary">4 Bidang</span>
                  <span class="stat-label">Layanan Komprehensif</span>
                </div>
              </div>

              <div class="about-cta-wrap">
                <router-link to="/tentang-kami" class="btn-primary-about">
                  <span>Selengkapnya Tentang Kami</span>
                  <span class="material-symbols-outlined">arrow_forward</span>
                </router-link>
              </div>
            </div>

            <!-- Right Showcase -->
            <div class="about-media-col">
              <div class="about-img-frame">
                <img
                  src="/ruang-terapi-atc.jpg"
                  alt="Fasilitas Ruang Terapi Ramah Anak Amanah Tin's Center"
                  class="about-img"
                  loading="lazy"
                  decoding="async"
                />
                <!-- Floating Facility Badge Overlay -->
                <div class="about-facility-badge">
                  <span class="facility-dot"></span>
                  <span>Fasilitas Terakreditasi &amp; Higienis</span>
                </div>
              </div>
              <div class="about-founders-capsule">
                <div class="founders-icon-wrap">
                  <span class="material-symbols-outlined">diversity_1</span>
                </div>
                <div>
                  <p class="founders-label">Didirikan Oleh:</p>
                  <p class="founders-names">Bapak Artin Ristriawan & Ibu Hertin Nurfarida</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ==================== 4. LAYANAN KAMI (PROGRAM & SERVICE BENTO GRID) ==================== -->
    <section class="services-section" id="layanan">
      <div class="container">
        <div class="section-header-row">
          <div>
            <span class="section-badge-label">LAYANAN KAMI</span>
            <h2 class="section-heading">Terapi untuk Tumbuh Kembang yang Lebih Baik</h2>
            <p class="section-subheading">Program stimulasi yang terstruktur dan didampingi secara intensif oleh praktisi ahli.</p>
          </div>
          <router-link to="/layanan" class="header-more-link">
            <span>Lihat Selengkapnya</span>
            <span class="material-symbols-outlined">arrow_forward</span>
          </router-link>
        </div>

        <div class="services-grid">
          <div v-for="svc in services" :key="svc.title" class="service-card">
            <div class="svc-top">
              <div class="svc-icon-circle" :class="svc.iconBg">
                <span class="material-symbols-outlined">{{ svc.icon }}</span>
              </div>
              <h3 class="svc-title">{{ svc.title }}</h3>
              <span class="svc-tag" :class="svc.tagColor">{{ svc.tag }}</span>
              <p class="svc-desc">{{ svc.desc }}</p>
            </div>
            <div class="svc-footer">
              <router-link :to="svc.link" class="svc-read-link">
                <span>Selengkapnya</span>
                <span class="material-symbols-outlined">arrow_forward</span>
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ==================== 5. INSPIRING BANNER / QUOTE ==================== -->
    <section class="quote-section">
      <div class="container">
        <div class="quote-card">
          <span class="material-symbols-outlined quote-icon">format_quote</span>
          <blockquote class="quote-text">
            "Bersama, kita wujudkan masa depan terbaik untuk anak-anak."
          </blockquote>
          <p class="quote-sub">
            Langkah kecil hari ini adalah pondasi perubahan besar bagi kemandirian buah hati esok hari.
          </p>
        </div>
      </div>
    </section>

    <!-- ==================== 6. TIM KAMI (DIDAMPINGI TERAPIS AHLI & BERDEDIKASI) ==================== -->
    <section class="team-section" id="tim-kami">
      <div class="container">
        <div class="section-header-row">
          <div>
            <span class="section-badge-label">TIM KAMI</span>
            <h2 class="section-heading">Didampingi Terapis Ahli &amp; Berdedikasi</h2>
            <p class="section-subheading">Praktisi profesional berlisensi dan berpengalaman di bidang tumbuh kembang anak dengan pendekatan penuh kasih.</p>
          </div>
          <router-link to="/tim-kami" class="header-more-link">
            <span>Lihat Semua Tim</span>
            <span class="material-symbols-outlined">arrow_forward</span>
          </router-link>
        </div>

        <div class="team-grid">
          <div v-for="member in displayTeam" :key="member.name" class="team-card">
            <!-- Photo Frame with STR Badge -->
            <div class="team-photo-wrap">
              <img :src="member.photo" :alt="member.name" class="team-real-img" loading="lazy" decoding="async" />
              <span class="team-str-badge">
                <span class="material-symbols-outlined str-icon">verified</span>
                {{ member.str }}
              </span>
            </div>

            <!-- Card Info -->
            <div class="team-card-content">
              <h3 class="team-name">{{ member.name }}</h3>
              <span class="team-role" :class="member.roleColor">{{ member.role }}</span>
              <p class="team-bio">{{ member.bio }}</p>

              <!-- Tags -->
              <div class="team-tags">
                <span v-for="tag in member.tags" :key="tag" class="team-tag">{{ tag }}</span>
              </div>

              <!-- Consult Link -->
              <div class="team-card-action">
                <router-link to="/jadwal-pendaftaran" class="team-consult-link">
                  <span>Jadwalkan Konsultasi</span>
                  <span class="material-symbols-outlined">arrow_forward</span>
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ==================== 7. CERITA AYAH & BUNDA (TESTIMONI & KISAH NYATA) ==================== -->
    <section class="testimonials-section" id="testimoni">
      <div class="container">
        <!-- Section Header -->
        <div class="testimonials-header">
          <div class="section-badge-label">
            <span class="material-symbols-outlined badge-icon">favorite</span>
            <span>CERITA AYAH &amp; BUNDA</span>
          </div>
          <h2 class="section-heading">Kisah Nyata &amp; Kemajuan Buah Hati Kami</h2>
          <p class="section-subheading">
            Setiap anak memiliki keunikan dan ritme bertumbuh masing-masing. Simak bagaimana pendekatan empatik berbasis bukti di Amanah Tin's Center membantu ratusan keluarga menemukan kembali senyuman dan kemandirian ananda.
          </p>
        </div>

        <!-- Social Proof Stats Banner -->
        <div class="testimonials-stats-bar">
          <div class="stat-pill">
            <div class="stat-pill-stars">
              <span v-for="i in 5" :key="i" class="material-symbols-outlined icon-fill">star</span>
            </div>
            <div>
              <span class="stat-pill-val">4.9 / 5.0</span>
              <span class="stat-pill-lbl">Rating Kepuasan Orang Tua</span>
            </div>
          </div>
          <div class="stat-pill">
            <span class="material-symbols-outlined stat-pill-icon">diversity_1</span>
            <div>
              <span class="stat-pill-val">15.000+ Sesi</span>
              <span class="stat-pill-lbl">Terapi Terlaksana di Jagakarsa</span>
            </div>
          </div>
          <div class="stat-pill">
            <span class="material-symbols-outlined stat-pill-icon">trending_up</span>
            <div>
              <span class="stat-pill-val">98.4% Kemajuan</span>
              <span class="stat-pill-lbl">Evaluasi Berkala Terukur</span>
            </div>
          </div>
          <div class="stat-pill">
            <span class="material-symbols-outlined stat-pill-icon">verified_user</span>
            <div>
              <span class="stat-pill-val">100% STR Resmi</span>
              <span class="stat-pill-lbl">Terapis Standar Kemenkes RI</span>
            </div>
          </div>
        </div>

        <!-- In-Depth Testimonial Cards Grid -->
        <div class="testimonials-grid">
          <div
            v-for="story in stories"
            :key="story.childName"
            class="story-card"
          >
            <!-- Card Header: Profile & Service Tag -->
            <div class="story-card-header">
              <div class="story-profile">
                <img :src="story.parentPhoto" :alt="story.parentName" class="story-avatar" loading="lazy" decoding="async" />
                <div>
                  <h4 class="story-parent-name">{{ story.parentName }}</h4>
                  <div class="story-verified-badge">
                    <span class="material-symbols-outlined">verified</span>
                    <span>Orang Tua Terverifikasi</span>
                  </div>
                  <span class="story-parent-loc">{{ story.parentLocation }}</span>
                </div>
              </div>
              <span class="story-service-tag" :class="story.serviceTagColor">{{ story.service }}</span>
            </div>

            <!-- Child Case & Milestone Focus -->
            <div class="story-case-box">
              <div class="story-child-row">
                <span class="material-symbols-outlined text-primary">child_care</span>
                <span class="story-child-title"><strong>{{ story.childName }}</strong> ({{ story.childAge }})</span>
              </div>
              <div class="story-condition">
                <span class="case-label">Kondisi Awal:</span>
                <span class="case-text">{{ story.initialCondition }}</span>
              </div>
            </div>

            <!-- Quote Text -->
            <div class="story-quote-body">
              <span class="material-symbols-outlined story-quote-mark">format_quote</span>
              <p class="story-quote-text">"{{ story.quote }}"</p>
            </div>

            <!-- Before-After Progress Highlights -->
            <div class="story-progress-box">
              <span class="progress-box-title">Kemajuan Nyata Teramati:</span>
              <ul class="progress-list">
                <li v-for="prog in story.progressPoints" :key="prog">
                  <span class="material-symbols-outlined check-icon">check_circle</span>
                  <span>{{ prog }}</span>
                </li>
              </ul>
            </div>

            <!-- Card Footer -->
            <div class="story-card-footer">
              <div class="story-stars">
                <span v-for="i in 5" :key="i" class="material-symbols-outlined icon-fill">star</span>
              </div>
              <span class="story-duration">{{ story.duration }}</span>
            </div>
          </div>
        </div>

        <!-- Encouraging CTA Strip -->
        <div class="testimonials-cta-strip">
          <div class="cta-strip-content">
            <h3 class="cta-strip-title">Ingin Buah Hati Mengalami Kemajuan Bermakna yang Sama?</h3>
            <p class="cta-strip-desc">Jangan tunda masa keemasan (*golden age*) si kecil. Tim terapis profesional kami siap menyambut Ayah dan Bunda dengan asesmen awal yang ramah dan komprehensif.</p>
          </div>
          <div class="cta-strip-buttons">
            <router-link to="/jadwal-pendaftaran" class="btn-strip-primary">
              <span class="material-symbols-outlined">event_available</span>
              <span>Jadwalkan Asesmen Awal</span>
            </router-link>
            <a
              :href="waLink('Halo Admin Amanah Tin\'s Center, saya membaca Cerita Ayah & Bunda dan ingin konsultasi jadwal asesmen awal ananda.')"
              target="_blank"
              rel="noopener noreferrer"
              class="btn-strip-wa"
            >
              <span class="material-symbols-outlined">chat</span>
              <span>Tanya via WhatsApp</span>
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- ==================== 7. ARTIKEL & TIPS ==================== -->
    <section class="articles-section" id="artikel">
      <div class="container">
        <div class="section-header-row">
          <div>
            <span class="section-badge-label">ARTIKEL & TIPS</span>
            <h2 class="section-heading">Informasi Seputar Tumbuh Kembang & Parenting</h2>
            <p class="section-subheading">Panduan praktis dan artikel berbasis medis untuk mendukung stimulasi harian di rumah.</p>
          </div>
          <router-link to="/artikel" class="header-more-link">
            <span>Lihat Selengkapnya</span>
            <span class="material-symbols-outlined">arrow_forward</span>
          </router-link>
        </div>

        <div class="articles-grid">
          <article v-for="art in displayArticles" :key="art.title" class="article-card">
            <div class="article-thumb-wrap">
              <img :src="art.image" :alt="art.title" class="article-thumb" loading="lazy" decoding="async" />
            </div>
            <div class="article-content">
              <div>
                <span class="article-date-tag" :class="art.tagColor">{{ art.date || art.category }}</span>
                <h3 class="article-title">{{ art.title }}</h3>
                <p class="article-excerpt">{{ art.excerpt }}</p>
              </div>
              <router-link :to="art.link || `/artikel/${art.slug}`" class="article-read-link">
                <span>Baca Selengkapnya</span>
                <span class="material-symbols-outlined">arrow_forward</span>
              </router-link>
            </div>
          </article>
        </div>
      </div>
    </section>

    <!-- ==================== 8. JADWAL & CARA MENDAFTAR ==================== -->
    <section class="schedule-section" id="jadwal">
      <div class="container">
        <div class="schedule-container-box">
          <div class="schedule-header">
            <span class="section-badge-label">JADWAL & PENDAFTARAN</span>
            <h2 class="schedule-title">Mudah & Cepat Memulai Perjalanan Terapi</h2>
            <p class="schedule-desc">Ikuti 3 tahapan sederhana untuk mendaftarkan ananda dalam program asesmen awal bersama tim terapis profesional kami.</p>
          </div>

          <!-- 3 Steps Grid -->
          <div class="steps-grid">
            <div class="step-card">
              <div class="step-badge step-1">1</div>
              <h4 class="step-title">Hubungi Kami</h4>
              <p class="step-desc">Konsultasi awal secara fleksibel melalui WhatsApp atau formulir pendaftaran klinik.</p>
            </div>
            <div class="step-card">
              <div class="step-badge step-2">2</div>
              <h4 class="step-title">Pilih Jadwal Asesmen</h4>
              <p class="step-desc">Tim administrasi membantu menyesuaikan jadwal terapis sesuai kesiapan ananda dan keluarga.</p>
            </div>
            <div class="step-card">
              <div class="step-badge step-3">3</div>
              <h4 class="step-title">Konfirmasi & Sesi Terapi</h4>
              <p class="step-desc">Lakukan konfirmasi jadwal asesmen dan lengkapi profil tumbuh kembang anak.</p>
            </div>
          </div>

          <!-- Bottom Action Capsule -->
          <div class="schedule-action-box">
            <div class="schedule-action-info">
              <div class="location-pill">
                <span class="material-symbols-outlined">location_on</span>
                <span>Pusat Layanan: {{ settings?.address || 'Jl. Raya Jagakarsa No. 12, Jakarta Selatan' }}</span>
              </div>
              <p class="location-sub">Layanan pendaftaran dibuka setiap hari kerja. Konsultasi langsung dapat dijadwalkan dengan praktisi.</p>
            </div>
            <router-link to="/jadwal-pendaftaran" class="btn-primary-schedule">
              <span>Buka Jadwal & Formulir Lengkap</span>
              <span class="material-symbols-outlined">arrow_forward</span>
            </router-link>
          </div>
        </div>
      </div>
    </section>

    <!-- ==================== 9. KONTAK & LOKASI KLINIK ==================== -->
    <section class="contact-section" id="kontak">
      <div class="container">
        <div class="contact-header">
          <div class="contact-badge">
            <span class="material-symbols-outlined">distance</span>
            <span>PUSAT INFORMASI & LOKASI</span>
          </div>
          <h2 class="contact-title">Konsultasi & Kunjungi Klinik Kami</h2>
          <p class="contact-sub">
            Punya pertanyaan seputar tumbuh kembang ananda atau ingin berkonsultasi langsung? Tim kami siap menyambut Ayah dan Bunda dengan hangat di Jagakarsa.
          </p>
        </div>

        <!-- Map Canvas with Floating Info Pop-up Card -->
        <div class="map-section-wrapper">
          <div class="map-canvas-container">
            <!-- Google Maps Embed Iframe -->
            <iframe
              :src="mapEmbedUrl"
              class="map-iframe"
              allowfullscreen=""
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
              title="Peta Lokasi Amanah Tin's Center"
            ></iframe>

            <!-- Pop-up Informasi (Floating Card) -->
            <div class="map-popup-card">
              <h3 class="map-popup-title">
                {{ settings?.clinic_name || "Amanah Tin's Center" }} - Jagakarsa
              </h3>
              <div class="map-popup-accent"></div>

              <div class="map-popup-items">
                <!-- Alamat -->
                <div class="map-popup-row">
                  <span class="material-symbols-outlined map-icon-orange">location_on</span>
                  <div class="map-row-content">
                    <p class="map-row-text">
                      {{ settings?.address || 'Jl. Gudang Baru Jl. Moch. Kahfi II No.5, RT.1/RW.4, Jagakarsa, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12620' }}
                    </p>
                  </div>
                </div>

                <!-- Telepon -->
                <div class="map-popup-row">
                  <span class="material-symbols-outlined map-icon-orange">call</span>
                  <div class="map-row-content">
                    <p class="map-row-text">
                      <a :href="`tel:${(settings?.phone || '0217262849').replace(/[^0-9+]/g, '')}`" class="map-link">
                        {{ settings?.phone || '021 – 7262849' }}
                      </a>
                      <template v-if="formattedContactWa">
                        <span class="map-sep">|</span>
                        <a :href="waLink('Halo Admin Amanah Tin\'s Center, saya ingin bertanya tentang layanan')" target="_blank" rel="noopener noreferrer" class="map-link">
                          {{ formattedContactWa }}
                        </a>
                      </template>
                    </p>
                  </div>
                </div>

                <!-- Email -->
                <div class="map-popup-row">
                  <span class="material-symbols-outlined map-icon-orange">mail</span>
                  <div class="map-row-content">
                    <p class="map-row-text">
                      <a :href="`mailto:${settings?.email || 'informasi@amanahtinscenter.com'}`" class="map-link">
                        {{ settings?.email || 'informasi@amanahtinscenter.com' }}
                      </a>
                    </p>
                  </div>
                </div>
              </div>

              <!-- Action Buttons -->
              <div class="map-popup-actions">
                <router-link to="/jadwal-pendaftaran" class="map-popup-btn btn-navy">
                  Daftar Sekarang
                </router-link>
                <a
                  :href="settings?.maps_url || 'https://maps.app.goo.gl/q96p7NeJuXLPbY5VA'"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="map-popup-btn btn-navy"
                >
                  Lihat Lokasi
                </a>
              </div>
            </div>
          </div>

          <!-- Bottom Operational Strip -->
          <div class="clinic-quick-strip">
            <div class="quick-strip-item">
              <div class="quick-strip-icon bg-primary-soft">
                <span class="material-symbols-outlined">schedule</span>
              </div>
              <div class="quick-strip-info">
                <span class="quick-strip-label">Jam Operasional Klinik</span>
                <span class="quick-strip-val">
                  {{ settings?.weekday_hours || 'Senin – Jumat: 08.00 – 17.00 WIB' }}
                  <span class="val-separator">|</span>
                  {{ settings?.weekend_hours || 'Sabtu: 08.00 – 15.00 WIB (Minggu Libur)' }}
                </span>
              </div>
            </div>
            <div class="quick-strip-divider"></div>
            <div class="quick-strip-item">
              <div class="quick-strip-icon bg-wa-soft">
                <span class="material-symbols-outlined">chat</span>
              </div>
              <div class="quick-strip-info">
                <span class="quick-strip-label">Reservasi &amp; Konsultasi Online</span>
                <span class="quick-strip-val">Tersedia 24 Jam via Website &amp; WhatsApp Resmi</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import PublicLayout from '../layouts/PublicLayout.vue'
import api from '../services/api'
import { activeSection } from '../composables/useActiveSection'
import { useClinicSettings } from '../composables/useClinicSettings'

const { settings, whatsappNumber, waLink } = useClinicSettings()

const formattedContactWa = computed(() => {
  const p = whatsappNumber.value
  if (p && p.startsWith('62') && p.length >= 11) {
    return `+62 ${p.slice(2, 5)}-${p.slice(5, 9)}-${p.slice(9)}`
  }
  return p ? `+${p}` : '0821 8889 9900'
})

const mapEmbedUrl = computed(() => {
  const addr = settings.value?.address || "Amanah Tin's Center, Jl. Gudang Baru Jl. Moch. Kahfi II No.5, Jagakarsa, Jakarta Selatan"
  return `https://maps.google.com/maps?q=${encodeURIComponent(addr)}&t=&z=15&ie=UTF8&iwloc=&output=embed`
})

// 1. Four Pillars
const pillars = [
  {
    icon: 'psychology',
    bg: 'icon-primary-soft',
    title: 'Terapi Berkualitas',
    desc: 'Ditangani oleh terapis berpengalaman dan tersertifikasi di bidangnya.'
  },
  {
    icon: 'event_available',
    bg: 'icon-secondary-soft',
    title: 'Jadwal Fleksibel',
    desc: 'Menyesuaikan kebutuhan waktu terbaik anak dan kesiapan keluarga.'
  },
  {
    icon: 'volunteer_activism',
    bg: 'icon-tertiary-soft',
    title: 'Pendekatan Personal',
    desc: 'Setiap anak unik; program disesuaikan dengan profiling milestone spesifik.'
  },
  {
    icon: 'cottage',
    bg: 'icon-high-soft',
    title: 'Lingkungan Nyaman',
    desc: 'Ruang terapi higienis, aman, ramah sensori, dan bebas dari rasa takut.'
  }
]

// 2. Services
const services = [
  {
    icon: 'record_voice_over',
    iconBg: 'svc-bg-primary',
    title: 'Terapi Wicara (TW)',
    tag: 'Speech Therapy',
    tagColor: 'tag-primary',
    desc: 'Membantu anak mengembangkan kemampuan komunikasi, artikulasi pengucapan, pemahaman bahasa, dan kelancaran berbicara.',
    link: '/layanan/terapi-wicara'
  },
  {
    icon: 'pan_tool',
    iconBg: 'svc-bg-secondary',
    title: 'Terapi Okupasi (BT)',
    tag: 'Occupational Therapy',
    tagColor: 'tag-secondary',
    desc: 'Melatih keterampilan motorik halus dan kasar, koordinasi anggota tubuh, kemandirian makan, serta aktivitas harian anak.',
    link: '/layanan/terapi-okupasi'
  },
  {
    icon: 'extension',
    iconBg: 'svc-bg-tertiary',
    title: 'Sensori Integrasi (SI)',
    tag: 'Sensory Integration',
    tagColor: 'tag-tertiary',
    desc: 'Membantu memproses rangsangan sensori (sentuhan, keseimbangan, suara, gerak) agar anak lebih fokus, tenang, dan adaptif.',
    link: '/layanan/sensori-integrasi'
  },
  {
    icon: 'sentiment_very_satisfied',
    iconBg: 'svc-bg-high',
    title: 'Psikolog',
    tag: 'Clinical Psychologist',
    tagColor: 'tag-primary',
    desc: 'Layanan konsultasi & asesmen psikologi profesional untuk Anak, Remaja, hingga Dewasa & Keluarga.',
    link: '/layanan/psikolog'
  }
]

// 3. Default Curated Team
const defaultTeam = [
  {
    photo: 'https://lh3.googleusercontent.com/aida-public/AB6AXuARq7DzRwA-rJhJLIXBolnUBS70HG4EgQhQ6siQc5wOCBPmojR_dvk2D22zt1H83m9tdj8kembmDE-mZ3sWEljXK44nSgZaTnrAqm7C4QW5u4NZcr6AQoBKHsRfV9MuqhXxEuwQjpA75jDPOvR_R4jriqhbU3OZDs7qd2wemWAz8AYy-UczwQfqO5mn9qT_vBHKBRZDijRsi9u7y982VOU1jEuHl9v60nnn8nTiPH8',
    specialtyBadge: 'Dokter Spesialis Anak',
    str: 'SIP Aktif • 10 Th Pengalaman',
    name: 'dr. Raden Sarah Amalia, Sp.A',
    role: 'Dokter Spesialis Anak Konsultan',
    roleColor: 'role-primary',
    bio: 'Menangani asesmen klinis milestone fisik, saraf, kognitif anak, serta evaluasi diagnosis komprehensif.',
    tags: ['Asesmen Klinis', 'Milestone Anak', 'Konsultasi Medis']
  },
  {
    photo: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDEqiyk6121gv8ChNiZuew6FvZqYM6PDAblTcYiCp2zrKejXMcq6F6UwgjGu7Iaa3e4rXhIrp_ywvJu9Kz9EhZiKd2459Um-Gc6zqJkmD5lhWLepwgqsb7evjTW02DHYySTvbEICSv5mKabSc6kIEwah6t2brhAK9Ha_QJuZU78_R80wE4TxyfldjEjEqtUW1cwa3Hj7QA3-OuMXKmQRyIu4-9fb9bGbMCfwDx090c',
    specialtyBadge: 'Kepala Terapis Wicara',
    str: 'STR Kemenkes Aktif • 6 Th Pengalaman',
    name: 'Annisa Larasati, A.Md.TW',
    role: 'Terapis Wicara (Speech Pathologist)',
    roleColor: 'role-secondary',
    bio: 'Spesialisasi penanganan keterlambatan bicara (speech delay), artikulasi pengucapan, dan kelancaran bahasa.',
    tags: ['Speech Delay', 'Artikulasi Fonem', 'Oral Motorik']
  },
  {
    photo: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCqzaTQVtPUaU-jjH7JUkPgscxWU1F6ORXYUDhxi6OwEhZoL2SBGnzy7hEbs44MRtKcZBbwsTnFzF2l3eMKjbUQa0Z9W4BlJC8f0wAWn_6L8BvLrPsxdq6emLK0b9Q6JavjVgzOahGIeLB17EaAciv7FNpjFAQaTcfJj3_WWeQNp1weADSSiald3o28J8AEyY4nyowmBtpig9BqakgYufsRxF22-KKVgSr1dkshnOA',
    specialtyBadge: 'Terapis Okupasi Senior',
    str: 'STR Kemenkes Aktif • 5 Th Pengalaman',
    name: 'Dimas Bagaswara, S.Tr.Kes (OT)',
    role: 'Terapis Okupasi & Kemandirian Anak',
    roleColor: 'role-tertiary',
    bio: 'Fokus melatih koordinasi motorik halus (memegang sendok/pensil), kemandirian diri (ADL), dan postur tubuh.',
    tags: ['Motorik Halus', 'Kemandirian Diri', 'Kekuatan Genggaman']
  },
  {
    photo: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBBtaiTyNRvVyTC0twGu_A_OOgQaPPquYuuzHBM9n1Ox2rtWbSz7r0KQFKvbiPmm2hWx1hQE7R-oFMCgBlZjscdh2-McSZ83oQESA-0NjvPh0UX2UWifpBhfmLjk_H-ZojRnCI7RX-XGhyP2tyTKJDyud5c34H2kj50-7UjoFyauJh1a_2swq37hsQVrcU3gDK0P-5t1Fdc1oqXQ_7tUKjQ0Gz6zW5PT2-nHWAR6JI',
    specialtyBadge: 'Praktisi C.SI Bersertifikat',
    str: 'STR Kemenkes & Sertifikasi C.SI',
    name: 'Nurul Fauziah, A.Md.OT, C.SI',
    role: 'Praktisi Sensori Integrasi Pediatrik',
    roleColor: 'role-secondary',
    bio: 'Menangani modulasi sensori anak hiperaktif, hipersensitif tekstur & suara, serta keseimbangan vestibular tubuh.',
    tags: ['Regulasi Sensori', 'Vestibular & Taktil', 'Keseimbangan']
  }
]

// 4. Cerita Ayah & Bunda (Testimoni & Kisah Nyata Perjalanan Terapi)
const stories = [
  {
    parentName: 'Bunda Fitriani & Ayah Raditya',
    parentLocation: 'Jagakarsa, Jakarta Selatan',
    parentPhoto: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDndS1MEqhUoM1jUcloTszQuiVyvZQQTdkWTSuBfJTiomzP1PM9XqIRCM9jqFGt1cW7d3Leb19e2RyIVFI-ZAZVTtp0cqgL1J5nVzOeM9xb3jMOsV1syIVqmGBEzTpxgNh7DR4Bmof0JjfqdICLKa4vueP7V49v6bJx6jBVOILCbqk-mUAQWiGEt6MTKP0dWcxjtDpTGkGPMvUKtluVegL-I7DXLjkf67qRXyeHcC4',
    service: 'Terapi Wicara (TW)',
    serviceTagColor: 'tag-primary',
    childName: 'Ananda Kenzo',
    childAge: '3 Tahun 2 Bulan',
    initialCondition: 'Speech delay berat, hanya bisa mengucap "mama" & "papa", sering tantrum hebat karena keinginannya tidak dipahami.',
    quote: 'Awalnya saya cemas sekali membandingkan Kenzo dengan teman sebayanya. Di ATC, terapis Mbak Annisa sangat telaten dengan metode bermain tanpa paksaan. Setiap sesi selesai kami selalu diberi lembar evaluasi dan PR stimulasi di rumah. Sekarang Kenzo cerewet dan ceria bercerita!',
    progressPoints: [
      'Kosakata aktif melonjak 100+ kata baru',
      'Mampu merangkai 3-4 kata ("Bunda mau susu di meja")',
      'Tantrum berkurang drastis karena komunikasi lancar'
    ],
    duration: '16 Sesi (4 Bulan Terapi)'
  },
  {
    parentName: 'Bunda Nadhira',
    parentLocation: 'Pasar Minggu, Jakarta Selatan',
    parentPhoto: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDA6AxaP_1sTKsevX0SNiWyRLSqBTmdOpthTzKUtdw2629F_zlaMj9qXVWQgswk5vS1vNJB6lex_af6gpEcXS26Q6i1UNwwm-hOYueJc0NUuz0KofHGQ4UIEKYpCwrZ0cN_dRkzJP0Xb_XZ19fdPzVRbHxXP_JNQQCjs57FaWxRIxDKyIzA8Itfn7C3kP0upzOwvfBovYcWgXxj-wyKin6fV78ESnwPCkweevSPvAM',
    service: 'Sensori Integrasi (SI) & Okupasi',
    serviceTagColor: 'tag-secondary',
    childName: 'Ananda Aisyah',
    childAge: '4 Tahun',
    initialCondition: 'Hipersensitif sentuhan (takut rumput & pasir), histeris mendengar suara blender/pengering rambut, dan tidak bisa duduk tenang.',
    quote: 'Ruang sensori integrasi di ATC sangat luas, bersih, dan peralatannya lengkap berstandar medis. Terapis menjelaskan akar masalah sensori Aisyah dengan sangat ilmiah namun mudah dipahami orang tua awam. Aisyah yang tadinya takut kotor kini senang sekali bermain di taman.',
    progressPoints: [
      'Berani menginjak rumput dan bermain sensory bin',
      'Tenang saat terpapar suara bising di keramaian',
      'Atensi dan fokus meningkat hingga 20 menit'
    ],
    duration: '20 Sesi (5 Bulan Terapi)'
  },
  {
    parentName: 'Ayah Hendra & Bunda Maria',
    parentLocation: 'Ciganjur, Jakarta Selatan',
    parentPhoto: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCFnIGzFbZWa4l3SIk50aPn96KY27lU07tg9J5Jx2GS_IK0XvHXN-2DDskmjdAgWOWRof4YXiVpYcRdhAdGrHhLFY3kJeCrzAorWZhl9avFTC8Hz5N_hpNtpCjKHHW91WlUmRhbZG_Aa3ixQ3e6CjcMYtNQySfL50xEvTnG-4h6gNvGwU-HS77DVP5oW_jepXXh6PH-6aB_jyVORKqhzbEEd6cUG95ve4rUHJm8_Dg',
    service: 'Terapi Okupasi (OT)',
    serviceTagColor: 'tag-tertiary',
    childName: 'Ananda Arkan',
    childAge: '5 Tahun',
    initialCondition: 'Kekuatan genggaman jari sangat lemah, belum bisa mengancing baju atau memegang sendok dengan benar, cepat lelah saat menulis.',
    quote: 'Menjelang masuk TK B kami sangat khawatir Arkan tertinggal kemandiriannya. Mas Dimas di ATC melatih kekuatan motorik halus Arkan dengan pendekatan yang menyenangkan. Yang paling kami kagumi adalah pendekatan holistik ATC yang melibatkan kami sebagai partner terapi di rumah.',
    progressPoints: [
      'Bisa menulis namanya sendiri dengan genggaman mantap',
      'Mandiri memakai dan melepas sepatu serta baju berkancing',
      'Koordinasi dua tangan (bilateral) jauh lebih sinkron'
    ],
    duration: '12 Sesi (3 Bulan Terapi)'
  }
]

const clinicWa = ref('6282188899900')

// 5. Default Curated Blueprint Articles
const blueprintArticles = [
  {
    image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuD0Xzl7sWBmkpbXiFs2SnTon1VvVP6GRnXTOh5w9jaj3l9tj7v9CGSUffsN9KJOZouUuWL_xkSvYKDfVakN3dcTJon7v6pr5Hu4UI6jodCDXvrnbhInk2DrYm6p8PNCF_LI5J_jZ18kskooRZ7-x0nuhzb_Ez5BGvMd7NpmX2vwpkCIFUtc_INNaJbbGLiGSdivEEVZ8VIxfkc5EGTkqqUgQGRhMPQcpy5lqafqQgc',
    date: '12 Mei 2025',
    tagColor: 'tag-primary',
    title: 'Tanda-Tanda Anak Membutuhkan Terapi Wicara',
    excerpt: 'Ketahui red flags keterlambatan bicara sejak usia dini agar penanganan tidak tertunda.',
    link: '/artikel/mengenal-tanda-speech-delay-pada-anak-usia-1-3-tahun'
  },
  {
    image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDPEUVVykApdqKKsDkSnu79sI6NZ35gZjy6qp6mFqk20lYyzEhQ3Avgtwi8cjuh8MjaPsxwvY5wuiLWAXG3EaIU87Axdg8TU8EtP3gLk_o9JfVwiMgdJq1lNrRsfO0jSs4Ju22M1tpsHXmtSwSl45NbVNqAYx_lzh8E0sbTsspE9A5S-hbmwVqAPKBxnsJcsACkvQgUGX-iiJYf9VA2jwb8dTUr3e0R3y70nu7KCFs',
    date: '5 Mei 2025',
    tagColor: 'tag-secondary',
    title: 'Tips Stimulasi Motorik Anak di Rumah Sederhana',
    excerpt: 'Aktivitas seru tanpa gadget yang dapat melatih kekuatan genggaman dan fokus tangan si kecil.',
    link: '/artikel/5-aktivitas-di-rumah-melatih-motorik-halus'
  },
  {
    image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAZJpUPJo94cKHPW1u8OGMXvL8GHLuZroeNJvTkDh6NTBYwKV0V5QVhaM2XpHEMhkcEqEUX2S2DvQ4oF1BcyJnHBvhniy0ArqeTaJTw1AV6DVKrPY4K9DjPgt5BsurLemLri79U-lA8kkGZcsxkjxmtur9sBxXtP3xXkbWlImHUgZxL7_S6wd8uxciCIbtxU-_sPBZXmbIVKIT3Kd9cfou-Pwg2AVMDXX_DiJpcbRU',
    date: '28 April 2025',
    tagColor: 'tag-tertiary',
    title: 'Pentingnya Konsistensi dalam Terapi Tumbuh Kembang',
    excerpt: 'Mengapa keteraturan jadwal dan pengulangan stimulasi di rumah sangat menentukan kemajuan anak.',
    link: '/artikel/apa-itu-sensori-integrasi-dan-pentingnya-bagi-anak'
  },
  {
    image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBUcNQQ3ptCAikvCt7_ZHy-oLtjAdeye1u7TTYe0_UrkGEAXPL2usKA3QxyqqOpR-ZetukZ2mkXD4WB15P7MEDIIHBegHVG_bEYnlrJfLJja0aZ3B-TN3sRCgK7H_CtRs1fiOWxhmq60xLC3Ra1qEyj2IrNVl7DlmQAZ7TiqtwBot5eZ7gC5dOeZ0BYFappwYRM_R-Hi9pnrgz3qTaiIUEz5sCZgzg8_ASwOA4aX2A',
    date: '20 April 2025',
    tagColor: 'tag-primary',
    title: 'Cara Membangun Komunikasi Positif dengan Anak',
    excerpt: 'Meredakan ledakan tantrum dengan teknik validasi emosi dan mendengarkan aktif.',
    link: '/artikel/fisioterapi-pediatrik-membantu-tonggak-motorik-kasar'
  }
]

const apiArticles = ref([])
const apiTeam = ref([])

// Section tracking for active navbar state
const sectionIds = [
  'beranda',
  'tentang-kami',
  'layanan',
  'tim-kami',
  'testimoni',
  'artikel',
  'jadwal',
  'kontak'
]

const sanitizedClinicWa = computed(() => {
  let cleaned = String(clinicWa.value || '6282188899900').replace(/[^0-9]/g, '')
  if (cleaned.startsWith('0')) {
    cleaned = '62' + cleaned.slice(1)
  }
  return cleaned
})

function handleScroll() {
  const scrollPosition = window.scrollY + 130 // Navbar height offset + trigger buffer

  // Bottom of page detection -> highlight 'kontak'
  const isBottom = window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 70
  if (isBottom) {
    activeSection.value = 'kontak'
    return
  }

  let current = 'beranda'
  for (const id of sectionIds) {
    const el = document.getElementById(id)
    if (el) {
      const top = el.offsetTop
      if (scrollPosition >= top) {
        current = id
      }
    }
  }
  activeSection.value = current
}

onMounted(async () => {
  window.addEventListener('scroll', handleScroll, { passive: true })
  handleScroll()

  // Smooth scroll if URL already contains a hash on initial load
  if (window.location.hash) {
    setTimeout(() => {
      const target = document.querySelector(window.location.hash)
      if (target) {
        const navHeight = 80
        const targetTop = target.getBoundingClientRect().top + window.scrollY - navHeight
        window.scrollTo({ top: targetTop, behavior: 'smooth' })
      }
    }, 150)
  }

  try {
    const articlesRes = await api.get('/articles?per_page=4')
    if (articlesRes.data?.data && articlesRes.data.data.length > 0) {
      apiArticles.value = articlesRes.data.data
    }
  } catch {
    // Graceful fallback to blueprint articles
  }

  try {
    const teamRes = await api.get('/team')
    const teamData = Array.isArray(teamRes.data) ? teamRes.data : (teamRes.data?.data || [])
    if (teamData.length > 0) {
      apiTeam.value = teamData
    }
  } catch {
    // Graceful fallback to default team
  }
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})

const displayArticles = computed(() => {
  if (apiArticles.value.length > 0) {
    return apiArticles.value.map((art, idx) => ({
      image: art.image || blueprintArticles[idx % blueprintArticles.length]?.image,
      category: art.category,
      date: new Date(art.published_at || art.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }),
      tagColor: idx % 3 === 0 ? 'tag-primary' : (idx % 3 === 1 ? 'tag-secondary' : 'tag-tertiary'),
      title: art.title,
      excerpt: art.excerpt,
      slug: art.slug
    }))
  }
  return blueprintArticles
})

const displayTeam = computed(() => {
  if (apiTeam.value.length > 0) {
    return apiTeam.value.slice(0, 4).map((member, idx) => ({
      photo: member.image || member.photo || defaultTeam[idx % defaultTeam.length]?.photo,
      specialtyBadge: member.specialization || member.role,
      str: member.str_number ? `STR: ${member.str_number}` : (member.experience_years ? `STR Aktif • ${member.experience_years}` : 'STR Kemenkes Aktif'),
      name: member.name,
      role: member.role,
      roleColor: idx % 3 === 0 ? 'role-primary' : (idx % 3 === 1 ? 'role-secondary' : 'role-tertiary'),
      bio: member.bio,
      tags: Array.isArray(member.tags) ? member.tags : (typeof member.tags === 'string' ? JSON.parse(member.tags || '[]') : [])
    }))
  }
  return defaultTeam
})
</script>

<style scoped>
/* ==================== COMMON UTILITIES ==================== */
section[id] {
  scroll-margin-top: 80px;
}

.icon-fill {
  font-variation-settings: 'FILL' 1;
}

.section-badge-label {
  display: inline-block;
  font-family: var(--font-headline);
  font-size: 13px;
  font-weight: 700;
  letter-spacing: 0.05em;
  text-transform: uppercase;
  color: var(--primary);
  margin-bottom: 0.35rem;
}

.section-header-row {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: flex-start;
  gap: 1rem;
  margin-bottom: var(--space-lg);
}

@media (min-width: 768px) {
  .section-header-row {
    flex-direction: row;
    align-items: flex-end;
  }
}

.section-heading {
  font-family: var(--font-headline);
  font-size: 1.85rem;
  font-weight: 600;
  color: var(--on-surface);
  line-height: 1.25;
}

@media (min-width: 768px) {
  .section-heading {
    font-size: 2.25rem;
  }
}

.section-subheading {
  font-size: 1rem;
  color: var(--on-surface-variant);
  max-width: 650px;
  margin-top: 0.35rem;
  line-height: 1.5;
}

@media (max-width: 640px) {
  .section-badge-label {
    font-size: 12px;
  }
  .section-header-row {
    margin-bottom: 1.25rem;
    gap: 0.75rem;
  }
  .section-heading {
    font-size: 1.55rem;
    line-height: 1.25;
  }
  .section-subheading {
    font-size: 0.925rem;
    line-height: 1.5;
  }
  .header-more-link {
    font-size: 0.9rem;
  }
}

.header-more-link {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  font-family: var(--font-headline);
  font-size: 0.95rem;
  font-weight: 600;
  color: var(--primary);
  text-decoration: none;
  white-space: nowrap;
  transition: transform 0.2s ease, color 0.2s ease;
}

.header-more-link:hover {
  text-decoration: underline;
  transform: translateX(3px);
}

.header-more-link .material-symbols-outlined {
  font-size: 16px;
}

/* ==================== 1. HERO SECTION ==================== */
.hero-section {
  padding: 3rem 0;
  overflow: hidden;
  background-color: var(--background);
}

.hero-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 2.5rem;
  align-items: center;
}

@media (min-width: 768px) and (max-width: 1023px) {
  .hero-grid {
    grid-template-columns: 1.15fr 0.85fr;
    gap: 2rem;
    align-items: center;
  }
}

@media (min-width: 1024px) {
  .hero-grid {
    grid-template-columns: 1fr 1fr;
    gap: 3.5rem;
  }
}

.hero-text {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 1.25rem;
}

.hero-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.375rem 1rem;
  border-radius: var(--radius-full);
  background-color: var(--secondary-fixed);
  color: var(--secondary);
  font-family: var(--font-body);
  font-size: 13px;
  font-weight: 600;
}

.hero-badge .material-symbols-outlined {
  font-size: 15px;
  color: var(--secondary);
}

.hero-headline {
  display: flex;
  flex-direction: column;
}

.headline-sub {
  font-family: var(--font-headline);
  font-size: 1.75rem;
  font-weight: 600;
  color: var(--on-surface);
  line-height: 1.2;
}

@media (min-width: 768px) {
  .headline-sub {
    font-size: 2.25rem;
  }
}

.headline-main {
  font-family: var(--font-headline);
  font-size: 2.25rem;
  font-weight: 700;
  color: var(--primary);
  line-height: 1.15;
}

@media (min-width: 768px) {
  .headline-main {
    font-size: 3rem;
  }
}

.hero-desc {
  font-size: 1.05rem;
  color: var(--on-surface-variant);
  line-height: 1.6;
  max-width: 540px;
}

.hero-ctas {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding-top: 0.25rem;
}

.btn-primary-hero {
  display: inline-flex;
  align-items: center;
  gap: 0.6rem;
  padding: 0.85rem 2rem;
  background-color: var(--primary);
  color: var(--on-primary);
  border-radius: var(--radius-full);
  font-family: var(--font-headline);
  font-size: 15px;
  font-weight: 600;
  text-decoration: none;
  box-shadow: 0 4px 12px rgba(0, 99, 132, 0.2);
  transition: all 0.2s ease;
}

.btn-primary-hero:hover {
  background-color: var(--primary-container);
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(0, 99, 132, 0.3);
}

.hero-trust {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding-top: 1rem;
  border-top: 1px solid rgba(191, 200, 206, 0.4);
  width: 100%;
}

.trust-avatars {
  display: flex;
  align-items: center;
}

.trust-avatar-img {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  border: 2.5px solid #ffffff;
  object-fit: cover;
  margin-left: -10px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
  transition: transform 0.2s ease, z-index 0.2s ease;
}

.trust-avatar-img:first-child {
  margin-left: 0;
}

.trust-avatar-img:hover {
  transform: translateY(-2px) scale(1.1);
  z-index: 10;
}

.trust-avatar-badge {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  border: 2.5px solid #ffffff;
  background: linear-gradient(135deg, #006384 0%, #00839e 100%);
  color: #ffffff;
  font-size: 11px;
  font-weight: 700;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-left: -10px;
  box-shadow: 0 2px 8px rgba(0, 99, 132, 0.25);
}

.star-rating-val {
  font-size: 12.5px;
  font-weight: 800;
  color: #091d2e;
  margin-left: 4px;
}

.trust-content {
  display: flex;
  flex-direction: column;
}

.stars {
  display: flex;
  gap: 2px;
  color: #f59e0b;
}

.stars .star {
  font-size: 16px;
}

.trust-desc {
  font-size: 12px;
  color: var(--on-surface-variant);
  font-weight: 500;
}

/* Media Right */
.hero-media-wrap {
  position: relative;
  display: flex;
  justify-content: center;
}

.hero-backdrop-blob {
  position: absolute;
  inset: -12px;
  background-color: rgba(193, 232, 255, 0.45);
  border-radius: 2.5rem;
  transform: rotate(-1.5deg);
  z-index: 1;
}

.hero-image-card {
  position: relative;
  width: 100%;
  border-radius: 2rem;
  overflow: hidden;
  box-shadow: var(--shadow-lift);
  border: 1px solid rgba(191, 200, 206, 0.3);
  background-color: var(--surface-container-lowest);
  z-index: 2;
}

.hero-img {
  width: 100%;
  height: 420px;
  object-fit: cover;
  object-position: center;
  display: block;
}

.hero-float-badge {
  position: absolute;
  bottom: 1.25rem;
  left: 1.25rem;
  right: 1.25rem;
  background-color: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(8px);
  padding: 0.85rem 1.25rem;
  border-radius: 1.25rem;
  border: 1px solid rgba(191, 200, 206, 0.35);
  display: flex;
  align-items: center;
  justify-content: space-between;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
}

.float-badge-left {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.float-badge-icon {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background-color: var(--secondary-fixed);
  color: var(--secondary);
  display: flex;
  align-items: center;
  justify-content: center;
}

.float-badge-icon .material-symbols-outlined {
  font-size: 22px;
}

.float-badge-title {
  font-family: var(--font-headline);
  font-size: 15px;
  font-weight: 600;
  color: var(--on-surface);
  line-height: 1.2;
}

.float-badge-sub {
  font-size: 12px;
  color: var(--on-surface-variant);
}

.float-badge-pct {
  font-family: var(--font-headline);
  font-size: 13px;
  font-weight: 700;
  color: var(--primary);
}

@media (min-width: 768px) and (max-width: 1023px) {
  .headline-main {
    font-size: 2.35rem;
  }
  .headline-sub {
    font-size: 1.65rem;
  }
  .hero-desc {
    font-size: 1rem;
  }
  .hero-img {
    height: 380px;
  }
  .hero-float-badge {
    padding: 0.75rem 1rem;
  }
}

@media (max-width: 640px) {
  .hero-section {
    padding: 1.5rem 0 2rem;
  }
  .hero-badge {
    font-size: 11.5px;
    padding: 0.3rem 0.8rem;
    gap: 0.35rem;
  }
  .hero-badge .material-symbols-outlined {
    font-size: 14px;
  }
  .hero-headline {
    gap: 0.2rem;
  }
  .headline-sub {
    font-size: 1.25rem;
  }
  .headline-main {
    font-size: 1.85rem;
    line-height: 1.2;
    word-break: break-word;
  }
  .hero-desc {
    font-size: 0.925rem;
    line-height: 1.55;
  }
  .hero-ctas {
    width: 100%;
  }
  .btn-primary-hero {
    width: 100%;
    justify-content: center;
    padding: 0.85rem 1.5rem;
    font-size: 15px;
  }
  .hero-trust {
    flex-direction: row;
    align-items: center;
    gap: 0.85rem;
    padding-top: 0.85rem;
  }
  .trust-avatar-img,
  .trust-avatar-badge {
    width: 36px;
    height: 36px;
    margin-left: -8px;
  }
  .trust-avatar-badge {
    font-size: 10px;
  }
  .stars .star {
    font-size: 15px;
  }
  .star-rating-val {
    font-size: 12px;
  }
  .trust-desc {
    font-size: 11px;
    line-height: 1.35;
  }
  .hero-media-wrap {
    margin-top: 0.25rem;
  }
  .hero-img {
    height: 280px;
  }
  .hero-float-badge {
    left: 0.65rem;
    right: 0.65rem;
    bottom: 0.65rem;
    padding: 0.55rem 0.75rem;
    border-radius: 1rem;
  }
  .float-badge-icon {
    width: 36px;
    height: 36px;
  }
  .float-badge-icon .material-symbols-outlined {
    font-size: 20px;
  }
  .float-badge-title {
    font-size: 13.5px;
  }
  .float-badge-sub {
    font-size: 11px;
    line-height: 1.25;
  }
  .float-badge-pct {
    display: none;
  }
}

/* ==================== 2. FOUR PILLARS ==================== */
.pillars-section {
  padding: 1.5rem 0 3rem;
}

.pillars-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 0.75rem;
}

@media (min-width: 640px) {
  .pillars-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 1.25rem;
  }
}

@media (min-width: 1024px) {
  .pillars-grid {
    grid-template-columns: repeat(4, 1fr);
    gap: 1.25rem;
  }
}

.pillar-card {
  background-color: var(--surface-container-lowest);
  border-radius: var(--radius);
  padding: 1.75rem 1.25rem;
  border: 1px solid rgba(191, 200, 206, 0.25);
  box-shadow: var(--shadow-soft);
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.pillar-card:hover {
  transform: translateY(-4px);
  box-shadow: var(--shadow-lift);
}

.pillar-icon {
  width: 56px;
  height: 56px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 1rem;
}

.pillar-icon .material-symbols-outlined {
  font-size: 26px;
}

.icon-primary-soft {
  background-color: rgba(193, 232, 255, 0.5);
  color: var(--primary);
}

.icon-secondary-soft {
  background-color: rgba(204, 239, 142, 0.5);
  color: var(--secondary);
}

.icon-tertiary-soft {
  background-color: rgba(255, 220, 191, 0.5);
  color: var(--tertiary);
}

.icon-high-soft {
  background-color: var(--surface-container-high);
  color: var(--primary);
}

.pillar-title {
  font-family: var(--font-headline);
  font-size: 17px;
  font-weight: 600;
  color: var(--on-surface);
  margin-bottom: 0.45rem;
}

.pillar-desc {
  font-size: 13.5px;
  color: var(--on-surface-variant);
  line-height: 1.45;
}

/* ==================== 3. ABOUT SECTION ==================== */
.about-section {
  padding: 2.5rem 0;
}

.about-container-box {
  background-color: var(--surface-container-low);
  border-radius: 2rem;
  padding: 2rem;
  border: 1px solid rgba(191, 200, 206, 0.35);
}

@media (min-width: 768px) {
  .about-container-box {
    padding: 3rem;
  }
}

.about-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 2.5rem;
  align-items: center;
}

@media (min-width: 768px) and (max-width: 1023px) {
  .about-container-box {
    padding: 2.25rem 2rem;
  }
  .about-grid {
    grid-template-columns: 1.15fr 0.85fr;
    gap: 2rem;
  }
  .about-img {
    height: 270px;
  }
}

@media (min-width: 1024px) {
  .about-grid {
    grid-template-columns: 1fr 1fr;
    gap: 3.5rem;
  }
}

.about-text-col {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 0.85rem;
}

.about-title {
  font-family: var(--font-headline);
  font-size: 1.85rem;
  font-weight: 600;
  color: var(--on-surface);
  line-height: 1.25;
}

@media (min-width: 768px) {
  .about-title {
    font-size: 2.25rem;
  }
}

.about-desc {
  font-size: 15px;
  color: var(--on-surface-variant);
  line-height: 1.6;
}

.about-stats-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
  width: 100%;
  margin: 0.5rem 0;
}

.about-stat-box {
  background-color: var(--surface-container-lowest);
  padding: 1rem 1.25rem;
  border-radius: 1rem;
  border: 1px solid rgba(191, 200, 206, 0.25);
  box-shadow: var(--shadow-soft);
}

.stat-num {
  display: block;
  font-family: var(--font-headline);
  font-size: 1.75rem;
  font-weight: 700;
  line-height: 1.1;
}

.stat-primary {
  color: var(--primary);
}

.stat-secondary {
  color: var(--secondary);
}

.stat-label {
  font-size: 12.5px;
  color: var(--on-surface-variant);
}

.about-cta-wrap {
  padding-top: 0.5rem;
}

.btn-primary-about {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.75rem 1.75rem;
  background-color: var(--primary);
  color: var(--on-primary);
  border-radius: var(--radius-full);
  font-family: var(--font-headline);
  font-size: 14px;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.2s ease;
}

.btn-primary-about:hover {
  background-color: var(--primary-container);
  transform: translateY(-2px);
}

.btn-primary-about .material-symbols-outlined {
  font-size: 18px;
}

/* About Media */
.about-media-col {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.about-img-frame {
  position: relative;
  border-radius: 1.25rem;
  overflow: hidden;
  border: 1px solid rgba(191, 200, 206, 0.35);
  box-shadow: 0 8px 24px -4px rgba(9, 29, 46, 0.08);
  background-color: var(--surface-container-lowest);
}

.about-img {
  width: 100%;
  height: 310px;
  object-fit: cover;
  display: block;
  transition: transform 0.4s ease;
}

.about-img-frame:hover .about-img {
  transform: scale(1.03);
}

.about-facility-badge {
  position: absolute;
  top: 1rem;
  right: 1rem;
  background: rgba(255, 255, 255, 0.94);
  color: #006384;
  font-family: var(--font-headline);
  font-size: 11.5px;
  font-weight: 700;
  padding: 0.35rem 0.75rem;
  border-radius: 999px;
  backdrop-filter: blur(6px);
  display: flex;
  align-items: center;
  gap: 0.4rem;
  box-shadow: 0 4px 12px rgba(9, 29, 46, 0.12);
  border: 1px solid rgba(255, 255, 255, 0.8);
}

.facility-dot {
  width: 7px;
  height: 7px;
  background: #25d366;
  border-radius: 50%;
  box-shadow: 0 0 0 2px rgba(37, 211, 102, 0.3);
}

.about-founders-capsule {
  background-color: var(--surface-container-lowest);
  border-radius: 1rem;
  padding: 1rem 1.25rem;
  border: 1px solid rgba(191, 200, 206, 0.25);
  display: flex;
  align-items: center;
  gap: 1rem;
  box-shadow: var(--shadow-soft);
}

.founders-icon-wrap {
  width: 44px;
  height: 44px;
  border-radius: 50%;
  background-color: var(--secondary-fixed);
  color: var(--secondary);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.founders-icon-wrap .material-symbols-outlined {
  font-size: 22px;
}

.founders-label {
  font-family: var(--font-headline);
  font-size: 14px;
  font-weight: 700;
  color: var(--on-surface);
  line-height: 1.2;
}

.founders-names {
  font-size: 13.5px;
  color: var(--on-surface-variant);
  font-weight: 500;
}

/* ==================== 4. SERVICES SECTION ==================== */
.services-section {
  padding: 3.5rem 0;
}

.services-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.5rem;
}

@media (min-width: 640px) {
  .services-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 1024px) {
  .services-grid {
    grid-template-columns: repeat(4, 1fr);
  }
}

@media (min-width: 1280px) {
  .services-grid {
    grid-template-columns: repeat(4, 1fr);
  }
}

.service-card {
  background-color: var(--surface-container-lowest);
  border-radius: 1.25rem;
  padding: 1.75rem;
  border: 1px solid rgba(191, 200, 206, 0.25);
  box-shadow: var(--shadow-soft);
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.service-card:hover {
  transform: translateY(-4px);
  box-shadow: var(--shadow-lift);
}

.svc-top {
  display: flex;
  flex-direction: column;
}

.svc-icon-circle {
  width: 52px;
  height: 52px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 1.25rem;
}

.svc-icon-circle .material-symbols-outlined {
  font-size: 24px;
}

.svc-bg-primary {
  background-color: var(--primary-fixed);
  color: var(--primary);
}

.svc-bg-secondary {
  background-color: var(--secondary-fixed);
  color: var(--secondary);
}

.svc-bg-tertiary {
  background-color: var(--tertiary-fixed);
  color: var(--tertiary);
}

.svc-bg-high {
  background-color: var(--surface-container-high);
  color: var(--primary);
}

.svc-bg-indigo {
  background-color: #e0e7ff;
  color: #4338ca;
}

.svc-bg-violet {
  background-color: #ede9fe;
  color: #7c3aed;
}

.svc-bg-emerald {
  background-color: #d1fae5;
  color: #059669;
}

.svc-title {
  font-family: var(--font-headline);
  font-size: 17px;
  font-weight: 600;
  color: var(--on-surface);
  margin-bottom: 0.2rem;
}

.svc-tag {
  display: inline-block;
  font-size: 12px;
  font-weight: 600;
  margin-bottom: 0.75rem;
}

.tag-primary {
  color: var(--primary);
}

.tag-secondary {
  color: var(--secondary);
}

.tag-tertiary {
  color: var(--tertiary);
}

.tag-indigo {
  color: #4338ca;
}

.tag-violet {
  color: #7c3aed;
}

.tag-emerald {
  color: #059669;
}

.svc-desc {
  font-size: 13.5px;
  color: var(--on-surface-variant);
  line-height: 1.5;
}

.svc-footer {
  padding-top: 1rem;
  margin-top: 1rem;
  border-top: 1px solid rgba(191, 200, 206, 0.25);
}

.svc-read-link {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  font-family: var(--font-headline);
  font-size: 13.5px;
  font-weight: 700;
  color: var(--primary);
  text-decoration: none;
  transition: transform 0.2s ease;
}

.svc-read-link:hover {
  text-decoration: underline;
  transform: translateX(3px);
}

.svc-read-link .material-symbols-outlined {
  font-size: 16px;
}

/* ==================== 5. QUOTE SECTION ==================== */
.quote-section {
  padding: 1rem 0 2.5rem;
}

.quote-card {
  background-color: var(--surface-container-lowest);
  border-radius: 1.5rem;
  padding: 2.5rem 1.5rem;
  border: 1px solid rgba(191, 200, 206, 0.25);
  box-shadow: var(--shadow-soft);
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.75rem;
}

@media (min-width: 768px) {
  .quote-card {
    padding: 3rem 2.5rem;
  }
}

.quote-icon {
  font-size: 40px;
  color: var(--tertiary);
}

.quote-text {
  font-family: var(--font-headline);
  font-size: 1.35rem;
  font-weight: 600;
  color: var(--primary);
  font-style: italic;
  max-width: 750px;
  line-height: 1.4;
}

@media (min-width: 768px) {
  .quote-text {
    font-size: 1.65rem;
  }
}

.quote-sub {
  font-size: 14.5px;
  color: var(--on-surface-variant);
  max-width: 580px;
}

/* ==================== 6. TEAM SECTION (DENGAN FOTO ASLI & KREDENSIAL) ==================== */
.team-section {
  padding: 3rem 0 4rem;
}

.team-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.75rem;
}

@media (min-width: 640px) {
  .team-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 1024px) {
  .team-grid {
    grid-template-columns: repeat(4, 1fr);
  }
}

.team-card {
  background-color: var(--surface-container-lowest);
  border-radius: 1.25rem;
  border: 1px solid rgba(191, 200, 206, 0.3);
  box-shadow: 0 4px 20px -2px rgba(9, 29, 46, 0.06);
  overflow: hidden;
  display: flex;
  flex-direction: column;
  transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.25s ease;
}

.team-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 16px 36px -6px rgba(9, 29, 46, 0.14);
}

.team-photo-wrap {
  position: relative;
  width: 100%;
  height: 240px;
  overflow: hidden;
  background: #edf4fa;
}

.team-real-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: top center;
  transition: transform 0.4s ease;
}

.team-card:hover .team-real-img {
  transform: scale(1.05);
}

.team-str-badge {
  position: absolute;
  bottom: 0.85rem;
  left: 0.85rem;
  right: 0.85rem;
  background: rgba(255, 255, 255, 0.92);
  color: #203243;
  font-size: 11px;
  font-weight: 700;
  padding: 0.35rem 0.65rem;
  border-radius: 8px;
  display: flex;
  align-items: center;
  gap: 0.35rem;
  backdrop-filter: blur(4px);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.team-str-badge .str-icon {
  font-size: 15px;
  color: #006384;
}

.team-card-content {
  padding: 1.25rem 1.15rem 1.35rem;
  display: flex;
  flex-direction: column;
  flex: 1;
}

.team-name {
  font-family: var(--font-headline);
  font-size: 16px;
  font-weight: 700;
  color: var(--on-surface);
  margin-bottom: 0.25rem;
  line-height: 1.3;
}

.team-role {
  display: inline-block;
  font-size: 12px;
  font-weight: 700;
  margin-bottom: 0.65rem;
  line-height: 1.3;
}

.team-bio {
  font-size: 13px;
  color: var(--on-surface-variant);
  line-height: 1.5;
  margin-bottom: 0.85rem;
  flex: 1;
}

.team-tags {
  display: flex;
  flex-wrap: wrap;
  gap: 0.35rem;
  margin-bottom: 1rem;
}

.team-tag {
  font-size: 10.5px;
  font-weight: 600;
  color: #006384;
  background: #edf6ff;
  padding: 0.2rem 0.5rem;
  border-radius: 6px;
  border: 1px solid rgba(193, 232, 255, 0.7);
}

.team-card-action {
  border-top: 1px solid rgba(191, 200, 206, 0.3);
  padding-top: 0.85rem;
}

.team-consult-link {
  display: inline-flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  font-family: var(--font-headline);
  font-size: 13px;
  font-weight: 700;
  color: var(--primary);
  text-decoration: none;
  transition: transform 0.2s ease, color 0.2s ease;
}

.team-consult-link:hover {
  color: #00839e;
  transform: translateX(3px);
}

.team-consult-link .material-symbols-outlined {
  font-size: 16px;
}

/* ==================== 7. CERITA AYAH & BUNDA (TESTIMONIALS SECTION) ==================== */
.testimonials-section {
  padding: 4rem 0 4.5rem;
  background: linear-gradient(180deg, #f7faff 0%, #edf4fc 100%);
  border-top: 1px solid rgba(191, 200, 206, 0.35);
  border-bottom: 1px solid rgba(191, 200, 206, 0.35);
}

.testimonials-header {
  text-align: center;
  max-width: 780px;
  margin: 0 auto 2.5rem;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.testimonials-header .badge-icon {
  font-size: 15px;
  color: #e11d48;
}

/* Social Proof Stats Bar */
.testimonials-stats-bar {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1rem;
  margin-bottom: 3rem;
  background: #ffffff;
  padding: 1.25rem 1.5rem;
  border-radius: 1.25rem;
  box-shadow: 0 4px 20px -2px rgba(9, 29, 46, 0.06);
  border: 1px solid rgba(191, 200, 206, 0.3);
}

@media (min-width: 640px) {
  .testimonials-stats-bar {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 1024px) {
  .testimonials-stats-bar {
    grid-template-columns: repeat(4, 1fr);
  }
}

.stat-pill {
  display: flex;
  align-items: center;
  gap: 0.85rem;
  padding: 0.5rem 0.75rem;
  border-radius: 12px;
}

.stat-pill-stars {
  display: flex;
  color: #f59e0b;
  gap: 1px;
}

.stat-pill-stars .material-symbols-outlined {
  font-size: 18px;
}

.stat-pill-icon {
  font-size: 28px;
  color: #006384;
}

.stat-pill-val {
  display: block;
  font-family: var(--font-headline);
  font-size: 16px;
  font-weight: 800;
  color: #091d2e;
  line-height: 1.2;
}

.stat-pill-lbl {
  display: block;
  font-size: 11.5px;
  color: #556066;
  font-weight: 600;
}

/* In-Depth Story Cards Grid */
.testimonials-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 2rem;
  margin-bottom: 3rem;
}

@media (min-width: 640px) {
  .testimonials-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
  }
}

@media (min-width: 1024px) {
  .testimonials-grid {
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
  }
}

.story-card {
  background: #ffffff;
  border-radius: 1.5rem;
  padding: 1.75rem 1.6rem;
  border: 1px solid rgba(191, 200, 206, 0.4);
  box-shadow: 0 6px 24px -4px rgba(9, 29, 46, 0.07);
  display: flex;
  flex-direction: column;
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.story-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 16px 36px -6px rgba(9, 29, 46, 0.13);
}

.story-card-header {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 0.75rem;
  margin-bottom: 1.25rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid #edf2f7;
}

.story-profile {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.story-avatar {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid #006384;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.story-parent-name {
  font-family: var(--font-headline);
  font-size: 14.5px;
  font-weight: 700;
  color: #091d2e;
  line-height: 1.2;
}

.story-verified-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
  font-size: 10.5px;
  font-weight: 700;
  color: #0d7066;
  margin-top: 2px;
}

.story-verified-badge .material-symbols-outlined {
  font-size: 13px;
  color: #0d7066;
}

.story-parent-loc {
  display: block;
  font-size: 10.5px;
  color: #70787e;
}

.story-service-tag {
  font-size: 11px;
  font-weight: 700;
  padding: 0.25rem 0.65rem;
  border-radius: 999px;
  white-space: nowrap;
}

/* Child case box */
.story-case-box {
  background: #f8fafc;
  border-left: 3.5px solid #006384;
  padding: 0.75rem 0.85rem;
  border-radius: 0 10px 10px 0;
  margin-bottom: 1.15rem;
}

.story-child-row {
  display: flex;
  align-items: center;
  gap: 0.45rem;
  font-size: 13px;
  margin-bottom: 0.35rem;
}

.story-child-row .text-primary {
  font-size: 18px;
  color: #006384;
}

.story-child-title {
  font-size: 13px;
  color: #091d2e;
}

.story-condition {
  font-size: 12px;
  color: #556066;
  line-height: 1.45;
}

.case-label {
  font-weight: 700;
  color: #334155;
  margin-right: 0.3rem;
}

/* Quote text */
.story-quote-body {
  position: relative;
  margin-bottom: 1.25rem;
  flex: 1;
}

.story-quote-mark {
  font-size: 24px;
  color: #cbd5e1;
  position: absolute;
  top: -6px;
  left: -2px;
  opacity: 0.7;
}

.story-quote-text {
  font-size: 13.5px;
  color: #334155;
  line-height: 1.6;
  font-style: italic;
  padding-left: 1.5rem;
  margin: 0;
}

/* Before After highlights */
.story-progress-box {
  background: #f0fdf4;
  border: 1px solid #bbf7d0;
  border-radius: 12px;
  padding: 0.85rem 1rem;
  margin-bottom: 1.25rem;
}

.progress-box-title {
  display: block;
  font-family: var(--font-headline);
  font-size: 11.5px;
  font-weight: 800;
  color: #166534;
  text-transform: uppercase;
  letter-spacing: 0.3px;
  margin-bottom: 0.45rem;
}

.progress-list {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 0.35rem;
}

.progress-list li {
  display: flex;
  align-items: flex-start;
  gap: 0.45rem;
  font-size: 12.5px;
  color: #1e293b;
  line-height: 1.4;
  font-weight: 600;
}

.progress-list .check-icon {
  font-size: 16px;
  color: #16a34a;
  margin-top: 1px;
  flex-shrink: 0;
}

/* Card footer */
.story-card-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-top: 0.85rem;
  border-top: 1px solid #edf2f7;
}

.story-stars {
  display: flex;
  color: #f59e0b;
  gap: 1px;
}

.story-stars .material-symbols-outlined {
  font-size: 16px;
}

.story-duration {
  font-size: 11px;
  font-weight: 700;
  color: #64748b;
  background: #f1f5f9;
  padding: 0.2rem 0.55rem;
  border-radius: 999px;
}

/* Testimonials CTA Strip */
.testimonials-cta-strip {
  background: linear-gradient(135deg, #006384 0%, #00839e 100%);
  color: #ffffff;
  border-radius: 1.5rem;
  padding: 2.25rem 2.5rem;
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
  align-items: center;
  box-shadow: 0 16px 36px -4px rgba(0, 99, 132, 0.25);
}

@media (min-width: 1024px) {
  .testimonials-cta-strip {
    flex-direction: row;
    justify-content: space-between;
  }
}

.cta-strip-content {
  max-width: 650px;
}

.cta-strip-title {
  font-family: var(--font-headline);
  font-size: 1.5rem;
  font-weight: 800;
  color: #ffffff;
  margin-bottom: 0.5rem;
  line-height: 1.25;
}

.cta-strip-desc {
  font-size: 14px;
  color: rgba(255, 255, 255, 0.9);
  line-height: 1.55;
  margin: 0;
}

.cta-strip-buttons {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 0.85rem;
  flex-shrink: 0;
}

.btn-strip-primary {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.8rem 1.6rem;
  background: #ffffff;
  color: #006384;
  border-radius: var(--radius-full);
  font-family: var(--font-headline);
  font-size: 14px;
  font-weight: 700;
  text-decoration: none;
  box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
  transition: all 0.2s ease;
}

.btn-strip-primary:hover {
  transform: translateY(-2px);
  background: #f0f7ff;
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.2);
}

.btn-strip-wa {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.8rem 1.5rem;
  background: #25d366;
  color: #ffffff;
  border-radius: var(--radius-full);
  font-family: var(--font-headline);
  font-size: 14px;
  font-weight: 700;
  text-decoration: none;
  box-shadow: 0 4px 14px rgba(37, 211, 102, 0.3);
  transition: all 0.2s ease;
}

.btn-strip-wa:hover {
  transform: translateY(-2px);
  background: #1ebc59;
  box-shadow: 0 6px 18px rgba(37, 211, 102, 0.4);
}

/* ==================== 7. ARTICLES SECTION ==================== */
.articles-section {
  padding: 2rem 0 3.5rem;
}

.articles-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.5rem;
}

@media (min-width: 640px) {
  .articles-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 1024px) {
  .articles-grid {
    grid-template-columns: repeat(4, 1fr);
  }
}

.article-card {
  background-color: var(--surface-container-lowest);
  border-radius: 1.25rem;
  border: 1px solid rgba(191, 200, 206, 0.25);
  overflow: hidden;
  box-shadow: var(--shadow-soft);
  display: flex;
  flex-direction: column;
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.article-card:hover {
  transform: translateY(-4px);
  box-shadow: var(--shadow-lift);
}

.article-thumb-wrap {
  height: 175px;
  overflow: hidden;
}

.article-thumb {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.35s ease;
}

.article-card:hover .article-thumb {
  transform: scale(1.05);
}

.article-content {
  padding: 1.25rem;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  flex-grow: 1;
}

.article-date-tag {
  display: inline-block;
  font-size: 11.5px;
  font-weight: 700;
  text-transform: uppercase;
  margin-bottom: 0.35rem;
}

.article-title {
  font-family: var(--font-headline);
  font-size: 16px;
  font-weight: 600;
  color: var(--on-surface);
  line-height: 1.35;
  margin-bottom: 0.45rem;
  transition: color 0.2s ease;
}

.article-card:hover .article-title {
  color: var(--primary);
}

.article-excerpt {
  font-size: 13px;
  color: var(--on-surface-variant);
  line-height: 1.45;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.article-read-link {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  font-family: var(--font-headline);
  font-size: 13px;
  font-weight: 700;
  color: var(--primary);
  text-decoration: none;
  margin-top: 1rem;
  transition: transform 0.2s ease;
}

.article-read-link:hover {
  text-decoration: underline;
  transform: translateX(3px);
}

.article-read-link .material-symbols-outlined {
  font-size: 15px;
}

/* ==================== 8. SCHEDULE & REGISTRATION ==================== */
.schedule-section {
  padding: 2.5rem 0 3.5rem;
}

.schedule-container-box {
  background-color: var(--surface-container);
  border-radius: 2rem;
  padding: 2rem;
  border: 1px solid rgba(191, 200, 206, 0.35);
}

@media (min-width: 768px) {
  .schedule-container-box {
    padding: 3rem;
  }
}

.schedule-header {
  text-align: center;
  max-width: 750px;
  margin: 0 auto;
}

.schedule-title {
  font-family: var(--font-headline);
  font-size: 1.85rem;
  font-weight: 600;
  color: var(--on-surface);
  margin-top: 0.25rem;
}

@media (min-width: 768px) {
  .schedule-title {
    font-size: 2.25rem;
  }
}

.schedule-desc {
  font-size: 15px;
  color: var(--on-surface-variant);
  margin-top: 0.45rem;
  line-height: 1.5;
}

.steps-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.5rem;
  margin: 2.5rem 0;
}

@media (min-width: 768px) {
  .steps-grid {
    grid-template-columns: repeat(3, 1fr);
  }
}

.step-card {
  background-color: var(--surface-container-lowest);
  border-radius: 1.25rem;
  padding: 2rem 1.5rem;
  border: 1px solid rgba(191, 200, 206, 0.25);
  box-shadow: var(--shadow-soft);
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
}

.step-badge {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: var(--font-headline);
  font-size: 18px;
  font-weight: 700;
  color: #fff;
  margin-bottom: 1rem;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.step-1 {
  background-color: var(--primary);
}

.step-2 {
  background-color: var(--secondary);
}

.step-3 {
  background-color: var(--tertiary);
}

.step-title {
  font-family: var(--font-headline);
  font-size: 17px;
  font-weight: 600;
  color: var(--on-surface);
  margin-bottom: 0.45rem;
}

.step-desc {
  font-size: 13.5px;
  color: var(--on-surface-variant);
  line-height: 1.5;
}

.schedule-action-box {
  background-color: var(--surface-container-lowest);
  border-radius: 1.25rem;
  padding: 1.5rem 2rem;
  border: 1px solid rgba(191, 200, 206, 0.25);
  box-shadow: var(--shadow-soft);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-between;
  gap: 1.5rem;
}

@media (min-width: 768px) {
  .schedule-action-box {
    flex-direction: row;
  }
}

.schedule-action-info {
  display: flex;
  flex-direction: column;
  gap: 0.35rem;
  text-align: center;
}

@media (min-width: 768px) {
  .schedule-action-info {
    text-align: left;
  }
}

.location-pill {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.35rem;
  color: var(--primary);
  font-size: 13.5px;
  font-weight: 600;
}

@media (min-width: 768px) {
  .location-pill {
    justify-content: flex-start;
  }
}

.location-pill .material-symbols-outlined {
  font-size: 18px;
}

.location-sub {
  font-size: 13.5px;
  color: var(--on-surface-variant);
}

.btn-primary-schedule {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.85rem 2rem;
  background-color: var(--primary);
  color: var(--on-primary);
  border-radius: var(--radius-full);
  font-family: var(--font-headline);
  font-size: 14.5px;
  font-weight: 600;
  text-decoration: none;
  white-space: nowrap;
  box-shadow: 0 4px 12px rgba(0, 99, 132, 0.2);
  transition: all 0.2s ease;
  flex-shrink: 0;
}

.btn-primary-schedule:hover {
  background-color: var(--primary-container);
  transform: translateY(-2px);
}

/* ==================== 9. CONTACT SECTION ==================== */
.contact-section {
  padding: 3rem 0 4rem;
}

.contact-header {
  text-align: center;
  max-width: 750px;
  margin: 0 auto 2.5rem;
}

.contact-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.35rem 1rem;
  border-radius: var(--radius-full);
  background-color: var(--secondary-fixed);
  color: var(--secondary);
  font-size: 12.5px;
  font-weight: 700;
  letter-spacing: 0.05em;
  margin-bottom: 0.75rem;
}

.contact-badge .material-symbols-outlined {
  font-size: 16px;
}

.contact-title {
  font-family: var(--font-headline);
  font-size: 1.85rem;
  font-weight: 600;
  color: var(--on-surface);
  line-height: 1.25;
}

@media (min-width: 768px) {
  .contact-title {
    font-size: 2.25rem;
  }
}

.contact-sub {
  font-size: 15px;
  color: var(--on-surface-variant);
  margin-top: 0.5rem;
  line-height: 1.6;
}

/* ==================== 9. MAP & POP-UP INFORMASI ==================== */
.map-section-wrapper {
  max-width: 1200px;
  margin: 0 auto;
}

.map-canvas-container {
  position: relative;
  width: 100%;
  height: 520px;
  border-radius: 1.25rem;
  overflow: hidden;
  box-shadow: 0 12px 36px rgba(15, 23, 42, 0.08), 0 2px 6px rgba(15, 23, 42, 0.04);
  border: 1px solid rgba(191, 200, 206, 0.4);
  background-color: #e5e7eb;
}

.map-iframe {
  width: 100%;
  height: 100%;
  border: 0;
  display: block;
}

/* Floating Pop-up Card (As in user reference image) */
.map-popup-card {
  position: absolute;
  top: 50%;
  right: 36px;
  transform: translateY(-50%);
  width: 380px;
  max-width: calc(100% - 72px);
  background-color: #ffffff;
  border-radius: 1rem;
  padding: 1.75rem 1.6rem;
  box-shadow: 0 16px 40px rgba(15, 23, 42, 0.16), 0 4px 12px rgba(15, 23, 42, 0.08);
  border: 1px solid rgba(226, 232, 240, 0.9);
  z-index: 5;
  transition: box-shadow 0.3s ease;
}

.map-popup-card:hover {
  box-shadow: 0 20px 48px rgba(15, 23, 42, 0.2), 0 6px 16px rgba(15, 23, 42, 0.1);
}

.map-popup-title {
  font-family: var(--font-headline);
  font-size: 1.22rem;
  font-weight: 700;
  color: #1e293b;
  line-height: 1.3;
  margin: 0;
}

/* Orange Accent Bar under Title */
.map-popup-accent {
  width: 36px;
  height: 3.5px;
  background-color: #e26a2c;
  border-radius: 2px;
  margin: 0.75rem 0 1.25rem;
}

.map-popup-items {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.map-popup-row {
  display: flex;
  align-items: flex-start;
  gap: 0.85rem;
}

.map-icon-orange {
  font-size: 20px;
  color: #e26a2c;
  flex-shrink: 0;
  margin-top: 1px;
}

.map-row-content {
  flex: 1;
}

.map-row-text {
  font-size: 13.5px;
  line-height: 1.55;
  color: #475569;
  margin: 0;
}

.map-link {
  color: #475569;
  text-decoration: none;
  transition: color 0.2s ease;
}

.map-link:hover {
  color: #e26a2c;
  text-decoration: underline;
}

.map-sep {
  margin: 0 0.35rem;
  color: #94a3b8;
}

/* Action Buttons (Solid Deep Navy Pills) */
.map-popup-actions {
  display: flex;
  flex-direction: column;
  gap: 0.65rem;
  margin-top: 1.5rem;
}

.map-popup-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  padding: 0.78rem 1.25rem;
  border-radius: var(--radius-full);
  font-size: 14.5px;
  font-weight: 700;
  text-decoration: none;
  cursor: pointer;
  transition: all 0.2s ease;
  letter-spacing: 0.01em;
}

.btn-navy {
  background-color: #0d2e4f;
  color: #ffffff;
  border: 1px solid #0d2e4f;
}

.btn-navy:hover {
  background-color: #061c33;
  border-color: #061c33;
  color: #ffffff;
  transform: translateY(-2px);
  box-shadow: 0 6px 18px rgba(13, 46, 79, 0.3);
  text-decoration: none;
}

/* Bottom Operational Strip */
.clinic-quick-strip {
  margin-top: 1.25rem;
  background-color: var(--surface-container-low);
  border: 1px solid rgba(191, 200, 206, 0.35);
  border-radius: 1rem;
  padding: 1rem 1.5rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1.5rem;
  box-shadow: var(--shadow-soft);
}

.quick-strip-item {
  display: flex;
  align-items: center;
  gap: 0.85rem;
  flex: 1;
}

.quick-strip-icon {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.quick-strip-icon .material-symbols-outlined {
  font-size: 20px;
}

.bg-primary-soft {
  background-color: var(--primary-fixed);
  color: var(--primary);
}

.bg-wa-soft {
  background-color: rgba(37, 211, 102, 0.15);
  color: #1b873f;
}

.quick-strip-info {
  display: flex;
  flex-direction: column;
}

.quick-strip-label {
  font-size: 12px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.04em;
  color: var(--on-surface-variant);
}

.quick-strip-val {
  font-size: 13.5px;
  font-weight: 600;
  color: var(--on-surface);
  margin-top: 0.1rem;
}

.val-separator {
  margin: 0 0.4rem;
  color: #94a3b8;
  font-weight: 400;
}

.quick-strip-divider {
  width: 1px;
  height: 36px;
  background-color: rgba(191, 200, 206, 0.4);
}

@media (max-width: 991px) {
  .map-canvas-container {
    height: auto;
    display: flex;
    flex-direction: column;
  }
  .map-iframe {
    height: 350px;
  }
  .map-popup-card {
    position: static;
    transform: none;
    width: 100%;
    max-width: 100%;
    border-radius: 0;
    box-shadow: none;
    border-top: 1px solid rgba(226, 232, 240, 0.9);
    padding: 1.5rem 1.25rem;
  }
  .clinic-quick-strip {
    flex-direction: column;
    align-items: flex-start;
    gap: 1rem;
  }
  .quick-strip-divider {
    display: none;
  }
}

/* ==================== COMPREHENSIVE RESPONSIVE STYLES (MOBILE & TABLET) ==================== */

/* Tablet Optimization (640px - 1023px) */
@media (min-width: 640px) and (max-width: 1023px) {
  .services-section {
    padding: 2.75rem 0;
  }
  .services-grid {
    gap: 1.25rem;
  }
  .service-card {
    padding: 1.5rem 1.25rem;
  }

  .team-section {
    padding: 2.75rem 0 3.5rem;
  }
  .team-grid {
    gap: 1.25rem;
  }
  .team-photo-wrap {
    height: 220px;
  }

  .testimonials-section {
    padding: 3rem 0 3.5rem;
  }
  .testimonials-stats-bar {
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    padding: 1.15rem 1.25rem;
    margin-bottom: 2.25rem;
  }
  .testimonials-cta-strip {
    padding: 2rem;
  }

  .articles-section {
    padding: 2.25rem 0 3rem;
  }
  .articles-grid {
    gap: 1.25rem;
  }
  .article-thumb-wrap {
    height: 170px;
  }

  .schedule-container-box {
    padding: 2.25rem 2rem;
  }
  .step-card {
    padding: 1.5rem 1rem;
  }

  .contact-inner-card {
    padding: 2rem;
  }
}

/* Mobile Phone Optimization (< 640px) */
@media (max-width: 640px) {
  /* Pillars Section Mobile Polish */
  .pillars-section {
    padding: 1rem 0 2.25rem;
  }
  .pillar-card {
    padding: 1.15rem 0.65rem;
    border-radius: 1rem;
  }
  .pillar-icon {
    width: 44px;
    height: 44px;
    margin-bottom: 0.65rem;
  }
  .pillar-icon .material-symbols-outlined {
    font-size: 22px;
  }
  .pillar-title {
    font-size: 14px;
    margin-bottom: 0.25rem;
  }
  .pillar-desc {
    font-size: 11.5px;
    line-height: 1.35;
  }

  /* About Section Mobile Polish */
  .about-section {
    padding: 1.75rem 0;
  }
  .about-container-box {
    padding: 1.35rem 1rem;
    border-radius: 1.35rem;
  }
  .about-grid {
    gap: 1.75rem;
  }
  .about-title {
    font-size: 1.55rem;
  }
  .about-desc {
    font-size: 13.5px;
    line-height: 1.55;
  }
  .about-stats-row {
    gap: 0.65rem;
    margin: 0.25rem 0;
  }
  .about-stat-box {
    padding: 0.75rem 0.85rem;
    border-radius: 0.85rem;
  }
  .stat-num {
    font-size: 1.45rem;
  }
  .stat-label {
    font-size: 11.5px;
  }
  .about-cta-wrap {
    width: 100%;
  }
  .btn-primary-about {
    width: 100%;
    justify-content: center;
    padding: 0.75rem 1.25rem;
    font-size: 13.5px;
  }
  .about-img {
    height: 220px;
  }
  .about-facility-badge {
    font-size: 10px;
    padding: 0.3rem 0.55rem;
    top: 0.65rem;
    right: 0.65rem;
  }
  .about-founders-capsule {
    padding: 0.75rem 0.85rem;
    gap: 0.75rem;
    border-radius: 0.85rem;
  }
  .founders-icon-wrap {
    width: 38px;
    height: 38px;
  }
  .founders-icon-wrap .material-symbols-outlined {
    font-size: 20px;
  }
  .founders-label {
    font-size: 13px;
  }
  .founders-names {
    font-size: 12.5px;
  }

  /* Services Section Mobile Polish */
  .services-section {
    padding: 2.25rem 0;
  }
  .services-grid {
    gap: 1rem;
  }
  .service-card {
    padding: 1.25rem 1.15rem;
    border-radius: 1rem;
  }
  .svc-icon-circle {
    width: 46px;
    height: 46px;
    margin-bottom: 0.85rem;
  }
  .svc-icon-circle .material-symbols-outlined {
    font-size: 22px;
  }
  .svc-title {
    font-size: 16px;
  }
  .svc-tag {
    font-size: 11.5px;
    margin-bottom: 0.5rem;
  }
  .svc-desc {
    font-size: 13px;
    line-height: 1.45;
  }
  .svc-footer {
    margin-top: 0.85rem;
    padding-top: 0.75rem;
  }

  /* Quote Section Mobile Polish */
  .quote-section {
    padding: 0.5rem 0 2rem;
  }
  .quote-card {
    padding: 1.75rem 1.15rem;
    border-radius: 1.25rem;
    gap: 0.5rem;
  }
  .quote-icon {
    font-size: 32px;
  }
  .quote-text {
    font-size: 1.15rem;
    line-height: 1.45;
  }
  .quote-sub {
    font-size: 13px;
  }

  /* Team Section Mobile Polish */
  .team-section {
    padding: 2.25rem 0 3rem;
  }
  .team-grid {
    gap: 1.25rem;
  }
  .team-card {
    border-radius: 1rem;
  }
  .team-photo-wrap {
    height: 210px;
  }
  .team-card-content {
    padding: 1.15rem 1rem;
    word-break: break-word;
  }
  .team-name {
    font-size: 15.5px;
  }
  .team-role {
    font-size: 11.5px;
    margin-bottom: 0.5rem;
  }
  .team-bio {
    font-size: 12.5px;
    line-height: 1.45;
    margin-bottom: 0.75rem;
  }
  .team-tags {
    margin-bottom: 0.75rem;
    gap: 0.3rem;
  }
  .team-tag {
    font-size: 10px;
    padding: 0.2rem 0.45rem;
  }
  .team-card-action {
    padding-top: 0.75rem;
  }
  .team-consult-link {
    font-size: 12.5px;
  }

  /* Testimonials Section Mobile Polish */
  .testimonials-section {
    padding: 2.25rem 0 2.75rem;
  }
  .testimonials-header {
    margin-bottom: 1.5rem;
  }
  .testimonials-stats-bar {
    grid-template-columns: repeat(2, 1fr);
    gap: 0.65rem;
    padding: 0.85rem 0.75rem;
    border-radius: 1rem;
    margin-bottom: 1.75rem;
  }
  .stat-pill {
    padding: 0.4rem 0.5rem;
    gap: 0.5rem;
    border-radius: 8px;
  }
  .stat-pill-icon {
    font-size: 22px;
  }
  .stat-pill-val {
    font-size: 13.5px;
  }
  .stat-pill-lbl {
    font-size: 10px;
    line-height: 1.2;
  }
  .stat-pill-stars .material-symbols-outlined {
    font-size: 14px;
  }
  .testimonials-grid {
    gap: 1.25rem;
    margin-bottom: 1.75rem;
  }
  .story-card {
    padding: 1.25rem 1rem;
    border-radius: 1.15rem;
  }
  .story-card-header {
    gap: 0.5rem;
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
  }
  .story-avatar {
    width: 42px;
    height: 42px;
  }
  .story-parent-name {
    font-size: 13.5px;
  }
  .story-service-tag {
    font-size: 10px;
    padding: 0.2rem 0.5rem;
  }
  .story-case-box {
    padding: 0.65rem 0.75rem;
    margin-bottom: 0.85rem;
    border-radius: 0 8px 8px 0;
  }
  .story-quote-body {
    margin-bottom: 1rem;
  }
  .story-quote-mark {
    font-size: 18px;
    top: -4px;
    left: 0;
  }
  .story-quote-text {
    font-size: 12.5px;
    line-height: 1.5;
    padding-left: 1.2rem;
  }
  .story-progress-box {
    padding: 0.65rem 0.75rem;
    border-radius: 10px;
    margin-bottom: 1rem;
  }
  .progress-box-title {
    font-size: 10.5px;
    margin-bottom: 0.35rem;
  }
  .progress-list li {
    font-size: 11.5px;
    gap: 0.35rem;
  }
  .progress-list .check-icon {
    font-size: 14px;
  }
  .story-card-footer {
    padding-top: 0.75rem;
  }
  .story-stars .material-symbols-outlined {
    font-size: 14px;
  }
  .story-duration {
    font-size: 10px;
    padding: 0.15rem 0.45rem;
  }
  .testimonials-cta-strip {
    padding: 1.5rem 1.15rem;
    border-radius: 1.25rem;
    text-align: center;
    gap: 1.25rem;
  }
  .cta-strip-title {
    font-size: 1.25rem;
  }
  .cta-strip-desc {
    font-size: 13px;
    line-height: 1.5;
  }
  .cta-strip-buttons {
    width: 100%;
    flex-direction: column;
    gap: 0.65rem;
  }
  .btn-strip-primary,
  .btn-strip-wa {
    width: 100%;
    justify-content: center;
    padding: 0.75rem 1.25rem;
    font-size: 13.5px;
  }

  /* Articles Section Mobile Polish */
  .articles-section {
    padding: 1.75rem 0 2.5rem;
  }
  .articles-grid {
    gap: 1.25rem;
  }
  .article-card {
    border-radius: 1rem;
  }
  .article-thumb-wrap {
    height: 160px;
  }
  .article-content {
    padding: 1rem;
  }
  .article-date-tag {
    font-size: 10.5px;
  }
  .article-title {
    font-size: 15px;
  }
  .article-excerpt {
    font-size: 12.5px;
    line-height: 1.45;
  }
  .article-read-link {
    font-size: 12.5px;
    margin-top: 0.85rem;
  }

  /* Schedule Section Mobile Polish */
  .schedule-section {
    padding: 2rem 0 2.5rem;
  }
  .schedule-container-box {
    padding: 1.35rem 1rem;
    border-radius: 1.35rem;
  }
  .schedule-title {
    font-size: 1.55rem;
  }
  .schedule-desc {
    font-size: 13.5px;
  }
  .steps-grid {
    gap: 1rem;
    margin: 1.75rem 0;
  }
  .step-card {
    padding: 1.35rem 1rem;
    border-radius: 1rem;
  }
  .step-badge {
    width: 42px;
    height: 42px;
    font-size: 16px;
    margin-bottom: 0.75rem;
  }
  .step-title {
    font-size: 15.5px;
  }
  .step-desc {
    font-size: 12.5px;
  }
  .schedule-action-box {
    padding: 1.25rem 1rem;
    border-radius: 1rem;
    gap: 1rem;
  }
  .location-pill {
    font-size: 12.5px;
    text-align: center;
  }
  .location-sub {
    font-size: 12px;
  }
  .btn-primary-schedule {
    width: 100%;
    justify-content: center;
    padding: 0.8rem 1.5rem;
    font-size: 14px;
  }

  /* Map & Pop-up Section Mobile Polish */
  .contact-section {
    padding: 2.25rem 0 3rem;
  }
  .contact-header {
    margin-bottom: 1.75rem;
  }
  .contact-title {
    font-size: 1.55rem;
  }
  .contact-sub {
    font-size: 13.5px;
  }
  .map-canvas-container {
    border-radius: 1rem;
  }
  .map-iframe {
    height: 300px;
  }
  .map-popup-card {
    padding: 1.35rem 1.15rem;
  }
  .map-popup-title {
    font-size: 1.15rem;
  }
  .map-popup-accent {
    margin: 0.6rem 0 1rem;
  }
  .map-popup-items {
    gap: 0.85rem;
  }
  .map-row-text {
    font-size: 12.5px;
  }
  .map-popup-actions {
    margin-top: 1.25rem;
    gap: 0.5rem;
  }
  .map-popup-btn {
    padding: 0.72rem 1rem;
    font-size: 13.5px;
  }
  .clinic-quick-strip {
    padding: 1rem;
    border-radius: 0.85rem;
  }
  .quick-strip-val {
    font-size: 12.5px;
  }
}
</style>
