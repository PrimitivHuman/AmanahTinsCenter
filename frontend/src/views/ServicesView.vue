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
              <span>Terapis Berlisensi STR Kemenkes • Jagakarsa</span>
            </div>
            <h1 class="hero-title">
              Layanan Terapi Terpadu untuk <span class="hero-title-accent">Tumbuh Kembang Optimal</span> Buah Hati
            </h1>
            <p class="hero-desc">
              Pendampingan tumbuh kembang ramah anak yang dirancang khusus untuk memfasilitasi kebutuhan bicara, motorik, sensorik, dan emosional si Kecil melalui pendekatan bermain yang hangat, terstruktur, dan berbasis bukti klinis.
            </p>
            <div class="hero-actions">
              <a href="#therapy-matcher" class="btn-primary hero-btn-primary">
                <span>Panduan Memilih Terapi</span>
                <span class="material-symbols-outlined" style="font-size:18px">psychology_alt</span>
              </a>
              <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Amanah%20Tin's%20Center,%20saya%20ingin%20konsultasi%20mengenai%20layanan%20terapi%20untuk%20anak%20saya" target="_blank" rel="noopener noreferrer" class="btn-outline-secondary hero-btn-wa">
                <span class="material-symbols-outlined fill" style="font-size:20px; color: #25d366">chat</span>
                <span>Konsultasi Awal WhatsApp</span>
              </a>
            </div>
          </div>

          <!-- Right: Image -->
          <div class="hero-image-col">
            <div class="hero-image-frame">
              <img
                src="/ruang-terapi-atc.jpg"
                alt="Fasilitas Ruang Terapi Ramah Anak Amanah Tin's Center Jagakarsa"
                class="hero-img"
              />
              <div class="hero-badge-float">
                <div class="badge-float-icon">
                  <span class="material-symbols-outlined fill" style="font-size:22px">health_and_safety</span>
                </div>
                <div>
                  <div class="badge-float-title">100% Ramah Anak</div>
                  <div class="badge-float-sub">Fasilitas aman, higienis &amp; tersertifikasi</div>
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

    <!-- ===== SECTION 3: INTERACTIVE THERAPY MATCHER (PANDUAN BERBASIS GEJALA HARIAN) ===== -->
    <section class="matcher-section" id="therapy-matcher">
      <div class="container">
        <div class="section-header">
          <div class="matcher-badge-chip">
            <span class="material-symbols-outlined chip-icon">help</span>
            <span>Panduan Cepat Orang Tua</span>
          </div>
          <h2 class="section-title">Bingung Memilih Terapi yang Tepat untuk Si Kecil?</h2>
          <p class="section-sub">
            Ayah &amp; Bunda tidak perlu menghafal istilah medis klinis. Cukup amati perilaku sehari-hari si Kecil di bawah ini untuk menemukan rekomendasi program terapi yang paling tepat:
          </p>
        </div>

        <!-- 4 Symptom Selector Cards -->
        <div class="symptom-cards-grid">
          <button
            v-for="(symptom, idx) in symptoms"
            :key="symptom.id"
            @click="activeSymptomIndex = idx"
            class="symptom-card-btn"
            :class="{ 'is-active': activeSymptomIndex === idx }"
          >
            <div class="symptom-btn-icon" :class="symptom.iconClass">
              <span class="material-symbols-outlined">{{ symptom.icon }}</span>
            </div>
            <div class="symptom-btn-body">
              <span class="symptom-cat-badge">{{ symptom.badge }}</span>
              <h3 class="symptom-btn-title">{{ symptom.title }}</h3>
              <p class="symptom-btn-worry">"{{ symptom.parentWorry }}"</p>
            </div>
            <div class="symptom-check-indicator">
              <span class="material-symbols-outlined indicator-icon">
                {{ activeSymptomIndex === idx ? 'check_circle' : 'radio_button_unchecked' }}
              </span>
            </div>
          </button>
        </div>

        <!-- Active Recommendation Showcase -->
        <div v-if="currentSymptom" class="matcher-result-card" :class="currentSymptom.cardClass">
          <div class="result-top-bar">
            <div class="result-badge-group">
              <span class="result-match-pill">
                <span class="material-symbols-outlined fill match-star">verified</span>
                Rekomendasi Terapi Utama
              </span>
              <span class="result-age-badge">
                <span class="material-symbols-outlined">face</span>
                Usia: {{ currentSymptom.targetAge }}
              </span>
            </div>
            <span class="result-status-tag">1-on-1 Privat Bersama Terapis Ber-STR</span>
          </div>

          <div class="result-grid">
            <!-- Left Info -->
            <div class="result-main-col">
              <div class="result-title-row">
                <div class="result-big-icon" :class="currentSymptom.iconClass">
                  <span class="material-symbols-outlined">{{ currentSymptom.icon }}</span>
                </div>
                <div>
                  <h3 class="result-prog-name">{{ currentSymptom.matchedTherapy }}</h3>
                  <p class="result-focus-tag">Fokus: Pendekatan Play-Based Tanpa Rasa Takut</p>
                </div>
              </div>

              <div class="result-why-box">
                <h4 class="why-title">
                  <span class="material-symbols-outlined">lightbulb</span>
                  Mengapa program ini cocok untuk si Kecil?
                </h4>
                <p class="why-text">{{ currentSymptom.whyMatch }}</p>
              </div>

              <!-- Milestones Target -->
              <div class="result-milestones-box">
                <h4 class="milestones-title">Target Perubahan yang Dilatih:</h4>
                <ul class="milestones-list">
                  <li v-for="(milestone, mIdx) in currentSymptom.milestones" :key="mIdx">
                    <span class="material-symbols-outlined check-bullet">check_circle</span>
                    <span>{{ milestone }}</span>
                  </li>
                </ul>
              </div>
            </div>

            <!-- Right Action Box -->
            <div class="result-action-col">
              <div class="action-card-inner">
                <div class="action-header">
                  <span class="action-price-label">Asesmen Awal Mulai</span>
                  <div class="action-price-val">Rp 300.000 <span class="unit">/ sesi 60 mnt</span></div>
                  <p class="action-sub">Termasuk observasi klinis, konsultasi orang tua &amp; laporan tertulis.</p>
                </div>

                <div class="action-buttons-wrap">
                  <router-link :to="'/layanan/' + currentSymptom.slug" class="btn-result-detail">
                    <span>Pelajari Detail Program &amp; Biaya</span>
                    <span class="material-symbols-outlined">arrow_forward</span>
                  </router-link>

                  <a
                    :href="getWhatsAppMatcherUrl(currentSymptom)"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="btn-result-wa"
                  >
                    <span class="material-symbols-outlined fill">chat</span>
                    <span>Konsultasikan Gejala via WA</span>
                  </a>
                </div>

                <div class="action-assurance">
                  <span class="material-symbols-outlined lock-icon">verified_user</span>
                  <span>Klinik Resmi Berizin &bull; Jadwal Fleksibel</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ===== SECTION 4: 4 Core Therapy Programs (2x2 Bento Cards) ===== -->
    <section class="programs-section" id="program">
      <div class="container">
        <div class="section-header">
          <span class="section-eyebrow">Katalog Layanan Lengkap</span>
          <h2 class="section-title">4 Pilar Program Tumbuh Kembang Kami</h2>
          <p class="section-sub">
            Dirancang secara komprehensif untuk mendampingi setiap tahap tumbuh kembang dengan kurikulum individual yang terukur dan dipantau berkala.
          </p>
        </div>

        <div class="programs-grid">
          <!-- Card 1: Terapi Wicara -->
          <div class="prog-card prog-card--blue" :class="{ 'is-highlighted': activeSymptomIndex === 0 }">
            <div class="prog-card-top">
              <div class="prog-icon prog-icon--blue">
                <span class="material-symbols-outlined" style="font-size:32px">record_voice_over</span>
              </div>
              <span class="prog-badge prog-badge--blue">TW Program</span>
            </div>
            <h3 class="prog-name">Terapi Wicara (TW)</h3>
            <p class="prog-desc">
              Membantu anak mengekspresikan diri, mengatasi keterlambatan bicara (speech delay), stimulasi kejelasan artikulasi (cadel/pelo), dan melatih pemahaman instruksi.
            </p>

            <!-- Parent-Friendly Daily Signs Box -->
            <div class="prog-parent-box">
              <div class="parent-box-header">
                <span class="material-symbols-outlined box-icon">visibility</span>
                <span>Tanda Khas di Rumah:</span>
              </div>
              <p class="parent-box-text">
                Anak hanya menunjuk saat minta minum/makan, belum ada kata bermakna di usia 2 tahun, atau ucapan tidak dipahami orang di luar rumah.
              </p>
            </div>

            <div class="prog-focus">
              <div class="prog-focus-label">Fokus Stimulasi:</div>
              <div class="prog-tags">
                <span class="prog-tag">Speech Delay</span>
                <span class="prog-tag">Artikulasi &amp; Cadel</span>
                <span class="prog-tag">Kosa Kata Reseptif</span>
                <span class="prog-tag">Oral Motor &amp; Makan</span>
              </div>
            </div>

            <div class="prog-footer">
              <span class="prog-duration">
                <span class="material-symbols-outlined icon-small">schedule</span>
                Sesi 45 - 60 Menit (1-on-1)
              </span>
              <router-link to="/layanan/terapi-wicara" class="prog-link prog-link--blue">
                <span>Detail &amp; Biaya</span>
                <span class="material-symbols-outlined" style="font-size:18px">arrow_forward</span>
              </router-link>
            </div>
          </div>

          <!-- Card 2: Terapi Okupasi -->
          <div class="prog-card prog-card--green" :class="{ 'is-highlighted': activeSymptomIndex === 2 }">
            <div class="prog-card-top">
              <div class="prog-icon prog-icon--green">
                <span class="material-symbols-outlined" style="font-size:32px">front_hand</span>
              </div>
              <span class="prog-badge prog-badge--green">TO / BT Program</span>
            </div>
            <h3 class="prog-name">Terapi Okupasi (BT / OT)</h3>
            <p class="prog-desc">
              Melatih keterampilan otot motorik halus, koordinasi kedua tangan, serta kemandirian anak dalam makan sendiri, berpakaian, dan kesiapan memegang pensil / menulis.
            </p>

            <!-- Parent-Friendly Daily Signs Box -->
            <div class="prog-parent-box">
              <div class="parent-box-header">
                <span class="material-symbols-outlined box-icon">visibility</span>
                <span>Tanda Khas di Rumah:</span>
              </div>
              <p class="parent-box-text">
                Selalu minta disuapi, belum bisa mengancingkan baju, cepat lelah memegang pensil atau gunting, serta tulisan tangan sangat keluar garis.
              </p>
            </div>

            <div class="prog-focus">
              <div class="prog-focus-label">Fokus Stimulasi:</div>
              <div class="prog-tags">
                <span class="prog-tag">Motorik Halus (Fine Motor)</span>
                <span class="prog-tag">Makan &amp; Berpakaian (ADL)</span>
                <span class="prog-tag">Kesiapan Pra-Menulis</span>
                <span class="prog-tag">Koordinasi Tangan-Mata</span>
              </div>
            </div>

            <div class="prog-footer">
              <span class="prog-duration">
                <span class="material-symbols-outlined icon-small">schedule</span>
                Sesi 45 - 60 Menit (1-on-1)
              </span>
              <router-link to="/layanan/terapi-okupasi" class="prog-link prog-link--green">
                <span>Detail &amp; Biaya</span>
                <span class="material-symbols-outlined" style="font-size:18px">arrow_forward</span>
              </router-link>
            </div>
          </div>

          <!-- Card 3: Sensori Integrasi -->
          <div class="prog-card prog-card--teal" :class="{ 'is-highlighted': activeSymptomIndex === 1 }">
            <div class="prog-card-top">
              <div class="prog-icon prog-icon--teal">
                <span class="material-symbols-outlined" style="font-size:32px">sports_gymnastics</span>
              </div>
              <span class="prog-badge prog-badge--teal">SI Sensory</span>
            </div>
            <h3 class="prog-name">Terapi Sensori Integrasi (SI)</h3>
            <p class="prog-desc">
              Menyeimbangkan sistem pemrosesan saraf anak terhadap rangsangan (suara, sentuhan, keseimbangan tubuh) agar anak lebih tenang, fokus, dan tidak mudah tantrum sensorik.
            </p>

            <!-- Parent-Friendly Daily Signs Box -->
            <div class="prog-parent-box">
              <div class="parent-box-header">
                <span class="material-symbols-outlined box-icon">visibility</span>
                <span>Tanda Khas di Rumah:</span>
              </div>
              <p class="parent-box-text">
                Menutup telinga saat mendengar suara mesin/blender, jijik memegang tekstur lengket/pasir, atau hiperaktif melompat menabrak tanpa rasa takut.
              </p>
            </div>

            <div class="prog-focus">
              <div class="prog-focus-label">Fokus Stimulasi:</div>
              <div class="prog-tags">
                <span class="prog-tag">Sensory Gym &amp; Ayunan</span>
                <span class="prog-tag">Desensitisasi Taktil</span>
                <span class="prog-tag">Regulasi Emosi Sensori</span>
                <span class="prog-tag">Keseimbangan Vestibular</span>
              </div>
            </div>

            <div class="prog-footer">
              <span class="prog-duration">
                <span class="material-symbols-outlined icon-small">schedule</span>
                Sesi 45 - 60 Menit (1-on-1)
              </span>
              <router-link to="/layanan/sensori-integrasi" class="prog-link prog-link--blue">
                <span>Detail &amp; Biaya</span>
                <span class="material-symbols-outlined" style="font-size:18px">arrow_forward</span>
              </router-link>
            </div>
          </div>

          <!-- Card 4: Psikologi Anak -->
          <div class="prog-card prog-card--amber" :class="{ 'is-highlighted': activeSymptomIndex === 3 }">
            <div class="prog-card-top">
              <div class="prog-icon prog-icon--amber">
                <span class="material-symbols-outlined" style="font-size:32px">psychology</span>
              </div>
              <span class="prog-badge prog-badge--amber">Psikologi Klinis</span>
            </div>
            <h3 class="prog-name">Psikologi &amp; Konseling Anak</h3>
            <p class="prog-desc">
              Mendampingi aspek emosi, atensi fokus, kesiapan sekolah, dan interaksi sosial anak, dilengkapi konsultasi pengasuhan (parenting coaching) terarah untuk Ayah &amp; Bunda.
            </p>

            <!-- Parent-Friendly Daily Signs Box -->
            <div class="prog-parent-box">
              <div class="parent-box-header">
                <span class="material-symbols-outlined box-icon">visibility</span>
                <span>Tanda Khas di Rumah:</span>
              </div>
              <p class="parent-box-text">
                Tantrum berkepanjangan saat kecewa, rentang atensi sangat pendek di sekolah, atau kesulitan menjalin pertemanan dengan anak sebaya.
              </p>
            </div>

            <div class="prog-focus">
              <div class="prog-focus-label">Fokus Stimulasi:</div>
              <div class="prog-tags">
                <span class="prog-tag">Manajemen Emosi &amp; Marah</span>
                <span class="prog-tag">Asesmen Kognitif / IQ</span>
                <span class="prog-tag">Sosialisasi Teman Sebaya</span>
                <span class="prog-tag">Parenting Coaching</span>
              </div>
            </div>

            <div class="prog-footer">
              <span class="prog-duration">
                <span class="material-symbols-outlined icon-small">schedule</span>
                Sesi 60 Menit / Konsultasi
              </span>
              <router-link to="/layanan/psikologi-anak" class="prog-link prog-link--amber">
                <span>Detail &amp; Biaya</span>
                <span class="material-symbols-outlined" style="font-size:18px">arrow_forward</span>
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ===== SECTION 5: Step-by-Step Flow Infographics ===== -->
    <section class="steps-section">
      <div class="container">
        <div class="section-header">
          <span class="section-eyebrow">Alur Terapi Terstandar</span>
          <h2 class="section-title">4 Tahap Nyaman Memulai Terapi Buah Hati</h2>
          <p class="section-sub">
            Kami memastikan proses terapi berlangsung tanpa rasa cemas, dengan keterlibatan penuh orang tua di setiap langkah kemajuan si Kecil.
          </p>
        </div>
        <div class="steps-grid">
          <div v-for="(step, idx) in steps" :key="step.title" class="step-card">
            <div class="step-card-badge">Tahap 0{{ idx + 1 }}</div>
            <div class="step-num">{{ idx + 1 }}</div>
            <h4 class="step-title">{{ step.title }}</h4>
            <p class="step-desc">{{ step.desc }}</p>
            <div class="step-output-pill">
              <span class="material-symbols-outlined pill-icon">task_alt</span>
              <span>{{ step.output }}</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ===== SECTION 6: Inspirational Quote ===== -->
    <section class="quote-section">
      <div class="container-narrow">
        <div class="quote-card">
          <div class="quote-icon-wrap">
            <span class="material-symbols-outlined fill" style="font-size:32px">favorite</span>
          </div>
          <blockquote class="quote-text">
            "Setiap anak bertumbuh dengan ritmenya masing-masing. Tugas kita bukan membandingkannya dengan anak lain, melainkan membantunya mencapai versi terbaik dari dirinya sendiri."
          </blockquote>
          <div class="quote-author">
            <div class="quote-author-name">Amanah Tin's Center</div>
            <div class="quote-author-sub">Didirikan oleh Bapak Artin Ristriawan &amp; Ibu Hertin Nurfarida</div>
          </div>
        </div>
      </div>
    </section>

    <!-- ===== SECTION 7: CTA ===== -->
    <section class="cta-section" id="jadwalkan">
      <div class="container">
        <div class="cta-card">
          <div class="cta-content">
            <div class="cta-location-badge">
              <span class="material-symbols-outlined" style="font-size:16px">location_on</span>
              <span>Jagakarsa, Jakarta Selatan</span>
            </div>
            <h2 class="cta-title">Siap Mendampingi Masa Emas Tumbuh Kembang Si Kecil?</h2>
            <p class="cta-desc">
              Tim profesional Amanah Tin's Center siap mendengarkan cerita dan pertanyaan Ayah &amp; Bunda. Dapatkan sesi konsultasi awal yang ramah dan jadwalkan asesmen perdana hari ini.
            </p>
          </div>
          <div class="cta-actions">
            <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Amanah%20Tin's%20Center,%20saya%20ingin%20jadwalkan%20asesmen%20untuk%20anak%20saya" target="_blank" rel="noopener noreferrer" class="btn-wa">
              <span class="material-symbols-outlined fill" style="font-size:22px">chat</span>
              <span>Chat WhatsApp Admin</span>
            </a>
            <router-link to="/jadwal-pendaftaran" class="btn-phone">
              <span class="material-symbols-outlined" style="font-size:20px">calendar_month</span>
              <span>Pendaftaran Online</span>
            </router-link>
          </div>
        </div>
      </div>
    </section>

  </PublicLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import PublicLayout from '../layouts/PublicLayout.vue'

const activeSymptomIndex = ref(0)

const symptoms = [
  {
    id: 'bicara',
    slug: 'terapi-wicara',
    icon: 'record_voice_over',
    iconClass: 'icon-blue',
    title: 'Bicara & Bahasa',
    badge: 'Speech Therapy',
    parentWorry: 'Belum ada kata bermakna di usia 2 tahun, bicaranya pelo/cadel, atau hanya menunjuk saat minta sesuatu.',
    matchedTherapy: 'Terapi Wicara (TW)',
    whyMatch: 'Program ini melatih artikulasi organ bicara (oral motor), penguasaan kosa kata ekspresif, dan pemahaman bahasa anak dengan metode bermain interaktif tanpa stres.',
    milestones: [
      'Mampu menirukan bunyi kata bermakna (mama / papa / mau / susu)',
      'Pengucapan artikulasi lebih jelas sehingga dipahami orang luar',
      'Mengurangi frustrasi dan tantrum karena anak mampu mengutarakan keinginannya'
    ],
    targetAge: '1.5 – 12 Tahun',
    cardClass: 'matcher-tw'
  },
  {
    id: 'sensori',
    slug: 'sensori-integrasi',
    icon: 'sports_gymnastics',
    iconClass: 'icon-teal',
    title: 'Sensori & Regulasi Tubuh',
    badge: 'Sensory Integration',
    parentWorry: 'Mudah kaget/tutup telinga dengar blender, jijik tekstur nasi/pasir, atau melompat tiada henti.',
    matchedTherapy: 'Sensori Integrasi (SI)',
    whyMatch: 'Menstimulasi dan mengorganisasi sistem saraf sensorik anak melalui sensory gym berstandar, ayunan terapeutik, dan modulasi taktil agar tubuh anak rileks dan adaptif.',
    milestones: [
      'Regulasi emosi lebih stabil di tempat ramai, mall, atau ruangan bising',
      'Toleransi lebih baik terhadap tekstur makanan & tekstur basah/kotor',
      'Peningkatan konsentrasi dan ketenangan saat duduk beraktivitas'
    ],
    targetAge: '1.5 – 10 Tahun',
    cardClass: 'matcher-si'
  },
  {
    id: 'motorik',
    slug: 'terapi-okupasi',
    icon: 'front_hand',
    iconClass: 'icon-green',
    title: 'Motorik & Kemandirian Harian',
    badge: 'Occupational Therapy',
    parentWorry: 'Belum bisa makan sendiri, susah kancing baju/sepatu, atau cepat lelah saat memegang pensil.',
    matchedTherapy: 'Terapi Okupasi (BT / OT)',
    whyMatch: 'Melatih kekuatan otot motorik halus, koordinasi kedua tangan, serta keterampilan aktivitas hidup mandiri (ADL) agar anak siap bersekolah dan percaya diri.',
    milestones: [
      'Mampu memegang sendok dan makan sendiri tanpa tumpah berlebih',
      'Kematangan otot tangan untuk memegang pensil dan menggunting rapi',
      'Mampu mengenakan kancing baju, ritsleting, dan sepatu secara mandiri'
    ],
    targetAge: '2 – 12 Tahun',
    cardClass: 'matcher-to'
  },
  {
    id: 'emosi',
    slug: 'psikologi-anak',
    icon: 'psychology',
    iconClass: 'icon-amber',
    title: 'Emosi, Fokus & Perilaku',
    badge: 'Child Psychology',
    parentWorry: 'Sering tantrum meledak-ledak, konsentrasi sangat singkat di kelas, atau sulit berbaur dengan teman.',
    matchedTherapy: 'Psikologi & Konseling Anak',
    whyMatch: 'Membimbing anak mengenali dan meregulasi rasa marah/kecewa, skrining kognitif kesiapan belajar, serta edukasi pola asuh (parent coaching) bagi keluarga di rumah.',
    milestones: [
      'Mampu mengekspresikan kekecewaan dengan tenang tanpa memukul/menyakiti',
      'Peningkatan daya rentang fokus saat mengerjakan tugas meja',
      'Kemampuan berbagi dan berinteraksi nyaman dalam kelompok teman sebaya'
    ],
    targetAge: '2 – 15 Tahun',
    cardClass: 'matcher-psiko'
  }
]

const currentSymptom = computed(() => {
  return symptoms[activeSymptomIndex.value] || symptoms[0]
})

const getWhatsAppMatcherUrl = (sym) => {
  const text = `Halo Admin Amanah Tin's Center, saya telah membaca panduan di website. Anak saya mengalami tanda pada bidang ${sym.title}: "${sym.parentWorry}". Saya ingin konsultasi awal mengenai program ${sym.matchedTherapy}.`
  return `https://wa.me/6281234567890?text=${encodeURIComponent(text)}`
}

const trustItems = [
  { icon: 'school',           iconBg: 'trust-bg-blue',   label: 'Terapis Ber-STR',   sub: 'Praktisi lulusan fisioterapi & terapi wicara' },
  { icon: 'calendar_clock',   iconBg: 'trust-bg-green',  label: 'Jadwal Fleksibel',  sub: 'Senin - Sabtu (08.00 - 17.00 WIB)' },
  { icon: 'diversity_1',      iconBg: 'trust-bg-indigo', label: '1-on-1 Privat',     sub: 'Sesi fokus individual tanpa distraksi' },
  { icon: 'clinical_notes',   iconBg: 'trust-bg-amber',  label: 'Evaluasi Terbuka',  sub: 'Laporan perkembangan tertulis berkala' },
]

const steps = [
  {
    title: 'Konsultasi & Asesmen Awal',
    desc: 'Observasi 60 menit yang ramah anak untuk memetakan potensi dan hambatan tumbuh kembang tanpa rasa tertekan.',
    output: 'Output: Laporan Hasil Asesmen Tertulis'
  },
  {
    title: 'Penyusunan Program IEP',
    desc: 'Terapis merancang sasaran capaian (Individualized Education Program) yang dipersonalisasi sesuai keunikan anak.',
    output: 'Output: Target Capaian 3 Bulan Terukur'
  },
  {
    title: 'Sesi Terapi Play-Based',
    desc: 'Stimulasi rutin 1-on-1 mingguan dengan media sensori dan mainan edukatif yang menyenangkan bagi anak.',
    output: 'Output: Diskusi 10 Menit Bersama Orang Tua'
  },
  {
    title: 'Evaluasi & Home Program',
    desc: 'Pantau grafik kemajuan anak secara berkala dan dapatkan panduan stimulasi sederhana yang dapat dipraktikkan di rumah.',
    output: 'Output: Evaluasi Capaian Bulanan'
  },
]
</script>

<style scoped>
/* ============================================================
   HERO BANNER
   ============================================================ */
.hero-banner {
  background: linear-gradient(to bottom, #f0f7fb, var(--background));
  padding: 2rem 0 3.5rem;
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
  background-color: #e0f2fe;
  color: #0369a1;
  padding: 0.4rem 0.95rem;
  border-radius: 9999px;
  font-size: 13px;
  font-weight: 700;
  width: fit-content;
  border: 1px solid rgba(3, 105, 161, 0.2);
}
.hero-title {
  font-family: var(--font-headline);
  font-size: 36px;
  font-weight: 800;
  line-height: 1.25;
  letter-spacing: -0.015em;
  color: #091d2e;
  margin: 0;
}
.hero-title-accent { color: var(--primary); }
.hero-desc {
  font-size: 16.5px;
  line-height: 1.68;
  color: #4b5860;
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
  box-shadow: 0 4px 14px rgba(0, 99, 132, 0.25);
}
.hero-btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 18px rgba(0, 99, 132, 0.35);
}
.hero-btn-wa {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  background-color: #fff;
  border: 1.5px solid #25d366;
  color: #128c7e;
  font-weight: 700;
  font-size: 15px;
  padding: 0.85rem 1.5rem;
  border-radius: 9999px;
  text-decoration: none;
  transition: all 0.2s;
  box-shadow: 0 2px 8px rgba(37, 211, 102, 0.15);
}
.hero-btn-wa:hover {
  background-color: #f0fdf4;
  transform: translateY(-2px);
}

/* Hero image */
.hero-image-col { position: relative; }
.hero-image-frame {
  background: #fff;
  border-radius: 1.25rem;
  border: 1px solid rgba(191, 200, 206, 0.4);
  padding: 0.75rem;
  box-shadow: 0 12px 32px -6px rgba(9, 29, 46, 0.1);
  position: relative;
}
.hero-img {
  width: 100%;
  height: 320px;
  object-fit: cover;
  border-radius: 1rem;
  display: block;
}
.hero-badge-float {
  position: absolute;
  bottom: -1rem;
  left: -0.75rem;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(8px);
  border: 1px solid rgba(191, 200, 206, 0.3);
  border-radius: 1rem;
  box-shadow: 0 8px 24px rgba(9, 29, 46, 0.12);
  padding: 0.75rem 1.15rem;
  display: flex;
  align-items: center;
  gap: 0.75rem;
}
.badge-float-icon {
  width: 40px; height: 40px;
  border-radius: 50%;
  background-color: #e0f2fe;
  color: var(--primary);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.badge-float-title { font-size: 13.5px; font-weight: 800; color: #091d2e; }
.badge-float-sub { font-size: 11.5px; color: #556066; }

/* ============================================================
   TRUST STRIP
   ============================================================ */
.trust-strip {
  background: #fff;
  border-top: 1px solid rgba(191, 200, 206, 0.25);
  border-bottom: 1px solid rgba(191, 200, 206, 0.25);
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
  gap: 0.85rem;
  padding: 0.5rem;
}
.trust-icon {
  width: 48px; height: 48px;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.trust-bg-blue   { background-color: #e0f2fe; color: #006384; }
.trust-bg-green  { background-color: #ecfdf5; color: #059669; }
.trust-bg-indigo { background-color: #f1f5f9; color: #006384; }
.trust-bg-amber  { background-color: #fef3c7; color: #d97706; }
.trust-label { font-size: 16px; font-weight: 800; color: #091d2e; font-family: var(--font-headline); }
.trust-sub { font-size: 12px; color: #556066; line-height: 1.35; margin-top: 2px; }

/* ============================================================
   SECTION 3: THERAPY MATCHER (INTERACTIVE)
   ============================================================ */
.matcher-section {
  padding: 4.5rem 0 3.5rem;
  background: linear-gradient(180deg, #ffffff 0%, #f7fafc 100%);
}

.matcher-badge-chip {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  background: #eef8fb;
  color: #006384;
  border: 1px solid rgba(0, 99, 132, 0.25);
  padding: 0.35rem 0.85rem;
  border-radius: 999px;
  font-size: 12px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  margin-bottom: 0.75rem;
}

.matcher-badge-chip .chip-icon {
  font-size: 16px;
}

/* 4 Symptom Selector Cards Grid */
.symptom-cards-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1.25rem;
  margin-bottom: 2rem;
}

.symptom-card-btn {
  background: #ffffff;
  border: 1.5px solid rgba(191, 200, 206, 0.45);
  border-radius: 1.25rem;
  padding: 1.5rem 1.25rem;
  text-align: left;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  cursor: pointer;
  transition: all 0.25s ease;
  position: relative;
  box-shadow: 0 4px 16px -2px rgba(9, 29, 46, 0.04);
}

.symptom-card-btn:hover {
  transform: translateY(-3px);
  border-color: #006384;
  box-shadow: 0 10px 24px -4px rgba(0, 99, 132, 0.12);
}

.symptom-card-btn.is-active {
  border-color: #006384;
  background: #f0f9ff;
  box-shadow: 0 12px 28px -4px rgba(0, 99, 132, 0.16);
  border-width: 2px;
}

.symptom-btn-icon {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 1rem;
}

.icon-blue  { background: #e0f2fe; color: #006384; }
.icon-teal  { background: #ccfbf1; color: #0d9488; }
.icon-green { background: #dcfce7; color: #16a34a; }
.icon-amber { background: #fef3c7; color: #d97706; }

.symptom-cat-badge {
  display: inline-block;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  color: #64748b;
  margin-bottom: 0.35rem;
}

.symptom-btn-title {
  font-family: var(--font-headline);
  font-size: 16px;
  font-weight: 800;
  color: #091d2e;
  margin: 0 0 0.5rem;
  line-height: 1.3;
}

.symptom-btn-worry {
  font-size: 12.5px;
  color: #556066;
  line-height: 1.5;
  font-style: italic;
  margin: 0;
  flex: 1;
}

.symptom-check-indicator {
  display: flex;
  justify-content: flex-end;
  padding-top: 1rem;
}

.indicator-icon {
  font-size: 20px;
  color: #94a3b8;
  transition: color 0.2s;
}

.symptom-card-btn.is-active .indicator-icon {
  color: #006384;
}

/* Active Matcher Result Showcase */
.matcher-result-card {
  background: #ffffff;
  border-radius: 1.5rem;
  border: 2px solid #006384;
  padding: 2.25rem 2.5rem;
  box-shadow: 0 16px 40px -8px rgba(0, 99, 132, 0.16);
  position: relative;
  overflow: hidden;
  animation: fadeInMatcher 0.3s ease;
}

@keyframes fadeInMatcher {
  from { opacity: 0; transform: translateY(8px); }
  to { opacity: 1; transform: translateY(0); }
}

.result-top-bar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 1rem;
  padding-bottom: 1.25rem;
  border-bottom: 1px solid #edf2f7;
  margin-bottom: 1.75rem;
}

.result-badge-group {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.result-match-pill {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  background: #006384;
  color: #ffffff;
  font-family: var(--font-headline);
  font-size: 12px;
  font-weight: 800;
  padding: 0.35rem 0.85rem;
  border-radius: 999px;
  text-transform: uppercase;
}

.match-star { font-size: 16px; color: #ffd166; }

.result-age-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  background: #f1f5f9;
  color: #334155;
  font-size: 12px;
  font-weight: 700;
  padding: 0.35rem 0.75rem;
  border-radius: 999px;
}

.result-age-badge .material-symbols-outlined { font-size: 16px; }

.result-status-tag {
  font-size: 12.5px;
  font-weight: 700;
  color: #059669;
  background: #ecfdf5;
  padding: 0.3rem 0.75rem;
  border-radius: 999px;
}

.result-grid {
  display: grid;
  grid-template-columns: 7fr 5fr;
  gap: 2.5rem;
  align-items: stretch;
}

.result-main-col {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
}

.result-title-row {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.result-big-icon {
  width: 56px;
  height: 56px;
  border-radius: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.result-big-icon .material-symbols-outlined {
  font-size: 32px;
}

.result-prog-name {
  font-family: var(--font-headline);
  font-size: 24px;
  font-weight: 800;
  color: #091d2e;
  margin: 0;
}

.result-focus-tag {
  font-size: 13px;
  color: #556066;
  font-weight: 600;
  margin: 3px 0 0;
}

.result-why-box {
  background: #f8fafc;
  border-left: 4px solid #006384;
  padding: 1rem 1.25rem;
  border-radius: 0 12px 12px 0;
}

.why-title {
  display: flex;
  align-items: center;
  gap: 0.4rem;
  font-family: var(--font-headline);
  font-size: 13.5px;
  font-weight: 800;
  color: #091d2e;
  margin: 0 0 0.4rem;
}

.why-title .material-symbols-outlined {
  font-size: 18px;
  color: #006384;
}

.why-text {
  font-size: 13.5px;
  color: #334155;
  line-height: 1.6;
  margin: 0;
}

.result-milestones-box {
  margin-top: 0.25rem;
}

.milestones-title {
  font-family: var(--font-headline);
  font-size: 13px;
  font-weight: 800;
  color: #091d2e;
  text-transform: uppercase;
  letter-spacing: 0.04em;
  margin: 0 0 0.65rem;
}

.milestones-list {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 0.45rem;
}

.milestones-list li {
  display: flex;
  align-items: flex-start;
  gap: 0.5rem;
  font-size: 13px;
  color: #1e293b;
  font-weight: 600;
  line-height: 1.45;
}

.check-bullet {
  font-size: 18px;
  color: #16a34a;
  flex-shrink: 0;
  margin-top: 1px;
}

/* Right Action Box */
.result-action-col {
  display: flex;
  flex-direction: column;
}

.action-card-inner {
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 1.25rem;
  padding: 1.75rem;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  height: 100%;
}

.action-header {
  margin-bottom: 1.25rem;
}

.action-price-label {
  font-size: 12px;
  font-weight: 700;
  color: #64748b;
  text-transform: uppercase;
}

.action-price-val {
  font-family: var(--font-headline);
  font-size: 26px;
  font-weight: 800;
  color: #006384;
  margin: 0.25rem 0 0.5rem;
}

.action-price-val .unit {
  font-size: 13px;
  font-weight: 600;
  color: #64748b;
}

.action-sub {
  font-size: 12px;
  color: #556066;
  line-height: 1.5;
  margin: 0;
}

.action-buttons-wrap {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  margin: 1.25rem 0;
}

.btn-result-detail {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  background: #006384;
  color: #ffffff;
  padding: 0.85rem 1.25rem;
  border-radius: 999px;
  font-family: var(--font-headline);
  font-size: 13.5px;
  font-weight: 700;
  text-decoration: none;
  transition: all 0.2s;
  box-shadow: 0 4px 12px rgba(0, 99, 132, 0.2);
}

.btn-result-detail:hover {
  background: #004d66;
  transform: translateY(-2px);
}

.btn-result-wa {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  background: #25d366;
  color: #ffffff;
  padding: 0.85rem 1.25rem;
  border-radius: 999px;
  font-family: var(--font-headline);
  font-size: 13.5px;
  font-weight: 700;
  text-decoration: none;
  transition: all 0.2s;
  box-shadow: 0 4px 12px rgba(37, 211, 102, 0.25);
}

.btn-result-wa:hover {
  background: #1ebc59;
  transform: translateY(-2px);
}

.action-assurance {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.35rem;
  font-size: 11.5px;
  font-weight: 700;
  color: #64748b;
}

.lock-icon { font-size: 16px; color: #006384; }

/* ============================================================
   PROGRAMS SECTION (2X2 BENTO)
   ============================================================ */
.programs-section { padding: var(--space-xl) 0; }

.section-header { text-align: center; max-width: 720px; margin: 0 auto 3.5rem; }
.section-eyebrow {
  font-size: 13px; font-weight: 800; color: var(--primary);
  text-transform: uppercase; letter-spacing: 0.08em;
}
.section-title {
  font-family: var(--font-headline);
  font-size: 34px; font-weight: 800; letter-spacing: -0.015em;
  color: #091d2e; margin: 0.5rem 0 1rem;
}
.section-sub { font-size: 16px; color: #556066; line-height: 1.6; }

.programs-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 2rem;
}

.prog-card {
  background: #fff;
  border-radius: 1.5rem;
  padding: 2.25rem;
  border: 1.5px solid rgba(191, 200, 206, 0.4);
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  transition: all 0.3s ease;
  position: relative;
}

.prog-card.is-highlighted {
  border-color: #006384;
  box-shadow: 0 16px 36px -6px rgba(0, 99, 132, 0.15);
}

.prog-card--blue:hover  { border-color: rgba(0, 99, 132, 0.5); box-shadow: 0 14px 32px -6px rgba(43,61,79,0.1); }
.prog-card--green:hover { border-color: rgba(22, 163, 74, 0.5); box-shadow: 0 14px 32px -6px rgba(43,61,79,0.1); }
.prog-card--teal:hover  { border-color: rgba(13, 148, 136, 0.5); box-shadow: 0 14px 32px -6px rgba(43,61,79,0.1); }
.prog-card--amber:hover { border-color: rgba(217, 119, 6, 0.5); box-shadow: 0 14px 32px -6px rgba(43,61,79,0.1); }

.prog-card-top {
  display: flex; align-items: flex-start;
  justify-content: space-between;
  margin-bottom: 1.25rem;
}
.prog-icon {
  width: 56px; height: 56px;
  border-radius: 16px;
  display: flex; align-items: center; justify-content: center;
}
.prog-icon--blue  { background-color: #e0f2fe; color: #006384; }
.prog-icon--green { background-color: #dcfce7; color: #16a34a; }
.prog-icon--teal  { background-color: #ccfbf1; color: #0d9488; }
.prog-icon--amber { background-color: #fef3c7; color: #d97706; }

.prog-badge {
  font-size: 12px; font-weight: 800;
  padding: 0.3rem 0.8rem;
  border-radius: 9999px;
  text-transform: uppercase;
}
.prog-badge--blue  { background-color: #e0f2fe; color: #006384; }
.prog-badge--green { background-color: #dcfce7; color: #16a34a; }
.prog-badge--teal  { background-color: #ccfbf1; color: #0d9488; }
.prog-badge--amber { background-color: #fef3c7; color: #d97706; }

.prog-name {
  font-family: var(--font-headline);
  font-size: 22px; font-weight: 800;
  color: #091d2e;
  margin: 0 0 0.65rem;
  transition: color 0.2s;
}
.prog-card--blue:hover  .prog-name { color: #006384; }
.prog-card--green:hover .prog-name { color: #16a34a; }
.prog-card--teal:hover  .prog-name { color: #0d9488; }
.prog-card--amber:hover .prog-name { color: #d97706; }

.prog-desc {
  font-size: 14.5px; line-height: 1.65;
  color: #4b5860;
  margin: 0 0 1.25rem;
}

/* Parent Friendly Signs Box */
.prog-parent-box {
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  padding: 0.85rem 1rem;
  margin-bottom: 1.25rem;
}

.parent-box-header {
  display: flex;
  align-items: center;
  gap: 0.35rem;
  font-size: 12px;
  font-weight: 800;
  color: #006384;
  text-transform: uppercase;
  margin-bottom: 0.35rem;
}

.box-icon { font-size: 16px; }

.parent-box-text {
  font-size: 13px;
  color: #334155;
  line-height: 1.5;
  margin: 0;
  font-style: italic;
}

.prog-focus { margin-bottom: 1.5rem; }
.prog-focus-label { font-size: 12px; font-weight: 800; color: #091d2e; margin-bottom: 0.45rem; text-transform: uppercase; }
.prog-tags { display: flex; flex-wrap: wrap; gap: 0.45rem; }
.prog-tag {
  font-size: 12px;
  background-color: #f1f5f9;
  color: #334155;
  padding: 0.25rem 0.65rem;
  border-radius: 9999px;
  font-weight: 600;
}

.prog-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-top: 1.25rem;
  border-top: 1px solid rgba(191, 200, 206, 0.25);
}
.prog-duration {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  font-size: 12px;
  color: #64748b;
  font-weight: 600;
}
.icon-small { font-size: 16px; color: #006384; }

.prog-link {
  font-size: 14px; font-weight: 800;
  display: flex; align-items: center; gap: 0.25rem;
  text-decoration: none;
  transition: transform 0.2s;
}
.prog-card:hover .prog-link { transform: translateX(4px); }
.prog-link--blue  { color: #006384; }
.prog-link--green { color: #16a34a; }
.prog-link--amber { color: #d97706; }

/* ============================================================
   STEPS SECTION (ALUR 4 TAHAP)
   ============================================================ */
.steps-section {
  padding: var(--space-xl) 0;
  background-color: #f0f7fb;
}
.steps-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1.5rem;
}
.step-card {
  background: #fff;
  border: 1px solid rgba(191, 200, 206, 0.3);
  border-radius: 1.25rem;
  padding: 1.75rem 1.5rem;
  position: relative;
  transition: box-shadow 0.2s;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.step-card:hover { box-shadow: 0 8px 24px rgba(9, 29, 46, 0.08); }

.step-card-badge {
  font-size: 11px;
  font-weight: 800;
  color: #006384;
  text-transform: uppercase;
  margin-bottom: 0.75rem;
}

.step-num {
  width: 42px; height: 42px;
  border-radius: 50%;
  background-color: #006384;
  color: #fff;
  font-family: var(--font-headline);
  font-size: 18px; font-weight: 800;
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 1rem;
}
.step-title {
  font-family: var(--font-headline);
  font-size: 17px; font-weight: 800;
  color: #091d2e;
  margin: 0 0 0.5rem;
  line-height: 1.35;
}
.step-desc {
  font-size: 13.5px; line-height: 1.6;
  color: #556066;
  margin: 0 0 1rem;
  flex: 1;
}

.step-output-pill {
  display: flex;
  align-items: center;
  gap: 0.4rem;
  background: #eef8fb;
  color: #006384;
  font-size: 11.5px;
  font-weight: 700;
  padding: 0.35rem 0.65rem;
  border-radius: 8px;
}

.pill-icon { font-size: 15px; color: #006384; }

/* ============================================================
   QUOTE SECTION
   ============================================================ */
.quote-section { padding: var(--space-lg) 0; }
.container-narrow { max-width: 800px; margin: 0 auto; padding: 0 var(--gutter); }
.quote-card {
  background: linear-gradient(135deg, #f0f7fb 0%, #ffffff 50%, #f0fdf4 100%);
  border: 1px solid rgba(191, 200, 206, 0.35);
  border-radius: 1.5rem;
  padding: 3.5rem 3rem;
  text-align: center;
  position: relative;
  overflow: hidden;
  box-shadow: 0 4px 16px rgba(0,0,0,0.04);
}
.quote-icon-wrap {
  width: 56px; height: 56px;
  background: #fff;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  color: var(--primary);
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  margin: 0 auto 1.25rem;
}
.quote-text {
  font-family: var(--font-headline);
  font-size: 22px; font-weight: 700;
  color: #091d2e;
  line-height: 1.6;
  max-width: 680px;
  margin: 0 auto;
}
.quote-author { margin-top: 1.5rem; }
.quote-author-name { font-size: 15px; font-weight: 800; color: var(--primary); font-family: var(--font-headline); }
.quote-author-sub { font-size: 12.5px; color: #556066; margin-top: 0.25rem; }

/* ============================================================
   CTA SECTION
   ============================================================ */
.cta-section { padding: var(--space-xl) 0; }
.cta-card {
  background: linear-gradient(135deg, #006384 0%, #00839e 100%);
  color: #fff;
  border-radius: 1.5rem;
  padding: 3.5rem;
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: space-between;
  gap: 2rem;
  box-shadow: 0 16px 36px -4px rgba(0, 99, 132, 0.25);
  overflow: hidden;
  position: relative;
}
.cta-content { max-width: 640px; }
.cta-location-badge {
  display: inline-flex; align-items: center; gap: 0.5rem;
  background: rgba(255,255,255,0.18);
  border-radius: 9999px;
  padding: 0.3rem 0.85rem;
  font-size: 12.5px;
  font-weight: 700;
  margin-bottom: 1rem;
}
.cta-title {
  font-family: var(--font-headline);
  font-size: 32px; font-weight: 800;
  color: #fff; margin: 0 0 1rem;
  line-height: 1.28;
}
.cta-desc {
  font-size: 16px; line-height: 1.65;
  color: rgba(255, 255, 255, 0.9);
  margin: 0;
}
.cta-actions {
  display: flex;
  flex-direction: column;
  gap: 0.85rem;
  flex-shrink: 0;
  min-width: 230px;
}
.btn-wa, .btn-phone {
  display: flex; align-items: center; justify-content: center; gap: 0.5rem;
  padding: 0.9rem 1.75rem;
  border-radius: 9999px;
  font-family: var(--font-headline);
  font-size: 14.5px; font-weight: 700;
  text-decoration: none;
  transition: all 0.2s;
  white-space: nowrap;
}
.btn-wa {
  background-color: #25d366;
  color: #fff;
  box-shadow: 0 4px 14px rgba(37, 211, 102, 0.35);
}
.btn-wa:hover {
  background-color: #1ebc59;
  transform: translateY(-2px);
}
.btn-phone {
  background-color: rgba(255,255,255,0.18);
  color: #fff;
  border: 1.5px solid rgba(255,255,255,0.4);
}
.btn-phone:hover {
  background-color: rgba(255,255,255,0.28);
  transform: translateY(-2px);
}

/* ============================================================
   RESPONSIVE
   ============================================================ */
@media (max-width: 1024px) {
  .symptom-cards-grid { grid-template-columns: repeat(2, 1fr); }
  .result-grid { grid-template-columns: 1fr; gap: 2rem; }
  .programs-grid { grid-template-columns: 1fr; }
  .steps-grid { grid-template-columns: repeat(2, 1fr); }
  .trust-grid { grid-template-columns: repeat(2, 1fr); }
  .cta-card { flex-direction: column; text-align: center; padding: 2.5rem; }
  .cta-content { max-width: 100%; }
  .cta-actions { flex-direction: row; flex-wrap: wrap; justify-content: center; min-width: unset; width: 100%; }
}
@media (max-width: 768px) {
  .hero-grid { grid-template-columns: 1fr; gap: 1.75rem; }
  .hero-image-col { display: block; }
  .hero-image-frame { padding: 0.5rem; }
  .hero-img { height: 210px; width: 100%; object-fit: cover; border-radius: 1rem; }
  .hero-badge-float { bottom: 0.75rem; left: 0.75rem; right: 0.75rem; padding: 0.65rem 0.85rem; }
  .hero-actions { flex-direction: column; width: 100%; gap: 0.75rem; }
  .hero-btn-primary, .hero-btn-wa { width: 100%; justify-content: center; text-align: center; }
  .hero-title { font-size: 26px; }
  .hero-desc { font-size: 15px; }
  .symptom-cards-grid { grid-template-columns: 1fr; }
  .matcher-result-card { padding: 1.5rem; }
  .programs-grid { gap: 1.25rem; }
  .steps-grid { grid-template-columns: 1fr; }
  .trust-grid { grid-template-columns: 1fr; }
  .quote-card { padding: 2rem 1.25rem; }
  .quote-text { font-size: 17px; }
  .cta-title { font-size: 24px; }
}
</style>
