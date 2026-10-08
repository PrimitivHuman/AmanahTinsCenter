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
            
            <!-- Trust Badges & Clinical Endorsement -->
            <div class="hero-trust">
              <div class="trust-avatars">
                <div class="trust-avatar avatar-tw">TW</div>
                <div class="trust-avatar avatar-ot">OT</div>
                <div class="trust-avatar avatar-si">SI</div>
              </div>
              <div class="trust-content">
                <div class="stars">
                  <span v-for="i in 5" :key="i" class="material-symbols-outlined star icon-fill">star</span>
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
                  src="https://lh3.googleusercontent.com/aida-public/AB6AXuA7KRNifS1-zPhLJA_LVUizozlej0k7mqPdRFi4j3F1BCntUefBunKjAsGZog6F6mfgJuECODOHnid6MkmGXoXJCql6to7vtq385Drpi8oke37YwjJYv7nkwqfrK8x--c7sgKYK50XqKZ5mPlHuMdlerlPQWtw3UKjt9t0j42HG6lvNY7M_VOshTzxXk74Ph4LULLnZU1Vz2Tq0vEuglhU7U6E7gRsP7Rh9wYyWwjA"
                  alt="Ruang terapi Amanah Tin's Center"
                  class="about-img"
                />
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
            <h2 class="section-heading">Didampingi Terapis Ahli & Berdedikasi</h2>
            <p class="section-subheading">Praktisi profesional berlisensi dan berpengalaman di bidang tumbuh kembang anak dengan pendekatan penuh kasih.</p>
          </div>
          <router-link to="/tim-kami" class="header-more-link">
            <span>Lihat Semua Tim</span>
            <span class="material-symbols-outlined">arrow_forward</span>
          </router-link>
        </div>

        <div class="team-grid">
          <div v-for="member in team" :key="member.name" class="team-card">
            <div class="team-icon-circle" :class="member.bg">
              <span class="material-symbols-outlined">{{ member.icon }}</span>
            </div>
            <h3 class="team-name">{{ member.name }}</h3>
            <span class="team-role" :class="member.roleColor">{{ member.role }}</span>
            <p class="team-bio">{{ member.bio }}</p>
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
              <img :src="art.image" :alt="art.title" class="article-thumb" />
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
                <span>Pusat Layanan: Jl. Raya Jagakarsa No. 12, Jakarta Selatan</span>
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
            <span class="material-symbols-outlined">support_agent</span>
            <span>HUBUNGI KAMI</span>
          </div>
          <h2 class="contact-title">Konsultasi & Kunjungi Klinik Kami</h2>
          <p class="contact-sub">
            Punya pertanyaan seputar tumbuh kembang ananda atau ingin berkonsultasi langsung? Tim kami siap menyambut Ayah dan Bunda dengan hangat di Jagakarsa.
          </p>
        </div>

        <div class="contact-card-wrapper">
          <div class="contact-inner-card">
            <div class="contact-inner-header">
              <h3 class="contact-inner-title">Pusat Informasi & Lokasi</h3>
              <p class="contact-inner-sub">Silakan hubungi kami atau berkunjung ke klinik kami pada jam kerja.</p>
            </div>

            <div class="contact-items-grid">
              <!-- Alamat -->
              <div class="contact-item">
                <div class="contact-icon-circle bg-primary-soft">
                  <span class="material-symbols-outlined">location_on</span>
                </div>
                <div class="contact-item-info">
                  <h4 class="contact-item-label">Alamat Klinik</h4>
                  <p class="contact-item-val">Jl. Raya Jagakarsa No. 12, Jagakarsa, Jakarta Selatan 12620</p>
                  <a href="https://maps.google.com/?q=Jl.+Raya+Jagakarsa+No.+12+Jakarta+Selatan" target="_blank" rel="noopener noreferrer" class="contact-item-link">
                    <span class="material-symbols-outlined">map</span>
                    <span>Buka di Google Maps</span>
                  </a>
                </div>
              </div>

              <!-- WhatsApp -->
              <div class="contact-item">
                <div class="contact-icon-circle bg-secondary-soft">
                  <span class="material-symbols-outlined">chat</span>
                </div>
                <div class="contact-item-info">
                  <h4 class="contact-item-label">WhatsApp Resmi</h4>
                  <p class="contact-item-val">0812 3456 7890 (Respon cepat selama jam layanan)</p>
                </div>
              </div>

              <!-- Telepon -->
              <div class="contact-item contact-item-compact">
                <div class="contact-icon-circle-sm bg-primary-soft">
                  <span class="material-symbols-outlined">call</span>
                </div>
                <div>
                  <span class="contact-compact-label">Telepon Klinik</span>
                  <span class="contact-compact-val">(021) 1234 5678</span>
                </div>
              </div>

              <!-- Email -->
              <div class="contact-item contact-item-compact">
                <div class="contact-icon-circle-sm bg-tertiary-soft">
                  <span class="material-symbols-outlined">mail</span>
                </div>
                <div>
                  <span class="contact-compact-label">Email Resmi</span>
                  <span class="contact-compact-val">info@amanah-tinscenter.id</span>
                </div>
              </div>

              <!-- Jam Operasional (Full width) -->
              <div class="contact-item contact-item-wide">
                <div class="contact-icon-circle bg-tertiary-soft">
                  <span class="material-symbols-outlined">schedule</span>
                </div>
                <div class="contact-item-info">
                  <h4 class="contact-item-label">Jam Operasional</h4>
                  <ul class="operating-hours-list">
                    <li class="hours-row">
                      <span>Senin – Jumat:</span>
                      <span class="hours-bold">08.00 – 17.00 WIB</span>
                    </li>
                    <li class="hours-row">
                      <span>Sabtu:</span>
                      <span class="hours-bold">08.00 – 15.00 WIB</span>
                    </li>
                    <li class="hours-row hours-closed">
                      <span>Minggu & Libur Nasional:</span>
                      <span>Tutup (Reservasi Online Buka)</span>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ==================== 10. FLOATING WHATSAPP BUTTON ==================== -->
    <aside class="floating-wa-container" aria-label="Kontak Cepat WhatsApp">
      <a href="https://wa.me/6281234567890" target="_blank" rel="noopener noreferrer" class="btn-floating-wa">
        <span class="material-symbols-outlined">chat</span>
        <span>Konsultasi WhatsApp</span>
      </a>
    </aside>
  </PublicLayout>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import PublicLayout from '../layouts/PublicLayout.vue'
import api from '../services/api'
import { activeSection } from '../composables/useActiveSection'

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
    title: 'Psikologi Anak',
    tag: 'Child Psychology',
    tagColor: 'tag-primary',
    desc: 'Mendampingi aspek emosional, perilaku, kesiapan masuk sekolah dasar, asesmen IQ, serta konsultasi parenting terpadu.',
    link: '/layanan/psikologi-anak'
  }
]

// 3. Team
const team = [
  {
    icon: 'medical_services',
    bg: 'team-bg-primary',
    name: 'dr. Raden Sarah Amalia, Sp.A',
    role: 'Dokter Spesialis Anak & Tumbuh Kembang',
    roleColor: 'role-primary',
    bio: 'Fokus asesmen klinis, evaluasi milestone fisik & kognitif anak secara komprehensif.'
  },
  {
    icon: 'record_voice_over',
    bg: 'team-bg-secondary',
    name: 'Annisa Larasati, A.Md.TW',
    role: 'Terapis Wicara (Speech Pathologist)',
    roleColor: 'role-secondary',
    bio: 'Spesialisasi artikulasi, stimulasi speech delay, serta kelancaran komunikasi dua arah.'
  },
  {
    icon: 'accessibility_new',
    bg: 'team-bg-tertiary',
    name: 'Dimas Bagaswara, S.Tr.Kes',
    role: 'Terapis Okupasi & Sensori Integrasi',
    roleColor: 'role-tertiary',
    bio: 'Fokus regulasi sensori, kemandirian motorik, dan pelatihan integrasi sensori adaptif.'
  }
]

// 4. Default Curated Blueprint Articles
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

// Section tracking for active navbar state
const sectionIds = [
  'beranda',
  'tentang-kami',
  'layanan',
  'tim-kami',
  'artikel',
  'jadwal',
  'kontak'
]

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
    const res = await api.get('/articles?per_page=4')
    if (res.data?.data && res.data.data.length >= 4) {
      apiArticles.value = res.data.data
    }
  } catch {
    // Graceful fallback to blueprint articles
  }
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})

const displayArticles = computed(() => {
  if (apiArticles.value.length >= 4) {
    return apiArticles.value.map((art, idx) => ({
      image: art.image || blueprintArticles[idx % 4].image,
      category: art.category,
      date: new Date(art.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }),
      tagColor: idx % 3 === 0 ? 'tag-primary' : (idx % 3 === 1 ? 'tag-secondary' : 'tag-tertiary'),
      title: art.title,
      excerpt: art.excerpt,
      slug: art.slug
    }))
  }
  return blueprintArticles
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
}

.trust-avatar {
  width: 38px;
  height: 38px;
  border-radius: 50%;
  border: 2px solid var(--surface-container-lowest);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 11px;
  font-weight: 700;
  margin-left: -10px;
}

.trust-avatar:first-child {
  margin-left: 0;
}

.avatar-tw {
  background-color: var(--surface-container);
  color: var(--primary);
}

.avatar-ot {
  background-color: var(--secondary-fixed);
  color: var(--secondary);
}

.avatar-si {
  background-color: var(--tertiary-fixed);
  color: var(--tertiary);
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

/* ==================== 2. FOUR PILLARS ==================== */
.pillars-section {
  padding: 1.5rem 0 3rem;
}

.pillars-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.25rem;
}

@media (min-width: 640px) {
  .pillars-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 1024px) {
  .pillars-grid {
    grid-template-columns: repeat(4, 1fr);
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
  border-radius: 1.25rem;
  overflow: hidden;
  border: 1px solid rgba(191, 200, 206, 0.25);
  box-shadow: var(--shadow-soft);
  background-color: var(--surface-container-lowest);
}

.about-img {
  width: 100%;
  height: 300px;
  object-fit: cover;
  display: block;
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

/* ==================== 6. TEAM SECTION ==================== */
.team-section {
  padding: 2.5rem 0 3.5rem;
}

.team-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.5rem;
}

@media (min-width: 768px) {
  .team-grid {
    grid-template-columns: repeat(3, 1fr);
  }
}

.team-card {
  background-color: var(--surface-container-lowest);
  border-radius: 1.25rem;
  padding: 2rem 1.5rem;
  border: 1px solid rgba(191, 200, 206, 0.25);
  box-shadow: var(--shadow-soft);
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.team-card:hover {
  transform: translateY(-4px);
  box-shadow: var(--shadow-lift);
}

.team-icon-circle {
  width: 72px;
  height: 72px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 1.25rem;
}

.team-icon-circle .material-symbols-outlined {
  font-size: 34px;
}

.team-bg-primary {
  background-color: rgba(193, 232, 255, 0.6);
  color: var(--primary);
}

.team-bg-secondary {
  background-color: rgba(204, 239, 142, 0.6);
  color: var(--secondary);
}

.team-bg-tertiary {
  background-color: rgba(255, 220, 191, 0.6);
  color: var(--tertiary);
}

.team-name {
  font-family: var(--font-headline);
  font-size: 17px;
  font-weight: 600;
  color: var(--on-surface);
  margin-bottom: 0.2rem;
}

.team-role {
  display: inline-block;
  font-size: 12px;
  font-weight: 600;
  margin-bottom: 0.75rem;
}

.role-primary {
  color: var(--primary);
}

.role-secondary {
  color: var(--secondary);
}

.role-tertiary {
  color: var(--tertiary);
}

.team-bio {
  font-size: 13.5px;
  color: var(--on-surface-variant);
  line-height: 1.5;
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

.contact-card-wrapper {
  max-width: 860px;
  margin: 0 auto;
}

.contact-inner-card {
  background-color: var(--surface-container-low);
  border-radius: 1.5rem;
  padding: 2rem;
  border: 1px solid rgba(191, 200, 206, 0.35);
  box-shadow: var(--shadow-soft);
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

@media (min-width: 768px) {
  .contact-inner-card {
    padding: 2.5rem;
  }
}

.contact-inner-title {
  font-family: var(--font-headline);
  font-size: 1.25rem;
  font-weight: 700;
  color: var(--primary);
  margin-bottom: 0.2rem;
}

.contact-inner-sub {
  font-size: 13.5px;
  color: var(--on-surface-variant);
}

.contact-items-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.25rem;
}

@media (min-width: 768px) {
  .contact-items-grid {
    grid-template-columns: 1fr 1fr;
  }
}

.contact-item {
  background-color: var(--surface-container-lowest);
  border-radius: 1rem;
  padding: 1.25rem;
  border: 1px solid rgba(191, 200, 206, 0.25);
  display: flex;
  align-items: flex-start;
  gap: 1rem;
}

.contact-item-compact {
  align-items: center;
  gap: 0.75rem;
}

@media (min-width: 768px) {
  .contact-item-wide {
    grid-column: span 2;
  }
}

.contact-icon-circle {
  width: 44px;
  height: 44px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.contact-icon-circle .material-symbols-outlined {
  font-size: 22px;
}

.contact-icon-circle-sm {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.contact-icon-circle-sm .material-symbols-outlined {
  font-size: 18px;
}

.bg-primary-soft {
  background-color: var(--primary-fixed);
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

.contact-item-info {
  flex: 1;
}

.contact-item-label {
  font-family: var(--font-headline);
  font-size: 15px;
  font-weight: 600;
  color: var(--on-surface);
}

.contact-item-val {
  font-size: 13.5px;
  color: var(--on-surface-variant);
  margin-top: 0.2rem;
  line-height: 1.45;
}

.contact-item-link {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  font-size: 13px;
  font-weight: 700;
  color: var(--primary);
  text-decoration: none;
  margin-top: 0.5rem;
}

.contact-item-link:hover {
  text-decoration: underline;
}

.contact-item-link .material-symbols-outlined {
  font-size: 16px;
}

.contact-compact-label {
  display: block;
  font-size: 12.5px;
  font-weight: 600;
  color: var(--on-surface);
}

.contact-compact-val {
  font-size: 13.5px;
  color: var(--on-surface-variant);
}

.operating-hours-list {
  list-style: none;
  padding: 0;
  margin: 0.5rem 0 0 0;
  display: flex;
  flex-direction: column;
  gap: 0.35rem;
  font-size: 13.5px;
  color: var(--on-surface-variant);
}

.hours-row {
  display: flex;
  justify-content: space-between;
  border-bottom: 1px solid rgba(191, 200, 206, 0.2);
  padding-bottom: 0.35rem;
}

.hours-bold {
  font-weight: 600;
  color: var(--on-surface);
}

.hours-closed {
  border-bottom: none;
  color: var(--tertiary);
  font-weight: 500;
  padding-top: 0.2rem;
}

/* ==================== 10. FLOATING WHATSAPP PILL ==================== */
.floating-wa-container {
  position: fixed;
  bottom: 1.5rem;
  right: 1.5rem;
  z-index: 50;
  display: none;
}

@media (min-width: 640px) {
  .floating-wa-container {
    display: block;
  }
}

.btn-floating-wa {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.75rem 1.35rem;
  background-color: var(--secondary);
  color: var(--on-secondary);
  border-radius: var(--radius-full);
  font-family: var(--font-headline);
  font-size: 14.5px;
  font-weight: 600;
  text-decoration: none;
  box-shadow: 0 6px 20px rgba(75, 103, 22, 0.35);
  border: 1px solid rgba(204, 239, 142, 0.5);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.btn-floating-wa:hover {
  transform: scale(1.05);
  box-shadow: 0 8px 24px rgba(75, 103, 22, 0.45);
}
</style>
