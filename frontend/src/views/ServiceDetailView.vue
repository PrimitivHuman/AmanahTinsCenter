<template>
  <PublicLayout>
    <div v-if="loading" class="loading-state">
      <div class="spinner"></div>
    </div>

    <div v-else-if="service" class="service-detail-page">
      <!-- ==================== BREADCRUMBS & BACK ANCHOR ==================== -->
      <section class="breadcrumb-strip">
        <div class="container breadcrumb-container">
          <nav class="breadcrumb-nav" aria-label="Breadcrumb">
            <router-link to="/" class="bc-link">
              <span class="material-symbols-outlined bc-home-icon">home</span>
              Beranda
            </router-link>
            <span class="material-symbols-outlined bc-sep">chevron_right</span>
            <router-link to="/layanan" class="bc-link">Layanan</router-link>
            <span class="material-symbols-outlined bc-sep">chevron_right</span>
            <span class="bc-active">Detail: {{ service.name }}</span>
          </nav>
          <router-link to="/layanan" class="back-link">
            <span class="material-symbols-outlined back-icon">arrow_back</span>
            Kembali ke Semua Layanan
          </router-link>
        </div>
      </section>

      <!-- ==================== HERO SECTION ==================== -->
      <section class="service-hero">
        <div class="hero-bg-blob-1"></div>
        <div class="hero-bg-blob-2"></div>
        <div class="container">
          <div class="hero-grid">
            <!-- Left Col: Details & CTAs -->
            <div class="hero-content">
              <div class="category-badge">
                <span class="material-symbols-outlined fill cat-icon">{{ service.badgeIcon || 'record_voice_over' }}</span>
                <span>{{ service.categoryBadge }}</span>
              </div>

              <h1 class="hero-title">
                {{ service.titleMain }}
                <span class="hero-title-accent">{{ service.titleAccent }}</span>
              </h1>

              <p class="hero-description">
                {{ service.heroDesc }}
              </p>

              <!-- Quick Specification Bento Bar -->
              <div class="specs-bento">
                <div v-for="spec in service.specs" :key="spec.label" class="spec-card">
                  <div class="spec-icon" :class="spec.bgClass">
                    <span class="material-symbols-outlined">{{ spec.icon }}</span>
                  </div>
                  <div class="spec-info">
                    <span class="spec-label">{{ spec.label }}</span>
                    <span class="spec-val">{{ spec.value }}</span>
                  </div>
                </div>
              </div>

              <!-- Hero Action CTAs -->
              <div class="hero-actions">
                <a href="#daftar-sekarang" class="btn-primary-hero">
                  <span>{{ service.ctaPrimaryText }}</span>
                  <span class="material-symbols-outlined">calendar_month</span>
                </a>
                <a :href="waUrl" target="_blank" rel="noopener noreferrer" class="btn-wa-hero">
                  <span class="material-symbols-outlined">chat</span>
                  <span>Hubungi via WhatsApp</span>
                </a>
              </div>

              <!-- Trust Badges Under Hero -->
              <div class="trust-badges">
                <div class="trust-item">
                  <span class="material-symbols-outlined check-icon">check_circle</span>
                  <span>Ruang Terapi Ber-AC &amp; Higienis</span>
                </div>
                <div class="trust-item">
                  <span class="material-symbols-outlined check-icon">check_circle</span>
                  <span>Praktisi STR Kemenkes Aktif</span>
                </div>
                <div class="trust-item">
                  <span class="material-symbols-outlined check-icon">check_circle</span>
                  <span>Pendampingan Edukasi Orang Tua</span>
                </div>
              </div>
            </div>

            <!-- Right Col: Visual Container -->
            <div class="hero-visual-col">
              <div class="visual-frame">
                <img
                  :src="service.heroImage"
                  :alt="service.titleMain"
                  class="hero-img"
                />
                <!-- Floating Overlay Tag -->
                <div class="floating-badge-tag">
                  <div class="float-tag-left">
                    <div class="float-icon-wrap">
                      <span class="material-symbols-outlined">sentiment_satisfied</span>
                    </div>
                    <div>
                      <h4 class="float-tag-title">Metode Fun &amp; Play-Based</h4>
                      <p class="float-tag-sub">Bebas stres, nyaman, dan disesuaikan minat si Kecil</p>
                    </div>
                  </div>
                  <span class="float-loc-pill">Jagakarsa Center</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ==================== SECTION 2: INDIKASI & DETEKSI GEJALA (INTERAKTIF) ==================== -->
      <section class="section-indications">
        <div class="container">
          <div class="section-header center">
            <span class="section-eyebrow eyebrow-secondary">Deteksi Dini Perkembangan</span>
            <h2 class="section-title">Kapan Si Kecil Perlu Asesmen {{ service.shortName }}?</h2>
            <p class="section-desc">
              {{ service.indicationsDesc }}
            </p>
          </div>

          <!-- Interactive Checklist Toolbar -->
          <div class="symptom-check-toolbar">
            <div class="toolbar-info">
              <span class="material-symbols-outlined toolbar-icon">checklist_rtl</span>
              <span><strong>Panduan Ayah &amp; Bunda:</strong> Klik/tandai keluhan yang saat ini sering diamati pada si Kecil di rumah:</span>
            </div>
            <div class="toolbar-counter" :class="{ 'has-checked': checkedSymptoms.length > 0 }">
              <span class="counter-num">{{ checkedSymptoms.length }}</span>
              <span>Gejala Ditandai</span>
            </div>
          </div>

          <!-- Interactive Indications Checklist Grid -->
          <div class="indications-grid">
            <div
              v-for="item in service.indications"
              :key="item.title"
              class="indication-card"
              :class="{ 'is-checked': isSymptomChecked(item.title) }"
              @click="toggleSymptom(item.title)"
            >
              <div>
                <div class="ind-card-top">
                  <div class="ind-icon-wrap" :class="item.iconBg">
                    <span class="material-symbols-outlined">{{ item.icon }}</span>
                  </div>
                  <div class="ind-checkbox" :class="{ 'checked': isSymptomChecked(item.title) }">
                    <span class="material-symbols-outlined check-icon-ui">
                      {{ isSymptomChecked(item.title) ? 'check_box' : 'check_box_outline_blank' }}
                    </span>
                  </div>
                </div>
                <h3 class="ind-title">{{ item.title }}</h3>
                <p class="ind-desc">{{ item.desc }}</p>
              </div>
              <div class="ind-footer">
                <span class="material-symbols-outlined ind-info-icon">info</span>
                <span>Kriteria Usia: {{ item.age }}</span>
              </div>
            </div>
          </div>

          <!-- Alert Banner when >= 1 symptom checked -->
          <div v-if="checkedSymptoms.length > 0" class="symptom-checked-alert">
            <div class="checked-alert-left">
              <span class="material-symbols-outlined star-icon">verified</span>
              <div>
                <h4 class="alert-title">{{ checkedSymptoms.length }} Indikasi Ditandai untuk {{ service.shortName }}</h4>
                <p class="alert-sub">Intervensi sedini mungkin pada masa emas anak memberikan hasil paling optimal sebelum hambatan menetap.</p>
              </div>
            </div>
            <a :href="getCheckedSymptomsWaUrl" target="_blank" rel="noopener noreferrer" class="btn-alert-wa">
              <span class="material-symbols-outlined fill">chat</span>
              <span>Konsultasikan {{ checkedSymptoms.length }} Gejala via WA</span>
            </a>
          </div>

          <!-- Quick Guidance Callout -->
          <div v-else class="guidance-callout">
            <div class="guidance-left">
              <div class="guidance-icon-circle">
                <span class="material-symbols-outlined">lightbulb</span>
              </div>
              <p class="guidance-text">
                <strong>Catatan Terapis:</strong> Jangan menunggu hingga usia sekolah. "Wait and see" sering kali menunda penanganan masa emas (golden period) otak anak.
              </p>
            </div>
            <a href="#jadwal-biaya" class="guidance-link">
              Lihat Pilihan Skrining Awal &rarr;
            </a>
          </div>
        </div>
      </section>

      <!-- ==================== SECTION 3: AREA FOKUS (INTERACTIVE TABBED SWITCHER) ==================== -->
      <section class="section-focus-methods">
        <div class="container">
          <div class="focus-header">
            <div>
              <span class="section-eyebrow eyebrow-primary">Kurikulum Klinis Terpadu</span>
              <h2 class="section-title">Area Fokus &amp; Metode Intervensi {{ service.code }}</h2>
            </div>
            <p class="focus-header-desc">
              Pilih pilar intervensi di bawah ini untuk melihat sasaran stimulasi dan target capaian nyata bagi si Kecil:
            </p>
          </div>

          <!-- Tab Bar Selector -->
          <div class="pillar-tabs-nav">
            <button
              v-for="(pillar, pIdx) in service.pillars"
              :key="pillar.title"
              @click="activePillarIndex = pIdx"
              class="pillar-tab-btn"
              :class="{ 'is-active': activePillarIndex === pIdx }"
            >
              <div class="tab-icon-wrap" :class="pillar.bgClass">
                <span class="material-symbols-outlined">{{ pillar.icon }}</span>
              </div>
              <div class="tab-text-wrap">
                <span class="tab-num">Pilar 0{{ pIdx + 1 }}</span>
                <span class="tab-title">{{ pillar.title }}</span>
              </div>
            </button>
          </div>

          <!-- Active Pillar Visual Showcase Card -->
          <div v-if="currentPillar" class="pillar-showcase-card">
            <div class="pillar-showcase-header">
              <div class="showcase-header-left">
                <div class="pillar-icon-wrap-lg" :class="currentPillar.bgClass">
                  <span class="material-symbols-outlined">{{ currentPillar.icon }}</span>
                </div>
                <div>
                  <span class="pillar-stage-pill">Kurikulum Klinis • Pilar 0{{ activePillarIndex + 1 }} dari {{ service.pillars.length }}</span>
                  <h3 class="pillar-showcase-title">{{ currentPillar.title }}</h3>
                </div>
              </div>
              <div class="pillar-nav-arrows">
                <button
                  @click="activePillarIndex = (activePillarIndex - 1 + service.pillars.length) % service.pillars.length"
                  class="btn-pillar-nav"
                  title="Pilar Sebelumnya"
                >
                  <span class="material-symbols-outlined">chevron_left</span>
                </button>
                <button
                  @click="activePillarIndex = (activePillarIndex + 1) % service.pillars.length"
                  class="btn-pillar-nav"
                  title="Pilar Selanjutnya"
                >
                  <span class="material-symbols-outlined">chevron_right</span>
                </button>
              </div>
            </div>

            <p class="pillar-showcase-desc">{{ currentPillar.desc }}</p>

            <div class="pillar-competencies-grid">
              <div v-for="bullet in currentPillar.bullets" :key="bullet" class="competency-card">
                <span class="material-symbols-outlined comp-check">check_circle</span>
                <span class="comp-text">{{ bullet }}</span>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ==================== SECTION 4: ALUR PROSES TERAPI ==================== -->
      <section class="section-process">
        <div class="container">
          <div class="section-header center">
            <span class="section-eyebrow eyebrow-primary">Tahapan Berkelanjutan</span>
            <h2 class="section-title">Alur Proses Terapi {{ service.shortName }}</h2>
            <p class="section-desc">
              Pendampingan terstruktur dari hari pertama asesmen hingga anak mandiri berkomunikasi dan beraktivitas, dengan keterlibatan penuh orang tua.
            </p>
          </div>

          <div class="process-grid">
            <div
              v-for="step in service.processSteps"
              :key="step.number"
              class="process-card"
            >
              <div>
                <div class="process-card-top">
                  <span class="process-num" :class="step.numBgClass">{{ step.number }}</span>
                  <span class="process-badge" :class="step.badgeBgClass">{{ step.badge }}</span>
                </div>
                <h3 class="process-title">{{ step.title }}</h3>
                <p class="process-desc">{{ step.desc }}</p>
              </div>
              <div class="process-footer">
                <span class="material-symbols-outlined footer-icon">{{ step.footerIcon }}</span>
                <span>{{ step.footerText }}</span>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ==================== SECTION 5: TIM TERAPIS ==================== -->
      <section class="section-therapists">
        <div class="container">
          <div class="focus-header">
            <div>
              <span class="section-eyebrow eyebrow-primary">Praktisi Berpengalaman &amp; Ber-STR</span>
              <h2 class="section-title">Tim Terapis {{ service.shortName }} Kami</h2>
            </div>
            <p class="focus-header-desc">
              Didukung oleh terapis lulusan program studi resmi dengan sertifikasi keahlian pediatrik dan pendekatan penuh kesabaran.
            </p>
          </div>

          <div class="therapists-grid">
            <div
              v-for="therapist in service.therapists"
              :key="therapist.name"
              class="therapist-card"
            >
              <div class="therapist-img-wrap">
                <img :src="therapist.image" :alt="therapist.name" class="therapist-img" />
                <div class="str-badge">STR Aktif Kemenkes</div>
              </div>
              <div class="therapist-body">
                <div>
                  <h3 class="therapist-name">{{ therapist.name }}</h3>
                  <p class="therapist-role">{{ therapist.role }}</p>
                </div>
                <p class="therapist-bio">{{ therapist.bio }}</p>
                <div class="therapist-footer">
                  <span class="therapist-cert">{{ therapist.cert }}</span>
                  <span class="therapist-rating">
                    <span class="material-symbols-outlined fill star-icon">star</span>
                    {{ therapist.rating }}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ==================== SECTION 6: PAKET TRANSPARAN ==================== -->
      <section class="section-pricing" id="jadwal-biaya">
        <div class="container">
          <div class="section-header center">
            <span class="section-eyebrow eyebrow-primary">Jadwal &amp; Investasi Tumbuh Kembang</span>
            <h2 class="section-title">Paket Terapi Transparan</h2>
            <p class="section-desc">
              Investasi terbaik untuk kemandirian dan rasa percaya diri masa depan anak Anda, tanpa biaya tersembunyi.
            </p>
          </div>

          <!-- Schedule Ribbon -->
          <div class="schedule-ribbon">
            <div class="ribbon-left">
              <span class="material-symbols-outlined ribbon-icon">event_available</span>
              <span class="ribbon-text">Operasional: <strong>Senin &ndash; Sabtu (08.00 &ndash; 17.00 WIB)</strong></span>
            </div>
            <div class="ribbon-right">
              <span class="dot-green"></span>
              <span>Slot Pagi &amp; Sore Tersedia</span>
            </div>
          </div>

          <!-- Package Cards (3 Packages) -->
          <div class="packages-grid">
            <div
              v-for="pkg in service.packages"
              :key="pkg.title"
              class="package-card"
              :class="{ 'package-card--popular': pkg.isPopular }"
            >
              <div v-if="pkg.isPopular" class="popular-ribbon">
                Rekomendasi Utama Ortu
              </div>

              <div>
                <div class="pkg-top-tag">
                  <span class="pkg-tag" :class="pkg.tagClass">{{ pkg.tag }}</span>
                </div>

                <h3 class="pkg-title">{{ pkg.title }}</h3>
                <p class="pkg-sub">{{ pkg.subtitle }}</p>

                <div class="pkg-price-block">
                  <span class="pkg-price-label">{{ pkg.priceLabel || 'Total Investasi' }}</span>
                  <div class="pkg-price">
                    {{ pkg.price }} <span class="pkg-price-unit">/ {{ pkg.unit }}</span>
                  </div>
                  <span v-if="pkg.savingNote" class="pkg-saving">{{ pkg.savingNote }}</span>
                </div>

                <ul class="pkg-features">
                  <li v-for="feat in pkg.features" :key="feat">
                    <span class="material-symbols-outlined feat-check">check</span>
                    <span>{{ feat }}</span>
                  </li>
                </ul>
              </div>

              <div class="pkg-btn-wrap">
                <button
                  type="button"
                  @click="selectPackage(pkg.title)"
                  class="btn-pkg"
                  :class="pkg.isPopular ? 'btn-pkg--primary' : 'btn-pkg--outline'"
                >
                  {{ pkg.buttonText }} (Pilih Paket)
                </button>
                <a
                  :href="getPackageWaUrl(pkg)"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="btn-pkg-wa-link"
                >
                  <span class="material-symbols-outlined fill wa-btn-icon">chat</span>
                  <span>Tanya via WhatsApp</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ==================== SECTION 7: FAQ (INTERACTIVE ACCORDION) ==================== -->
      <section class="section-faq">
        <div class="container max-w-faq">
          <div class="section-header center">
            <span class="section-eyebrow eyebrow-primary">Tanya Jawab Orang Tua</span>
            <h2 class="section-title">FAQ Seputar {{ service.name }}</h2>
            <p class="section-desc">
              Pertanyaan yang paling sering dikonsultasikan orang tua sebelum memulai sesi perdana.
            </p>
          </div>

          <div class="faq-accordion-list">
            <div
              v-for="(faq, index) in service.faqs"
              :key="index"
              class="faq-accordion-item"
              :class="{ 'is-open': activeFaqIndex === index }"
            >
              <button @click="toggleFaq(index)" class="faq-accordion-btn" type="button">
                <div class="faq-btn-left">
                  <span class="material-symbols-outlined faq-q-icon">help</span>
                  <span class="faq-q-text">{{ faq.q }}</span>
                </div>
                <span class="material-symbols-outlined faq-toggle-icon">
                  {{ activeFaqIndex === index ? 'remove_circle' : 'add_circle' }}
                </span>
              </button>
              <div v-show="activeFaqIndex === index" class="faq-accordion-content">
                <p class="faq-answer-paragraph">{{ faq.a }}</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ==================== SECTION 8: BANNER CTA & FORM ==================== -->
      <section class="section-cta-banner" id="daftar-sekarang">
        <div class="container">
          <div class="cta-grid">
            <!-- Left Info -->
            <div class="cta-left">
              <span class="cta-pill">
                Pusat Layanan Jagakarsa, Jakarta Selatan
              </span>
              <h2 class="cta-title">
                Mulai Langkah Pertama Si Kecil {{ service.ctaFocusWord || 'Berbicara' }} Hari Ini
              </h2>
              <p class="cta-desc">
                Konsultasikan kekhawatiran Ayah &amp; Bunda dengan tim terapis {{ service.shortName.toLowerCase() }} kami. Tim admin kami siap membantu pencocokan jadwal asesmen yang paling nyaman untuk keluarga Anda.
              </p>

              <div class="cta-avatars-row">
                <div class="cta-avatar-stack">
                  <div class="cta-avatar cta-avatar--1">ATC</div>
                  <div class="cta-avatar cta-avatar--2">STR</div>
                  <div class="cta-avatar cta-avatar--3">1:1</div>
                </div>
                <div class="cta-trust-counter">
                  <strong>500+ Anak Didampingi</strong> sejak 2021 di Amanah Tin's Center
                </div>
              </div>
            </div>

            <!-- Right Form -->
            <div class="cta-right">
              <div class="booking-card">
                <h3 class="booking-title">Formulir Booking Asesmen {{ service.code }}</h3>
                <p class="booking-sub">
                  Isi data singkat berikut, tim admin kami akan menghubungi via WhatsApp dalam 1x24 jam.
                </p>

                <form @submit.prevent="submitBooking" class="booking-form">
                  <div class="form-row-2">
                    <div class="form-group">
                      <label class="form-label">Nama Orang Tua</label>
                      <input
                        v-model="bookingForm.parentName"
                        type="text"
                        required
                        class="form-input"
                        placeholder="Bunda / Ayah..."
                      />
                    </div>
                    <div class="form-group">
                      <label class="form-label">Nomor WhatsApp Aktif</label>
                      <input
                        v-model="bookingForm.whatsapp"
                        type="tel"
                        required
                        class="form-input"
                        placeholder="0812-xxxx-xxxx"
                      />
                    </div>
                  </div>

                  <div class="form-row-2">
                    <div class="form-group">
                      <label class="form-label">Nama Panggilan Anak</label>
                      <input
                        v-model="bookingForm.childName"
                        type="text"
                        required
                        class="form-input"
                        placeholder="Contoh: Kenzo"
                      />
                    </div>
                    <div class="form-group">
                      <label class="form-label">Usia Anak Saat Ini</label>
                      <input
                        v-model="bookingForm.childAge"
                        type="text"
                        required
                        class="form-input"
                        placeholder="Contoh: 2 Tahun 4 Bulan"
                      />
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="form-label">Pilihan Paket Terapi</label>
                    <select v-model="bookingForm.selectedPackage" class="form-input">
                      <option value="">-- Pilih Paket Terapi (Opsional) --</option>
                      <option v-for="pkg in service.packages" :key="pkg.title" :value="pkg.title">
                        {{ pkg.title }} ({{ pkg.price }})
                      </option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label class="form-label">Keluhan / Catatan Tambahan</label>
                    <textarea
                      v-model="bookingForm.notes"
                      rows="2"
                      class="form-input form-textarea"
                      placeholder="Contoh: Anak belum mengucap kata bermakna, sering menarik tangan jika ingin sesuatu..."
                    ></textarea>
                  </div>

                  <button type="submit" class="btn-submit-booking">
                    <span>Kirim Pendaftaran &amp; Jadwalkan Sesi</span>
                    <span class="material-symbols-outlined submit-icon">send</span>
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <!-- NOT FOUND STATE -->
    <div v-else class="not-found-state">
      <div class="container not-found-container">
        <span class="material-symbols-outlined not-found-icon">search_off</span>
        <h2>Layanan Tidak Ditemukan</h2>
        <p>Maaf, layanan terapi yang Anda cari tidak tersedia atau URL salah.</p>
        <router-link to="/layanan" class="btn-primary-hero">
          Kembali ke Daftar Layanan
        </router-link>
      </div>
    </div>
  </PublicLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useClinicSettings } from '../composables/useClinicSettings'

const { waLink, waLinkEncoded } = useClinicSettings()
import { useRoute } from 'vue-router'
import PublicLayout from '../layouts/PublicLayout.vue'

const route = useRoute()
const loading = ref(false)

const checkedSymptoms = ref([])
const activePillarIndex = ref(0)
const activeFaqIndex = ref(0)

const isSymptomChecked = (title) => checkedSymptoms.value.includes(title)

const toggleSymptom = (title) => {
  const idx = checkedSymptoms.value.indexOf(title)
  if (idx > -1) {
    checkedSymptoms.value.splice(idx, 1)
  } else {
    checkedSymptoms.value.push(title)
  }
}

const toggleFaq = (index) => {
  activeFaqIndex.value = activeFaqIndex.value === index ? -1 : index
}

const currentPillar = computed(() => {
  if (!service.value || !service.value.pillars) return null
  return service.value.pillars[activePillarIndex.value] || service.value.pillars[0]
})

const getCheckedSymptomsWaUrl = computed(() => {
  const currentSvc = service.value ? service.value.name : 'Layanan'
  const list = checkedSymptoms.value.map((s, i) => `${i + 1}. ${s}`).join('%0A')
  const text = `Halo Admin Amanah Tin's Center, saya ingin konsultasi mengenai ${currentSvc}. Dari deteksi mandiri di website, anak saya mengalami gejala berikut:%0A${list}%0AMohon info jadwal asesmen awal dan saran langkahnya.`
  return waLinkEncoded(text)
})

const selectPackage = (pkgTitle) => {
  bookingForm.value.selectedPackage = pkgTitle
  const el = document.getElementById('daftar-sekarang')
  if (el) el.scrollIntoView({ behavior: 'smooth' })
}

const getPackageWaUrl = (pkg) => {
  const currentSvc = service.value ? service.value.name : 'Layanan'
  const text = `Halo Admin Amanah Tin's Center, saya tertarik mendaftar "${pkg.title}" untuk ${currentSvc}. Apakah jadwal terapis masih tersedia?`
  return waLink(text)
}

const bookingForm = ref({
  parentName: '',
  whatsapp: '',
  childName: '',
  childAge: '',
  selectedPackage: '',
  notes: ''
})

const waUrl = computed(() => {
  return waLink()
})

const submitBooking = () => {
  const currentSvc = service.value ? service.value.name : 'Layanan'
  const text = `Halo Admin Amanah Tin's Center, saya ingin booking Asesmen ${currentSvc}:%0A` +
    `- Nama Orang Tua: ${bookingForm.value.parentName}%0A` +
    `- No. WhatsApp: ${bookingForm.value.whatsapp}%0A` +
    `- Nama Anak: ${bookingForm.value.childName}%0A` +
    `- Usia Anak: ${bookingForm.value.childAge}%0A` +
    `- Paket Pilihan: ${bookingForm.value.selectedPackage || '-'}` +
    `- Catatan/Keluhan: ${bookingForm.value.notes || '-'}`
  
  window.open(waLinkEncoded(text), '_blank')
}

const allServicesData = {
  'terapi-wicara': {
    code: 'TW',
    name: 'Terapi Wicara (TW)',
    shortName: 'Terapi Wicara',
    badgeIcon: 'record_voice_over',
    categoryBadge: 'Program Spesialisasi Klinis • Terapi Wicara (TW)',
    titleMain: 'Terapi Wicara & Bahasa Anak',
    titleAccent: '(Speech Therapy)',
    heroDesc: 'Membantu anak mengekspresikan diri, mengatasi speech delay, stimulasi artikulasi bicara, pemahaman bahasa reseptif, serta melatih kelancaran komunikasi sosial dengan metode interaktif & ramah anak.',
    heroImage: 'https://lh3.googleusercontent.com/aida-public/AB6AXuB67b9MYgTLA9wMNy5O-9w6TkEnA6ohATQiH43KYlSlPAmDtbLTXu9B57WwqylRdCzHjZg7YF4bb-q7SJupFjxrp4FuawKotOYM7BPa42N5RxpxS7h6YusSVGHIhzMc89oCMmGfcZMwM64SG8vYil6uUlaDoMhfxkJZwyGiNg29r65HN9Ey3IEqYnmf_CSs1nLyHBOFCOiM9-yjTVs48R71yCk3d9Uzal8zzuTfeK8',
    ctaPrimaryText: 'Konsultasi & Asesmen TW',
    ctaFocusWord: 'Berbicara',
    specs: [
      { icon: 'schedule', label: 'Durasi Sesi', value: '45 - 60 Menit', bgClass: 'spec-bg-blue' },
      { icon: 'person', label: 'Pendekatan', value: '1-on-1 Individual', bgClass: 'spec-bg-green' },
      { icon: 'face', label: 'Rekomendasi', value: '1.5 - 12 Tahun', bgClass: 'spec-bg-orange' },
      { icon: 'verified_user', label: 'Kualifikasi', value: 'A.Md.TW / S.Tr.Kes', bgClass: 'spec-bg-blue' }
    ],
    indicationsDesc: 'Setiap anak berkembang dengan ritmenya sendiri, namun keterlambatan bicara membutuhkan intervensi sedini mungkin untuk mencegah hambatan akademis dan sosial di masa depan.',
    indications: [
      {
        icon: 'timer',
        iconBg: 'ind-icon-blue',
        title: 'Speech Delay (Keterlambatan Bicara)',
        desc: 'Belum mengucap kata bermakna (seperti "mama", "papa", "mau") pada rentang usia 18–24 bulan atau minim respon saat diajak interaksi verbal.',
        age: '18 - 24 Bulan'
      },
      {
        icon: 'mic_off',
        iconBg: 'ind-icon-green',
        title: 'Kesulitan Artikulasi (Bicara Cadel / Pelo)',
        desc: 'Bunyi huruf sering tertukar atau dihilangkan (misal: "makan" jadi "atan", "lari" jadi "yayi") sehingga ucapan sulit dimengerti orang di luar rumah.',
        age: '3 - 6 Tahun'
      },
      {
        icon: 'format_list_bulleted',
        iconBg: 'ind-icon-orange',
        title: 'Kosakata Terbatas (Bahasa Ekspresif)',
        desc: 'Kesulitan merangkai dua kata atau lebih dalam satu kalimat sederhana dan cenderung berkomunikasi dengan menarik tangan atau menunjuk semata.',
        age: '2 - 4 Tahun'
      },
      {
        icon: 'hearing',
        iconBg: 'ind-icon-teal',
        title: 'Gangguan Bahasa Reseptif (Pemahaman)',
        desc: 'Kesulitan mencerna atau mematuhi instruksi dua langkah (contoh: "Ambil bola lalu berikan ke Ayah") serta tampak tidak memahami pertanyaan mendasar.',
        age: '2 - 5 Tahun'
      },
      {
        icon: 'graphic_eq',
        iconBg: 'ind-icon-blue',
        title: 'Gangguan Kelancaran (Gagap / Stuttering)',
        desc: 'Terdapat pengulangan suku kata awal, pemanjangan bunyi, atau jeda tersendat yang disertai ketegangan otot wajah saat anak hendak bertutur.',
        age: '3 - 10 Tahun'
      },
      {
        icon: 'restaurant',
        iconBg: 'ind-icon-green',
        title: 'Hambatan Oral Motor & Makan',
        desc: 'Kesulitan mengunyah tekstur padat, sering tersedak, mengeluarkan air liur (ngeces) berlebih di atas usia wajar, atau otot lidah/bibir yang lemah.',
        age: '1.5 - 7 Tahun'
      }
    ],
    pillars: [
      {
        icon: 'spatial_audio_off',
        bgClass: 'pillar-bg-blue',
        title: 'Artikulasi & Kejelasan Bicara',
        desc: "Melatih ketepatan posisi organ artikulator (lidah, gigi, bibir, langit-langit) untuk memproduksi fonem vokal dan konsonan yang benar. Mengeliminasi substitusi bunyi (seperti 'r' menjadi 'l' atau 'k' menjadi 't') melalui kartu fonetik dan cermin artikulasi.",
        bullets: [
          'Stimulasi fonem terisolasi hingga kalimat utuh',
          'Visual biofeedback menggunakan cermin terapi'
        ]
      },
      {
        icon: 'menu_book',
        bgClass: 'pillar-bg-green',
        title: 'Bahasa Reseptif & Ekspresif',
        desc: 'Memperkaya perbendaharaan kosa kata (kata benda, kata kerja, sifat), meningkatkan daya serap terhadap perintah bertingkat, serta melatih kemampuan anak dalam mengekspresikan kebutuhan, emosi, dan ide secara terstruktur.',
        bullets: [
          'Media permainan simbolik & buku cerita interaktif',
          'Struktur kalimat S-P-O-K ramah anak'
        ]
      },
      {
        icon: 'sentiment_very_satisfied',
        bgClass: 'pillar-bg-orange',
        title: 'Oral Motor Placement Therapy',
        desc: 'Terapi motorik oral untuk menguatkan tonus otot rahang, bibir, pipi, dan lidah. Sangat penting bagi anak dengan hipotonus, kesulitan mengunyah makanan keras, sering mengeces (drooling), atau kelemahan gerak bibir saat bicara.',
        bullets: [
          'Latihan meniup peluit terapeutik, sedotan graduated, dan chewy tubes',
          'Pijat stimulasi taktil intra-oral & ekstra-oral yang higienis'
        ]
      },
      {
        icon: 'groups',
        bgClass: 'pillar-bg-teal',
        title: 'Pragmatik & Komunikasi Sosial',
        desc: 'Bicara bukan sekadar mengeluarkan bunyi, melainkan kemampuan terhubung dengan manusia lain. Kami membimbing anak memahami giliran bicara (turn-taking), membaca ekspresi teman sebaya, kontak mata hangat, dan menyapa secara spontan.',
        bullets: [
          'Role-play sosial interaktif bersama terapis',
          'Transisi kesiapan interaksi di sekolah reguler / inklusi'
        ]
      }
    ],
    processSteps: [
      {
        number: '01',
        numBgClass: 'num-blue',
        badge: 'Sesi 60 Menit',
        badgeBgClass: 'badge-blue',
        title: 'Asesmen Klinis Awal',
        desc: 'Terapis wicara melakukan skrining menyeluruh pada anatomi organ wicara, refleks oral motor, usia pemahaman bahasa (reseptif), dan kemampuan ekspresif.',
        footerIcon: 'assignment',
        footerText: 'Output: Laporan Diagnostik'
      },
      {
        number: '02',
        numBgClass: 'num-primary-cont',
        badge: 'Kolaborasi Ortu',
        badgeBgClass: 'badge-green',
        title: 'Penyusunan Program (IEP)',
        desc: 'Merumuskan sasaran target jangka pendek dan panjang (Individualized Education/Therapy Plan) yang realistis berdasarkan kebutuhan unik anak.',
        footerIcon: 'track_changes',
        footerText: 'Target Capaian 3 Bulan'
      },
      {
        number: '03',
        numBgClass: 'num-green',
        badge: '1 - 2x Seminggu',
        badgeBgClass: 'badge-orange',
        title: 'Sesi Terapi 1-on-1 Intensif',
        desc: 'Sesi privat interaktif dengan terapis terdedikasi. Memadukan stimulasi oral motor, fonetik, dan bermain peran yang menyenangkan.',
        footerIcon: 'toys',
        footerText: 'Alat Stimulasi Steril'
      },
      {
        number: '04',
        numBgClass: 'num-dark-blue',
        badge: 'Evaluasi Rutin',
        badgeBgClass: 'badge-blue',
        title: 'Home Program & Laporan',
        desc: 'Orang tua mendapatkan instruksi stimulasi harian di rumah, didukung buku komunikasi berkala serta evaluasi perkembangan bulanan.',
        footerIcon: 'family_restroom',
        footerText: 'Rapor Perkembangan'
      }
    ],
    therapists: [
      {
        name: 'Nabila Maharani, S.Tr.Kes',
        role: 'Spesialis Terapi Wicara & Bahasa Anak',
        bio: 'Fokus pada penanganan Speech Delay, Gangguan Fonologi, dan Stimulasi Bahasa Balita. Berpengalaman 6+ tahun menangani kasus keterlambatan bicara.',
        cert: 'Alumni Poltekkes Jakarta',
        rating: '4.9 (120+ Sesi)',
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAf4OVUo-Wxnq8f6xSABM4mGtVxKAMm7lICIoE-PAxYxAZi_WeX9xbdVYLOIjzYftHDfEytV-2fKTnkbwLfFeFxQhERvsIwEIwli4j-NnHuby3Z4nZIptqt_qejl-BUIf2bOej8oKcP5I91K6rBDTT3Y_dcU9uGgiexN7tPlJ3Rl4hy_RT46xH8h_J4kmToqINJ4tSlKYrmbz3NaTyHUwpZhBG53oHWwMDE4iKDYXM'
      },
      {
        name: 'Rizky Adiputra, A.Md.TW',
        role: 'Spesialis Artikulasi & Oral Motor Placement',
        bio: 'Keahlian khusus pada stimulasi otot oral motor, penanganan cadel/pelo, feeding difficulties, dan kelancaran bicara (stuttering).',
        cert: 'Sertifikasi OPT Level 2',
        rating: '4.95 (95+ Sesi)',
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCIKvDfJPyVbIyPla4wyzxNhLrF8Ce1fVTVaOqumdJmrh2Bk8V7oAZmxceDSGifuQqVl1kki4aGpoTx11e5k91D13E3IbOLK8wQjn1WI_Sl-7zRbNYinsXJ3V2vevUjDzfQnwz96Sj-elpEFz1TGMDkGcogynWSoUS19_F-iFSPo0EzFQKVk3iSrq6SDGNB96CrjY8D4dfGTmV7xw7183jxJQ6xTu9aQJYX-uGTcYA'
      },
      {
        name: 'Dian Safitri, S.Tr.Kes',
        role: 'Spesialis Pragmatik & Komunikasi Inklusi',
        bio: 'Fokus mendampingi komunikasi anak dengan spektrum autisme, ADHD, dan kesiapan komunikasi verbal menjelang masuk sekolah formal.',
        cert: 'Pengalaman 8+ Tahun',
        rating: '5.0 (150+ Sesi)',
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuB9TdTX3hAv4l3XEhF6RnRoVq9SrEZWWigruM-Zmmi35kXtkmTMve9H7N1-RIYg5jM937Tx9sEWQyzXR66Neo9Sa7776w3Zo6VajIJukCAkN8s151ZqH9c7PF-4nlF1-SVkqD1DZB7BwB9tpZaUcpcSsq9obGxkdggEXSE_IuVRlN-Fsh23JI2d9iMF_qq9LXNCduvqstqvjnXBb1KvcBfZ0q46z2EUUUP0j15K0do'
      }
    ],
    packages: [
      {
        tag: 'Langkah Wajib',
        tagClass: 'tag-blue',
        title: 'Asesmen Awal & Konsultasi',
        subtitle: 'Pemeriksaan komprehensif tingkat kemampuan bahasa dan organ wicara.',
        priceLabel: 'Mulai dari',
        price: 'Rp 300.000',
        unit: 'sesi',
        features: [
          'Durasi 60 menit tatap muka terapis',
          'Pemeriksaan artikulasi & oral motor',
          'Laporan hasil asesmen tertulis resmi',
          'Rancangan IEP target awal'
        ],
        buttonText: 'Pilih Jadwal Asesmen',
        isPopular: false
      },
      {
        tag: 'Paket 4 Sesi',
        tagClass: 'tag-green',
        title: 'Paket Terapi Intensif (4x)',
        subtitle: '1x sesi per minggu selama 1 bulan untuk penanganan berkelanjutan.',
        priceLabel: 'Total Investasi',
        price: 'Rp 850.000',
        unit: 'paket',
        savingNote: 'Hemat Rp 50.000 dari tarif per sesi',
        features: [
          '4 sesi terapi privat 1-on-1 (50 menit/sesi)',
          'Konsultasi perkembangan 10 menit pasca sesi',
          'Buku evaluasi perkembangan & home program',
          'Prioritas pemilihan jam & ruangan terapi'
        ],
        buttonText: 'Daftar Paket Terapi 4x',
        isPopular: true
      },
      {
        tag: 'Paket 8 Sesi',
        tagClass: 'tag-orange',
        title: 'Paket Optimal (8x)',
        subtitle: '2x sesi per minggu untuk akselerasi hasil bicara lebih cepat.',
        priceLabel: 'Total Investasi',
        price: 'Rp 1.600.000',
        unit: 'paket',
        savingNote: 'Hemat Rp 200.000 + Bebas Reschedule',
        features: [
          '8 sesi terapi privat 1-on-1 intensif',
          'Evaluasi tengah periode bersama Lead Therapist',
          'Laporan perkembangan bulanan terinci',
          'Fleksibilitas jadwal jika si kecil berhalangan'
        ],
        buttonText: 'Pilih Paket 8 Sesi',
        isPopular: false
      }
    ],
    faqs: [
      {
        q: 'Berapa lama terapi biasanya mulai menunjukkan hasil?',
        a: 'Setiap anak memiliki respons yang unik tergantung usia, keparahan diagnosis, dan konsistensi stimulasi di rumah. Rata-rata kemajuan awal (seperti meningkatnya kontak mata, bertambahnya 5–10 kata baru, atau kepatuhan instruksi) terlihat dalam 8–12 sesi terapi berkala dengan penerapan panduan home program secara aktif.'
      },
      {
        q: 'Apakah orang tua diperbolehkan mendampingi di dalam ruang terapi?',
        a: 'Pada 1–2 sesi pertama untuk fase adaptasi dan asesmen, satu orang tua sangat dianjurkan hadir di ruangan agar anak merasa nyaman. Selanjutnya, demi melatih kemandirian dan fokus anak dengan terapis, orang tua dapat memantau melalui area tunggu atau bergabung di 10 menit terakhir untuk edukasi stimulasi rumah.'
      },
      {
        q: 'Apa perbedaan antara Speech Delay biasa dengan kondisi Spektrum Autisme?',
        a: 'Anak dengan speech delay murni umumnya tetap memiliki keinginan berkomunikasi non-verbal yang baik (menggunakan gestur, kontak mata hangat, menunjuk objek yang diinginkan). Sementara pada spektrum autisme, keterlambatan bicara kerap disertai kesulitan interaksi sosial timbal balik, minim kontak mata, perilaku repetitif, atau hipersensitivitas sensori. Asesmen awal di klinik kami akan memetakan hal ini secara akurat.'
      },
      {
        q: 'Apakah anak yang sering \'ngeces\' dan sulit mengunyah perlu Terapi Wicara?',
        a: 'Ya, benar. Kemampuan mengunyah, menelan, dan menahan air liur dikendalikan oleh otot organ yang sama dengan produksi suara. Terapis wicara kami tersertifikasi dalam Oral Motor Placement Therapy untuk menguatkan kontrol rahang, bibir, dan lidah anak.'
      }
    ]
  },

  'terapi-okupasi': {
    code: 'TO',
    name: 'Terapi Okupasi (TO)',
    shortName: 'Terapi Okupasi',
    badgeIcon: 'accessibility_new',
    categoryBadge: 'Program Spesialisasi Klinis • Terapi Okupasi (TO)',
    titleMain: 'Terapi Okupasi & Kemandirian Anak',
    titleAccent: '(Occupational Therapy)',
    heroDesc: 'Mendukung kemandirian anak dalam aktivitas sehari-hari (ADL), penguatan motorik halus, koordinasi bilateral, koordinasi visual motorik, serta fokus belajar di sekolah.',
    heroImage: 'https://lh3.googleusercontent.com/aida-public/AB6AXuB67b9MYgTLA9wMNy5O-9w6TkEnA6ohATQiH43KYlSlPAmDtbLTXu9B57WwqylRdCzHjZg7YF4bb-q7SJupFjxrp4FuawKotOYM7BPa42N5RxpxS7h6YusSVGHIhzMc89oCMmGfcZMwM64SG8vYil6uUlaDoMhfxkJZwyGiNg29r65HN9Ey3IEqYnmf_CSs1nLyHBOFCOiM9-yjTVs48R71yCk3d9Uzal8zzuTfeK8',
    ctaPrimaryText: 'Konsultasi & Asesmen TO',
    ctaFocusWord: 'Mandiri',
    specs: [
      { icon: 'schedule', label: 'Durasi Sesi', value: '45 - 60 Menit', bgClass: 'spec-bg-blue' },
      { icon: 'person', label: 'Pendekatan', value: '1-on-1 Individual', bgClass: 'spec-bg-green' },
      { icon: 'face', label: 'Rekomendasi', value: '2 - 12 Tahun', bgClass: 'spec-bg-orange' },
      { icon: 'verified_user', label: 'Kualifikasi', value: 'A.Md.OT / S.Tr.Kes', bgClass: 'spec-bg-blue' }
    ],
    indicationsDesc: 'Kemandirian motorik halus dan koordinasi tubuh sangat esensial bagi kesiapan sekolah dan kepercayaan diri anak dalam berinteraksi.',
    indications: [
      {
        icon: 'pan_tool',
        iconBg: 'ind-icon-green',
        title: 'Kelemahan Motorik Halus',
        desc: 'Kesulitan menggenggam pensil, memegang sendok, menggunting kertas, atau meronce manik-manik secara terarah.',
        age: '2 - 6 Tahun'
      },
      {
        icon: 'dry_cleaning',
        iconBg: 'ind-icon-blue',
        title: 'Hambatan Kemandirian Harian (ADL)',
        desc: 'Belum mampu memakai baju berkancing, mengikat tali sepatu, membuka ritsleting, atau makan sendiri tanpa bantuan penuh.',
        age: '3 - 7 Tahun'
      },
      {
        icon: 'draw',
        iconBg: 'ind-icon-orange',
        title: 'Kesiapan Pra-Menulis Rendah',
        desc: 'Cepat lelah saat menulis, tulisan tidak beraturan keluar garis, atau genggaman pensil yang belum matang (palmar grasp).',
        age: '4 - 8 Tahun'
      },
      {
        icon: 'accessibility',
        iconBg: 'ind-icon-teal',
        title: 'Koordinasi Bilateral Terganggu',
        desc: 'Kesulitan mengkoordinasikan kedua sisi tubuh bersamaan (misal: menahan kertas dengan satu tangan saat tangan lain menggunting).',
        age: '3 - 6 Tahun'
      },
      {
        icon: 'visibility',
        iconBg: 'ind-icon-blue',
        title: 'Diskriminasi Visual Spasial',
        desc: 'Sering tertukar orientasi huruf (b/d, p/q) atau sulit meniru pola gambar dan susunan balok sederhana.',
        age: '4 - 9 Tahun'
      },
      {
        icon: 'self_improvement',
        iconBg: 'ind-icon-green',
        title: 'Ketahanan Duduk & Konsentrasi',
        desc: 'Anak gelisah tidak bisa duduk tenang selama 10-15 menit saat mengerjakan tugas meja (task avoidance).',
        age: '3 - 8 Tahun'
      }
    ],
    pillars: [
      {
        icon: 'draw',
        bgClass: 'pillar-bg-green',
        title: 'Motorik Halus & Grafomotor',
        desc: 'Melatih kekuatan otot intrinsik telapak tangan, jari-jemari, dan stabilitas pergelangan tangan untuk kesiapan menulis dan menggambar.',
        bullets: ['Penguatan genggaman pincer grasp', 'Stimulasi playdough terapeutik & clay']
      },
      {
        icon: 'check_room',
        bgClass: 'pillar-bg-blue',
        title: 'Kemandirian Aktivitas Harian (ADL)',
        desc: 'Mengajarkan langkah bertahap memakai pakaian, mengancingkan baju, makan mandiri, dan menjaga kebersihan diri.',
        bullets: ['Metode backward chaining ramah anak', 'Adaptasi alat bantu makan jika dibutuhkan']
      },
      {
        icon: 'extension',
        bgClass: 'pillar-bg-orange',
        title: 'Koordinasi Visual-Motorik',
        desc: 'Mengintegrasikan kemampuan visual mata dan ketangkasan gerak tangan untuk menyusun puzzle, menggunting, dan menjiplak bentuk.',
        bullets: ['Latihan tracing presisi bertahap', 'Eksplorasi balok dan konstruksi spasial']
      },
      {
        icon: 'psychology',
        bgClass: 'pillar-bg-teal',
        title: 'Regulasi Diri & Perilaku Adaptif',
        desc: 'Membimbing anak mengelola energi tubuh agar mampu memfokuskan perhatian pada instruksi dan tugas terstruktur.',
        bullets: ['Sensory break yang terjadwal', 'Penguatan postur duduk ergonomis']
      }
    ],
    processSteps: [
      {
        number: '01',
        numBgClass: 'num-green',
        badge: 'Sesi 60 Menit',
        badgeBgClass: 'badge-green',
        title: 'Asesmen Motorik & ADL',
        desc: 'Pemeriksaan komprehensif tonus otot, fleksibilitas sendi, ketangkasan motorik halus, dan kemandirian sehari-hari.',
        footerIcon: 'assignment',
        footerText: 'Output: Analisis Fungsional'
      },
      {
        number: '02',
        numBgClass: 'num-primary-cont',
        badge: 'Target Individual',
        badgeBgClass: 'badge-blue',
        title: 'Rancangan Program IEP',
        desc: 'Menetapkan target kemandirian konkret yang relevan dengan rutinitas anak di rumah dan sekolah.',
        footerIcon: 'track_changes',
        footerText: 'Target Capaian 3 Bulan'
      },
      {
        number: '03',
        numBgClass: 'num-blue',
        badge: '1 - 2x Seminggu',
        badgeBgClass: 'badge-orange',
        title: 'Sesi Terapi Fungsional',
        desc: 'Latihan 1-on-1 dengan media edukasi dan peralatan terapi okupasi bersertifikasi ramah anak.',
        footerIcon: 'toys',
        footerText: 'Peralatan Steril & Aman'
      },
      {
        number: '04',
        numBgClass: 'num-dark-blue',
        badge: 'Evaluasi Rutin',
        badgeBgClass: 'badge-blue',
        title: 'Home Program & Evaluasi',
        desc: 'Instruksi panduan aktivitas motorik yang dapat dipraktikkan orang tua di rumah setiap hari.',
        footerIcon: 'family_restroom',
        footerText: 'Laporan Kemandirian'
      }
    ],
    therapists: [
      {
        name: 'Rahmat Hidayat, S.Tr.Kes',
        role: 'Spesialis Terapi Okupasi Pediatrik',
        bio: 'Berpengalaman 7+ tahun dalam menstimulasi keterampilan motorik halus, grafomotor, dan kemandirian harian anak berkebutuhan khusus.',
        cert: 'Alumni Poltekkes Surakarta',
        rating: '4.95 (110+ Sesi)',
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCIKvDfJPyVbIyPla4wyzxNhLrF8Ce1fVTVaOqumdJmrh2Bk8V7oAZmxceDSGifuQqVl1kki4aGpoTx11e5k91D13E3IbOLK8wQjn1WI_Sl-7zRbNYinsXJ3V2vevUjDzfQnwz96Sj-elpEFz1TGMDkGcogynWSoUS19_F-iFSPo0EzFQKVk3iSrq6SDGNB96CrjY8D4dfGTmV7xw7183jxJQ6xTu9aQJYX-uGTcYA'
      },
      {
        name: 'Siti Nurhaliza, A.Md.OT',
        role: 'Spesialis ADL & Grafomotor Anak',
        bio: 'Fokus pada kesiapan pra-sekolah, penanganan hipotonia otot tangan, serta kemandirian berpakaian dan makan mandiri.',
        cert: 'Sertifikasi Hand Rehabilitation',
        rating: '4.9 (85+ Sesi)',
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAf4OVUo-Wxnq8f6xSABM4mGtVxKAMm7lICIoE-PAxYxAZi_WeX9xbdVYLOIjzYftHDfEytV-2fKTnkbwLfFeFxQhERvsIwEIwli4j-NnHuby3Z4nZIptqt_qejl-BUIf2bOej8oKcP5I91K6rBDTT3Y_dcU9uGgiexN7tPlJ3Rl4hy_RT46xH8h_J4kmToqINJ4tSlKYrmbz3NaTyHUwpZhBG53oHWwMDE4iKDYXM'
      },
      {
        name: 'Anisa Rahmawati, S.Tr.Kes',
        role: 'Spesialis Visual Motor & Play Therapy',
        bio: 'Mendampingi anak dengan ADHD dan disgrafia untuk mencapai kemandirian belajar dan ketahanan fokus saat mengerjakan tugas.',
        cert: 'Pengalaman 5+ Tahun',
        rating: '4.98 (90+ Sesi)',
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuB9TdTX3hAv4l3XEhF6RnRoVq9SrEZWWigruM-Zmmi35kXtkmTMve9H7N1-RIYg5jM937Tx9sEWQyzXR66Neo9Sa7776w3Zo6VajIJukCAkN8s151ZqH9c7PF-4nlF1-SVkqD1DZB7BwB9tpZaUcpcSsq9obGxkdggEXSE_IuVRlN-Fsh23JI2d9iMF_qq9LXNCduvqstqvjnXBb1KvcBfZ0q46z2EUUUP0j15K0do'
      }
    ],
    packages: [
      {
        tag: 'Langkah Wajib',
        tagClass: 'tag-blue',
        title: 'Asesmen Awal & Konsultasi TO',
        subtitle: 'Pemeriksaan detail motorik halus, kekuatan cengkeraman, dan kemampuan ADL.',
        priceLabel: 'Mulai dari',
        price: 'Rp 300.000',
        unit: 'sesi',
        features: [
          'Durasi 60 menit observasi fungsional',
          'Pemeriksaan grafomotor & integrasi motorik',
          'Laporan hasil asesmen tertulis',
          'Penyusunan target prioritas IEP'
        ],
        buttonText: 'Pilih Jadwal Asesmen',
        isPopular: false
      },
      {
        tag: 'Paket 4 Sesi',
        tagClass: 'tag-green',
        title: 'Paket Terapi Intensif (4x)',
        subtitle: '1x per minggu untuk melatih koordinasi dan stimulasi otot secara berkelanjutan.',
        priceLabel: 'Total Investasi',
        price: 'Rp 850.000',
        unit: 'paket',
        savingNote: 'Hemat Rp 50.000 dari tarif per sesi',
        features: [
          '4 sesi terapi privat 1-on-1 (50 menit/sesi)',
          'Konsultasi edukasi orang tua 10 menit',
          'Buku monitoring kemandirian di rumah',
          'Prioritas slot jadwal pagi/sore'
        ],
        buttonText: 'Daftar Paket Terapi 4x',
        isPopular: true
      },
      {
        tag: 'Paket 8 Sesi',
        tagClass: 'tag-orange',
        title: 'Paket Optimal (8x)',
        subtitle: '2x per minggu untuk percepatan kemandirian pra-sekolah.',
        priceLabel: 'Total Investasi',
        price: 'Rp 1.600.000',
        unit: 'paket',
        savingNote: 'Hemat Rp 200.000 + Bebas Reschedule',
        features: [
          '8 sesi terapi okupasi privat terpadu',
          'Evaluasi capaian bulanan oleh Lead Therapist',
          'Laporan perkembangan terperinci',
          'Fleksibilitas reschedule jadwal'
        ],
        buttonText: 'Pilih Paket 8 Sesi',
        isPopular: false
      }
    ],
    faqs: [
      {
        q: 'Apa perbedaan Terapi Okupasi dengan Terapi Wicara?',
        a: 'Terapi Wicara berfokus pada organ wicara, artikulasi, dan pemahaman bahasa. Sedangkan Terapi Okupasi berfokus pada motorik halus, koordinasi tubuh, ketahanan fokus tugas meja, serta kemampuan merawat diri sendiri (makan, memakai baju, menulis).'
      },
      {
        q: 'Berapa usia ideal anak memulai Terapi Okupasi?',
        a: 'Terapi Okupasi dapat dimulai sejak usia 1.5 tahun jika terdeteksi keterlambatan motorik halus, hingga usia sekolah dasar untuk mengatasi hambatan menulis dan konsentrasi.'
      },
      {
        q: 'Apakah Terapi Okupasi bisa membantu anak yang tidak mau diam?',
        a: 'Bisa. Terapis okupasi akan menilai apakah ketidakmampuan diam disebabkan oleh kebutuhan stimulasi propioseptif/vestibular atau kelemahan postur tubuh, lalu memberikan intervensi yang menenangkan sistem saraf anak.'
      },
      {
        q: 'Bagaimana peran orang tua dalam keberhasilan Terapi Okupasi?',
        a: 'Sangat besar. Terapis akan memberikan panduan aktivitas sederhana di rumah seperti memeras spons, meronce, dan memberi kesempatan anak makan sendiri tanpa disuapi untuk mempercepat capaian target.'
      }
    ]
  },

  'sensori-integrasi': {
    code: 'SI',
    name: 'Sensori Integrasi (SI)',
    shortName: 'Sensori Integrasi',
    badgeIcon: 'sports_gymnastics',
    categoryBadge: 'Program Spesialisasi Klinis • Sensori Integrasi (SI)',
    titleMain: 'Sensori Integrasi & Regulasi Anak',
    titleAccent: '(Sensory Integration)',
    heroDesc: 'Membantu anak memproses dan merespons rangsangan sensorik secara seimbang, melatih keseimbangan vestibular, stimulasi propioseptif, dan regulasi emosi.',
    heroImage: 'https://lh3.googleusercontent.com/aida-public/AB6AXuB67b9MYgTLA9wMNy5O-9w6TkEnA6ohATQiH43KYlSlPAmDtbLTXu9B57WwqylRdCzHjZg7YF4bb-q7SJupFjxrp4FuawKotOYM7BPa42N5RxpxS7h6YusSVGHIhzMc89oCMmGfcZMwM64SG8vYil6uUlaDoMhfxkJZwyGiNg29r65HN9Ey3IEqYnmf_CSs1nLyHBOFCOiM9-yjTVs48R71yCk3d9Uzal8zzuTfeK8',
    ctaPrimaryText: 'Konsultasi & Asesmen SI',
    ctaFocusWord: 'Tenang & Fokus',
    specs: [
      { icon: 'schedule', label: 'Durasi Sesi', value: '45 - 60 Menit', bgClass: 'spec-bg-blue' },
      { icon: 'person', label: 'Pendekatan', value: '1-on-1 Individual', bgClass: 'spec-bg-green' },
      { icon: 'face', label: 'Rekomendasi', value: '1.5 - 10 Tahun', bgClass: 'spec-bg-orange' },
      { icon: 'verified_user', label: 'Kualifikasi', value: 'Praktisi SI Tersertifikasi', bgClass: 'spec-bg-blue' }
    ],
    indicationsDesc: 'Otak anak memerlukan pengolahan input sensorik yang seimbang agar dapat merespons lingkungan secara tenang, terarah, dan adaptif.',
    indications: [
      {
        icon: 'volume_off',
        iconBg: 'ind-icon-orange',
        title: 'Hipersensitivitas Suara / Tekstur',
        desc: 'Menutup telinga berlebihan pada suara blender/vacuum cleaner, atau menolak memakai pakaian berlabel dan menginjak rumput.',
        age: '2 - 7 Tahun'
      },
      {
        icon: 'directions_run',
        iconBg: 'ind-icon-blue',
        title: 'Pencari Sensori (Sensory Seeking)',
        desc: 'Terus bergerak, suka menabrakkan badan ke sofa, melompat tanpa lelah, atau suka berputar kencang tanpa merasa pusing.',
        age: '2 - 8 Tahun'
      },
      {
        icon: 'mood_bad',
        iconBg: 'ind-icon-green',
        title: 'Tantrum Akibat Sensoric Overload',
        desc: 'Mudah kewalahan emosi di tempat ramai, mall, atau ruangan dengan banyak stimulasi visual dan auditori.',
        age: '2 - 6 Tahun'
      },
      {
        icon: 'skateboarding',
        iconBg: 'ind-icon-teal',
        title: 'Keseimbangan Tubuh Lemah',
        desc: 'Mudah tersandung dan jatuh saat berjalan di permukaan datar, takut saat kaki terangkat dari lantai (gravitational insecurity).',
        age: '2 - 7 Tahun'
      },
      {
        icon: 'touch_app',
        iconBg: 'ind-icon-blue',
        title: 'Hambatan Modulasi Taktil',
        desc: 'Menolak menyentuh tekstur basah, lengket, pasir, cat air, atau sangat selektif terhadap tekstur makanan (picky eater).',
        age: '1.5 - 6 Tahun'
      },
      {
        icon: 'center_focus_strong',
        iconBg: 'ind-icon-orange',
        title: 'Fokus & Atensi Singkat',
        desc: 'Sangat mudah terdistraksi oleh gerakan kecil atau suara di sekitar sehingga kesulitan menyelesaikan satu aktivitas sederhana.',
        age: '3 - 8 Tahun'
      }
    ],
    pillars: [
      {
        icon: 'airline_seat_recline_extra',
        bgClass: 'pillar-bg-orange',
        title: 'Stimulasi Sistem Vestibular',
        desc: 'Melatih keseimbangan dan orientasi spasial melalui ayunan terapeutik, papan titian, dan trampolin dengan pengawasan aman.',
        bullets: ['Penguatan rasa aman gravitasi', 'Stimulasi kanal semisirkularis telinga dalam']
      },
      {
        icon: 'fitness_center',
        bgClass: 'pillar-bg-blue',
        title: 'Input Propioseptif (Heavy Work)',
        desc: 'Aktivitas otot dan sendi seperti mendorong balok empuk, merangkak di terowongan, dan memanjat untuk menenangkan sistem saraf.',
        bullets: ['Regulasi kesadaran posisi tubuh', 'Pemberian beban pas (deep pressure input)']
      },
      {
        icon: 'soap',
        bgClass: 'pillar-bg-green',
        title: 'Desensitisasi & Modulasi Taktil',
        desc: 'Eksplorasi sensorik bertahap terhadap beragam tekstur kering, basah, lembut, hingga kasar menggunakan sensory bin.',
        bullets: ['Pendekatan tanpa paksaan (child-led)', 'Peningkatan toleransi sentuhan kulit']
      },
      {
        icon: 'self_improvement',
        bgClass: 'pillar-bg-teal',
        title: 'Regulasi Diri (Self-Regulation)',
        desc: 'Membimbing anak mengenali sinyal tubuh dan menemukan strategi menenangkan diri (calming strategies) saat mulai gelisah.',
        bullets: ['Zona regulasi emosi ramah anak', 'Sensory diet yang dapat dipraktikkan di rumah']
      }
    ],
    processSteps: [
      {
        number: '01',
        numBgClass: 'num-orange',
        badge: 'Sesi 60 Menit',
        badgeBgClass: 'badge-orange',
        title: 'Sensory Profile Assessment',
        desc: 'Analisis mendalam profil sensorik anak menggunakan kuesioner baku dan observasi langsung di sensory gym.',
        footerIcon: 'assignment',
        footerText: 'Output: Peta Profil Sensori'
      },
      {
        number: '02',
        numBgClass: 'num-primary-cont',
        badge: 'Rancangan Diet',
        badgeBgClass: 'badge-blue',
        title: 'Penyusunan Sensory Diet',
        desc: 'Merancang kombinasi stimulasi sensori terukur yang sesuai dengan ambang batas (threshold) anak.',
        footerIcon: 'track_changes',
        footerText: 'Target Regulasi 3 Bulan'
      },
      {
        number: '03',
        numBgClass: 'num-green',
        badge: '1 - 2x Seminggu',
        badgeBgClass: 'badge-green',
        title: 'Sesi Sensori Gym Aktif',
        desc: 'Sesi 1-on-1 di ruang Sensori Integrasi berstandar klinis dengan ayunan, matras, dan media taktil lengkap.',
        footerIcon: 'toys',
        footerText: 'Sensory Gym Aman & Teruji'
      },
      {
        number: '04',
        numBgClass: 'num-dark-blue',
        badge: 'Evaluasi Rutin',
        badgeBgClass: 'badge-blue',
        title: 'Panduan Regulasi di Rumah',
        desc: 'Orang tua mendapatkan panduan aktivitas harian untuk menjaga keseimbangan sensorik anak di lingkungan keluarga.',
        footerIcon: 'family_restroom',
        footerText: 'Rapor Perkembangan Regulasi'
      }
    ],
    therapists: [
      {
        name: 'Bayu Prasetyo, S.Tr.Kes',
        role: 'Spesialis Sensori Integrasi & Vestibular',
        bio: 'Berpengalaman 6+ tahun dalam menangani sensory modulation disorder, gravitational insecurity, dan anak hipo/hipersensitif.',
        cert: 'Sertifikasi Ayres Sensory Integration',
        rating: '4.96 (130+ Sesi)',
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCIKvDfJPyVbIyPla4wyzxNhLrF8Ce1fVTVaOqumdJmrh2Bk8V7oAZmxceDSGifuQqVl1kki4aGpoTx11e5k91D13E3IbOLK8wQjn1WI_Sl-7zRbNYinsXJ3V2vevUjDzfQnwz96Sj-elpEFz1TGMDkGcogynWSoUS19_F-iFSPo0EzFQKVk3iSrq6SDGNB96CrjY8D4dfGTmV7xw7183jxJQ6xTu9aQJYX-uGTcYA'
      },
      {
        name: 'Citra Amelia, A.Md.OT',
        role: 'Spesialis Modulasi Taktil & Regulasi Diri',
        bio: 'Fokus pada stimulasi taktil, penanganan picky eater berbasis sensori, dan pendampingan regulasi emosi anak balita.',
        cert: 'Pelatihan Sensory Play Pediatrik',
        rating: '4.9 (100+ Sesi)',
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAf4OVUo-Wxnq8f6xSABM4mGtVxKAMm7lICIoE-PAxYxAZi_WeX9xbdVYLOIjzYftHDfEytV-2fKTnkbwLfFeFxQhERvsIwEIwli4j-NnHuby3Z4nZIptqt_qejl-BUIf2bOej8oKcP5I91K6rBDTT3Y_dcU9uGgiexN7tPlJ3Rl4hy_RT46xH8h_J4kmToqINJ4tSlKYrmbz3NaTyHUwpZhBG53oHWwMDE4iKDYXM'
      },
      {
        name: 'Dian Safitri, S.Tr.Kes',
        role: 'Spesialis Integrasi Sensori & Komunikasi',
        bio: 'Pendekatan terpadu antara modulasi sensori dan kesiapan interaksi sosial bagi anak dengan autisme dan sensory seeking.',
        cert: 'Pengalaman 8+ Tahun',
        rating: '5.0 (150+ Sesi)',
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuB9TdTX3hAv4l3XEhF6RnRoVq9SrEZWWigruM-Zmmi35kXtkmTMve9H7N1-RIYg5jM937Tx9sEWQyzXR66Neo9Sa7776w3Zo6VajIJukCAkN8s151ZqH9c7PF-4nlF1-SVkqD1DZB7BwB9tpZaUcpcSsq9obGxkdggEXSE_IuVRlN-Fsh23JI2d9iMF_qq9LXNCduvqstqvjnXBb1KvcBfZ0q46z2EUUUP0j15K0do'
      }
    ],
    packages: [
      {
        tag: 'Langkah Wajib',
        tagClass: 'tag-blue',
        title: 'Asesmen Profil Sensori Awal',
        subtitle: 'Pemeriksaan pemrosesan 7 indra anak dan respons terhadap rangsangan fisik.',
        priceLabel: 'Mulai dari',
        price: 'Rp 300.000',
        unit: 'sesi',
        features: [
          'Durasi 60 menit observasi di Sensory Gym',
          'Analisis ambang batas rangsangan sensorik',
          'Laporan tertulis resmi Sensory Profile',
          'Rancangan sensory diet awal di rumah'
        ],
        buttonText: 'Pilih Jadwal Asesmen',
        isPopular: false
      },
      {
        tag: 'Paket 4 Sesi',
        tagClass: 'tag-green',
        title: 'Paket Terapi Intensif (4x)',
        subtitle: '1x per minggu untuk stabilisasi input sensorik dan pembiasaan regulasi.',
        priceLabel: 'Total Investasi',
        price: 'Rp 850.000',
        unit: 'paket',
        savingNote: 'Hemat Rp 50.000 dari tarif per sesi',
        features: [
          '4 sesi terapi privat 1-on-1 (50 menit/sesi)',
          'Edukasi strategi regulasi bagi orang tua',
          'Jurnal pemantauan stimulasi harian',
          'Akses ruangan sensory gym lengkap'
        ],
        buttonText: 'Daftar Paket Terapi 4x',
        isPopular: true
      },
      {
        tag: 'Paket 8 Sesi',
        tagClass: 'tag-orange',
        title: 'Paket Optimal (8x)',
        subtitle: '2x per minggu untuk adaptasi modulasi lebih cepat dan konsisten.',
        priceLabel: 'Total Investasi',
        price: 'Rp 1.600.000',
        unit: 'paket',
        savingNote: 'Hemat Rp 200.000 + Bebas Reschedule',
        features: [
          '8 sesi terapi sensori integrasi intensif',
          'Review tengah periode profil sensorik',
          'Laporan evaluasi modulasi bulanan',
          'Fleksibilitas jadwal jika anak lelah'
        ],
        buttonText: 'Pilih Paket 8 Sesi',
        isPopular: false
      }
    ],
    faqs: [
      {
        q: 'Apakah Sensori Integrasi hanya untuk anak dengan kebutuhan khusus?',
        a: 'Tidak. Banyak anak tipikal yang mengalami kesulitan modulasi sensori seperti takut ketinggian berlebih, mabuk perjalanan, pemilih makanan ekstrem, atau sangat gelisah saat belajar, yang sangat terbantu dengan Sensori Integrasi.'
      },
      {
        q: 'Apa yang terjadi di dalam ruang Sensori Integrasi?',
        a: 'Ruang SI dirancang dengan alas busa empuk, ayunan gantung terapeutik, trampolin, terowongan, kolam bola, dan sensory bins. Anak diajak beraktivitas menyenangkan yang secara sengaja menstimulasi vestibular, propioseptif, dan taktil mereka.'
      },
      {
        q: 'Bagaimana tanda bahwa anak mengalami sensory overload?',
        a: 'Tanda umumnya antara lain: menangis atau tantrum tiba-tiba tanpa sebab jelas di tempat ramai, menutup telinga/mata, menolak disentuh, atau justru bertingkah sangat liar dan tidak terkendali.'
      },
      {
        q: 'Berapa sesi terapi yang dibutuhkan sampai terlihat perubahan?',
        a: 'Biasanya dalam 8–12 sesi berkala, orang tua mulai melihat penurunan frekuensi tantrum akibat overload dan anak menjadi lebih tenang serta mampu memfokuskan perhatian lebih lama.'
      }
    ]
  },

  'psikologi-anak': {
    code: 'PSI',
    name: 'Psikologi Anak',
    shortName: 'Psikologi Anak',
    badgeIcon: 'psychology_alt',
    categoryBadge: 'Program Spesialisasi Klinis • Psikologi Anak',
    titleMain: 'Psikologi Perkembangan & Emosi Anak',
    titleAccent: '(Child Psychology)',
    heroDesc: 'Asesmen perkembangan holistik, tes IQ/kesiapan sekolah, konseling perilaku emosional anak, serta konsultasi parenting terpercaya bagi keluarga.',
    heroImage: 'https://lh3.googleusercontent.com/aida-public/AB6AXuB67b9MYgTLA9wMNy5O-9w6TkEnA6ohATQiH43KYlSlPAmDtbLTXu9B57WwqylRdCzHjZg7YF4bb-q7SJupFjxrp4FuawKotOYM7BPa42N5RxpxS7h6YusSVGHIhzMc89oCMmGfcZMwM64SG8vYil6uUlaDoMhfxkJZwyGiNg29r65HN9Ey3IEqYnmf_CSs1nLyHBOFCOiM9-yjTVs48R71yCk3d9Uzal8zzuTfeK8',
    ctaPrimaryText: 'Konsultasi & Asesmen Psikologi',
    ctaFocusWord: 'Berkembang Harmonis',
    specs: [
      { icon: 'schedule', label: 'Durasi Sesi', value: '50 - 60 Menit', bgClass: 'spec-bg-blue' },
      { icon: 'person', label: 'Pendekatan', value: 'Konseling & Tes Klinis', bgClass: 'spec-bg-green' },
      { icon: 'face', label: 'Rekomendasi', value: '2 - 14 Tahun', bgClass: 'spec-bg-orange' },
      { icon: 'verified_user', label: 'Kualifikasi', value: 'Psikolog Klinis S2 (SIPP)', bgClass: 'spec-bg-blue' }
    ],
    indicationsDesc: 'Kesehatan mental dan emosional adalah fondasi utama bagi tumbuh kembang kognitif serta karakter positif si Kecil.',
    indications: [
      {
        icon: 'sentiment_very_dissatisfied',
        iconBg: 'ind-icon-orange',
        title: 'Tantrum Berat & Agresivitas',
        desc: 'Sering meledak-ledak, memukul, melempar barang, atau melukai diri sendiri saat mengalami frustrasi atau keinginannya tidak terpenuhi.',
        age: '2 - 8 Tahun'
      },
      {
        icon: 'school',
        iconBg: 'ind-icon-blue',
        title: 'Keraguan Kesiapan Masuk SD',
        desc: 'Orang tua memerlukan asesmen psikologis untuk melihat kematangan kognitif, emosional, dan sosial anak menjelang masuk sekolah dasar.',
        age: '5 - 7 Tahun'
      },
      {
        icon: 'heart_broken',
        iconBg: 'ind-icon-green',
        title: 'Kecemasan Berpisah (Separation Anxiety)',
        desc: 'Menangis histeris berkepanjangan saat ditinggal orang tua di sekolah atau sangat takut menghadapi situasi baru.',
        age: '3 - 8 Tahun'
      },
      {
        icon: 'group_off',
        iconBg: 'ind-icon-teal',
        title: 'Hambatan Interaksi Sosial',
        desc: 'Menarik diri dari teman sebaya, sangat pemalu ekstrem, atau kesulitan membaca norma sosial saat bermain bersama.',
        age: '4 - 10 Tahun'
      },
      {
        icon: 'psychology',
        iconBg: 'ind-icon-blue',
        title: 'Kecurigaan ADHD / Spektrum Autisme',
        desc: 'Membutuhkan skrining diagnostik formal oleh psikolog klinis untuk mendapatkan diagnosa medis yang valid dan rujukan tepat.',
        age: '2 - 12 Tahun'
      },
      {
        icon: 'family_restroom',
        iconBg: 'ind-icon-green',
        title: 'Konsultasi Pola Asuh (Parenting)',
        desc: 'Ayah & Bunda memerlukan bimbingan strategi pola asuh positif, konsistensi disiplin, atau pendampingan sibling rivalry.',
        age: 'Semua Usia'
      }
    ],
    pillars: [
      {
        icon: 'psychology_alt',
        bgClass: 'pillar-bg-blue',
        title: 'Asesmen Psikologis & Tes IQ',
        desc: 'Pemeriksaan komprehensif kapasitas kognitif, bakat-minat, serta pemetaan profil kecerdasan anak menggunakan alat tes terstandar.',
        bullets: ['Tes Kesiapan Masuk Sekolah (NST)', 'Pemeriksaan inteligensi baku klinis']
      },
      {
        icon: 'sentiment_satisfied_alt',
        bgClass: 'pillar-bg-green',
        title: 'Konseling Emosi & Play Therapy',
        desc: 'Membantu anak mengekspresikan ketakutan, kecemasan, atau kemarahan melalui media bermain simbolik dan gambar terarah.',
        bullets: ['Metode ramah anak tanpa tekanan', 'Pengenalan nama-nama emosi dasar']
      },
      {
        icon: 'family_restroom',
        bgClass: 'pillar-bg-orange',
        title: 'Psikoedukasi & Parenting Coaching',
        desc: 'Sesi mendalam bersama orang tua untuk menyelaraskan pola komunikasi di rumah, manajemen gadget, dan disiplin positif.',
        bullets: ['Strategi penanganan tantrum di rumah', 'Peningkatan bonding hangat orang tua - anak']
      },
      {
        icon: 'diversity_1',
        bgClass: 'pillar-bg-teal',
        title: 'Modifikasi Perilaku (Behavior Therapy)',
        desc: 'Membimbing pembentukan kebiasaan baru yang adaptif, mengurangi perilaku menentang, dan melatih disiplin mandiri.',
        bullets: ['Reward system yang sehat dan konstruktif', 'Rencana intervensi perilaku terukur']
      }
    ],
    processSteps: [
      {
        number: '01',
        numBgClass: 'num-blue',
        badge: 'Sesi 60 Menit',
        badgeBgClass: 'badge-blue',
        title: 'Konsultasi Intake Orang Tua',
        desc: 'Wawancara klinis mendalam bersama orang tua mengenai riwayat kehamilan, tumbuh kembang, dan dinamika keluarga.',
        footerIcon: 'assignment',
        footerText: 'Output: Analisis Riwayat Tumbuh Kembang'
      },
      {
        number: '02',
        numBgClass: 'num-primary-cont',
        badge: 'Observasi Anak',
        badgeBgClass: 'badge-green',
        title: 'Asesmen & Observasi Anak',
        desc: 'Interaksi tatap muka langsung psikolog dengan anak melalui tes terstandar, aktivitas bermain, atau observasi perilaku.',
        footerIcon: 'track_changes',
        footerText: 'Pemetaan Karakter & Kognitif'
      },
      {
        number: '03',
        numBgClass: 'num-green',
        badge: 'Sesi Rutin',
        badgeBgClass: 'badge-orange',
        title: 'Sesi Konseling / Play Therapy',
        desc: 'Sesi intervensi terarah untuk melatih regulasi emosi, mengatasi kecemasan, dan memperkuat konsep diri positif anak.',
        footerIcon: 'toys',
        footerText: 'Ruang Konseling Nyaman & Privat'
      },
      {
        number: '04',
        numBgClass: 'num-dark-blue',
        badge: 'Edukasi Lengkap',
        badgeBgClass: 'badge-blue',
        title: 'Laporan Psikologis & Feedback',
        desc: 'Pemberian laporan tertulis resmi dan sesi diskusi tindak lanjut rekomendasi sekolah maupun pola asuh di rumah.',
        footerIcon: 'family_restroom',
        footerText: 'Laporan Psikologi Tertulis Resmi'
      }
    ],
    therapists: [
      {
        name: 'Sarah Wijayanti, M.Psi., Psikolog',
        role: 'Psikolog Klinis Anak & Remaja (SIPP)',
        bio: 'Fokus pada evaluasi tumbuh kembang anak, penanganan trauma, regulasi emosi, serta kesiapan sekolah anak usia dini.',
        cert: 'Alumni Magister Profesi Psikologi UI',
        rating: '5.0 (140+ Sesi)',
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuB9TdTX3hAv4l3XEhF6RnRoVq9SrEZWWigruM-Zmmi35kXtkmTMve9H7N1-RIYg5jM937Tx9sEWQyzXR66Neo9Sa7776w3Zo6VajIJukCAkN8s151ZqH9c7PF-4nlF1-SVkqD1DZB7BwB9tpZaUcpcSsq9obGxkdggEXSE_IuVRlN-Fsh23JI2d9iMF_qq9LXNCduvqstqvjnXBb1KvcBfZ0q46z2EUUUP0j15K0do'
      },
      {
        name: 'Farhan Maulana, M.Psi., Psikolog',
        role: 'Spesialis Asesmen Kognitif & ADHD',
        bio: 'Keahlian dalam skrining neurologis ringan, asesmen IQ, kesulitan belajar spesifik (disleksia), dan konseling perilaku anak.',
        cert: 'Anggota HIMPSI & Ikatan Psikolog Klinis',
        rating: '4.95 (115+ Sesi)',
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCIKvDfJPyVbIyPla4wyzxNhLrF8Ce1fVTVaOqumdJmrh2Bk8V7oAZmxceDSGifuQqVl1kki4aGpoTx11e5k91D13E3IbOLK8wQjn1WI_Sl-7zRbNYinsXJ3V2vevUjDzfQnwz96Sj-elpEFz1TGMDkGcogynWSoUS19_F-iFSPo0EzFQKVk3iSrq6SDGNB96CrjY8D4dfGTmV7xw7183jxJQ6xTu9aQJYX-uGTcYA'
      },
      {
        name: 'Nabila Maharani, S.Tr.Kes',
        role: 'Konsultan Kolaborasi Tumbuh Kembang',
        bio: 'Kolaborasi lintas disiplin antara aspek psikologi anak dan stimulasi perkembangan komunikasi verbal-sosial.',
        cert: '6+ Tahun Praktik Klinis',
        rating: '4.9 (120+ Sesi)',
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAf4OVUo-Wxnq8f6xSABM4mGtVxKAMm7lICIoE-PAxYxAZi_WeX9xbdVYLOIjzYftHDfEytV-2fKTnkbwLfFeFxQhERvsIwEIwli4j-NnHuby3Z4nZIptqt_qejl-BUIf2bOej8oKcP5I91K6rBDTT3Y_dcU9uGgiexN7tPlJ3Rl4hy_RT46xH8h_J4kmToqINJ4tSlKYrmbz3NaTyHUwpZhBG53oHWwMDE4iKDYXM'
      }
    ],
    packages: [
      {
        tag: 'Langkah Wajib',
        tagClass: 'tag-blue',
        title: 'Konsultasi & Asesmen Awal',
        subtitle: 'Sesi intake psikolog klinis bersama orang tua dan observasi kepribadian anak.',
        priceLabel: 'Mulai dari',
        price: 'Rp 350.000',
        unit: 'sesi',
        features: [
          'Durasi 60 menit tatap muka psikolog klinis',
          'Analisis dinamika emosi dan perilaku',
          'Laporan ringkas asesmen klinis',
          'Rekomendasi tindak lanjut penanganan'
        ],
        buttonText: 'Pilih Jadwal Konsultasi',
        isPopular: false
      },
      {
        tag: 'Paket Kesiapan',
        tagClass: 'tag-green',
        title: 'Tes Kesiapan Masuk SD',
        subtitle: 'Asesmen lengkap kematangan kognitif, motorik, dan emosional anak usia 5–7 tahun.',
        priceLabel: 'Total Investasi',
        price: 'Rp 650.000',
        unit: 'paket',
        savingNote: 'Termasuk Surat Rekomendasi Resmi Sekolah',
        features: [
          'Pemeriksaan tes NST / tes kesiapan terstandar',
          'Sesi feedback 30 menit bersama orang tua',
          'Sertifikat & surat rekomendasi formal sekolah',
          'Panduan stimulasi pra-akademik di rumah'
        ],
        buttonText: 'Daftar Tes Kesiapan SD',
        isPopular: true
      },
      {
        tag: 'Paket Konseling',
        tagClass: 'tag-orange',
        title: 'Paket Konseling & Terapi (4x)',
        subtitle: '4 sesi konseling rutin / play therapy untuk pemulihan emosi & modifikasi perilaku.',
        priceLabel: 'Total Investasi',
        price: 'Rp 1.300.000',
        unit: 'paket',
        savingNote: 'Hemat Rp 100.000 + Pendampingan WA',
        features: [
          '4 sesi tatap muka intensif (50 menit/sesi)',
          'Kombinasi sesi anak dan sesi parenting orang tua',
          'Laporan evaluasi perkembangan berkala',
          'Fleksibilitas jadwal konsultasi'
        ],
        buttonText: 'Pilih Paket Konseling 4x',
        isPopular: false
      }
    ],
    faqs: [
      {
        q: 'Kapan anak perlu dibawa ke psikolog anak?',
        a: 'Bila anak menunjukkan perubahan perilaku drastis, tantrum ekstrem yang sulit ditenangkan, kecemasan berlebih saat berpisah, kemunduran prestasi belajar mendadak, atau ketika orang tua membutuhkan tes kesiapan sekolah formal.'
      },
      {
        q: 'Apakah hasil tes psikologi dijamin kerahasiaannya?',
        a: 'Ya, mutlak. Seluruh data asesmen dan riwayat konseling dilindungi oleh Kode Etik Psikologi Indonesia dan hanya dibagikan kepada pihak lain atas izin tertulis orang tua.'
      },
      {
        q: 'Bagaimana pendekatan psikolog terhadap anak yang menolak diajak bicara?',
        a: 'Psikolog anak kami menggunakan metode Play Therapy dan media gambar. Anak tidak dipaksa untuk langsung bercerita, melainkan diajak bermain dengan nyaman hingga rasa percaya (rapport) terbentuk secara alami.'
      },
      {
        q: 'Apakah orang tua ikut masuk ke dalam ruang konseling?',
        a: 'Pada sesi pertama, orang tua dilibatkan penuh untuk wawancara riwayat tumbuh kembang. Pada sesi berikutnya, disesuaikan dengan kebutuhan anak—apakah membutuhkan ruang privat sendiri atau didampingi.'
      }
    ]
  }
}

const service = computed(() => {
  const slug = route.params.slug
  if (slug && allServicesData[slug]) {
    return allServicesData[slug]
  }
  // Default fallback to Terapi Wicara if not found or empty
  return allServicesData['terapi-wicara']
})
</script>

<style scoped>
/* ==================== GLOBAL HELPERS ==================== */
.service-detail-page {
  background-color: var(--background);
  color: var(--on-surface);
  overflow-x: hidden;
}

.container {
  width: 100%;
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 1.5rem;
}

.fill {
  font-variation-settings: 'FILL' 1, 'wght' 500, 'GRAD' 0, 'opsz' 24;
}

.loading-state, .not-found-state {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 50vh;
  padding: 4rem 1.5rem;
}

.spinner {
  width: 48px;
  height: 48px;
  border: 4px solid var(--surface-container);
  border-top-color: var(--primary);
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.not-found-container {
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1rem;
}

.not-found-icon {
  font-size: 64px;
  color: var(--outline);
}

/* ==================== SECTION TYPOGRAPHY ==================== */
.section-header {
  margin-bottom: 2.5rem;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.section-header.center {
  text-align: center;
  align-items: center;
  max-width: 760px;
  margin-left: auto;
  margin-right: auto;
}

.section-eyebrow {
  font-size: 13px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.08em;
}

.eyebrow-primary {
  color: var(--primary);
}

.eyebrow-secondary {
  color: var(--secondary);
}

.section-title {
  font-family: var(--font-headline);
  font-size: clamp(24px, 3vw, 34px);
  font-weight: 700;
  color: var(--on-surface);
  line-height: 1.25;
}

.section-desc {
  font-size: 15px;
  line-height: 1.6;
  color: var(--on-surface-variant);
}

/* ==================== BREADCRUMBS ==================== */
.breadcrumb-strip {
  background-color: var(--surface-container-low);
  border-bottom: 1px solid rgba(191, 200, 206, 0.3);
  padding: 0.875rem 0;
}

.breadcrumb-container {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: space-between;
  gap: 0.75rem;
}

.breadcrumb-nav {
  display: flex;
  align-items: center;
  gap: 0.375rem;
  font-size: 13px;
  color: var(--on-surface-variant);
  font-weight: 600;
}

.bc-link {
  color: var(--on-surface-variant);
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
  transition: color 0.15s;
}

.bc-link:hover {
  color: var(--primary);
}

.bc-home-icon {
  font-size: 16px;
}

.bc-sep {
  font-size: 14px;
  color: var(--outline);
}

.bc-active {
  color: var(--primary);
  font-weight: 700;
}

.back-link {
  display: inline-flex;
  align-items: center;
  gap: 0.375rem;
  font-size: 13px;
  font-weight: 700;
  color: var(--primary);
  text-decoration: none;
  transition: all 0.15s;
}

.back-link:hover {
  color: var(--primary-container);
}

.back-icon {
  font-size: 18px;
  transition: transform 0.2s;
}

.back-link:hover .back-icon {
  transform: translateX(-4px);
}

/* ==================== HERO SECTION ==================== */
.service-hero {
  position: relative;
  padding: 3rem 0 3.5rem;
  background: linear-gradient(180deg, var(--surface-container-low) 0%, var(--background) 60%, var(--background) 100%);
  overflow: hidden;
}

.hero-bg-blob-1 {
  position: absolute;
  top: -2rem;
  right: -2rem;
  width: 18rem;
  height: 18rem;
  background: rgba(193, 232, 255, 0.45);
  border-radius: 50%;
  filter: blur(60px);
  pointer-events: none;
}

.hero-bg-blob-2 {
  position: absolute;
  bottom: 0;
  left: -3rem;
  width: 20rem;
  height: 20rem;
  background: rgba(204, 239, 142, 0.4);
  border-radius: 50%;
  filter: blur(70px);
  pointer-events: none;
}

.hero-grid {
  display: grid;
  grid-template-columns: 1.15fr 0.85fr;
  gap: 2.5rem;
  align-items: center;
  position: relative;
  z-index: 2;
}

.hero-content {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
}

.category-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  background: rgba(193, 232, 255, 0.7);
  border: 1px solid rgba(0, 99, 132, 0.25);
  color: var(--primary);
  padding: 0.375rem 1rem;
  border-radius: 9999px;
  font-size: 13px;
  font-weight: 700;
  width: fit-content;
}

.cat-icon {
  font-size: 18px;
}

.hero-title {
  font-family: var(--font-headline);
  font-size: clamp(28px, 3.5vw, 42px);
  font-weight: 700;
  line-height: 1.2;
  color: var(--on-surface);
  letter-spacing: -0.015em;
}

.hero-title-accent {
  color: var(--primary);
  display: block;
}

.hero-description {
  font-size: 16px;
  line-height: 1.65;
  color: var(--on-surface-variant);
  max-width: 600px;
}

/* Specs Bento Bar */
.specs-bento {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 0.75rem;
  background: var(--surface-container-lowest);
  padding: 0.875rem;
  border-radius: 1rem;
  border: 1px solid rgba(191, 200, 206, 0.4);
  box-shadow: 0 8px 24px -4px rgba(58, 134, 168, 0.08);
}

.spec-card {
  display: flex;
  align-items: center;
  gap: 0.625rem;
  padding: 0.625rem 0.75rem;
  border-radius: 0.75rem;
  background: var(--surface-container-low);
}

.spec-icon {
  width: 38px;
  height: 38px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.spec-icon .material-symbols-outlined {
  font-size: 20px;
}

.spec-bg-blue {
  background: rgba(0, 99, 132, 0.12);
  color: var(--primary);
}

.spec-bg-green {
  background: rgba(75, 103, 22, 0.12);
  color: var(--secondary);
}

.spec-bg-orange {
  background: rgba(136, 78, 3, 0.12);
  color: var(--tertiary);
}

.spec-info {
  display: flex;
  flex-direction: column;
}

.spec-label {
  font-size: 11px;
  color: var(--on-surface-variant);
}

.spec-val {
  font-size: 13px;
  font-weight: 700;
  color: var(--on-surface);
  white-space: nowrap;
}

/* Hero Action CTAs */
.hero-actions {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 1rem;
  padding-top: 0.25rem;
}

.btn-primary-hero {
  background: var(--primary);
  color: var(--on-primary);
  font-size: 15px;
  font-weight: 700;
  padding: 0.875rem 2rem;
  border-radius: 9999px;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  text-decoration: none;
  box-shadow: 0 4px 14px rgba(0, 99, 132, 0.25);
  transition: all 0.2s ease;
}

.btn-primary-hero:hover {
  background: var(--primary-container);
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(0, 99, 132, 0.35);
}

.btn-wa-hero {
  background: var(--surface-container-lowest);
  color: var(--secondary);
  border: 2px solid var(--secondary);
  font-size: 15px;
  font-weight: 700;
  padding: 0.75rem 1.75rem;
  border-radius: 9999px;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  text-decoration: none;
  transition: all 0.2s ease;
}

.btn-wa-hero:hover {
  background: rgba(204, 239, 142, 0.3);
  transform: translateY(-2px);
}

/* Trust Badges Under Hero */
.trust-badges {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 1.5rem;
  padding-top: 0.5rem;
  font-size: 12px;
  color: var(--on-surface-variant);
}

.trust-item {
  display: flex;
  align-items: center;
  gap: 0.375rem;
}

.check-icon {
  font-size: 17px;
  color: var(--secondary);
  font-variation-settings: 'FILL' 1;
}

/* Hero Visual */
.hero-visual-col {
  position: relative;
}

.visual-frame {
  position: relative;
  border-radius: 1.5rem;
  overflow: hidden;
  background: rgba(209, 228, 251, 0.5);
  border: 4px solid var(--surface-container-lowest);
  box-shadow: 0 16px 36px -6px rgba(43, 61, 79, 0.12);
}

.hero-img {
  width: 100%;
  height: 460px;
  object-fit: cover;
  display: block;
}

.floating-badge-tag {
  position: absolute;
  bottom: 1rem;
  left: 1rem;
  right: 1rem;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  padding: 0.875rem 1rem;
  border-radius: 1rem;
  border: 1px solid rgba(191, 200, 206, 0.4);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 0.75rem;
}

.float-tag-left {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.float-icon-wrap {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: var(--secondary-fixed);
  color: var(--on-secondary-fixed);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.float-icon-wrap .material-symbols-outlined {
  font-size: 22px;
}

.float-tag-title {
  font-family: var(--font-headline);
  font-size: 15px;
  font-weight: 700;
  color: var(--on-surface);
  margin-bottom: 2px;
  line-height: 1.2;
}

.float-tag-sub {
  font-size: 12px;
  color: var(--on-surface-variant);
  line-height: 1.3;
}

.float-loc-pill {
  font-size: 12px;
  font-weight: 700;
  color: var(--primary);
  background: rgba(193, 232, 255, 0.7);
  padding: 0.35rem 0.75rem;
  border-radius: 9999px;
  white-space: nowrap;
}

/* ==================== SECTION 2: INDIKASI (INTERACTIVE CHECKLIST) ==================== */
.section-indications {
  padding: 4rem 0;
  background: var(--surface-container-lowest);
  border-top: 1px solid rgba(191, 200, 206, 0.3);
  border-bottom: 1px solid rgba(191, 200, 206, 0.3);
}

.symptom-check-toolbar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 1rem;
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 1rem;
  padding: 0.85rem 1.25rem;
  margin-bottom: 1.5rem;
}

.toolbar-info {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 13.5px;
  color: #334155;
}

.toolbar-icon {
  font-size: 20px;
  color: #006384;
}

.toolbar-counter {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  background: #e2e8f0;
  color: #64748b;
  font-size: 12px;
  font-weight: 700;
  padding: 0.3rem 0.75rem;
  border-radius: 999px;
  transition: all 0.25s ease;
}

.toolbar-counter.has-checked {
  background: #006384;
  color: #ffffff;
}

.counter-num {
  font-size: 13px;
  font-weight: 800;
}

.indications-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.5rem;
}

.indication-card {
  background: #ffffff;
  border: 1.5px solid rgba(191, 200, 206, 0.4);
  border-radius: 1.25rem;
  padding: 1.5rem;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  cursor: pointer;
  transition: all 0.25s ease;
  user-select: none;
}

.indication-card:hover {
  border-color: #006384;
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(0, 99, 132, 0.1);
}

.indication-card.is-checked {
  border-color: #006384;
  background: #f0f9ff;
  box-shadow: 0 8px 24px rgba(0, 99, 132, 0.14);
}

.ind-card-top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 1rem;
}

.ind-icon-wrap {
  width: 44px;
  height: 44px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.ind-icon-wrap .material-symbols-outlined {
  font-size: 22px;
}

.ind-checkbox {
  color: #94a3b8;
  transition: color 0.2s;
}

.ind-checkbox.checked {
  color: #006384;
}

.check-icon-ui {
  font-size: 24px;
}

.ind-icon-blue {
  background: #e0f2fe;
  color: #006384;
}

.ind-icon-green {
  background: #dcfce7;
  color: #16a34a;
}

.ind-icon-orange {
  background: #fef3c7;
  color: #d97706;
}

.ind-icon-teal {
  background: #ccfbf1;
  color: #0d9488;
}

.ind-title {
  font-family: var(--font-headline);
  font-size: 16.5px;
  font-weight: 800;
  color: #091d2e;
  margin-bottom: 0.45rem;
  line-height: 1.3;
}

.ind-desc {
  font-size: 13.5px;
  line-height: 1.55;
  color: #556066;
}

.ind-footer {
  margin-top: 1.25rem;
  padding-top: 0.85rem;
  border-top: 1px solid rgba(191, 200, 206, 0.25);
  display: flex;
  align-items: center;
  gap: 0.375rem;
  font-size: 12px;
  font-weight: 700;
  color: #006384;
}

.ind-info-icon {
  font-size: 16px;
}

/* Symptom Checked Alert Banner */
.symptom-checked-alert {
  margin-top: 2rem;
  background: linear-gradient(135deg, #006384 0%, #00839e 100%);
  color: #ffffff;
  border-radius: 1.25rem;
  padding: 1.5rem 2rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1.5rem;
  box-shadow: 0 12px 30px rgba(0, 99, 132, 0.25);
  animation: slideInUp 0.3s ease;
}

@keyframes slideInUp {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

.checked-alert-left {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.star-icon {
  font-size: 32px;
  color: #ffd166;
  flex-shrink: 0;
}

.alert-title {
  font-family: var(--font-headline);
  font-size: 17px;
  font-weight: 800;
  margin: 0 0 0.25rem;
}

.alert-sub {
  font-size: 13px;
  color: rgba(255, 255, 255, 0.9);
  margin: 0;
  line-height: 1.45;
}

.btn-alert-wa {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  background: #25d366;
  color: #ffffff;
  font-family: var(--font-headline);
  font-size: 14px;
  font-weight: 700;
  padding: 0.8rem 1.5rem;
  border-radius: 999px;
  text-decoration: none;
  white-space: nowrap;
  box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
  transition: all 0.2s;
  flex-shrink: 0;
}

.btn-alert-wa:hover {
  background: #1ebc59;
  transform: translateY(-2px);
}

/* Guidance Callout */
.guidance-callout {
  margin-top: 2rem;
  background: #f8fafc;
  border: 1px solid rgba(191, 200, 206, 0.4);
  padding: 1.25rem 1.5rem;
  border-radius: 1rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1.5rem;
}

.guidance-left {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.guidance-icon-circle {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: #006384;
  color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.guidance-icon-circle .material-symbols-outlined {
  font-size: 20px;
}

.guidance-text {
  font-size: 13.5px;
  color: #334155;
  line-height: 1.5;
  margin: 0;
}

.guidance-link {
  font-size: 13.5px;
  font-weight: 700;
  color: #006384;
  text-decoration: none;
  white-space: nowrap;
  flex-shrink: 0;
  transition: color 0.15s;
}

.guidance-link:hover {
  text-decoration: underline;
}

/* ==================== SECTION 3: AREA FOKUS (TABBED SWITCHER) ==================== */
.section-focus-methods {
  padding: 4.5rem 0;
  background: #f8fafc;
}

.focus-header {
  display: flex;
  flex-direction: row;
  align-items: flex-end;
  justify-content: space-between;
  gap: 2rem;
  margin-bottom: 2.5rem;
}

.focus-header-desc {
  font-size: 15px;
  line-height: 1.6;
  color: #556066;
  max-width: 440px;
  margin: 0;
}

/* Pillar Tabs Nav */
.pillar-tabs-nav {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1rem;
  margin-bottom: 1.75rem;
}

.pillar-tab-btn {
  background: #ffffff;
  border: 1.5px solid rgba(191, 200, 206, 0.4);
  border-radius: 1rem;
  padding: 1rem;
  display: flex;
  align-items: center;
  gap: 0.75rem;
  cursor: pointer;
  text-align: left;
  transition: all 0.25s ease;
}

.pillar-tab-btn:hover {
  border-color: #006384;
  transform: translateY(-2px);
}

.pillar-tab-btn.is-active {
  border-color: #006384;
  background: #f0f9ff;
  border-width: 2px;
  box-shadow: 0 6px 18px rgba(0, 99, 132, 0.12);
}

.tab-icon-wrap {
  width: 42px;
  height: 42px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.tab-icon-wrap .material-symbols-outlined {
  font-size: 22px;
}

.tab-text-wrap {
  display: flex;
  flex-direction: column;
}

.tab-num {
  font-size: 11px;
  font-weight: 800;
  text-transform: uppercase;
  color: #64748b;
}

.tab-title {
  font-family: var(--font-headline);
  font-size: 13.5px;
  font-weight: 800;
  color: #091d2e;
  line-height: 1.25;
}

/* Pillar Showcase Card */
.pillar-showcase-card {
  background: #ffffff;
  border: 2px solid #006384;
  border-radius: 1.5rem;
  padding: 2.25rem;
  box-shadow: 0 12px 32px -4px rgba(0, 99, 132, 0.12);
  animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(6px); }
  to { opacity: 1; transform: translateY(0); }
}

.pillar-showcase-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1.5rem;
  margin-bottom: 1.25rem;
  padding-bottom: 1.25rem;
  border-bottom: 1px solid #edf2f7;
}

.showcase-header-left {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.pillar-icon-wrap-lg {
  width: 56px;
  height: 56px;
  border-radius: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.pillar-icon-wrap-lg .material-symbols-outlined {
  font-size: 30px;
}

.pillar-stage-pill {
  display: inline-block;
  font-size: 11.5px;
  font-weight: 800;
  color: #006384;
  text-transform: uppercase;
  margin-bottom: 0.25rem;
}

.pillar-showcase-title {
  font-family: var(--font-headline);
  font-size: 22px;
  font-weight: 800;
  color: #091d2e;
  margin: 0;
}

.pillar-nav-arrows {
  display: flex;
  gap: 0.5rem;
}

.btn-pillar-nav {
  width: 38px;
  height: 38px;
  border-radius: 50%;
  border: 1.5px solid #cbd5e1;
  background: #ffffff;
  color: #091d2e;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-pillar-nav:hover {
  background: #006384;
  color: #ffffff;
  border-color: #006384;
}

.pillar-showcase-desc {
  font-size: 15px;
  line-height: 1.7;
  color: #334155;
  margin: 0 0 1.5rem;
}

.pillar-competencies-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 0.85rem;
}

.competency-card {
  display: flex;
  align-items: center;
  gap: 0.65rem;
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  padding: 0.85rem 1rem;
}

.comp-check {
  font-size: 20px;
  color: #16a34a;
  flex-shrink: 0;
}

.comp-text {
  font-size: 13.5px;
  font-weight: 600;
  color: #1e293b;
}

/* ==================== SECTION 4: ALUR PROSES ==================== */
.section-process {
  padding: 4.5rem 0;
  background: var(--surface-container-low);
  border-top: 1px solid rgba(191, 200, 206, 0.3);
  border-bottom: 1px solid rgba(191, 200, 206, 0.3);
}

.process-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1.5rem;
}

.process-card {
  background: var(--surface-container-lowest);
  border: 1px solid rgba(191, 200, 206, 0.35);
  border-radius: 1.25rem;
  padding: 1.5rem;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
  transition: transform 0.25s, box-shadow 0.25s;
}

.process-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
}

.process-card-top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 1rem;
}

.process-num {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: var(--font-headline);
  font-size: 15px;
  font-weight: 700;
  color: var(--on-primary);
}

.num-blue {
  background: var(--primary);
}

.num-primary-cont {
  background: var(--primary-container);
}

.num-green {
  background: var(--secondary);
}

.num-dark-blue {
  background: var(--surface-tint);
}

.num-orange {
  background: var(--tertiary);
}

.process-badge {
  font-size: 12px;
  font-weight: 700;
  padding: 0.3rem 0.75rem;
  border-radius: 9999px;
}

.badge-blue {
  background: rgba(193, 232, 255, 0.6);
  color: var(--primary);
}

.badge-green {
  background: rgba(204, 239, 142, 0.6);
  color: var(--secondary);
}

.badge-orange {
  background: rgba(255, 220, 191, 0.6);
  color: var(--tertiary);
}

.process-title {
  font-family: var(--font-headline);
  font-size: 17px;
  font-weight: 700;
  color: var(--on-surface);
  margin-bottom: 0.5rem;
  line-height: 1.3;
}

.process-desc {
  font-size: 14px;
  line-height: 1.6;
  color: var(--on-surface-variant);
}

.process-footer {
  margin-top: 1.25rem;
  padding-top: 0.875rem;
  border-top: 1px solid rgba(191, 200, 206, 0.3);
  display: flex;
  align-items: center;
  gap: 0.375rem;
  font-size: 12px;
  font-weight: 600;
  color: var(--on-surface-variant);
}

.footer-icon {
  font-size: 17px;
  color: var(--secondary);
}

/* ==================== SECTION 5: TIM TERAPIS ==================== */
.section-therapists {
  padding: 4.5rem 0;
  background: var(--background);
}

.therapists-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.75rem;
}

.therapist-card {
  background: var(--surface-container-lowest);
  border: 1px solid rgba(191, 200, 206, 0.35);
  border-radius: 1.25rem;
  overflow: hidden;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
  transition: transform 0.25s, box-shadow 0.25s;
}

.therapist-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 28px rgba(43, 61, 79, 0.1);
}

.therapist-img-wrap {
  position: relative;
  height: 260px;
  overflow: hidden;
  background: var(--surface-container-high);
}

.therapist-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.35s ease;
}

.therapist-card:hover .therapist-img {
  transform: scale(1.05);
}

.str-badge {
  position: absolute;
  top: 0.875rem;
  right: 0.875rem;
  background: var(--secondary);
  color: var(--on-secondary);
  padding: 0.35rem 0.875rem;
  border-radius: 9999px;
  font-size: 11px;
  font-weight: 700;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.therapist-body {
  padding: 1.5rem;
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.therapist-name {
  font-family: var(--font-headline);
  font-size: 17px;
  font-weight: 700;
  color: var(--on-surface);
  line-height: 1.2;
}

.therapist-role {
  font-size: 12px;
  font-weight: 700;
  color: var(--primary);
  margin-top: 2px;
}

.therapist-bio {
  font-size: 13.5px;
  line-height: 1.55;
  color: var(--on-surface-variant);
}

.therapist-footer {
  padding-top: 0.875rem;
  border-top: 1px solid rgba(191, 200, 206, 0.3);
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: 12px;
  color: var(--on-surface-variant);
}

.therapist-rating {
  display: flex;
  align-items: center;
  gap: 0.25rem;
  color: var(--secondary);
  font-weight: 700;
}

.star-icon {
  font-size: 16px;
  color: #f59e0b;
}

/* ==================== SECTION 6: PAKET TRANSPARAN ==================== */
.section-pricing {
  padding: 4.5rem 0;
  background: var(--surface-container-low);
  border-top: 1px solid rgba(191, 200, 206, 0.3);
  border-bottom: 1px solid rgba(191, 200, 206, 0.3);
}

.schedule-ribbon {
  background: var(--surface-container-lowest);
  padding: 0.75rem 1.5rem;
  border-radius: 9999px;
  border: 1px solid rgba(191, 200, 206, 0.35);
  max-width: 760px;
  margin: 0 auto 2.5rem;
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
}

.ribbon-left {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.ribbon-icon {
  color: var(--primary);
  font-size: 22px;
}

.ribbon-text {
  font-size: 13.5px;
  color: var(--on-surface);
}

.ribbon-right {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 12px;
  color: var(--on-surface-variant);
}

.dot-green {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background: var(--secondary);
}

.packages-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.75rem;
  align-items: stretch;
}

.package-card {
  background: var(--surface-container-lowest);
  border: 1px solid rgba(191, 200, 206, 0.35);
  border-radius: 1.25rem;
  padding: 2rem;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
  position: relative;
  transition: transform 0.25s, box-shadow 0.25s;
}

.package-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 30px rgba(43, 61, 79, 0.1);
}

.package-card--popular {
  border: 2px solid var(--primary);
  box-shadow: 0 8px 30px rgba(0, 99, 132, 0.12);
}

.popular-ribbon {
  position: absolute;
  top: -14px;
  left: 50%;
  transform: translateX(-50%);
  background: var(--primary);
  color: var(--on-primary);
  padding: 0.35rem 1.25rem;
  border-radius: 9999px;
  font-size: 12px;
  font-weight: 700;
  box-shadow: 0 2px 8px rgba(0, 99, 132, 0.25);
  white-space: nowrap;
}

.pkg-top-tag {
  margin-bottom: 0.75rem;
}

.pkg-tag {
  font-size: 12px;
  font-weight: 700;
  padding: 0.25rem 0.75rem;
  border-radius: 9999px;
}

.tag-blue {
  background: rgba(193, 232, 255, 0.7);
  color: var(--primary);
}

.tag-green {
  background: var(--secondary-fixed);
  color: var(--secondary);
}

.tag-orange {
  background: var(--tertiary-fixed);
  color: var(--tertiary);
}

.pkg-title {
  font-family: var(--font-headline);
  font-size: 20px;
  font-weight: 700;
  color: var(--on-surface);
  margin-bottom: 0.35rem;
}

.pkg-sub {
  font-size: 13.5px;
  color: var(--on-surface-variant);
  margin-bottom: 1.25rem;
  line-height: 1.45;
}

.pkg-price-block {
  margin-bottom: 1.5rem;
}

.pkg-price-label {
  font-size: 12px;
  color: var(--on-surface-variant);
  display: block;
  margin-bottom: 2px;
}

.pkg-price {
  font-family: var(--font-headline);
  font-size: 26px;
  font-weight: 700;
  color: var(--primary);
  line-height: 1.1;
}

.pkg-price-unit {
  font-size: 13px;
  font-weight: 400;
  color: var(--on-surface-variant);
}

.pkg-saving {
  display: block;
  font-size: 12px;
  font-weight: 700;
  color: var(--secondary);
  margin-top: 0.25rem;
}

.pkg-features {
  list-style: none;
  padding: 0;
  margin: 0 0 1.5rem;
  display: flex;
  flex-direction: column;
  gap: 0.625rem;
}

.pkg-features li {
  display: flex;
  align-items: flex-start;
  gap: 0.5rem;
  font-size: 13.5px;
  line-height: 1.45;
  color: var(--on-surface-variant);
}

.feat-check {
  font-size: 18px;
  color: var(--secondary);
  flex-shrink: 0;
  margin-top: 1px;
}

.pkg-btn-wrap {
  margin-top: auto;
}

.btn-pkg {
  display: block;
  width: 100%;
  text-align: center;
  padding: 0.75rem 1.5rem;
  border-radius: 9999px;
  font-size: 14px;
  font-weight: 700;
  text-decoration: none;
  transition: all 0.2s ease;
  cursor: pointer;
  border: none;
}

.btn-pkg--primary {
  background: var(--primary);
  color: #ffffff;
  box-shadow: 0 4px 12px rgba(0, 99, 132, 0.2);
}

.btn-pkg--primary:hover {
  background: var(--primary-container);
  transform: translateY(-2px);
}

.btn-pkg--outline {
  border: 1.5px solid var(--primary);
  color: var(--primary);
  background: transparent;
}

.btn-pkg--outline:hover {
  background: rgba(193, 232, 255, 0.4);
}

.btn-pkg-wa-link {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.4rem;
  margin-top: 0.65rem;
  font-size: 13px;
  font-weight: 700;
  color: #128c7e;
  text-decoration: none;
  transition: color 0.15s;
}

.btn-pkg-wa-link:hover {
  color: #075e54;
  text-decoration: underline;
}

.wa-btn-icon {
  font-size: 18px;
  color: #25d366;
}

/* ==================== SECTION 7: FAQ (ACCORDION) ==================== */
.section-faq {
  padding: 4.5rem 0;
  background: #f8fafc;
}

.max-w-faq {
  max-width: 860px;
}

.faq-accordion-list {
  display: flex;
  flex-direction: column;
  gap: 0.85rem;
}

.faq-accordion-item {
  background: #ffffff;
  border: 1.5px solid rgba(191, 200, 206, 0.35);
  border-radius: 1.25rem;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
  transition: all 0.25s ease;
}

.faq-accordion-item.is-open {
  border-color: #006384;
  box-shadow: 0 8px 20px rgba(0, 99, 132, 0.08);
}

.faq-accordion-btn {
  width: 100%;
  padding: 1.25rem 1.5rem;
  background: none;
  border: none;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
  text-align: left;
}

.faq-btn-left {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.faq-q-icon {
  color: #006384;
  font-size: 22px;
  flex-shrink: 0;
}

.faq-q-text {
  font-family: var(--font-headline);
  font-size: 16px;
  font-weight: 800;
  color: #091d2e;
  line-height: 1.35;
}

.faq-toggle-icon {
  color: #006384;
  font-size: 24px;
  flex-shrink: 0;
  transition: transform 0.2s;
}

.faq-accordion-content {
  padding: 0 1.5rem 1.35rem 3.5rem;
  animation: fadeInFaq 0.25s ease;
}

@keyframes fadeInFaq {
  from { opacity: 0; }
  to { opacity: 1; }
}

.faq-answer-paragraph {
  font-size: 14px;
  line-height: 1.65;
  color: #475569;
  margin: 0;
}

/* ==================== SECTION 8: BANNER CTA & FORM ==================== */
.section-cta-banner {
  padding: 4.5rem 0;
  background: linear-gradient(135deg, var(--primary) 0%, var(--primary-container) 100%);
  color: var(--on-primary);
  position: relative;
  overflow: hidden;
}

.cta-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 2.5rem;
  align-items: center;
}

.cta-left {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.cta-pill {
  background: rgba(255, 255, 255, 0.15);
  color: var(--inverse-primary);
  border: 1px solid rgba(136, 208, 244, 0.3);
  padding: 0.35rem 1rem;
  border-radius: 9999px;
  font-size: 13px;
  font-weight: 600;
  width: fit-content;
}

.cta-title {
  font-family: var(--font-headline);
  font-size: clamp(26px, 3.2vw, 36px);
  font-weight: 700;
  line-height: 1.25;
  color: #ffffff;
}

.cta-desc {
  font-size: 15px;
  line-height: 1.6;
  color: rgba(232, 242, 255, 0.9);
  max-width: 500px;
}

.cta-avatars-row {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding-top: 0.5rem;
}

.cta-avatar-stack {
  display: flex;
  margin-left: 0;
}

.cta-avatar {
  width: 38px;
  height: 38px;
  border-radius: 50%;
  border: 2px solid var(--primary);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 11px;
  font-weight: 700;
  margin-left: -8px;
}

.cta-avatar:first-child {
  margin-left: 0;
}

.cta-avatar--1 {
  background: #ffffff;
  color: var(--primary);
}

.cta-avatar--2 {
  background: var(--secondary-fixed);
  color: var(--on-secondary-fixed);
}

.cta-avatar--3 {
  background: var(--tertiary-fixed);
  color: var(--on-tertiary-fixed);
}

.cta-trust-counter {
  font-size: 12px;
  color: var(--inverse-on-surface);
}

/* Booking Card */
.booking-card {
  background: var(--surface-container-lowest);
  color: var(--on-surface);
  padding: 2rem;
  border-radius: 1.5rem;
  box-shadow: 0 16px 36px rgba(0, 0, 0, 0.16);
  border: 1px solid rgba(191, 200, 206, 0.3);
}

.booking-title {
  font-family: var(--font-headline);
  font-size: 20px;
  font-weight: 700;
  color: var(--on-surface);
  margin-bottom: 0.25rem;
}

.booking-sub {
  font-size: 13px;
  color: var(--on-surface-variant);
  margin-bottom: 1.25rem;
}

.booking-form {
  display: flex;
  flex-direction: column;
  gap: 0.875rem;
}

.form-row-2 {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 0.875rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.35rem;
}

.form-label {
  font-size: 13px;
  font-weight: 700;
  color: var(--on-surface);
}

.form-input {
  width: 100%;
  padding: 0.65rem 0.875rem;
  border-radius: 0.625rem;
  background: #f8faf8;
  border: 1px solid #dce5dc;
  font-size: 13.5px;
  font-family: inherit;
  color: var(--on-surface);
  outline: none;
  transition: all 0.2s;
}

.form-input:focus {
  border-color: var(--primary);
  background: #ffffff;
  box-shadow: 0 0 0 3px rgba(0, 99, 132, 0.15);
}

.form-textarea {
  resize: vertical;
}

.btn-submit-booking {
  width: 100%;
  padding: 0.875rem 1.5rem;
  border-radius: 9999px;
  background: var(--primary);
  color: var(--on-primary);
  font-size: 14.5px;
  font-weight: 700;
  border: none;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  box-shadow: 0 4px 14px rgba(0, 99, 132, 0.25);
  transition: all 0.2s ease;
  margin-top: 0.25rem;
}

.btn-submit-booking:hover {
  background: var(--primary-container);
  transform: translateY(-2px);
  box-shadow: 0 6px 18px rgba(0, 99, 132, 0.35);
}

.submit-icon {
  font-size: 18px;
}

/* ==================== RESPONSIVE BREAKPOINTS ==================== */
@media (max-width: 1024px) {
  .hero-grid {
    grid-template-columns: 1fr;
    gap: 2rem;
  }
  .specs-bento {
    grid-template-columns: repeat(2, 1fr);
  }
  .indications-grid {
    grid-template-columns: repeat(2, 1fr);
  }
  .pillar-tabs-nav {
    grid-template-columns: repeat(2, 1fr);
  }
  .process-grid {
    grid-template-columns: repeat(2, 1fr);
  }
  .packages-grid {
    grid-template-columns: 1fr;
    max-width: 500px;
    margin: 0 auto;
  }
  .cta-grid {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 768px) {
  .focus-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 0.75rem;
  }
  .pillar-tabs-nav {
    grid-template-columns: 1fr;
  }
  .pillar-competencies-grid {
    grid-template-columns: 1fr;
  }
  .pillar-showcase-header {
    flex-direction: column;
    align-items: flex-start;
  }
  .symptom-checked-alert {
    flex-direction: column;
    align-items: flex-start;
  }
  .faq-accordion-content {
    padding-left: 1.5rem;
  }
  .therapists-grid {
    grid-template-columns: 1fr;
    max-width: 440px;
    margin: 0 auto;
  }
  .indications-grid {
    grid-template-columns: 1fr;
  }
  .process-grid {
    grid-template-columns: 1fr;
  }
  .guidance-callout {
    flex-direction: column;
    align-items: flex-start;
  }
  .schedule-ribbon {
    border-radius: 1.25rem;
    flex-direction: column;
    align-items: flex-start;
  }
  .form-row-2 {
    grid-template-columns: 1fr;
  }
  .hero-img {
    height: 340px;
  }
}

@media (max-width: 480px) {
  .specs-bento {
    grid-template-columns: 1fr;
  }
  .hero-actions {
    flex-direction: column;
    width: 100%;
  }
  .btn-primary-hero, .btn-wa-hero {
    width: 100%;
    justify-content: center;
  }
  .floating-badge-tag {
    flex-direction: column;
    align-items: flex-start;
  }
}
</style>
