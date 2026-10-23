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
              <a :href="waLink('Halo Admin Amanah Tin\'s Center, saya ingin konsultasi mengenai layanan terapi untuk anak saya')" target="_blank" rel="noopener noreferrer" class="btn-outline-secondary hero-btn-wa">
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
                decoding="async"
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

        <!-- Slider Navigation Header -->
        <div class="symptom-slider-nav">
          <div class="slider-hint">
            <span class="material-symbols-outlined hint-icon">swipe</span>
            <span>Geser kartu untuk melihat program lainnya <strong>({{ symptoms.length }} Pilihan Kebutuhan)</strong></span>
          </div>
          <div class="slider-controls">
            <button
              @click="scrollSlider('left')"
              class="slider-btn"
              type="button"
              aria-label="Geser pilihan ke kiri"
            >
              <span class="material-symbols-outlined">chevron_left</span>
            </button>
            <button
              @click="scrollSlider('right')"
              class="slider-btn"
              type="button"
              aria-label="Geser pilihan ke kanan"
            >
              <span class="material-symbols-outlined">chevron_right</span>
            </button>
          </div>
        </div>

        <!-- Scrollable Symptom Cards Track -->
        <div ref="sliderRef" class="symptom-cards-scroll">
          <button
            v-for="(symptom, idx) in symptoms"
            :key="symptom.id"
            @click="selectSymptom(idx)"
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
            <span class="result-status-tag">{{ currentSymptom.sessionType || '1-on-1 Privat Bersama Terapis Ber-STR' }}</span>
          </div>

          <div class="result-grid">
            <!-- Left Info -->
            <div class="result-main-col">
              <div class="result-title-row">
                <div class="result-big-icon" :class="currentSymptom.iconClass">
                  <span class="material-symbols-outlined">{{ currentSymptom.icon }}</span>
                </div>
                <div class="result-title-info">
                  <h3 class="result-prog-name">{{ currentSymptom.matchedTherapy }}</h3>
                  <p class="result-focus-tag">{{ currentSymptom.focusText || 'Fokus: Pendekatan Play-Based Tanpa Rasa Takut' }}</p>
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
                  <div class="action-price-top-meta">
                    <span class="action-price-label">{{ currentSymptom.priceLabel || 'Estimasi Biaya Sesi' }}</span>
                    <span class="action-duration-chip">
                      <span class="material-symbols-outlined chip-clock">schedule</span>
                      {{ currentSymptom.duration || '60 Menit' }}
                    </span>
                  </div>

                  <!-- Weekday vs Weekend Comparison Grid -->
                  <div class="price-day-compare">
                    <!-- Weekday Card -->
                    <div class="price-day-card price-day-card--weekday">
                      <div class="price-day-badge-wrap">
                        <span class="price-day-badge badge-blue">
                          <span class="material-symbols-outlined badge-icon">calendar_today</span>
                          Weekday
                        </span>
                        <span class="price-day-sub">Senin – Jumat</span>
                      </div>
                      <div class="price-day-val-wrap">
                        <span class="currency">Rp</span>
                        <span class="amount">{{ currentSymptom.priceWeekday }}</span>
                        <span class="unit">/sesi</span>
                      </div>
                    </div>

                    <!-- Weekend Card -->
                    <div class="price-day-card price-day-card--weekend">
                      <div class="price-day-badge-wrap">
                        <span class="price-day-badge badge-amber">
                          <span class="material-symbols-outlined badge-icon">weekend</span>
                          Weekend
                        </span>
                        <span class="price-day-sub">Sabtu</span>
                      </div>
                      <div class="price-day-val-wrap val-amber">
                        <span class="currency">Rp</span>
                        <span class="amount">{{ currentSymptom.priceWeekend }}</span>
                        <span class="unit">/sesi</span>
                      </div>
                    </div>
                  </div>

                  <p class="action-sub">{{ currentSymptom.priceSub || 'Termasuk observasi klinis, konsultasi orang tua & laporan tertulis.' }}</p>
                </div>

                <div class="action-buttons-wrap">
                  <a
                    v-if="currentSymptom.slug.startsWith('#')"
                    :href="currentSymptom.slug"
                    class="btn-result-detail"
                  >
                    <span>Lihat Program di Katalog Bawah</span>
                    <span class="material-symbols-outlined">arrow_downward</span>
                  </a>
                  <router-link
                    v-else
                    :to="'/layanan/' + currentSymptom.slug"
                    class="btn-result-detail"
                  >
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
          <h2 class="section-title">Program Tumbuh Kembang Kami</h2>
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
              <router-link to="/layanan/sensori-integrasi" class="prog-link prog-link--teal">
                <span>Detail &amp; Biaya</span>
                <span class="material-symbols-outlined" style="font-size:18px">arrow_forward</span>
              </router-link>
            </div>
          </div>

          <!-- Card 4: Layanan Psikolog -->
          <div class="prog-card prog-card--amber" :class="{ 'is-highlighted': activeSymptomIndex === 3 }">
            <div class="prog-card-top">
              <div class="prog-icon prog-icon--amber">
                <span class="material-symbols-outlined" style="font-size:32px">psychology</span>
              </div>
              <span class="prog-badge prog-badge--amber">Psikolog Klinis</span>
            </div>
            <h3 class="prog-name">Layanan Psikolog <span class="prog-name-sub">(Anak, Remaja &amp; Dewasa)</span></h3>
            <p class="prog-desc">
              Pendampingan kesehatan mental dan asesmen psikologis terpadu untuk Anak, Remaja, serta Dewasa &amp; Keluarga bersama Psikolog Klinis berizin resmi (SIPP).
            </p>

            <!-- Parent-Friendly Daily Signs Box -->
            <div class="prog-parent-box">
              <div class="parent-box-header">
                <span class="material-symbols-outlined box-icon">visibility</span>
                <span>Cakupan Layanan:</span>
              </div>
              <p class="parent-box-text">
                Psikolog Anak (tumbuh kembang, kesiapan sekolah, tantrum), Psikolog Remaja (kecemasan, stres belajar, emosi), serta Psikolog Dewasa &amp; Konseling Keluarga.
              </p>
            </div>

            <div class="prog-focus">
              <div class="prog-focus-label">Fokus Layanan:</div>
              <div class="prog-tags">
                <span class="prog-tag">Psikolog Anak</span>
                <span class="prog-tag">Psikolog Remaja</span>
                <span class="prog-tag">Psikolog Dewasa</span>
                <span class="prog-tag">Asesmen IQ &amp; Kognitif</span>
                <span class="prog-tag">Konseling Keluarga</span>
              </div>
            </div>

            <div class="prog-footer">
              <span class="prog-duration">
                <span class="material-symbols-outlined icon-small">schedule</span>
                Sesi 60 Menit / Konsultasi
              </span>
              <router-link to="/layanan/psikolog" class="prog-link prog-link--amber">
                <span>Detail &amp; Biaya</span>
                <span class="material-symbols-outlined" style="font-size:18px">arrow_forward</span>
              </router-link>
            </div>
          </div>

          <!-- Card 5: Grup Terapi -->
          <div class="prog-card prog-card--indigo" id="grup-terapi">
            <div class="prog-card-top">
              <div class="prog-icon prog-icon--indigo">
                <span class="material-symbols-outlined" style="font-size:32px">groups</span>
              </div>
              <span class="prog-badge prog-badge--indigo">Grup Terapi</span>
            </div>
            <h3 class="prog-name">Grup Terapi</h3>
            <p class="prog-desc">
              Sesi terapi dalam kelompok kecil (3–6 anak) yang difasilitasi oleh terapis, dirancang untuk mengembangkan interaksi teman sebaya, kemampuan komunikasi sosial, dan aturan bermain bersama.
            </p>

            <!-- Parent-Friendly Daily Signs Box -->
            <div class="prog-parent-box">
              <div class="parent-box-header">
                <span class="material-symbols-outlined box-icon">visibility</span>
                <span>Tanda Khas di Rumah:</span>
              </div>
              <p class="parent-box-text">
                Anak kesulitan bermain bersama teman sebaya, belum memahami konsep berbagi &amp; antre giliran, atau cenderung asyik sendiri dan menarik diri.
              </p>
            </div>

            <div class="prog-focus">
              <div class="prog-focus-label">Fokus Stimulasi:</div>
              <div class="prog-tags">
                <span class="prog-tag">Interaksi Sosial</span>
                <span class="prog-tag">Giliran Bermain</span>
                <span class="prog-tag">Komunikasi Pragmatik</span>
                <span class="prog-tag">Regulasi Kelompok</span>
              </div>
            </div>

            <div class="prog-footer">
              <span class="prog-duration">
                <span class="material-symbols-outlined icon-small">schedule</span>
                3–6 Anak &bull; Sesi 60 - 90 Menit
              </span>
              <router-link to="/layanan/grup-terapi" class="prog-link prog-link--indigo">
                <span>Detail &amp; Biaya</span>
                <span class="material-symbols-outlined" style="font-size:18px">arrow_forward</span>
              </router-link>
            </div>
          </div>

          <!-- Card 6: Pra Vokasional (Persiapan Remaja ABK) -->
          <div class="prog-card prog-card--violet" id="pra-vokasional">
            <div class="prog-card-top">
              <div class="prog-icon prog-icon--violet">
                <span class="material-symbols-outlined" style="font-size:32px">work_history</span>
              </div>
              <span class="prog-badge prog-badge--violet">Pra Vokasional</span>
            </div>
            <h3 class="prog-name">Pra Vokasional <span class="prog-name-sub">(Persiapan Remaja ABK)</span></h3>
            <p class="prog-desc">
              Program pembekalan vokasional bagi remaja berkebutuhan khusus usia 12–18 tahun untuk membangun kemandirian hidup (ADL), keterampilan kerja dasar, dan adaptasi sosial menuju fase transisi dewasa.
            </p>

            <!-- Parent-Friendly Daily Signs Box -->
            <div class="prog-parent-box">
              <div class="parent-box-header">
                <span class="material-symbols-outlined box-icon">visibility</span>
                <span>Tanda Khas di Rumah:</span>
              </div>
              <p class="parent-box-text">
                Remaja ABK menjelang dewasa yang membutuhkan bimbingan kemandirian aktivitas sehari-hari, kedisiplinan kerja, dan kepercayaan diri di ruang publik.
              </p>
            </div>

            <div class="prog-focus">
              <div class="prog-focus-label">Fokus Stimulasi:</div>
              <div class="prog-tags">
                <span class="prog-tag">Keterampilan Kerja Dasar</span>
                <span class="prog-tag">Kemandirian Hidup (ADL)</span>
                <span class="prog-tag">Adaptasi Sosial</span>
                <span class="prog-tag">Orientasi Pekerjaan</span>
              </div>
            </div>

            <div class="prog-footer">
              <span class="prog-duration">
                <span class="material-symbols-outlined icon-small">schedule</span>
                Usia 12–18 Th &bull; Sesi 90 - 120 Menit
              </span>
              <router-link to="/layanan/pra-vokasional" class="prog-link prog-link--violet">
                <span>Detail &amp; Biaya</span>
                <span class="material-symbols-outlined" style="font-size:18px">arrow_forward</span>
              </router-link>
            </div>
          </div>

          <!-- Card 7: Kelas Persiapan Khusus -->
          <div class="prog-card prog-card--emerald" id="kelas-persiapan-khusus">
            <div class="prog-card-top">
              <div class="prog-icon prog-icon--emerald">
                <span class="material-symbols-outlined" style="font-size:32px">school</span>
              </div>
              <span class="prog-badge prog-badge--emerald">Kelas Persiapan</span>
            </div>
            <h3 class="prog-name">Kelas Persiapan Khusus</h3>
            <p class="prog-desc">
              Program intensif dalam kelompok kecil untuk mempersiapkan anak berkebutuhan khusus memasuki sekolah formal, meliputi kesiapan akademik dasar, pemahaman instruksi kelas, dan adaptasi lingkungan sekolah.
            </p>

            <!-- Parent-Friendly Daily Signs Box -->
            <div class="prog-parent-box">
              <div class="parent-box-header">
                <span class="material-symbols-outlined box-icon">visibility</span>
                <span>Tanda Khas di Rumah:</span>
              </div>
              <p class="parent-box-text">
                Anak akan masuk jenjang sekolah formal (TK/SD) namun masih sulit mengikuti instruksi kelompok, belum terbiasa duduk fokus, atau butuh pembiasaan aturan kelas.
              </p>
            </div>

            <div class="prog-focus">
              <div class="prog-focus-label">Fokus Stimulasi:</div>
              <div class="prog-tags">
                <span class="prog-tag">Kesiapan Akademik Dasar</span>
                <span class="prog-tag">Pra-Baca &amp; Pra-Hitung</span>
                <span class="prog-tag">Adaptasi Sekolah</span>
                <span class="prog-tag">Rutinitas Kelas</span>
              </div>
            </div>

            <div class="prog-footer">
              <span class="prog-duration">
                <span class="material-symbols-outlined icon-small">schedule</span>
                Usia 4–9 Th &bull; Sesi 60 - 90 Menit
              </span>
              <router-link to="/layanan/kelas-persiapan-khusus" class="prog-link prog-link--emerald">
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
            <a :href="waLink('Halo Admin Amanah Tin\'s Center, saya ingin jadwalkan asesmen untuk anak saya')" target="_blank" rel="noopener noreferrer" class="btn-wa">
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
import { useClinicSettings } from '../composables/useClinicSettings'

const { waLink } = useClinicSettings()

const activeSymptomIndex = ref(0)
const sliderRef = ref(null)

const scrollSlider = (direction) => {
  if (!sliderRef.value) return
  const amount = 320
  sliderRef.value.scrollBy({
    left: direction === 'left' ? -amount : amount,
    behavior: 'smooth'
  })
}

const selectSymptom = (idx) => {
  activeSymptomIndex.value = idx
}

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
    focusText: 'Fokus: Pendekatan Play-Based Tanpa Rasa Takut',
    sessionType: '1-on-1 Privat Bersama Terapis Ber-STR',
    priceLabel: 'Estimasi Biaya Sesi',
    duration: '60 Menit',
    priceWeekday: '275.000',
    priceWeekend: '325.000',
    priceSub: 'Termasuk observasi klinis wicara, konsultasi orang tua & lembar evaluasi tertulis.',
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
    focusText: 'Fokus: Sensory Gym & Desensitisasi Sensorik',
    sessionType: '1-on-1 Privat di Sensory Gym Standar',
    priceLabel: 'Estimasi Biaya Sesi',
    duration: '60 Menit',
    priceWeekday: '275.000',
    priceWeekend: '325.000',
    priceSub: 'Termasuk pemetaan profil sensorik anak & panduan stimulasi di rumah.',
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
    focusText: 'Fokus: Motorik Halus & Aktivitas Hidup Mandiri (ADL)',
    sessionType: '1-on-1 Privat Bersama Okupasi Terapis',
    priceLabel: 'Estimasi Biaya Sesi',
    duration: '60 Menit',
    priceWeekday: '275.000',
    priceWeekend: '325.000',
    priceSub: 'Observasi kekuatan otot tangan, kemandirian makan & kesiapan pra-tulis.',
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
    slug: 'psikolog',
    icon: 'psychology',
    iconClass: 'icon-amber',
    title: 'Emosi, Fokus & Perilaku',
    badge: 'Psychology',
    parentWorry: 'Sering tantrum meledak-ledak, konsentrasi sangat singkat di kelas, kecemasan remaja, atau butuh konseling pengasuhan.',
    matchedTherapy: 'Layanan Psikolog (Anak, Remaja & Dewasa)',
    focusText: 'Fokus: Konseling Klinis, Asesmen Kognitif & Parenting Coaching',
    sessionType: 'Sesi Privat Bersama Psikolog Klinis Berizin (SIPP)',
    priceLabel: 'Estimasi Biaya Sesi',
    duration: '60 Menit',
    priceWeekday: '350.000',
    priceWeekend: '400.000',
    priceSub: 'Konseling empatik terarah, tes IQ/kesiapan sekolah & lembar evaluasi tertulis.',
    whyMatch: 'Membimbing anak dan remaja mengenali serta meregulasi rasa marah/kecewa, skrining kognitif (IQ) kesiapan belajar, hingga konseling pengasuhan keluarga bagi orang tua.',
    milestones: [
      'Mampu meregulasi emosi dan menurunkan frekuensi tantrum/agresivitas',
      'Peningkatan daya rentang fokus saat belajar dan kepercayaan diri sosial',
      'Panduan pola asuh (parent coaching) yang harmonis dan efektif di rumah'
    ],
    targetAge: '2 – Dewasa',
    cardClass: 'matcher-psiko'
  },
  {
    id: 'grup',
    slug: 'grup-terapi',
    icon: 'groups',
    iconClass: 'icon-indigo',
    title: 'Interaksi & Sosialisasi Sebaya',
    badge: 'Group Therapy',
    parentWorry: 'Sulit berbaur dengan teman, belum paham giliran bermain, sering berebut mainan, atau asyik sendiri.',
    matchedTherapy: 'Grup Terapi (Sosial & Kolaboratif)',
    focusText: 'Fokus: Komunikasi Pragmatik, Antre Giliran & Kerja Sama',
    sessionType: 'Kelompok Kecil (3–6 Anak) Terfasilitasi Terapis',
    priceLabel: 'Estimasi Biaya Sesi',
    duration: '60 – 90 Menit',
    priceWeekday: '225.000',
    priceWeekend: '275.000',
    priceSub: 'Simulasi interaksi sosial nyata bersama terapis pendamping.',
    whyMatch: 'Sesi kelompok kecil yang terstruktur untuk melatih keterampilan komunikasi sosial, pemahaman aturan bersama, toleransi menunggu giliran, serta kolaborasi teman sebaya dalam situasi menyenangkan.',
    milestones: [
      'Mampu menunggu giliran dan berbagi mainan bersama teman',
      'Meningkatkan inisiatif menyapa dan merespons interaksi teman sebaya',
      'Regulasi emosi yang lebih tenang saat beraktivitas dalam kelompok'
    ],
    targetAge: '4 – 12 Tahun',
    cardClass: 'matcher-indigo'
  },
  {
    id: 'vokasional',
    slug: 'pra-vokasional',
    icon: 'work_history',
    iconClass: 'icon-violet',
    title: 'Kemandirian & Pra-Kerja Remaja',
    badge: 'Pre-Vocational',
    parentWorry: 'Remaja ABK menjelang dewasa butuh bekal kemandirian hidup harian, disiplin kerja praktis, dan percaya diri di ruang publik.',
    matchedTherapy: 'Pra Vokasional (Persiapan Remaja ABK)',
    focusText: 'Fokus: Keterampilan Hidup Mandiri (ADL) & Orientasi Kerja',
    sessionType: 'Pendampingan Intensif Transisi Remaja ABK Menuju Dewasa',
    priceLabel: 'Estimasi Biaya Sesi',
    duration: '90 – 120 Menit',
    priceWeekday: '325.000',
    priceWeekend: '375.000',
    priceSub: 'Pelatihan kerja terapan, simulasi tugas & pembiasaan etika kerja.',
    whyMatch: 'Program transisi vokasional bagi remaja berkebutuhan khusus (usia 12–18 tahun) untuk membangun kemandirian hidup sehari-hari, kedisiplinan kerja dasar, dan adaptasi sosial di lingkungan luas.',
    milestones: [
      'Kemandirian penuh dalam aktivitas pribadi (ADL) tanpa perlu selalu diarahkan',
      'Penguasaan tugas kerja dasar, pemahaman instruksi kerja, dan ketelitian',
      'Kesiapan mental, etika komunikasi, dan percaya diri berinteraksi di ruang publik'
    ],
    targetAge: '12 – 18 Tahun',
    cardClass: 'matcher-violet'
  },
  {
    id: 'persiapan',
    slug: 'kelas-persiapan-khusus',
    icon: 'school',
    iconClass: 'icon-emerald',
    title: 'Kesiapan Masuk Sekolah Formal',
    badge: 'Special Prep Class',
    parentWorry: 'Akan masuk TK/SD namun belum bisa duduk tenang, sulit memahami instruksi kelas, atau butuh penguatan pra-akademik.',
    matchedTherapy: 'Kelas Persiapan Khusus (Transisi Sekolah)',
    focusText: 'Fokus: Simulasi Suasana Kelas, Pra-Baca & Pra-Hitung',
    sessionType: 'Kelas Kecil Intensif (Maksimal 5 Anak per Kelas)',
    priceLabel: 'Estimasi Biaya Sesi',
    duration: '60 – 90 Menit',
    priceWeekday: '250.000',
    priceWeekend: '300.000',
    priceSub: 'Kurikulum transisi adaptif menuju jenjang sekolah formal.',
    whyMatch: 'Simulasi ruang kelas kondusif yang membiasakan anak pada rutinitas sekolah, kepatuhan instruksi guru, pengenalan pra-membaca dan pra-berhitung, serta kemandirian mengurus perlengkapan sekolah.',
    milestones: [
      'Kemampuan duduk fokus dan memperhatikan instruksi guru di depan kelas',
      'Penguatan pra-akademik: memegang pensil, pra-baca, dan logika berhitung awal',
      'Kesiapan mental berpisah dari orang tua selama jam belajar di kelas'
    ],
    targetAge: '4 – 9 Tahun',
    cardClass: 'matcher-emerald'
  }
]

const currentSymptom = computed(() => {
  return symptoms[activeSymptomIndex.value] || symptoms[0]
})

const getWhatsAppMatcherUrl = (sym) => {
  const text = `Halo Admin Amanah Tin's Center, saya telah membaca panduan di website. Anak saya mengalami tanda pada bidang ${sym.title}: "${sym.parentWorry}". Saya ingin konsultasi ketersediaan jadwal & reservasi (Weekday: Rp ${sym.priceWeekday} / Weekend: Rp ${sym.priceWeekend}) untuk program ${sym.matchedTherapy}.`
  return waLink(text)
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

/* Symptom Slider Nav & Controls */
.symptom-slider-nav {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 0.85rem;
  gap: 1rem;
}

.slider-hint {
  display: inline-flex;
  align-items: center;
  gap: 0.45rem;
  font-size: 13.5px;
  color: #556066;
}

.slider-hint .hint-icon {
  font-size: 20px;
  color: var(--primary);
  animation: bounceHint 2s infinite ease-in-out;
}

@keyframes bounceHint {
  0%, 100% { transform: translateX(0); }
  50% { transform: translateX(4px); }
}

.slider-controls {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.slider-btn {
  width: 38px;
  height: 38px;
  border-radius: 50%;
  border: 1.5px solid rgba(0, 99, 132, 0.25);
  background: #ffffff;
  color: #006384;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s ease;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.slider-btn:hover {
  background: #006384;
  color: #ffffff;
  border-color: #006384;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(0, 99, 132, 0.2);
}

/* Horizontal Scroll Track */
.symptom-cards-scroll {
  display: flex;
  gap: 1.25rem;
  overflow-x: auto;
  scroll-behavior: smooth;
  scroll-snap-type: x mandatory;
  padding: 0.5rem 0.25rem 1.25rem;
  margin-bottom: 1.75rem;
  -webkit-overflow-scrolling: touch;
  scrollbar-width: thin;
  scrollbar-color: rgba(0, 99, 132, 0.35) rgba(226, 232, 240, 0.5);
}

.symptom-cards-scroll::-webkit-scrollbar {
  height: 6px;
}

.symptom-cards-scroll::-webkit-scrollbar-track {
  background: rgba(226, 232, 240, 0.5);
  border-radius: 999px;
}

.symptom-cards-scroll::-webkit-scrollbar-thumb {
  background: rgba(0, 99, 132, 0.35);
  border-radius: 999px;
}

.symptom-cards-scroll::-webkit-scrollbar-thumb:hover {
  background: rgba(0, 99, 132, 0.6);
}

.symptom-card-btn {
  flex: 0 0 290px;
  min-width: 290px;
  scroll-snap-align: start;
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

.icon-blue    { background: #e0f2fe; color: #006384; }
.icon-teal    { background: #ccfbf1; color: #0d9488; }
.icon-green   { background: #dcfce7; color: #16a34a; }
.icon-amber   { background: #fef3c7; color: #d97706; }
.icon-indigo  { background: #e0e7ff; color: #4338ca; }
.icon-violet  { background: #ede9fe; color: #7c3aed; }
.icon-emerald { background: #d1fae5; color: #059669; }

.matcher-result-card.matcher-tw      { border-color: #006384; box-shadow: 0 16px 40px -8px rgba(0, 99, 132, 0.16); }
.matcher-result-card.matcher-si      { border-color: #0d9488; box-shadow: 0 16px 40px -8px rgba(13, 148, 136, 0.16); }
.matcher-result-card.matcher-ot      { border-color: #16a34a; box-shadow: 0 16px 40px -8px rgba(22, 163, 74, 0.16); }
.matcher-result-card.matcher-ft      { border-color: #d97706; box-shadow: 0 16px 40px -8px rgba(217, 119, 6, 0.16); }
.matcher-result-card.matcher-indigo  { border-color: #4338ca; box-shadow: 0 16px 40px -8px rgba(67, 56, 202, 0.16); }
.matcher-result-card.matcher-violet  { border-color: #7c3aed; box-shadow: 0 16px 40px -8px rgba(124, 58, 237, 0.16); }
.matcher-result-card.matcher-emerald { border-color: #059669; box-shadow: 0 16px 40px -8px rgba(5, 150, 105, 0.16); }

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

.result-title-info {
  min-width: 0;
  flex: 1;
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

.action-price-top-meta {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 0.75rem;
}

.action-price-label {
  font-size: 11.5px;
  font-weight: 800;
  color: #64748b;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.action-duration-chip {
  display: inline-flex;
  align-items: center;
  gap: 0.3rem;
  font-size: 11.5px;
  font-weight: 700;
  background: #e2e8f0;
  color: #334155;
  padding: 0.22rem 0.65rem;
  border-radius: 999px;
}

.chip-clock {
  font-size: 14px;
  color: #006384;
}

.price-day-compare {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 0.75rem;
  margin-bottom: 0.85rem;
}

.price-day-card {
  background: #ffffff;
  border: 1.5px solid #e2e8f0;
  border-radius: 14px;
  padding: 0.85rem 0.75rem;
  display: flex;
  flex-direction: column;
  gap: 0.45rem;
  transition: all 0.2s ease;
}

.price-day-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
}

.price-day-card--weekday {
  border-color: rgba(0, 99, 132, 0.3);
  background: linear-gradient(180deg, #f0f9ff 0%, #ffffff 100%);
}

.price-day-card--weekend {
  border-color: rgba(217, 119, 6, 0.35);
  background: linear-gradient(180deg, #fffbeb 0%, #ffffff 100%);
}

.price-day-badge-wrap {
  display: flex;
  flex-direction: column;
  gap: 2px;
}

.price-day-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.3rem;
  font-size: 11px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.04em;
  padding: 0.2rem 0.55rem;
  border-radius: 999px;
  align-self: flex-start;
}

.badge-blue {
  background: #e0f2fe;
  color: #006384;
}

.badge-amber {
  background: #fef3c7;
  color: #b45309;
}

.price-day-badge .badge-icon {
  font-size: 13px;
}

.price-day-sub {
  font-size: 11px;
  color: #64748b;
  font-weight: 600;
  padding-left: 2px;
}

.price-day-val-wrap {
  display: flex;
  align-items: baseline;
  gap: 2px;
  margin-top: 0.15rem;
}

.price-day-val-wrap .currency {
  font-size: 12px;
  font-weight: 700;
  color: #64748b;
}

.price-day-val-wrap .amount {
  font-family: var(--font-headline);
  font-size: 19px;
  font-weight: 800;
  color: #006384;
  line-height: 1;
}

.price-day-val-wrap.val-amber .amount {
  color: #b45309;
}

.price-day-val-wrap .unit {
  font-size: 11px;
  color: #64748b;
  font-weight: 600;
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

.prog-card--blue:hover    { border-color: rgba(0, 99, 132, 0.5); box-shadow: 0 14px 32px -6px rgba(43,61,79,0.1); }
.prog-card--green:hover   { border-color: rgba(22, 163, 74, 0.5); box-shadow: 0 14px 32px -6px rgba(43,61,79,0.1); }
.prog-card--teal:hover    { border-color: rgba(13, 148, 136, 0.5); box-shadow: 0 14px 32px -6px rgba(43,61,79,0.1); }
.prog-card--amber:hover   { border-color: rgba(217, 119, 6, 0.5); box-shadow: 0 14px 32px -6px rgba(43,61,79,0.1); }
.prog-card--indigo:hover  { border-color: rgba(79, 70, 229, 0.5); box-shadow: 0 14px 32px -6px rgba(79, 70, 229, 0.12); }
.prog-card--violet:hover  { border-color: rgba(124, 58, 237, 0.5); box-shadow: 0 14px 32px -6px rgba(124, 58, 237, 0.12); }
.prog-card--emerald:hover { border-color: rgba(5, 150, 105, 0.5); box-shadow: 0 14px 32px -6px rgba(5, 150, 105, 0.12); }

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
.prog-icon--blue    { background-color: #e0f2fe; color: #006384; }
.prog-icon--green   { background-color: #dcfce7; color: #16a34a; }
.prog-icon--teal    { background-color: #ccfbf1; color: #0d9488; }
.prog-icon--amber   { background-color: #fef3c7; color: #d97706; }
.prog-icon--indigo  { background-color: #e0e7ff; color: #4338ca; }
.prog-icon--violet  { background-color: #ede9fe; color: #7c3aed; }
.prog-icon--emerald { background-color: #d1fae5; color: #059669; }

.prog-badge {
  font-size: 12px; font-weight: 800;
  padding: 0.3rem 0.8rem;
  border-radius: 9999px;
  text-transform: uppercase;
}
.prog-badge--blue    { background-color: #e0f2fe; color: #006384; }
.prog-badge--green   { background-color: #dcfce7; color: #16a34a; }
.prog-badge--teal    { background-color: #ccfbf1; color: #0d9488; }
.prog-badge--amber   { background-color: #fef3c7; color: #d97706; }
.prog-badge--indigo  { background-color: #e0e7ff; color: #4338ca; }
.prog-badge--violet  { background-color: #ede9fe; color: #7c3aed; }
.prog-badge--emerald { background-color: #d1fae5; color: #059669; }

.prog-name {
  font-family: var(--font-headline);
  font-size: 22px; font-weight: 800;
  color: #091d2e;
  margin: 0 0 0.65rem;
  transition: color 0.2s;
}
.prog-card--blue:hover    .prog-name { color: #006384; }
.prog-card--green:hover   .prog-name { color: #16a34a; }
.prog-card--teal:hover    .prog-name { color: #0d9488; }
.prog-card--amber:hover   .prog-name { color: #d97706; }
.prog-card--indigo:hover  .prog-name { color: #4338ca; }
.prog-card--violet:hover  .prog-name { color: #7c3aed; }
.prog-card--emerald:hover .prog-name { color: #059669; }

.prog-name-sub {
  font-size: 15px;
  font-weight: 600;
  color: #64748b;
  display: inline-block;
  margin-left: 0.25rem;
}

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
  gap: 0.85rem;
  padding-top: 1.25rem;
  border-top: 1px solid rgba(191, 200, 206, 0.25);
  margin-top: auto;
}
.prog-duration {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  font-size: 12.5px;
  color: #64748b;
  font-weight: 600;
  line-height: 1.4;
  min-width: 0;
}
.icon-small { font-size: 17px; color: #006384; flex-shrink: 0; }

.prog-link {
  font-size: 14px; font-weight: 800;
  display: inline-flex; align-items: center; gap: 0.35rem;
  text-decoration: none;
  white-space: nowrap;
  flex-shrink: 0;
  transition: transform 0.2s, background-color 0.2s, border-color 0.2s;
}
.prog-card:hover .prog-link { transform: translateX(4px); }
.prog-link--blue    { color: #006384; }
.prog-link--green   { color: #16a34a; }
.prog-link--teal    { color: #0d9488; }
.prog-link--amber   { color: #d97706; }
.prog-link--indigo  { color: #4338ca; }
.prog-link--violet  { color: #7c3aed; }
.prog-link--emerald { color: #059669; }

/* Desktop: Center 7th odd card if alone on the last row */
@media (min-width: 768px) {
  .programs-grid .prog-card:last-child:nth-child(odd) {
    grid-column: 1 / -1;
    max-width: 580px;
    margin: 0 auto;
    width: 100%;
  }
}

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
  .matcher-section {
    padding: 3rem 0 2.5rem;
  }
  .matcher-result-card {
    padding: 1.75rem 1.5rem;
    border-radius: 1.25rem;
  }
  .result-grid {
    grid-template-columns: 1fr;
    gap: 1.5rem;
  }
  .result-prog-name {
    font-size: 21px;
  }
  .price-day-compare {
    grid-template-columns: 1fr 1fr;
    gap: 0.85rem;
  }
  .action-buttons-wrap {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.85rem;
  }
  .action-card-inner {
    padding: 1.5rem;
  }
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

  /* Matcher & Rekomendasi Terapi Utama on Mobile */
  .matcher-section {
    padding: 2.25rem 0 2rem;
  }
  .matcher-section .section-header {
    margin-bottom: 1.5rem;
  }
  .matcher-section .section-title {
    font-size: 22px;
    line-height: 1.3;
    margin: 0.35rem 0 0.5rem;
  }
  .matcher-section .section-sub {
    font-size: 13.5px;
    line-height: 1.5;
  }
  .symptom-slider-nav {
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 0.65rem;
  }
  .slider-hint {
    font-size: 11.5px;
    line-height: 1.3;
  }
  .slider-btn {
    width: 32px;
    height: 32px;
  }
  .symptom-cards-scroll {
    gap: 0.85rem;
    padding: 0.25rem 0.15rem 0.85rem;
    margin-bottom: 1.25rem;
  }
  .symptom-card-btn {
    flex: 0 0 240px;
    min-width: 240px;
    padding: 1.1rem 0.95rem;
    border-radius: 1rem;
  }
  .symptom-btn-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    margin-bottom: 0.75rem;
  }
  .symptom-btn-title {
    font-size: 14.5px;
    margin-bottom: 0.35rem;
  }
  .symptom-btn-worry {
    font-size: 11.5px;
    line-height: 1.45;
  }
  .symptom-check-indicator {
    padding-top: 0.65rem;
  }

  .matcher-result-card {
    padding: 1.25rem 1rem;
    border-radius: 1.15rem;
    box-shadow: 0 10px 28px -6px rgba(0, 99, 132, 0.12);
  }
  .result-top-bar {
    flex-direction: column;
    align-items: flex-start;
    gap: 0.5rem;
    padding-bottom: 0.85rem;
    margin-bottom: 1.15rem;
  }
  .result-badge-group {
    flex-wrap: wrap;
    gap: 0.4rem;
    width: 100%;
  }
  .result-match-pill {
    font-size: 11px;
    padding: 0.25rem 0.65rem;
  }
  .result-age-badge {
    font-size: 11px;
    padding: 0.25rem 0.65rem;
  }
  .result-status-tag {
    font-size: 11px;
    padding: 0.25rem 0.65rem;
    line-height: 1.35;
    max-width: 100%;
    align-self: flex-start;
  }
  .result-title-row {
    align-items: center;
    gap: 0.75rem;
  }
  .result-big-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
  }
  .result-big-icon .material-symbols-outlined {
    font-size: 24px;
  }
  .result-prog-name {
    font-size: 18px;
    line-height: 1.25;
    word-break: break-word;
  }
  .result-focus-tag {
    font-size: 11.5px;
    margin-top: 2px;
  }
  .result-why-box {
    padding: 0.75rem 0.85rem;
    border-radius: 0 10px 10px 0;
    border-left-width: 3.5px;
  }
  .why-title {
    font-size: 12.5px;
    gap: 0.35rem;
    margin-bottom: 0.3rem;
  }
  .why-title .material-symbols-outlined {
    font-size: 16px;
  }
  .why-text {
    font-size: 12px;
    line-height: 1.5;
  }
  .result-milestones-box {
    margin-top: 0;
  }
  .milestones-title {
    font-size: 11.5px;
    margin-bottom: 0.5rem;
  }
  .milestones-list {
    gap: 0.4rem;
  }
  .milestones-list li {
    font-size: 12px;
    line-height: 1.4;
    gap: 0.45rem;
  }
  .check-bullet {
    font-size: 16px;
    margin-top: 1px;
  }
  .action-card-inner {
    padding: 1.1rem 0.9rem;
    border-radius: 0.95rem;
  }
  .action-header {
    margin-bottom: 0.85rem;
  }
  .action-price-label {
    font-size: 10.5px;
  }
  .action-duration-chip {
    font-size: 10.5px;
    padding: 0.18rem 0.5rem;
  }
  .action-sub {
    font-size: 11px;
    line-height: 1.45;
    margin-top: 0.45rem;
  }
  .action-buttons-wrap {
    display: flex;
    flex-direction: column;
    gap: 0.6rem;
    margin: 0.85rem 0 0.65rem;
    width: 100%;
  }
  .btn-result-detail,
  .btn-result-wa {
    font-size: 12.5px;
    padding: 0.75rem 1rem;
    width: 100%;
    box-sizing: border-box;
    text-align: center;
  }
  .action-assurance {
    font-size: 11px;
  }

  .programs-grid { gap: 1.25rem; }
  .prog-card {
    padding: 1.65rem 1.35rem;
    border-radius: 1.25rem;
  }
  .prog-footer {
    gap: 0.85rem;
    padding-top: 1.1rem;
  }
  .prog-duration {
    font-size: 12px;
  }
  .steps-grid { grid-template-columns: 1fr; }
  .trust-grid { grid-template-columns: 1fr; }
  .quote-card { padding: 2rem 1.25rem; }
  .quote-text { font-size: 17px; }
  .cta-title { font-size: 24px; }
}

@media (max-width: 580px) {
  .programs-section {
    padding: 2.5rem 0;
  }
  .prog-card {
    padding: 1.35rem 1.15rem;
    border-radius: 1.15rem;
  }
  .prog-desc {
    font-size: 13.5px;
    line-height: 1.6;
    margin-bottom: 1rem;
  }
  .prog-parent-box {
    padding: 0.75rem 0.85rem;
    margin-bottom: 1rem;
  }
  .prog-focus {
    margin-bottom: 1.25rem;
  }
  .prog-footer {
    flex-direction: column;
    align-items: stretch;
    gap: 0.75rem;
    padding-top: 0.95rem;
  }
  .prog-duration {
    display: flex;
    align-items: center;
    gap: 0.45rem;
    font-size: 12px;
    color: #475569;
    background: #f8fafc;
    padding: 0.5rem 0.75rem;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    line-height: 1.35;
    width: 100%;
    box-sizing: border-box;
  }
  .prog-link {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.45rem;
    padding: 0.7rem 1rem;
    border-radius: 9999px;
    font-size: 13.5px;
    font-weight: 700;
    text-align: center;
    border: 1.5px solid currentColor;
    white-space: nowrap;
    width: 100%;
    box-sizing: border-box;
    transition: transform 0.15s ease, background-color 0.15s ease;
  }
  .prog-card:hover .prog-link {
    transform: none;
  }
  .prog-link:active {
    transform: scale(0.98);
  }
  .prog-link--blue    { background-color: #f0f9ff; color: #006384; border-color: rgba(0, 99, 132, 0.25); }
  .prog-link--green   { background-color: #f0fdf4; color: #16a34a; border-color: rgba(22, 163, 74, 0.25); }
  .prog-link--teal    { background-color: #f0fdfa; color: #0d9488; border-color: rgba(13, 148, 136, 0.25); }
  .prog-link--amber   { background-color: #fffbeb; color: #b45309; border-color: rgba(217, 119, 6, 0.25); }
  .prog-link--indigo  { background-color: #eef2ff; color: #4338ca; border-color: rgba(67, 56, 202, 0.25); }
  .prog-link--violet  { background-color: #f5f3ff; color: #7c3aed; border-color: rgba(124, 58, 237, 0.25); }
  .prog-link--emerald { background-color: #ecfdf5; color: #059669; border-color: rgba(5, 150, 105, 0.25); }

  .prog-link--blue:active    { background-color: #e0f2fe; }
  .prog-link--green:active   { background-color: #dcfce7; }
  .prog-link--teal:active    { background-color: #ccfbf1; }
  .prog-link--amber:active   { background-color: #fef3c7; }
  .prog-link--indigo:active  { background-color: #e0e7ff; }
  .prog-link--violet:active  { background-color: #ede9fe; }
  .prog-link--emerald:active { background-color: #d1fae5; }
}

@media (max-width: 520px) {
  .price-day-compare {
    grid-template-columns: 1fr;
    gap: 0.55rem;
  }
  .price-day-card {
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    padding: 0.65rem 0.85rem;
  }
  .price-day-badge-wrap {
    flex-direction: row;
    align-items: center;
    gap: 0.45rem;
    flex-wrap: wrap;
  }
  .price-day-val-wrap {
    margin-top: 0;
    flex-shrink: 0;
  }
  .price-day-val-wrap .amount {
    font-size: 17px;
  }
}
</style>
