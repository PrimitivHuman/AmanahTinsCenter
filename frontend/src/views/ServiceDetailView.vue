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
                <a
                  :href="waLink(`Halo Admin Amanah Tin\'s Center, saya ingin reservasi sesi asesmen ${service.name}`)"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="btn-primary-hero"
                >
                  <span>{{ service.ctaPrimaryText }}</span>
                  <span class="material-symbols-outlined">chat</span>
                </a>
                <router-link to="/jadwal-pendaftaran" class="btn-wa-hero">
                  <span class="material-symbols-outlined">event_available</span>
                  <span>Jadwal &amp; Pendaftaran</span>
                </router-link>
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
                  decoding="async"
                />
                <!-- Floating Overlay Tag -->
                <div class="floating-badge-tag">
                  <div class="float-tag-left">
                    <div class="float-icon-wrap">
                      <span class="material-symbols-outlined">sentiment_satisfied</span>
                    </div>
                    <div>
                      <h4 class="float-tag-title">{{ service.heroBadgeTitle || 'Metode Fun & Play-Based' }}</h4>
                      <p class="float-tag-sub">{{ service.heroBadgeSub || 'Bebas stres, nyaman, dan disesuaikan minat si Kecil' }}</p>
                    </div>
                  </div>
                  <span class="float-loc-pill">Jagakarsa Center</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ==================== SECTION: 3 KATEGORI LAYANAN UTAMA (KHUSUS / JIKA TERSEDIA) ==================== -->
      <section v-if="service.ageCategories" class="section-age-categories">
        <div class="container">
          <div class="section-header center">
            <span class="section-eyebrow eyebrow-primary">{{ service.ageCategoriesEyebrow || '3 Kategori Layanan' }}</span>
            <h2 class="section-title">{{ service.ageCategoriesTitle || 'Spesialisasi Psikologi Berdasarkan Kategori Usia' }}</h2>
            <p class="section-desc">
              {{ service.ageCategoriesDesc || 'Pendampingan kesehatan mental profesional yang dirancang khusus sesuai dinamika perkembangan: Psikologi Anak, Psikologi Remaja, serta Psikologi Dewasa & Konseling Keluarga.' }}
            </p>
          </div>

          <div class="age-categories-grid">
            <div
              v-for="cat in service.ageCategories"
              :key="cat.title"
              class="age-cat-card"
              :class="cat.cardClass"
            >
              <div class="age-cat-top">
                <div class="age-cat-icon-wrap" :class="cat.iconBgClass">
                  <span class="material-symbols-outlined">{{ cat.icon }}</span>
                </div>
                <span class="age-cat-badge" :class="cat.badgeClass">{{ cat.badge }}</span>
              </div>

              <h3 class="age-cat-title">{{ cat.title }}</h3>
              <div class="age-cat-target">
                <span class="material-symbols-outlined target-icon">schedule</span>
                <span>Sasaran Usia: <strong>{{ cat.ageTarget }}</strong></span>
              </div>
              <p class="age-cat-desc">{{ cat.desc }}</p>

              <div class="age-cat-focus-box">
                <div class="focus-box-title">
                  <span class="material-symbols-outlined">checklist</span>
                  <span>Fokus Penanganan Utama:</span>
                </div>
                <ul class="age-cat-list">
                  <li v-for="point in cat.points" :key="point">
                    <span class="material-symbols-outlined point-check">check_circle</span>
                    <span>{{ point }}</span>
                  </li>
                </ul>
              </div>

              <div class="age-cat-footer">
                <a
                  :href="waLink(`Halo Admin Amanah Tin\'s Center, saya ingin reservasi konsultasi untuk ${cat.title}`)"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="btn-cat-wa"
                  :class="cat.btnClass"
                >
                  <span class="material-symbols-outlined fill">chat</span>
                  <span>Konsultasi {{ cat.shortTitle || cat.title }}</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ==================== SECTION 2: INDIKASI & DETEKSI GEJALA (INTERAKTIF) ==================== -->
      <section class="section-indications">
        <div class="container">
          <div class="section-header center">
            <span class="section-eyebrow eyebrow-secondary">{{ service.indicationsEyebrow || 'Deteksi Dini Perkembangan' }}</span>
            <h2 class="section-title">{{ service.indicationsTitle || `Kapan Si Kecil Perlu Asesmen ${service.shortName}?` }}</h2>
            <p class="section-desc">
              {{ service.indicationsDesc }}
            </p>
          </div>

          <!-- Interactive Checklist Toolbar -->
          <div class="symptom-check-toolbar">
            <div class="toolbar-info">
              <span class="material-symbols-outlined toolbar-icon">checklist_rtl</span>
              <span><strong>{{ service.toolbarGuidanceTitle || 'Panduan Ayah & Bunda' }}:</strong> {{ service.toolbarGuidanceText || 'Klik/tandai keluhan yang saat ini sering diamati pada si Kecil di rumah:' }}</span>
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
                <p class="alert-sub">{{ service.alertSub || 'Intervensi sedini mungkin pada masa emas anak memberikan hasil paling optimal sebelum hambatan menetap.' }}</p>
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
                <strong>{{ service.guidanceAuthor || 'Catatan Terapis' }}:</strong> {{ service.guidanceText || 'Jangan menunggu hingga usia sekolah. "Wait and see" sering kali menunda penanganan masa emas (golden period) otak anak.' }}
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
            <span class="section-eyebrow eyebrow-primary">{{ service.processEyebrow || 'Tahapan Berkelanjutan' }}</span>
            <h2 class="section-title">{{ service.processTitle || `Alur Proses Terapi ${service.shortName}` }}</h2>
            <p class="section-desc">
              {{ service.processDesc || 'Pendampingan terstruktur dari hari pertama asesmen hingga anak mandiri berkomunikasi dan beraktivitas, dengan keterlibatan penuh orang tua.' }}
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
              <span class="section-eyebrow eyebrow-primary">{{ service.teamEyebrow || 'Praktisi Berpengalaman & Ber-STR' }}</span>
              <h2 class="section-title">{{ service.teamTitle || `Tim Terapis ${service.shortName} Kami` }}</h2>
            </div>
            <p class="focus-header-desc">
              {{ service.teamDesc || 'Didukung oleh terapis lulusan program studi resmi dengan sertifikasi keahlian pediatrik dan pendekatan penuh kesabaran.' }}
            </p>
          </div>

          <!-- SKELETON STATE (Memuat dari Database / API) -->
          <div v-if="isLoadingTeam" class="therapists-grid" aria-label="Memuat data praktisi...">
            <div v-for="n in 3" :key="'skel-' + n" class="therapist-card skeleton-card">
              <div class="therapist-img-wrap skeleton-shimmer"></div>
              <div class="therapist-body">
                <div>
                  <div class="skeleton-line skeleton-title skeleton-shimmer"></div>
                  <div class="skeleton-line skeleton-sub skeleton-shimmer"></div>
                </div>
                <div class="skeleton-line skeleton-bio skeleton-shimmer"></div>
                <div class="skeleton-line skeleton-bio2 skeleton-shimmer"></div>
                <div class="therapist-footer">
                  <div class="skeleton-line skeleton-badge skeleton-shimmer"></div>
                  <div class="skeleton-line skeleton-star skeleton-shimmer"></div>
                </div>
              </div>
            </div>
          </div>

          <!-- LOADED THERAPISTS (TERHUBUNG KE PORTAL ADMIN & DATABASE) -->
          <div v-else class="therapists-grid">
            <div
              v-for="therapist in serviceTherapists"
              :key="therapist.name"
              class="therapist-card"
            >
              <div class="therapist-img-wrap">
                <img :src="therapist.image" :alt="therapist.name" class="therapist-img" loading="lazy" decoding="async" />
                <div class="str-badge">{{ therapist.strBadge || 'STR Aktif Kemenkes' }}</div>
              </div>
              <div class="therapist-body">
                <div>
                  <h3 class="therapist-name">{{ therapist.name }}</h3>
                  <p class="therapist-role">{{ therapist.role }}</p>
                </div>
                <p class="therapist-bio">{{ therapist.bio }}</p>
                <div class="therapist-footer">
                  <span class="therapist-cert">{{ therapist.cert }}</span>
                  <span class="therapist-rating" v-if="therapist.rating">
                    <span class="material-symbols-outlined fill star-icon">star</span>
                    {{ therapist.rating }}
                  </span>
                  <span class="therapist-rating" v-else-if="therapist.experience">
                    <span class="material-symbols-outlined fill star-icon" style="color: var(--primary);">verified</span>
                    {{ therapist.experience }}
                  </span>
                </div>
              </div>
            </div>
          </div>

          <!-- LINK KE SELURUH TIM MEDIS -->
          <div class="therapists-action-wrap">
            <router-link to="/tim-kami" class="btn-all-team">
              <span>Lihat Seluruh Tim Medis ATC</span>
              <span class="material-symbols-outlined">arrow_forward</span>
            </router-link>
          </div>
        </div>
      </section>

      <!-- ==================== SECTION 6: PAKET TRANSPARAN ==================== -->
      <section class="section-pricing" id="jadwal-biaya">
        <div class="container">
          <div class="section-header center">
            <span class="section-eyebrow eyebrow-primary">{{ service.pricingEyebrow || 'Jadwal & Investasi Tumbuh Kembang' }}</span>
            <h2 class="section-title">{{ service.pricingTitle || 'Paket Terapi Transparan' }}</h2>
            <p class="section-desc">
              {{ service.pricingDesc || 'Investasi terbaik untuk kemandirian dan rasa percaya diri masa depan anak Anda, tanpa biaya tersembunyi.' }}
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
                <a
                  :href="getPackageWaUrl(pkg)"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="btn-pkg"
                  :class="pkg.isPopular ? 'btn-pkg--primary' : 'btn-pkg--outline'"
                >
                  <span class="material-symbols-outlined fill wa-btn-icon">chat</span>
                  <span>{{ pkg.buttonText || 'Pilih Paket via WhatsApp' }}</span>
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
            <span class="section-eyebrow eyebrow-primary">{{ service.faqEyebrow || 'Tanya Jawab Orang Tua' }}</span>
            <h2 class="section-title">{{ service.faqTitle || `FAQ Seputar ${service.name}` }}</h2>
            <p class="section-desc">
              {{ service.faqDesc || 'Pertanyaan yang paling sering dikonsultasikan orang tua sebelum memulai sesi perdana.' }}
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
import { ref, computed, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import api from '../services/api'
import { useClinicSettings } from '../composables/useClinicSettings'
import { useSeo } from '../composables/useSeo'
import PublicLayout from '../layouts/PublicLayout.vue'

const { waLink, waLinkEncoded } = useClinicSettings()
const route = useRoute()
const seo = useSeo()
const loading = ref(false)
const apiTeam = ref([])
const isLoadingTeam = ref(true)

function updateServiceSeo() {
  if (!service.value) return
  const origin = typeof window !== 'undefined' ? window.location.origin : 'https://tinsgrowcenter.com'
  const slug = route.params.slug || 'terapi-wicara'
  seo.updateSeo({
    title: `${service.value.name} - Layanan Terapi Anak Jagakarsa`,
    description: service.value.heroDesc || `Layanan ${service.value.name} terpadu berstandar medis ramah anak di Jagakarsa Jakarta Selatan.`,
    image: service.value.heroImage,
    url: `${origin}/layanan/${slug}`,
    type: 'website',
  })
}

onMounted(async () => {
  updateServiceSeo()
  try {
    const res = await api.get('/team')
    const data = Array.isArray(res.data) ? res.data : (res.data?.data || [])
    if (data.length > 0) {
      apiTeam.value = data
    }
  } catch (err) {
    console.warn('Gagal memuat tim terapis dari API, menggunakan data fallback lokal:', err)
  } finally {
    isLoadingTeam.value = false
  }
})

watch(() => route.params.slug, () => {
  updateServiceSeo()
})

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

const getPackageWaUrl = (pkg) => {
  const currentSvc = service.value ? service.value.name : 'Layanan'
  const text = `Halo Admin Amanah Tin's Center, saya tertarik mendaftar paket "${pkg.title}" untuk ${currentSvc}. Apakah jadwal terapis masih tersedia?`
  return waLink(text)
}

const waUrl = computed(() => {
  return waLink()
})

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
    name: 'Layanan Psikologi',
    shortName: 'Psikologi',
    badgeIcon: 'psychology_alt',
    categoryBadge: 'Program Spesialisasi Klinis • Layanan Psikologi Terpadu (3 Kategori Usia)',
    titleMain: 'Layanan Asesmen & Konseling Psikologi',
    titleAccent: '(Anak, Remaja & Dewasa)',
    heroDesc: 'Pendampingan kesehatan mental profesional, evaluasi perkembangan, dan asesmen psikologis terpadu yang terbagi menjadi 3 kategori: Psikologi Anak, Psikologi Remaja, serta Psikologi Dewasa & Konseling Keluarga bersama tim Psikolog Klinis berizin resmi (SIPP).',
    heroImage: 'https://lh3.googleusercontent.com/aida-public/AB6AXuB67b9MYgTLA9wMNy5O-9w6TkEnA6ohATQiH43KYlSlPAmDtbLTXu9B57WwqylRdCzHjZg7YF4bb-q7SJupFjxrp4FuawKotOYM7BPa42N5RxpxS7h6YusSVGHIhzMc89oCMmGfcZMwM64SG8vYil6uUlaDoMhfxkJZwyGiNg29r65HN9Ey3IEqYnmf_CSs1nLyHBOFCOiM9-yjTVs48R71yCk3d9Uzal8zzuTfeK8',
    ctaPrimaryText: 'Konsultasi & Asesmen Psikologi',
    ctaFocusWord: 'Kesehatan Mental & Karakter',
    heroBadgeTitle: 'Ruang Aman & Rahasia (Safe Space)',
    heroBadgeSub: 'Konseling privat, empatis & berstandar kode etik klinis',
    specs: [
      { icon: 'schedule', label: 'Durasi Sesi', value: '50 - 60 Menit', bgClass: 'spec-bg-blue' },
      { icon: 'person', label: 'Pendekatan', value: 'Konseling & Tes Klinis', bgClass: 'spec-bg-green' },
      { icon: 'face', label: 'Sasaran Usia', value: 'Anak, Remaja & Dewasa', bgClass: 'spec-bg-orange' },
      { icon: 'verified_user', label: 'Kualifikasi', value: 'Psikolog S2 (SIPP)', bgClass: 'spec-bg-blue' }
    ],
    ageCategoriesEyebrow: '3 Kategori Layanan',
    ageCategoriesTitle: 'Spesialisasi Psikologi Berdasarkan Kategori Usia',
    ageCategoriesDesc: 'Pendampingan kesehatan mental profesional yang dirancang khusus sesuai dinamika perkembangan: Psikologi Anak, Psikologi Remaja, serta Psikologi Dewasa & Konseling Keluarga.',
    ageCategories: [
      {
        cardClass: 'age-card-child',
        iconBgClass: 'icon-bg-blue',
        icon: 'child_care',
        badge: 'Kategori 01',
        badgeClass: 'badge-cat-blue',
        title: 'Psikologi Anak',
        shortTitle: 'Psikologi Anak',
        ageTarget: '2 – 11 Tahun',
        desc: 'Membantu anak mengenali emosi, melatih regulasi perilaku adaptif, asesmen kesiapan sekolah, stimulasi kognitif, dan terapi bermain yang menyenangkan.',
        points: [
          'Tes Kesiapan Masuk SD (NST) & Pemeriksaan IQ',
          'Play Therapy & Bimbingan Regulasi Emosi',
          'Penanganan Tantrum Ekstrem & Perilaku Agresif',
          'Skrining ADHD, Spektrum Autisme & Hambatan Belajar'
        ],
        btnClass: 'btn-cat-blue'
      },
      {
        cardClass: 'age-card-teen',
        iconBgClass: 'icon-bg-green',
        icon: 'school',
        badge: 'Kategori 02',
        badgeClass: 'badge-cat-green',
        title: 'Psikologi Remaja',
        shortTitle: 'Psikologi Remaja',
        ageTarget: '12 – 18 Tahun',
        desc: 'Mendampingi remaja melewati masa transisi pubertas, gejolak emosi (mood swing), stres akademik ujian, krisis percaya diri, dan penemuan arah masa depan.',
        points: [
          'Manajemen Stres Akademik & Kecemasan (Anxiety)',
          'Krisis Identitas Diri, Percaya Diri & Mood Swing',
          'Hambatan Relasi Sebaya, Bullying & Komunikasi Ortu',
          'Tes Minat Bakat Jurusan & Pemetaan Potensi Karier'
        ],
        btnClass: 'btn-cat-green'
      },
      {
        cardClass: 'age-card-adult',
        iconBgClass: 'icon-bg-orange',
        icon: 'psychology',
        badge: 'Kategori 03',
        badgeClass: 'badge-cat-orange',
        title: 'Psikologi Dewasa & Keluarga',
        shortTitle: 'Psikologi Dewasa',
        ageTarget: '19+ Tahun & Orang Tua',
        desc: 'Ruang konseling profesional dan privat untuk mengurai tekanan beban kerja (burnout), kecemasan, keharmonisan pernikahan, serta bimbingan pola asuh (parenting).',
        points: [
          'Konseling Stres Kerja, Burnout & Depresi Ringan',
          'Parenting Coaching & Konsistensi Pola Asuh Positif',
          'Konseling Pranikah, Harmonisasi Pasangan & Keluarga',
          'Regulasi Emosi Dewasa, Overthinking & Self-Healing'
        ],
        btnClass: 'btn-cat-orange'
      }
    ],
    indicationsEyebrow: 'Deteksi Kebutuhan & Konseling Sehat',
    indicationsTitle: 'Kapan Membutuhkan Asesmen atau Konseling Psikologi?',
    indicationsDesc: 'Kesehatan mental dan emosional merupakan fondasi utama di setiap fase hidup—mulai dari tumbuh kembang si kecil, pencarian jati diri remaja, hingga kematangan mental dewasa dan keharmonisan keluarga.',
    toolbarGuidanceTitle: 'Panduan Klien & Keluarga',
    toolbarGuidanceText: 'Klik/tandai kondisi atau keluhan yang saat ini dialami pada si kecil, remaja, maupun diri Anda di rumah:',
    alertSub: 'Konsultasi dini bersama psikolog klinis membantu mengurai akar permasalahan secara tepat sebelum berdampak lebih jauh.',
    guidanceAuthor: 'Catatan Psikolog Klinis',
    guidanceText: 'Menghubungi psikolog adalah langkah positif dan bijak untuk menjaga kesehatan mental. Tidak ada keluhan yang terlalu sepele jika itu sudah mengganggu kenyamanan dan aktivitas sehari-hari.',
    indications: [
      {
        icon: 'sentiment_very_dissatisfied',
        iconBg: 'ind-icon-orange',
        title: '[Anak] Tantrum Berat, Hambatan Emosi & Perilaku',
        desc: 'Sering meledak-ledak tanpa sebab jelas, memukul, melempar barang, melukai diri, atau kesulitan beradaptasi dengan rutinitas harian.',
        age: '2 - 11 Tahun'
      },
      {
        icon: 'school',
        iconBg: 'ind-icon-blue',
        title: '[Anak] Kesiapan Masuk SD & Asesmen Tumbuh Kembang',
        desc: 'Evaluasi kematangan kognitif, tes IQ, kesiapan masuk sekolah dasar, atau skrining kecurigaan ADHD dan kesulitan konsentrasi belajar.',
        age: '4 - 10 Tahun'
      },
      {
        icon: 'psychology',
        iconBg: 'ind-icon-teal',
        title: '[Remaja] Stres Akademik, Overthinking & Kecemasan',
        desc: 'Mengalami tekanan belajar tinggi menjelang ujian, perubahan suasana hati drastis (mood swing), kecemasan berlebih, hingga penarikan diri.',
        age: '12 - 18 Tahun'
      },
      {
        icon: 'explore',
        iconBg: 'ind-icon-green',
        title: '[Remaja] Bingung Minat Bakat & Krisis Percaya Diri',
        desc: 'Kesulitan menentukan jurusan sekolah/kuliah, krisis identitas diri, rendah diri, atau terdampak tekanan pergaulan teman sebaya (peer pressure).',
        age: '12 - 18 Tahun'
      },
      {
        icon: 'sentiment_neutral',
        iconBg: 'ind-icon-blue',
        title: '[Dewasa] Stres, Burnout Kerja & Gangguan Regulasi Emosi',
        desc: 'Kelelahan emosional berlebih akibat beban kerja atau kehidupan, kecemasan menetap, insomnia, atau beban pikiran yang mengganggu produktivitas.',
        age: 'Dewasa (19+ Tahun)'
      },
      {
        icon: 'family_restroom',
        iconBg: 'ind-icon-green',
        title: '[Dewasa & Keluarga] Pola Asuh Parenting & Konflik Pasangan',
        desc: 'Membutuhkan panduan parenting menghadapi anak berkebutuhan khusus/remaja, resolusi konflik pasangan, atau bimbingan keharmonisan rumah tangga.',
        age: 'Orang Tua & Pasangan'
      }
    ],
    pillars: [
      {
        icon: 'toys',
        bgClass: 'pillar-bg-blue',
        title: 'Psikologi Anak & Play Therapy',
        desc: 'Metode ramah anak yang mengintegrasikan Play Therapy, Art Therapy, dan modifikasi perilaku untuk melatih regulasi emosi, kemandirian, serta interaksi sosial tanpa paksaan.',
        bullets: [
          'Play Therapy & pengenalan regulasi emosi anak',
          'Modifikasi perilaku adaptif & reward system sehat',
          'Stimulasi fokus perhatian dan interaksi sosial'
        ]
      },
      {
        icon: 'record_voice_over',
        bgClass: 'pillar-bg-green',
        title: 'Konseling Remaja & Minat Bakat',
        desc: 'Sesi konseling suportif yang aman dan non-judgmental untuk remaja mengekspresikan dinamika batin, membangun konsep diri positif, serta memetakan arah minat bakat masa depan.',
        bullets: [
          'Konseling suportif emosi & penanganan overthinking',
          'Pemetaan tes minat bakat & penjurusan studi',
          'Strategi resiliensi menghadapi tekanan sosial dan akademik'
        ]
      },
      {
        icon: 'psychology',
        bgClass: 'pillar-bg-orange',
        title: 'Konseling Dewasa & Harmoni Keluarga',
        desc: 'Pendampingan profesional bagi dewasa dalam mengurai beban emosi, manajemen stres, pemulihan luka batin (inner child), serta penguatan komunikasi pasangan dan pola asuh anak.',
        bullets: [
          'Manajemen stres kerja, kecemasan, dan burnout',
          'Parenting coaching untuk pola asuh positif',
          'Konseling relasi pasangan & harmonisasi keluarga'
        ]
      },
      {
        icon: 'assignment_turned_in',
        bgClass: 'pillar-bg-teal',
        title: 'Asesmen Psikologis & Tes Klinis',
        desc: 'Pemeriksaan diagnostik komprehensif menggunakan instrumen tes psikologi terstandar dan tervalidasi untuk keperluan pendidikan, klinis, maupun evaluasi kepribadian.',
        bullets: [
          'Tes IQ terstandar (WISC, WAIS, Binet, CPM)',
          'Tes Kesiapan Masuk SD (NST) & evaluasi kognitif',
          'Laporan psikologis resmi bertanda tangan Psikolog SIPP'
        ]
      }
    ],
    processTitle: 'Alur Proses Konseling & Asesmen Psikologi',
    processDesc: 'Tahapan terstruktur yang menjamin ruang aman, privasi tinggi, dan kenyamanan Anda sejak sesi pertama hingga tindak lanjut evaluasi.',
    processSteps: [
      {
        number: '01',
        numBgClass: 'num-blue',
        badge: 'Sesi Intake',
        badgeBgClass: 'badge-blue',
        title: 'Konsultasi Intake & Identifikasi Awal',
        desc: 'Wawancara klinis mendalam bersama orang tua untuk anak, atau sesi konseling privat empatis untuk klien remaja dan dewasa.',
        footerIcon: 'assignment',
        footerText: 'Kerahasiaan Data & Informed Consent'
      },
      {
        number: '02',
        numBgClass: 'num-primary-cont',
        badge: 'Asesmen Klinis',
        badgeBgClass: 'badge-green',
        title: 'Asesmen / Observasi / Tes Psikologi',
        desc: 'Pelaksanaan tes psikologi terstandar, observasi interaksi anak, atau asesmen diagnostik mendalam sesuai kategori usia dan keluhan utama.',
        footerIcon: 'track_changes',
        footerText: 'Instrumen Tes Terstandar Klinis'
      },
      {
        number: '03',
        numBgClass: 'num-green',
        badge: 'Sesi Intervensi',
        badgeBgClass: 'badge-orange',
        title: 'Sesi Konseling & Terapi Terarah',
        desc: 'Sesi intervensi play therapy untuk anak, konseling suportif/CBT untuk remaja dan dewasa, serta psikoedukasi terarah untuk keluarga.',
        footerIcon: 'psychology',
        footerText: 'Ruang Konseling Nyaman & Privat'
      },
      {
        number: '04',
        numBgClass: 'num-dark-blue',
        badge: 'Laporan Resmi',
        badgeBgClass: 'badge-blue',
        title: 'Feedback, Laporan Resmi & Rencana Aksi',
        desc: 'Pemberian laporan psikologis tertulis resmi berstempel SIPP, sesi penjelasan komprehensif, serta panduan praktis penanganan sehari-hari.',
        footerIcon: 'verified',
        footerText: 'Laporan Resmi Berizin SIPP'
      }
    ],
    teamTitle: 'Tim Psikolog Klinis Kami',
    teamDesc: 'Didukung oleh Psikolog Klinis lulusan Magister Profesi Psikologi terakreditasi dengan Surat Izin Praktik Psikologi (SIPP) aktif dari HIMPSI dan Kemenkes.',
    therapists: [
      {
        name: 'Sarah Wijayanti, M.Psi., Psikolog',
        role: 'Psikolog Klinis Anak & Remaja (SIPP)',
        bio: 'Fokus pada evaluasi tumbuh kembang anak, penanganan trauma, regulasi emosi anak & remaja, serta kesiapan sekolah usia dini.',
        cert: 'Magister Profesi Psikologi UI • SIPP Aktif',
        rating: '5.0 (150+ Sesi)',
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuB9TdTX3hAv4l3XEhF6RnRoVq9SrEZWWigruM-Zmmi35kXtkmTMve9H7N1-RIYg5jM937Tx9sEWQyzXR66Neo9Sa7776w3Zo6VajIJukCAkN8s151ZqH9c7PF-4nlF1-SVkqD1DZB7BwB9tpZaUcpcSsq9obGxkdggEXSE_IuVRlN-Fsh23JI2d9iMF_qq9LXNCduvqstqvjnXBb1KvcBfZ0q46z2EUUUP0j15K0do'
      },
      {
        name: 'Farhan Maulana, M.Psi., Psikolog',
        role: 'Psikolog Klinis Remaja & Dewasa (SIPP)',
        bio: 'Keahlian dalam manajemen stres, kecemasan, asesmen kognitif & IQ, tes minat bakat penjurusan, serta konseling dewasa muda.',
        cert: 'Anggota HIMPSI & Ikatan Psikolog Klinis',
        rating: '4.95 (130+ Sesi)',
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCIKvDfJPyVbIyPla4wyzxNhLrF8Ce1fVTVaOqumdJmrh2Bk8V7oAZmxceDSGifuQqVl1kki4aGpoTx11e5k91D13E3IbOLK8wQjn1WI_Sl-7zRbNYinsXJ3V2vevUjDzfQnwz96Sj-elpEFz1TGMDkGcogynWSoUS19_F-iFSPo0EzFQKVk3iSrq6SDGNB96CrjY8D4dfGTmV7xw7183jxJQ6xTu9aQJYX-uGTcYA'
      },
      {
        name: 'Nabila Maharani, M.Psi., Psikolog',
        role: 'Konselor Keluarga & Parenting Coach',
        bio: 'Mendampingi pasangan dan orang tua dalam harmonisasi keluarga, psikoedukasi pola asuh anak, serta konseling hubungan.',
        cert: 'Praktisi SIPP & Certified Family Coach',
        rating: '4.9 (125+ Sesi)',
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAf4OVUo-Wxnq8f6xSABM4mGtVxKAMm7lICIoE-PAxYxAZi_WeX9xbdVYLOIjzYftHDfEytV-2fKTnkbwLfFeFxQhERvsIwEIwli4j-NnHuby3Z4nZIptqt_qejl-BUIf2bOej8oKcP5I91K6rBDTT3Y_dcU9uGgiexN7tPlJ3Rl4hy_RT46xH8h_J4kmToqINJ4tSlKYrmbz3NaTyHUwpZhBG53oHWwMDE4iKDYXM'
      }
    ],
    pricingTitle: 'Pilihan Sesi & Paket Layanan Psikologi',
    pricingDesc: 'Investasi terbaik untuk kesehatan mental, ketenangan keluarga, dan kematangan karakter tanpa biaya tersembunyi.',
    packages: [
      {
        tag: 'Pilihan Populer',
        tagClass: 'tag-blue',
        title: 'Konseling Individu (Anak / Remaja / Dewasa)',
        subtitle: '1 sesi tatap muka 60 menit bersama psikolog klinis berizin untuk konsultasi emosi, stres, atau pengasuhan.',
        priceLabel: 'Mulai dari',
        price: 'Rp 350.000',
        unit: 'sesi',
        features: [
          'Durasi 60 menit tatap muka psikolog klinis berizin (SIPP)',
          'Tersedia untuk Anak (Play therapy), Remaja, maupun Dewasa',
          'Sesi intake dan identifikasi akar permasalahan secara mendalam',
          'Rekomendasi langkah praktis tindak lanjut penanganan'
        ],
        buttonText: 'Pilih Jadwal Konsultasi',
        isPopular: false
      },
      {
        tag: 'Asesmen Diagnostik',
        tagClass: 'tag-green',
        title: 'Tes Psikologi Lengkap (IQ / Kesiapan SD / Minat Bakat)',
        subtitle: 'Pemeriksaan psikotes terstandar lengkap dengan laporan tertulis resmi bertanda tangan SIPP.',
        priceLabel: 'Total Investasi',
        price: 'Rp 650.000',
        unit: 'paket',
        savingNote: 'Termasuk Surat / Laporan Rekomendasi Resmi Sekolah',
        features: [
          'Pilihan: Kesiapan Masuk SD (NST) / Tes IQ / Minat Bakat Jurusan',
          'Sesi administrasi tes langsung oleh psikolog klinis',
          'Sesi feedback penjelasan hasil 30 menit bersama orang tua / klien',
          'Sertifikat & laporan psikologis tertulis resmi berstempel'
        ],
        buttonText: 'Daftar Tes Psikologi',
        isPopular: true
      },
      {
        tag: 'Program Terarah',
        tagClass: 'tag-orange',
        title: 'Paket Terapi & Konseling Berkelanjutan (4x)',
        subtitle: '4 sesi konseling rutin / play therapy untuk pendampingan pemulihan emosi atau konseling keluarga.',
        priceLabel: 'Total Investasi',
        price: 'Rp 1.300.000',
        unit: 'paket',
        savingNote: 'Hemat Rp 100.000 + Pendampingan WhatsApp',
        features: [
          '4 sesi tatap muka intensif terjadwal (50–60 menit/sesi)',
          'Fleksibel: dapat dikombinasikan antara sesi klien dan parenting',
          'Laporan evaluasi perkembangan berkala di setiap sesi',
          'Fleksibilitas jadwal konsultasi & prioritas reservasi'
        ],
        buttonText: 'Pilih Paket Konseling 4x',
        isPopular: false
      }
    ],
    faqTitle: 'FAQ Layanan Psikologi (Anak, Remaja & Dewasa)',
    faqDesc: 'Pertanyaan yang paling sering dikonsultasikan seputar layanan psikologi di Amanah Tin\'s Center.',
    faqs: [
      {
        q: 'Apa saja 3 kategori layanan psikologi di Amanah Tin\'s Center?',
        a: 'Layanan psikologi kami terbagi menjadi 3 kategori: (1) Psikologi Anak (usia 2–11 tahun) untuk tumbuh kembang, emosi, tantrum, kesiapan sekolah, dan play therapy; (2) Psikologi Remaja (usia 12–18 tahun) untuk penyesuaian diri, kecemasan akademik, mood swing, krisis identitas, dan tes minat bakat jurusan; serta (3) Psikologi Dewasa & Konseling Keluarga (19+ tahun) untuk manajemen stres, burnout, pemulihan trauma, konseling pernikahan, dan parenting coaching.'
      },
      {
        q: 'Kapan sebaiknya anak, remaja, atau orang dewasa berkonsultasi ke psikolog?',
        a: 'Untuk anak: saat menunjukkan perubahan perilaku drastis, tantrum intens, kesulitan fokus, atau perlu tes kesiapan sekolah formal. Untuk remaja: saat merasa tertekan, cemas berlebih, menarik diri, atau bingung arah masa depan. Untuk dewasa: ketika mengalami stres berkepanjangan, sulit mengelola emosi, masalah relasi/pernikahan, atau butuh panduan mendidik anak.'
      },
      {
        q: 'Apakah kerahasiaan isi sesi konseling dijamin aman?',
        a: 'Ya, mutlak. Seluruh data, hasil asesmen, dan cerita yang dibagikan dalam sesi konseling dilindungi penuh oleh Kode Etik Psikologi Indonesia dan asas kerahasiaan medis (confidentiality). Informasi tidak akan dibagikan ke pihak manapun tanpa persetujuan tertulis dari klien atau orang tua.'
      },
      {
        q: 'Bagaimana jika klien (anak atau remaja) menolak diajak bicara atau enggan datang?',
        a: 'Psikolog kami menggunakan pendekatan yang hangat, empatis, dan tidak memaksa (non-judgmental). Pada anak, kami menggunakan media bermain (Play Therapy) dan gambar. Pada remaja, kami membangun ruang aman yang setara agar mereka merasa didengar dan dihargai tanpa merasa dihakimi.'
      },
      {
        q: 'Apakah tes IQ atau tes kesiapan sekolah bisa digunakan untuk pendaftaran sekolah resmi?',
        a: 'Bisa. Laporan hasil tes psikologi dari Amanah Tin\'s Center diterbitkan secara resmi dengan tanda tangan dan nomor Surat Izin Praktik Psikologi (SIPP) aktif dari Psikolog Klinis berwenang, sehingga valid dan diakui oleh pihak sekolah maupun instansi pendidikan resmi.'
      }
    ]
  },

  'grup-terapi': {
    code: 'GT',
    name: 'Grup Terapi',
    shortName: 'Grup Terapi',
    badgeIcon: 'groups',
    categoryBadge: 'Program Kolaborasi Sosial • Terapi Kelompok Kecil',
    titleMain: 'Program Grup Terapi Anak & Sosial',
    titleAccent: '(Social Skills & Group Therapy)',
    heroDesc: 'Sesi terapi dalam kelompok kecil (3–6 anak) yang difasilitasi oleh terapis multidisiplin, dirancang khusus untuk melatih interaksi teman sebaya, toleransi menunggu giliran (turn-taking), komunikasi pragmatik, serta kepatuhan aturan kelompok dalam suasana menyenangkan.',
    heroImage: 'https://lh3.googleusercontent.com/aida-public/AB6AXuB67b9MYgTLA9wMNy5O-9w6TkEnA6ohATQiH43KYlSlPAmDtbLTXu9B57WwqylRdCzHjZg7YF4bb-q7SJupFjxrp4FuawKotOYM7BPa42N5RxpxS7h6YusSVGHIhzMc89oCMmGfcZMwM64SG8vYil6uUlaDoMhfxkJZwyGiNg29r65HN9Ey3IEqYnmf_CSs1nLyHBOFCOiM9-yjTVs48R71yCk3d9Uzal8zzuTfeK8',
    ctaPrimaryText: 'Konsultasi Grup Terapi',
    ctaFocusWord: 'Sosialisasi & Percaya Diri',
    heroBadgeTitle: 'Kelompok Kecil (3–6 Anak)',
    heroBadgeSub: 'Fasilitasi intensif terapis dengan peer-matching seimbang',
    specs: [
      { icon: 'schedule', label: 'Durasi Sesi', value: '60 - 90 Menit', bgClass: 'spec-bg-blue' },
      { icon: 'groups', label: 'Format Kelas', value: 'Kelompok 3–6 Anak', bgClass: 'spec-bg-green' },
      { icon: 'face', label: 'Sasaran Usia', value: 'Usia 4 – 12 Tahun', bgClass: 'spec-bg-orange' },
      { icon: 'verified_user', label: 'Fasilitator', value: 'TW + OT + Psikolog', bgClass: 'spec-bg-blue' }
    ],
    indicationsEyebrow: 'Deteksi Kebutuhan Sosial Anak',
    indicationsTitle: 'Kapan Anak Memerlukan Program Grup Terapi?',
    indicationsDesc: 'Interaksi sosial adalah keterampilan kompleks yang membutuhkan latihan nyata bersama teman sebaya. Grup terapi menjadi jembatan aman bagi anak sebelum mandiri di sekolah reguler.',
    toolbarGuidanceTitle: 'Panduan Pengamatan Ayah & Bunda',
    toolbarGuidanceText: 'Tandai kendala sosialisasi yang sering terlihat saat anak berada di taman bermain atau acara keluarga:',
    alertSub: 'Stimulasi sosial terarah dalam kelompok kecil efektif mengurangi kecemasan bergaul dan menumbuhkan rasa percaya diri anak.',
    guidanceAuthor: 'Catatan Terapis ATC',
    guidanceText: 'Anak yang sudah tuntas terapi individual 1-on-1 sering kali masih membutuhkan grup terapi sebagai jembatan simulasi sebelum masuk sekolah umum.',
    indications: [
      {
        icon: 'person_off',
        iconBg: 'ind-icon-orange',
        title: 'Hanya Bermain Sendiri (Parallel Play Menetap)',
        desc: 'Cenderung asyik sendiri dan tidak tertarik mendekati teman sebaya meskipun berada di arena bermain yang sama.',
        age: '3 - 8 Tahun'
      },
      {
        icon: 'front_hand',
        iconBg: 'ind-icon-blue',
        title: 'Sulit Menunggu Giliran & Suka Merebut',
        desc: 'Tantrum saat diminta mengantre giliran mainan, tidak sabar menunggu instruksi, atau belum memahami aturan berbagi.',
        age: '4 - 10 Tahun'
      },
      {
        icon: 'record_voice_over',
        iconBg: 'ind-icon-teal',
        title: 'Hambatan Bahasa Pragmatik Sosial',
        desc: 'Bisa berbicara lancar namun kesulitan memulai percakapan, kontak mata minim saat bicara kelompok, atau tidak merespon sapaan teman.',
        age: '4 - 12 Tahun'
      },
      {
        icon: 'sentiment_very_dissatisfied',
        iconBg: 'ind-icon-green',
        title: 'Mudah Frustrasi Saat Kalah Permainan',
        desc: 'Sering meledak marah atau mogok bermain bila aturan permainan tidak sesuai keinginannya atau mengalami kekalahan.',
        age: '5 - 11 Tahun'
      },
      {
        icon: 'lock',
        iconBg: 'ind-icon-blue',
        title: 'Kekakuan Pola Main (Rigid Behavior)',
        desc: 'Sulit diajak kompromi mengubah alur mainan, menolak ide teman kelompok, dan memaksakan aturan bermain sepihak.',
        age: '4 - 10 Tahun'
      },
      {
        icon: 'sentiment_neutral',
        iconBg: 'ind-icon-green',
        title: 'Kecemasan Sosial & Menarik Diri di Lingkungan Baru',
        desc: 'Sangat pemalu ekstrem, menempel terus pada orang tua, atau gemetar cemas ketika diminta berinteraksi bersama anak lain.',
        age: '4 - 12 Tahun'
      }
    ],
    pillars: [
      {
        icon: 'record_voice_over',
        bgClass: 'pillar-bg-blue',
        title: 'Komunikasi Pragmatik & Asertif',
        desc: 'Melatih kemampuan memulai obrolan, bertanya giliran, meminta izin pinjam mainan, mendengarkan teman, dan membaca bahasa tubuh lawan bicara secara natural.',
        bullets: [
          'Inisiasi percakapan & kontak mata bermakna',
          'Ekspresi verbal untuk meminta tolong & negosiasi',
          'Pemahaman humor sederhana dan giliran bicara'
        ]
      },
      {
        icon: 'handshake',
        bgClass: 'pillar-bg-green',
        title: 'Turn-Taking & Regulasi Bersama',
        desc: 'Stimulasi toleransi penundaan (delay of gratification), kesabaran menunggu antrean giliran, serta menjaga regulasi diri saat berada di tengah dinamika kelompok.',
        bullets: [
          'Toleransi menunggu giliran bermain terstruktur',
          'Regulasi emosi saat menghadapi kekalahan',
          'Fleksibilitas menerima aturan kompromi bersama'
        ]
      },
      {
        icon: 'extension',
        bgClass: 'pillar-bg-orange',
        title: 'Cooperative Play & Games',
        desc: 'Aktivitas bermain kooperatif berbasis proyek tim (membangun balok raksasa bersama, permainan estafet, seni kolaboratif) untuk melatih sinergi antar anak.',
        bullets: [
          'Proyek seni & permainan tim terkoordinasi',
          'Pembagian peran tugas yang adil dalam kelompok',
          'Menumbuhkan empati dan saling menyemangati teman'
        ]
      },
      {
        icon: 'psychology',
        bgClass: 'pillar-bg-teal',
        title: 'Problem Solving & Resolusi Konflik',
        desc: 'Bimbingan terapis dalam menengahi perselisihan kecil yang wajar terjadi saat bermain, melatih anak menyelesaikan masalah dengan komunikasi verbal tanpa agresi fisik.',
        bullets: [
          'Identifikasi akar masalah perselisihan bermain',
          'Teknik cooling down saat emosi mulai meningkat',
          'Saling meminta maaf dan membuat kesepakatan baru'
        ]
      }
    ],
    processTitle: 'Alur Program Grup Terapi ATC',
    processDesc: 'Setiap anak dipasangkan secara cermat ke dalam kelompok yang seimbang agar stimulasi sosial berjalan suportif dan efektif.',
    processSteps: [
      {
        number: '01',
        numBgClass: 'num-blue',
        badge: 'Skrining Kesiapan',
        badgeBgClass: 'badge-blue',
        title: 'Skrining Kesiapan & Peer-Matching',
        desc: 'Evaluasi individual untuk memetakan level regulasi emosi dan komunikasi anak agar ditempatkan pada kelompok dengan usia serta kemampuan yang setara.',
        footerIcon: 'checklist',
        footerText: 'Penyesuaian Kelompok Tepat Sasaran'
      },
      {
        number: '02',
        numBgClass: 'num-primary-cont',
        badge: 'Orientasi Sesi',
        badgeBgClass: 'badge-green',
        title: 'Sesi Pembiasaan & Kontrak Aturan',
        desc: 'Pengenalan teman kelompok, fasilitator terapis, serta pembentukan kesepakatan aturan main yang ramah dan dipahami bersama anak.',
        footerIcon: 'diversity_3',
        footerText: 'Membangun Rapport & Rasa Aman'
      },
      {
        number: '03',
        numBgClass: 'num-green',
        badge: 'Terapi Rutin',
        badgeBgClass: 'badge-orange',
        title: 'Sesi Terapi Sosial Terstruktur',
        desc: 'Rangkaian circle time, permainan kooperatif, stimulasi sensorik kelompok, dan simulasi skenario sosial nyata dengan rasio 1 terapis per 2–3 anak.',
        footerIcon: 'sports_esports',
        footerText: 'Suasana Ceria & Terarah'
      },
      {
        number: '04',
        numBgClass: 'num-dark-blue',
        badge: 'Evaluasi Berkala',
        badgeBgClass: 'badge-blue',
        title: 'Laporan Perkembangan & Feedback Ortu',
        desc: 'Pemberian laporan catatan sosial berkala dan sesi diskusi strategi penguatan keterampilan berteman di lingkungan rumah serta sekolah.',
        footerIcon: 'assignment',
        footerText: 'Laporan Progres Sosial Tertulis'
      }
    ],
    teamTitle: 'Tim Fasilitator Grup Terapi Kami',
    teamDesc: 'Didukung oleh kolaborasi praktisi Terapis Wicara, Terapis Okupasi, dan Psikolog Klinis Anak berpengalaman dalam dinamika kelompok kecil.',
    therapists: [
      {
        name: 'Annisa Larasati, A.Md.TW',
        role: 'Fasilitator Komunikasi Sosial & TW',
        bio: 'Fokus pada stimulasi kemampuan bicara pragmatik, inisiasi percakapan, dan ekspresi verbal dalam setting kelompok anak.',
        cert: 'STR Kemenkes Aktif • 7+ Th Pengalaman',
        rating: '4.95 (160+ Sesi)',
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuB9TdTX3hAv4l3XEhF6RnRoVq9SrEZWWigruM-Zmmi35kXtkmTMve9H7N1-RIYg5jM937Tx9sEWQyzXR66Neo9Sa7776w3Zo6VajIJukCAkN8s151ZqH9c7PF-4nlF1-SVkqD1DZB7BwB9tpZaUcpcSsq9obGxkdggEXSE_IuVRlN-Fsh23JI2d9iMF_qq9LXNCduvqstqvjnXBb1KvcBfZ0q46z2EUUUP0j15K0do'
      },
      {
        name: 'Budi Santoso, A.Md.OT',
        role: 'Spesialis Regulasi Perilaku Kelompok',
        bio: 'Keahlian dalam mengelola dinamika energi sensorik kelompok, toleransi giliran gerak, dan aktivitas motorik kolaboratif.',
        cert: 'Certified Sensory & Group Play Facilitator',
        rating: '4.9 (130+ Sesi)',
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCIKvDfJPyVbIyPla4wyzxNhLrF8Ce1fVTVaOqumdJmrh2Bk8V7oAZmxceDSGifuQqVl1kki4aGpoTx11e5k91D13E3IbOLK8wQjn1WI_Sl-7zRbNYinsXJ3V2vevUjDzfQnwz96Sj-elpEFz1TGMDkGcogynWSoUS19_F-iFSPo0EzFQKVk3iSrq6SDGNB96CrjY8D4dfGTmV7xw7183jxJQ6xTu9aQJYX-uGTcYA'
      },
      {
        name: 'Sarah Wijayanti, M.Psi., Psikolog',
        role: 'Konsultan Psikologi Sosial Anak',
        bio: 'Mengevaluasi kesiapan mental bergaul, penanganan kecemasan sosial anak, dan perancangan strategi peer-matching yang tepat.',
        cert: 'Psikolog Klinis SIPP Aktif • Magister UI',
        rating: '5.0 (150+ Sesi)',
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAf4OVUo-Wxnq8f6xSABM4mGtVxKAMm7lICIoE-PAxYxAZi_WeX9xbdVYLOIjzYftHDfEytV-2fKTnkbwLfFeFxQhERvsIwEIwli4j-NnHuby3Z4nZIptqt_qejl-BUIf2bOej8oKcP5I91K6rBDTT3Y_dcU9uGgiexN7tPlJ3Rl4hy_RT46xH8h_J4kmToqINJ4tSlKYrmbz3NaTyHUwpZhBG53oHWwMDE4iKDYXM'
      }
    ],
    pricingTitle: 'Pilihan Sesi & Paket Grup Terapi',
    pricingDesc: 'Investasi terjangkau untuk melatih keterampilan sosial esensial si Kecil dalam lingkungan kelompok kecil yang aman.',
    packages: [
      {
        tag: 'Sesi Trial',
        tagClass: 'tag-blue',
        title: 'Trial & Observasi Kelompok',
        subtitle: '1 sesi uji coba interaksi kelompok bersama terapis untuk menilai kecocokan peer-matching anak.',
        priceLabel: 'Total Investasi',
        price: 'Rp 275.000',
        unit: 'sesi (75 Menit)',
        features: [
          'Durasi 75 menit aktivitas kelompok terstruktur',
          'Rasio intensif (maksimal 4–5 anak per grup)',
          'Feedback langsung terapis pasca sesi',
          'Rekomendasi penempatan kelas lanjutan'
        ],
        buttonText: 'Daftar Sesi Trial',
        isPopular: false
      },
      {
        tag: 'Paling Diminati',
        tagClass: 'tag-green',
        title: 'Paket Bulanan Reguler (4x)',
        subtitle: 'Paket 4 sesi terjadwal (1 sesi/minggu) untuk pembentukan kebiasaan sosial dan antre giliran konsisten.',
        priceLabel: 'Total Investasi',
        price: 'Rp 950.000',
        unit: 'paket bulanan',
        savingNote: 'Hemat Rp 150.000 + Laporan Sosial Bulanan',
        features: [
          '4 sesi rutin terjadwal (75–90 menit/sesi)',
          'Kelompok teman sebaya yang konsisten',
          'Laporan perkembangan sosial berkala tertulis',
          'Konsultasi berkala via WhatsApp terapis'
        ],
        buttonText: 'Pilih Paket Bulanan 4x',
        isPopular: true
      },
      {
        tag: 'Program Intensif',
        tagClass: 'tag-orange',
        title: 'Paket Akselerasi Sosial (8x)',
        subtitle: 'Program intensif 8 sesi (2 sesi/minggu) untuk anak yang membutuhkan persiapan cepat adaptasi sekolah.',
        priceLabel: 'Total Investasi',
        price: 'Rp 1.800.000',
        unit: 'paket 8 sesi',
        savingNote: 'Hemat Rp 400.000 + Sesi Konseling Ortu',
        features: [
          '8 sesi intensif (75–90 menit/sesi)',
          'Simulasi skenario sosial indoor & mini outdoor',
          '1 sesi feedback psikolog privat untuk orang tua',
          'Prioritas pemilihan jadwal kelompok'
        ],
        buttonText: 'Pilih Paket Intensif 8x',
        isPopular: false
      }
    ],
    faqTitle: 'FAQ Seputar Grup Terapi Anak',
    faqDesc: 'Pertanyaan yang sering dikonsultasikan orang tua sebelum mendaftarkan anak ke sesi kelompok.',
    faqs: [
      {
        q: 'Kapan anak dikatakan siap masuk ke dalam Grup Terapi?',
        a: 'Anak idealnya sudah memiliki rentang atensi dasar minimal 5–10 menit, tidak menunjukkan agresi fisik berat yang membahayakan anak lain, dan mampu mengikuti instruksi satu langkah sederhana. Tim kami akan melakukan skrining awal untuk memastikan kesiapan anak.'
      },
      {
        q: 'Berapa jumlah anak dalam satu kelompok dan bagaimana rasionya?',
        a: 'Kelompok dibatasi hanya 3 hingga 6 anak per kelas, dan didampingi oleh 2 orang terapis profesional (rasio 1 terapis per 2–3 anak) untuk menjamin setiap anak tetap mendapatkan perhatian individual yang memadai.'
      },
      {
        q: 'Bagaimana jika anak menangis atau tantrum saat sesi berlangsung?',
        a: 'Hal tersebut sangat wajar terjadi pada proses adaptasi. Terapis kami terlatih dalam teknik de-eskalasi dan regulasi emosi. Anak akan dibimbing dengan tenang ke area cooling-down tanpa paksaan hingga siap bergabung kembali bersama teman-temannya.'
      },
      {
        q: 'Apakah grup terapi bisa menggantikan sesi terapi individual?',
        a: 'Grup terapi bersifat komplementer (pelengkap lanjutan). Untuk melatih teknik artikulasi bicara spesifik atau modulasi sensori primer, terapi individual tetap diperlukan. Grup terapi berfungsi sebagai panggung latihan mengaplikasikan kemampuan tersebut ke dunia nyata bersama teman sebaya.'
      }
    ]
  },

  'pra-vokasional': {
    code: 'PV',
    name: 'Pra Vokasional',
    shortName: 'Pra Vokasional',
    badgeIcon: 'work_history',
    categoryBadge: 'Program Transisi Mandiri • Pra Vokasional Remaja ABK',
    titleMain: 'Program Pra Vokasional & Keterampilan Kerja',
    titleAccent: '(Pre-Vocational Training)',
    heroDesc: 'Program pembekalan keterampilan hidup mandiri (ADL), disiplin kerja terapan, orientasi tugas praktis, serta adaptasi sosial di ruang publik bagi remaja berkebutuhan khusus (usia 12–18+ tahun) menuju fase transisi dewasa yang mandiri dan bermartabat.',
    heroImage: 'https://lh3.googleusercontent.com/aida-public/AB6AXuB67b9MYgTLA9wMNy5O-9w6TkEnA6ohATQiH43KYlSlPAmDtbLTXu9B57WwqylRdCzHjZg7YF4bb-q7SJupFjxrp4FuawKotOYM7BPa42N5RxpxS7h6YusSVGHIhzMc89oCMmGfcZMwM64SG8vYil6uUlaDoMhfxkJZwyGiNg29r65HN9Ey3IEqYnmf_CSs1nLyHBOFCOiM9-yjTVs48R71yCk3d9Uzal8zzuTfeK8',
    ctaPrimaryText: 'Konsultasi Pra Vokasional',
    ctaFocusWord: 'Kemandirian & Produktivitas',
    heroBadgeTitle: 'Pelatihan Kerja Terapan ABK',
    heroBadgeSub: 'Kurikulum praktis, aman & disesuaikan minat remaja',
    specs: [
      { icon: 'schedule', label: 'Durasi Sesi', value: '90 - 120 Menit', bgClass: 'spec-bg-blue' },
      { icon: 'precision_manufacturing', label: 'Metode', value: 'Project-Based Training', bgClass: 'spec-bg-green' },
      { icon: 'face', label: 'Sasaran Usia', value: 'Usia 12 – 18+ Tahun', bgClass: 'spec-bg-orange' },
      { icon: 'verified_user', label: 'Instruktur', value: 'Terapis Okupasi & Vokasi', bgClass: 'spec-bg-blue' }
    ],
    indicationsEyebrow: 'Persiapan Menuju Kemandirian Dewasa',
    indicationsTitle: 'Kapan Remaja ABK Memerlukan Program Pra Vokasional?',
    indicationsDesc: 'Memasuki usia remaja, fokus stimulasi beralih dari akademis teoritis menuju penguatan keterampilan praktis fungsional agar remaja mampu mandiri tanpa ketergantungan penuh pada keluarga.',
    toolbarGuidanceTitle: 'Panduan Evaluasi Kemandirian Remaja',
    toolbarGuidanceText: 'Tandai aspek kemandirian yang saat ini masih memerlukan pendampingan intensif di rumah:',
    alertSub: 'Pelatihan vokasional yang dimulai sedini mungkin sejak masa remaja memberikan waktu adaptasi yang cukup bagi anak meraih kemandirian hidup optimal.',
    guidanceAuthor: 'Catatan Tim Vokasi ATC',
    guidanceText: 'Kemandirian hidup (bina diri dan keuangan dasar) adalah bekal paling berharga bagi masa depan remaja berkebutuhan khusus saat memasuki usia dewasa.',
    indications: [
      {
        icon: 'accessibility_new',
        iconBg: 'ind-icon-orange',
        title: 'Ketergantungan Bina Diri Harian (ADL)',
        desc: 'Masih membutuhkan bantuan penuh dalam menyiapkan pakaian, makan, mencuci tangan, atau menjaga kebersihan diri sendiri.',
        age: '12 - 18 Tahun'
      },
      {
        icon: 'payments',
        iconBg: 'ind-icon-green',
        title: 'Kesulitan Mengenal Nilai Uang & Belanja',
        desc: 'Belum memahami nominal mata uang rupiah, tidak paham konsep kembalian, atau belum berani bertransaksi di toko/minimarket.',
        age: '12 - 18 Tahun'
      },
      {
        icon: 'checklist',
        iconBg: 'ind-icon-blue',
        title: 'Kesulitan Menyelesaikan Tugas Runtut',
        desc: 'Bingung saat menerima instruksi kerja bertingkat (misal: melipat, memasukkan ke plastik, lalu menempel stiker label).',
        age: '12 - 18 Tahun'
      },
      {
        icon: 'storefront',
        iconBg: 'ind-icon-teal',
        title: 'Kecemasan Berada di Ruang Publik',
        desc: 'Merasa sangat cemas atau canggung saat berada di lingkungan baru, tempat umum, atau berinteraksi dengan kasir dan orang luar.',
        age: '12 - 18 Tahun'
      },
      {
        icon: 'alarm',
        iconBg: 'ind-icon-orange',
        title: 'Belum Memahami Konsep Waktu & Disiplin',
        desc: 'Sulit mengatur jadwal harian mandiri, sering menunda-nunda tugas, atau tidak memahami batasan jam kerja dan istirahat.',
        age: '12 - 18 Tahun'
      },
      {
        icon: 'school',
        iconBg: 'ind-icon-blue',
        title: 'Fase Transisi Menjelang Lulus Sekolah',
        desc: 'Menjelang lulus dari SLB atau sekolah inklusi dan orang tua membutuhkan wadah pelatihan keterampilan kerja praktis lanjutan.',
        age: '14 - 18+ Tahun'
      }
    ],
    pillars: [
      {
        icon: 'home',
        bgClass: 'pillar-bg-blue',
        title: 'Bina Diri & Kemandirian Domestik',
        desc: 'Melatih kemampuan memasak makanan sederhana aman, membersihkan peralatan makan, melipat dan menyetrika pakaian, serta manajemen barang pribadi di kamar.',
        bullets: [
          'Penggunaan peralatan dapur aman & higienis',
          'Mencuci piring, menyapu, dan merapikan ruangan',
          'Perawatan kebersihan diri mandiri'
        ]
      },
      {
        icon: 'local_atm',
        bgClass: 'pillar-bg-green',
        title: 'Keterampilan Finansial & Transaksi',
        desc: 'Simulasi pengenalan mata uang kertas/koin, perhitungan belanja praktis, kalkulasi uang kembalian, hingga simulasi belanja mandiri di minimarket sungguhan.',
        bullets: [
          'Identifikasi nominal pecahan uang rupiah',
          'Simulasi kasir & etika bertransaksi sopan',
          'Pencatatan uang saku dan daftar belanjaan'
        ]
      },
      {
        icon: 'precision_manufacturing',
        bgClass: 'pillar-bg-orange',
        title: 'Simulasi Tugas Kerja & Perakitan',
        desc: 'Pelatihan tugas terapan industri sederhana: pengemasan produk (packaging), penyortiran barang (sorting), penempelan stiker label, dan pengarsipan berkas.',
        bullets: [
          'Ketelitian tugas repetitive & quality check',
          'Stamina kerja fokus 45–60 menit tanpa jeda tantrum',
          'Pembersihan & penataan area kerja (5R/5S)'
        ]
      },
      {
        icon: 'badge',
        bgClass: 'pillar-bg-teal',
        title: 'Etika Kerja & Komunikasi Interpersonal',
        desc: 'Membimbing pembentukan karakter disiplin: hadir tepat waktu, menyapa rekan kerja, meminta klarifikasi saat bingung, dan menerima umpan balik mentor.',
        bullets: [
          'Sopan santun berinteraksi dengan atasan/mentor',
          'Ketepatan waktu dan kepatuhan SOP kerja',
          'Manajemen emosi dan resolusi stres saat lelah'
        ]
      }
    ],
    processTitle: 'Alur Program Pelatihan Pra Vokasional',
    processDesc: 'Pendekatan terstruktur berbasis observasi minat bakat dan potensi unik setiap remaja ABK.',
    processSteps: [
      {
        number: '01',
        numBgClass: 'num-blue',
        badge: 'Asesmen Bakat',
        badgeBgClass: 'badge-blue',
        title: 'Asesmen Kapasitas & Minat Vokasi',
        desc: 'Pemeriksaan kemampuan motorik halus-kasar, atensi kerja, ketahanan fokus, serta pemetaan minat bidang kerja yang paling sesuai bagi remaja.',
        footerIcon: 'psychology',
        footerText: 'Pemetaan Profil Vokasi Terarah'
      },
      {
        number: '02',
        numBgClass: 'num-primary-cont',
        badge: 'Kurikulum Personalisasi',
        badgeBgClass: 'badge-green',
        title: 'Penyusunan Rencana Vokasi Individual',
        desc: 'Perancangan target keterampilan kerja fungsional yang realistis dan disepakati bersama orang tua sesuai profil kemampuan remaja.',
        footerIcon: 'assignment_turned_in',
        footerText: 'Target Kompetensi Terukur'
      },
      {
        number: '03',
        numBgClass: 'num-green',
        badge: 'Praktik Kerja',
        badgeBgClass: 'badge-orange',
        title: 'Pelatihan Kerja & Proyek Nyata',
        desc: 'Sesi latihan langsung 90–120 menit: simulasi tugas kerja riil, pembuatan produk kerajinan/kuliner sederhana, dan pembiasaan etika kerja profesional.',
        footerIcon: 'handyman',
        footerText: 'Hands-on Learning Berkelanjutan'
      },
      {
        number: '04',
        numBgClass: 'num-dark-blue',
        badge: 'Uji Mandiri',
        badgeBgClass: 'badge-blue',
        title: 'Field Trip & Portofolio Mandiri',
        desc: 'Praktik langsung di ruang publik (belanja di supermarket, naik transportasi umum) serta portofolio kompetensi kerja remaja.',
        footerIcon: 'workspace_premium',
        footerText: 'Portofolio Hasil Karya & Keterampilan'
      }
    ],
    teamTitle: 'Tim Instruktur Pra Vokasional Kami',
    teamDesc: 'Didukung oleh Terapis Okupasi klinis pediatrik dan konsultan psikologi vokasional yang sabar dan berpengalaman mendampingi remaja berkebutuhan khusus.',
    therapists: [
      {
        name: 'Budi Santoso, A.Md.OT',
        role: 'Instruktur Utama Vokasi & Terapi Okupasi',
        bio: 'Fokus pada pelatihan bina diri (ADL), koordinasi motorik kerja, ketahanan duduk kerja, dan penataan ergonomi aktivitas remaja ABK.',
        cert: 'STR Kemenkes Aktif • Anggota IOTI',
        rating: '4.95 (140+ Sesi)',
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCIKvDfJPyVbIyPla4wyzxNhLrF8Ce1fVTVaOqumdJmrh2Bk8V7oAZmxceDSGifuQqVl1kki4aGpoTx11e5k91D13E3IbOLK8wQjn1WI_Sl-7zRbNYinsXJ3V2vevUjDzfQnwz96Sj-elpEFz1TGMDkGcogynWSoUS19_F-iFSPo0EzFQKVk3iSrq6SDGNB96CrjY8D4dfGTmV7xw7183jxJQ6xTu9aQJYX-uGTcYA'
      },
      {
        name: 'Farhan Maulana, M.Psi., Psikolog',
        role: 'Psikolog Remaja & Asesmen Kerja',
        bio: 'Spesialisasi dalam evaluasi kapasitas kognitif fungsional, regulasi emosi pubertas remaja ABK, dan kesiapan mental memasuki dunia kerja.',
        cert: 'Psikolog Klinis SIPP Aktif • Anggota HIMPSI',
        rating: '4.95 (130+ Sesi)',
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAf4OVUo-Wxnq8f6xSABM4mGtVxKAMm7lICIoE-PAxYxAZi_WeX9xbdVYLOIjzYftHDfEytV-2fKTnkbwLfFeFxQhERvsIwEIwli4j-NnHuby3Z4nZIptqt_qejl-BUIf2bOej8oKcP5I91K6rBDTT3Y_dcU9uGgiexN7tPlJ3Rl4hy_RT46xH8h_J4kmToqINJ4tSlKYrmbz3NaTyHUwpZhBG53oHWwMDE4iKDYXM'
      },
      {
        name: 'Maya Indah, S.Tr.Kes',
        role: 'Fasilitator Keterampilan Hidup Mandiri',
        bio: 'Keahlian dalam simulasi transaksi belanja, keterampilan kuliner sederhana yang aman, dan pendampingan adaptasi ruang publik.',
        cert: 'Terapis Okupasi Klinis • 6+ Th Praktik',
        rating: '4.9 (115+ Sesi)',
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuB9TdTX3hAv4l3XEhF6RnRoVq9SrEZWWigruM-Zmmi35kXtkmTMve9H7N1-RIYg5jM937Tx9sEWQyzXR66Neo9Sa7776w3Zo6VajIJukCAkN8s151ZqH9c7PF-4nlF1-SVkqD1DZB7BwB9tpZaUcpcSsq9obGxkdggEXSE_IuVRlN-Fsh23JI2d9iMF_qq9LXNCduvqstqvjnXBb1KvcBfZ0q46z2EUUUP0j15K0do'
      }
    ],
    pricingTitle: 'Investasi Program Pra Vokasional',
    pricingDesc: 'Bekal kemandirian terbaik yang akan bermanfaat seumur hidup bagi kemandirian dan rasa percaya diri remaja Anda.',
    packages: [
      {
        tag: 'Langkah Awal',
        tagClass: 'tag-blue',
        title: 'Asesmen Kesiapan Vokasi',
        subtitle: 'Sesi evaluasi menyeluruh kapasitas motorik kerja, kemandirian ADL, dan minat vokasional remaja.',
        priceLabel: 'Total Investasi',
        price: 'Rp 350.000',
        unit: 'sesi asesmen',
        features: [
          'Durasi 90 menit pemeriksaan tatap muka',
          'Pemetaan profil keterampilan kerja dasar',
          'Laporan rekomendasi kurikulum vokasi tertulis',
          'Sesi konsultasi 30 menit bersama orang tua'
        ],
        buttonText: 'Jadwalkan Asesmen Vokasi',
        isPopular: false
      },
      {
        tag: 'Rekomendasi Utama',
        tagClass: 'tag-green',
        title: 'Paket Vokasi Bulanan (4x Sesi)',
        subtitle: '4 sesi intensif pelatihan kerja terapan @ 90–120 menit dengan modul proyek fungsional terarah.',
        priceLabel: 'Total Investasi',
        price: 'Rp 1.100.000',
        unit: 'paket bulanan',
        savingNote: 'Termasuk Bahan Praktik & Laporan Progres',
        features: [
          '4 sesi tatap muka intensif (90–120 menit/sesi)',
          'Modul bina diri, tugas kerja & finansial dasar',
          'Sudah termasuk seluruh alat & bahan praktik',
          'Laporan capaian kemandirian berkala'
        ],
        buttonText: 'Pilih Paket Bulanan',
        isPopular: true
      },
      {
        tag: 'Program Terpadu',
        tagClass: 'tag-orange',
        title: 'Paket Akselerasi Mandiri (8x + Field Trip)',
        subtitle: 'Program intensif 8 sesi kerja terapan ditambah 1 sesi simulasi belanja & transportasi di ruang publik.',
        priceLabel: 'Total Investasi',
        price: 'Rp 2.100.000',
        unit: 'paket lengkap',
        savingNote: 'Hemat Rp 300.000 + Didampingi 2 Mentor',
        features: [
          '8 sesi praktik kerja intensif di center',
          '1 sesi field trip praktik belanja minimarket',
          'Portofolio keterampilan kerja resmi tercetak',
          'Sesi evaluasi komprehensif bersama keluarga'
        ],
        buttonText: 'Pilih Paket Akselerasi 8x',
        isPopular: false
      }
    ],
    faqTitle: 'FAQ Seputar Program Pra Vokasional',
    faqDesc: 'Pertanyaan umum mengenai pelaksanaan program vokasi bagi remaja berkebutuhan khusus.',
    faqs: [
      {
        q: 'Remaja dengan diagnosa apa saja yang dapat mengikuti program ini?',
        a: 'Program ini terbuka untuk remaja usia 12–18+ tahun dengan berbagai latar belakang, termasuk Spektrum Autisme, Down Syndrome, ADHD, Intellectual Disability ringan-sedang, maupun kesulitan belajar spesifik yang membutuhkan kemandirian hidup.'
      },
      {
        q: 'Apa saja output nyata yang didapatkan remaja setelah mengikuti pelatihan?',
        a: 'Remaja akan memiliki keterampilan bina diri yang lebih mandiri di rumah, pemahaman nominal uang dan transaksi belanja sederhana, ketahanan bekerja fokus pada tugas terstruktur, serta sikap sopan santun dan etika komunikasi di ruang publik.'
      },
      {
        q: 'Bagaimana peran dan keterlibatan orang tua dalam program ini?',
        a: 'Orang tua adalah mitra utama. Di akhir setiap sesi, terapis memberikan panduan tugas rumah (home program) agar kebiasaan mandiri yang dilatih di klinik dapat langsung diterapkan dan dipertahankan dalam kehidupan sehari-hari di rumah.'
      },
      {
        q: 'Apakah ada ujian atau portofolio yang diberikan?',
        a: 'Ya. Setiap siswa pra vokasional akan memiliki Buku Portofolio Kemandirian yang mendokumentasikan daftar keterampilan (checklist kompetensi) yang sudah dikuasai beserta dokumentasi karya selama proses pelatihan.'
      }
    ]
  },

  'kelas-persiapan-khusus': {
    code: 'KPK',
    name: 'Kelas Persiapan Khusus',
    shortName: 'Kelas Persiapan',
    badgeIcon: 'school',
    categoryBadge: 'Program Transisi Sekolah • Kelas Persiapan Khusus Masuk SD/TK',
    titleMain: 'Kelas Persiapan Khusus Masuk Sekolah',
    titleAccent: '(School Readiness & Transition)',
    heroDesc: 'Program transisi sekolah intensif dalam kelompok kecil (3–5 anak) untuk membekali anak berkebutuhan khusus dengan kesiapan pra-akademik, ketahanan duduk fokus, kepatuhan instruksi kelas, serta kemandirian sosial menjelang masuk TK atau SD formal.',
    heroImage: 'https://lh3.googleusercontent.com/aida-public/AB6AXuB67b9MYgTLA9wMNy5O-9w6TkEnA6ohATQiH43KYlSlPAmDtbLTXu9B57WwqylRdCzHjZg7YF4bb-q7SJupFjxrp4FuawKotOYM7BPa42N5RxpxS7h6YusSVGHIhzMc89oCMmGfcZMwM64SG8vYil6uUlaDoMhfxkJZwyGiNg29r65HN9Ey3IEqYnmf_CSs1nLyHBOFCOiM9-yjTVs48R71yCk3d9Uzal8zzuTfeK8',
    ctaPrimaryText: 'Daftar Kelas Persiapan',
    ctaFocusWord: 'Kesiapan Sekolah & Kemandirian',
    heroBadgeTitle: 'Simulasi Ruang Kelas Nyata',
    heroBadgeSub: 'Kelompok kecil 3–5 anak dipandu terapis pedagogik',
    specs: [
      { icon: 'schedule', label: 'Durasi Sesi', value: '60 - 90 Menit', bgClass: 'spec-bg-blue' },
      { icon: 'chair_alt', label: 'Setting Kelas', value: 'Simulasi Kelas 3–5 Anak', bgClass: 'spec-bg-green' },
      { icon: 'face', label: 'Sasaran Usia', value: 'Usia 4 – 9 Tahun', bgClass: 'spec-bg-orange' },
      { icon: 'verified_user', label: 'Pengajar', value: 'Pedagogik & Terapis Anak', bgClass: 'spec-bg-blue' }
    ],
    indicationsEyebrow: 'Evaluasi Kesiapan Masuk Sekolah Formal',
    indicationsTitle: 'Kapan Anak Memerlukan Kelas Persiapan Khusus?',
    indicationsDesc: 'Banyak anak mengalami kaget (*culture shock*) saat beralih dari terapi 1-on-1 ke ruang kelas formal yang ramai. Kelas persiapan khusus menjembatani transisi tersebut agar anak siap belajar tanpa stres berlebih.',
    toolbarGuidanceTitle: 'Panduan Observasi Kesiapan Sekolah',
    toolbarGuidanceText: 'Tandai tanda-tanda yang saat ini masih menjadi kekhawatiran menjelang pendaftaran sekolah formal:',
    alertSub: 'Pembiasaan rutinitas sekolah sejak dini sangat membantu mencegah penolakan sekolah (school refusal) dan tantrum di minggu-minggu pertama masuk kelas.',
    guidanceAuthor: 'Catatan Guru & Terapis ATC',
    guidanceText: 'Kesiapan sekolah bukan hanya tentang bisa membaca dan berhitung, tetapi terutama kemampuan duduk tenang, memahami aturan kelas, dan regulasi mandiri.',
    indications: [
      {
        icon: 'airline_seat_recline_normal',
        iconBg: 'ind-icon-orange',
        title: 'Belum Bisa Duduk Tenang (Inseat Behavior Minim)',
        desc: 'Hanya mampu duduk kurang dari 5 menit, sering berlari-lari keliling meja, atau mudah terdistraksi benda di sekitar ruangan.',
        age: '4 - 8 Tahun'
      },
      {
        icon: 'record_voice_over',
        iconBg: 'ind-icon-blue',
        title: 'Bingung Mengikuti Instruksi Kelompok',
        desc: 'Hanya merespon bila dipanggil namanya secara individual 1-on-1, bingung saat guru memberi instruksi serentak pada seisi kelas.',
        age: '4 - 9 Tahun'
      },
      {
        icon: 'edit_note',
        iconBg: 'ind-icon-green',
        title: 'Kelemahan Motorik Halus Menulis (Pencil Grip)',
        desc: 'Genggaman pensil masih menggunakan kepalan tangan (fisted grip), tulisan sangat tipis, atau cepat mengeluh pegal saat mewarnai.',
        age: '4 - 8 Tahun'
      },
      {
        icon: 'numbers',
        iconBg: 'ind-icon-teal',
        title: 'Hambatan Pra-Membaca & Pra-Berhitung',
        desc: 'Kesulitan mengenali simbol huruf dasar, angka, membedakan konsep arah (kiri-kanan), atau konsep kuantitas banyak-sedikit.',
        age: '5 - 9 Tahun'
      },
      {
        icon: 'warning',
        iconBg: 'ind-icon-orange',
        title: 'Tantrum Saat Transisi Aktivitas Belajar',
        desc: 'Menolak keras saat waktu bermain bebas selesai dan harus berganti mengerjakan lembar tugas (*desk work*) di meja.',
        age: '4 - 8 Tahun'
      },
      {
        icon: 'backpack',
        iconBg: 'ind-icon-blue',
        title: 'Belum Mandiri Mengurus Perlengkapan Sendiri',
        desc: 'Masih bergantung penuh pada orang tua untuk membuka tas, memakai sepatu, mengeluarkan botol minum, atau izin ke toilet.',
        age: '4 - 9 Tahun'
      }
    ],
    pillars: [
      {
        icon: 'chair_alt',
        bgClass: 'pillar-bg-blue',
        title: 'Ketahanan Duduk & Fokus Meja (Desk Work)',
        desc: 'Melatih postur duduk ergonomis, ketahanan atensi fokus menyelesaikan tugas lembar kerja bertahap dari 10 menit hingga 30 menit tanpa terdistraksi.',
        bullets: [
          'Postur duduk tegak dan stabilitas core tubuh',
          'Fokus konsentrasi menyelesaikan tugas sampai tuntas',
          'Toleransi terhadap instruksi meja bertingkat'
        ]
      },
      {
        icon: 'notifications_active',
        bgClass: 'pillar-bg-green',
        title: 'Pemahaman Rutinitas & Aturan Kelas',
        desc: 'Simulasi tata tertib sekolah formal: berbaris tertib, merespon bel tanda masuk/istirahat, mengangkat tangan saat ingin bertanya, dan mendengarkan guru.',
        bullets: [
          'Kepatuhan instruksi kelompok dari depan kelas',
          'Rutinitas meletakkan tas dan sepatu pada loker',
          'Etika bertanya dan menunggu giliran bicara'
        ]
      },
      {
        icon: 'menu_book',
        bgClass: 'pillar-bg-orange',
        title: 'Stimulasi Pra-Akademik Terpadu (Pra-Calistung)',
        desc: 'Penguatan fondasi belajar: diskriminasi bentuk huruf/angka, koordinasi mata-tangan menulis garis, fonemik awal, serta logika spasial berhitung dasar.',
        bullets: [
          'Pematangan tripot grip memegang alat tulis',
          'Pengenalan bentuk huruf, bunyi fonetik, dan angka',
          'Diskriminasi visual gambar dan konsep ruang'
        ]
      },
      {
        icon: 'wc',
        bgClass: 'pillar-bg-teal',
        title: 'Kemandirian Bina Diri Sekolah',
        desc: 'Pelatihan kemandirian praktis tanpa ketergantungan orang tua: toilet training mandiri, membuka dan menutup kotak makan, serta merapikan alat tulis.',
        bullets: [
          'Toilet training mandiri & mencuci tangan bersih',
          'Makan bekal dan minum secara tertib mandiri',
          'Kesiapan mental berpisah hangat dari orang tua'
        ]
      }
    ],
    processTitle: 'Tahapan Program Kelas Persiapan Khusus',
    processDesc: 'Didampingi secara terukur dari skrining kematangan sekolah hingga rekomendasi formal untuk sekolah tujuan.',
    processSteps: [
      {
        number: '01',
        numBgClass: 'num-blue',
        badge: 'Tes Kematangan',
        badgeBgClass: 'badge-blue',
        title: 'Asesmen Kesiapan Masuk Sekolah (NST)',
        desc: 'Pemeriksaan standar Nijmeegse Schoolbekwaamheids Test (NST) dan observasi perilaku untuk melihat kematangan motorik, emosi, dan kognitif anak.',
        footerIcon: 'assignment_turned_in',
        footerText: 'Pemetaan Tingkat Kesiapan Sekolah'
      },
      {
        number: '02',
        numBgClass: 'num-primary-cont',
        badge: 'Setting Kelas',
        badgeBgClass: 'badge-green',
        title: 'Penempatan Kelas Simulasi Transisi',
        desc: 'Anak ditempatkan dalam kelompok kecil (3–5 siswa) dengan jadwal rutin terstruktur yang menyerupai jam sekolah sesungguhnya.',
        footerIcon: 'meeting_room',
        footerText: 'Suasana Ruang Kelas Kondusif'
      },
      {
        number: '03',
        numBgClass: 'num-green',
        badge: 'Simulasi Rutin',
        badgeBgClass: 'badge-orange',
        title: 'Pelaksanaan Pembiasaan Kelas Mandiri',
        desc: 'Sesi latihan rutin 60–90 menit yang mencakup circle time, instruksi guru di papan tulis, lembar kerja meja, dan waktu istirahat makan bekal bersama.',
        footerIcon: 'auto_stories',
        footerText: 'Adaptasi Menyenangkan Tanpa Trauma'
      },
      {
        number: '04',
        numBgClass: 'num-dark-blue',
        badge: 'Rekomendasi',
        badgeBgClass: 'badge-blue',
        title: 'Laporan Resmi & Rekomendasi Sekolah',
        desc: 'Penerbitan surat rekomendasi resmi dan laporan profil kesiapan sekolah untuk dilampirkan pada pendaftaran TK/SD inklusi atau reguler.',
        footerIcon: 'verified',
        footerText: 'Surat Rekomendasi Formal Sekolah'
      }
    ],
    teamTitle: 'Tim Pengajar Kelas Persiapan Kami',
    teamDesc: 'Kolaborasi praktisi Pendidikan Khusus (PKh), Terapis Wicara & Okupasi, serta Psikolog Anak berpengalaman mendampingi proses adaptasi sekolah inklusi.',
    therapists: [
      {
        name: 'Sarah Wijayanti, M.Psi., Psikolog',
        role: 'Evaluator Kesiapan Sekolah & Psikolog Anak',
        bio: 'Berpengalaman dalam pelaksanaan tes kesiapan sekolah formal (NST), evaluasi profil kecerdasan, dan rekomendasi akomodasi belajar anak di sekolah.',
        cert: 'Psikolog Klinis SIPP Aktif • Magister UI',
        rating: '5.0 (150+ Sesi)',
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuB9TdTX3hAv4l3XEhF6RnRoVq9SrEZWWigruM-Zmmi35kXtkmTMve9H7N1-RIYg5jM937Tx9sEWQyzXR66Neo9Sa7776w3Zo6VajIJukCAkN8s151ZqH9c7PF-4nlF1-SVkqD1DZB7BwB9tpZaUcpcSsq9obGxkdggEXSE_IuVRlN-Fsh23JI2d9iMF_qq9LXNCduvqstqvjnXBb1KvcBfZ0q46z2EUUUP0j15K0do'
      },
      {
        name: 'Maya Indah, S.Tr.Kes',
        role: 'Spesialis Motorik Halus & Pra-Menulis',
        bio: 'Fokus pada stimulasi penguatan otot tangan, ergonomi pensil (tripot grip), koordinasi visual motorik, dan ketahanan duduk tegak di meja kelas.',
        cert: 'STR Kemenkes Aktif • Praktisi Okupasi',
        rating: '4.9 (125+ Sesi)',
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCIKvDfJPyVbIyPla4wyzxNhLrF8Ce1fVTVaOqumdJmrh2Bk8V7oAZmxceDSGifuQqVl1kki4aGpoTx11e5k91D13E3IbOLK8wQjn1WI_Sl-7zRbNYinsXJ3V2vevUjDzfQnwz96Sj-elpEFz1TGMDkGcogynWSoUS19_F-iFSPo0EzFQKVk3iSrq6SDGNB96CrjY8D4dfGTmV7xw7183jxJQ6xTu9aQJYX-uGTcYA'
      },
      {
        name: 'Annisa Larasati, A.Md.TW',
        role: 'Stimulasi Pemahaman Instruksi Kelas',
        bio: 'Melatih kemampuan menyimak instruksi guru, pemahaman konsep bahasa verbal kelas, serta keberanian bertanya secara asertif di sekolah.',
        cert: 'Terapis Wicara Berlisensi STR • 7+ Th Pengalaman',
        rating: '4.95 (145+ Sesi)',
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAf4OVUo-Wxnq8f6xSABM4mGtVxKAMm7lICIoE-PAxYxAZi_WeX9xbdVYLOIjzYftHDfEytV-2fKTnkbwLfFeFxQhERvsIwEIwli4j-NnHuby3Z4nZIptqt_qejl-BUIf2bOej8oKcP5I91K6rBDTT3Y_dcU9uGgiexN7tPlJ3Rl4hy_RT46xH8h_J4kmToqINJ4tSlKYrmbz3NaTyHUwpZhBG53oHWwMDE4iKDYXM'
      }
    ],
    pricingTitle: 'Investasi Kelas Persiapan Khusus',
    pricingDesc: 'Persiapan matang yang menghindarkan anak dari trauma mogok sekolah dan kebingungan di tahun pertama sekolah formal.',
    packages: [
      {
        tag: 'Pemeriksaan Awal',
        tagClass: 'tag-blue',
        title: 'Paket Tes Kesiapan Sekolah (NST)',
        subtitle: 'Pemeriksaan psikotes terstandar kesiapan masuk SD lengkap dengan surat rekomendasi resmi bertanda tangan SIPP.',
        priceLabel: 'Total Investasi',
        price: 'Rp 650.000',
        unit: 'paket asesmen',
        features: [
          'Pemeriksaan tes NST / tes kesiapan masuk SD',
          'Sesi tatap muka psikolog klinis berizin',
          'Laporan psikologis tertulis resmi berstempel',
          'Sesi feedback penjelasan 30 menit bersama orang tua'
        ],
        buttonText: 'Daftar Tes Kesiapan SD',
        isPopular: false
      },
      {
        tag: 'Program Utama',
        tagClass: 'tag-green',
        title: 'Paket Kelas Transisi Bulanan (4x)',
        subtitle: '4 sesi kelas simulasi transisi sekolah (@ 60–90 menit) dalam kelompok kecil 3–5 anak dipandu terapis.',
        priceLabel: 'Total Investasi',
        price: 'Rp 1.050.000',
        unit: 'paket bulanan',
        savingNote: 'Termasuk Lembar Kerja & Laporan Bulanan',
        features: [
          '4 sesi rutin terjadwal (60–90 menit/sesi)',
          'Simulasi kelas formal & pembiasaan aturan sekolah',
          'Seluruh lembar kerja pra-akademik disediakan',
          'Laporan evaluasi adaptasi kelas berkala'
        ],
        buttonText: 'Pilih Kelas Transisi 4x',
        isPopular: true
      },
      {
        tag: 'Persiapan Lengkap',
        tagClass: 'tag-orange',
        title: 'Paket Intensif Siap Masuk SD (12x Sesi)',
        subtitle: 'Program intensif 3 bulan (1 sesi/minggu) atau 6 minggu (2 sesi/minggu) untuk akselerasi kesiapan total.',
        priceLabel: 'Total Investasi',
        price: 'Rp 2.800.000',
        unit: 'paket 12 sesi',
        savingNote: 'Hemat Rp 350.000 + Termasuk Tes NST Resmi',
        features: [
          '12 sesi intensif simulasi kelas transisi sekolah',
          'Sudah termasuk Asesmen Tes NST Resmi SIPP',
          'Sesi konsultasi persiapan pendaftaran sekolah',
          'Rekomendasi kebutuhan shadow teacher bila diperlukan'
        ],
        buttonText: 'Pilih Paket Intensif 12x',
        isPopular: false
      }
    ],
    faqTitle: 'FAQ Kelas Persiapan Khusus Masuk Sekolah',
    faqDesc: 'Pertanyaan yang sering diajukan orang tua seputar kelas persiapan transisi sekolah.',
    faqs: [
      {
        q: 'Apa perbedaan kelas persiapan khusus dengan les calistung biasa?',
        a: 'Les calistung biasa hanya fokus pada hafalan huruf dan angka tanpa memperhatikan kematangan sensorik, motorik halus, maupun regulasi emosi. Kelas Persiapan Khusus di ATC melatih kesiapan komprehensif: ketahanan duduk tenang, pemahaman instruksi kelas kelompok, kemandirian memakai tas/sepatu, serta interaksi sosial sebaya.'
      },
      {
        q: 'Apakah program ini bisa membantu menentukan sekolah yang tepat bagi anak?',
        a: 'Bisa. Berdasarkan hasil observasi selama kelas persiapan dan tes NST, tim psikolog kami akan memberikan rekomendasi obyektif mengenai tipe sekolah yang paling cocok (apakah sekolah reguler umum, sekolah inklusi dengan pendampingan, atau sekolah khusus).'
      },
      {
        q: 'Bagaimana jika anak belum tuntas terapi wicara atau okupasi?',
        a: 'Kelas persiapan khusus dapat dijalankan bersamaan (paralel) dengan terapi individual 1-on-1. Di sesi individual anak melatih organ artikulasi atau modulasi sensori primernya, sedangkan di kelas persiapan khusus anak mempraktikkan keterampilan tersebut dalam suasana ruang kelas mini.'
      },
      {
        q: 'Apakah orang tua mendampingi anak di dalam ruang kelas?',
        a: 'Pada 1–2 sesi awal penyesuaian, orang tua diperbolehkan memantau dari pintu atau mendampingi jika anak cemas berlebih. Namun target utama program adalah melatih kemandirian, sehingga secara bertahap anak dibimbing mandiri di dalam kelas bersama guru dan teman-temannya.'
      }
    ]
  }
}

// Alias routes for psychology services
allServicesData['psikolog'] = allServicesData['psikologi-anak']
allServicesData['psikologi'] = allServicesData['psikologi-anak']
allServicesData['psikologi-remaja'] = allServicesData['psikologi-anak']
allServicesData['psikologi-dewasa'] = allServicesData['psikologi-anak']

// Alias routes for group, vocational, and school preparation
allServicesData['group-therapy'] = allServicesData['grup-terapi']
allServicesData['prevocational'] = allServicesData['pra-vokasional']
allServicesData['vokasional'] = allServicesData['pra-vokasional']
allServicesData['kelas-persiapan'] = allServicesData['kelas-persiapan-khusus']

const service = computed(() => {
  const slug = route.params.slug
  if (slug && allServicesData[slug]) {
    return allServicesData[slug]
  }
  // Default fallback to Terapi Wicara if not found or empty
  return allServicesData['terapi-wicara']
})

const serviceCategoryMap = {
  'terapi-wicara': {
    category: 'tw',
    fallbackRegex: /\b(wicara|speech)\b/i,
  },
  'terapi-okupasi': {
    category: 'ot',
    fallbackRegex: /\b(okupasi|occupational)\b/i,
  },
  'sensori-integrasi': {
    category: 'si',
    fallbackRegex: /\b(sensori|sensory)\b/i,
  },
  'psikologi-anak': {
    category: 'psi',
    fallbackRegex: /\b(psikolog|psikologi)\b/i,
  },
  'psikolog': {
    category: 'psi',
    fallbackRegex: /\b(psikolog|psikologi)\b/i,
  },
  'psikologi': {
    category: 'psi',
    fallbackRegex: /\b(psikolog|psikologi)\b/i,
  },
  'psikologi-remaja': {
    category: 'psi',
    fallbackRegex: /\b(psikolog|psikologi)\b/i,
  },
  'psikologi-dewasa': {
    category: 'psi',
    fallbackRegex: /\b(psikolog|psikologi)\b/i,
  },
  'fisioterapi-anak': {
    category: 'ft',
    fallbackRegex: /\b(fisioterapi|fisioterapis)\b/i,
  },
  'grup-terapi': {
    category: 'gt',
    fallbackRegex: /\b(grup|group|sosial|kelompok)\b/i,
  },
  'group-therapy': {
    category: 'gt',
    fallbackRegex: /\b(grup|group|sosial|kelompok)\b/i,
  },
  'pra-vokasional': {
    category: 'pv',
    fallbackRegex: /\b(vokasi|vokasional|vocational|remaja)\b/i,
  },
  'prevocational': {
    category: 'pv',
    fallbackRegex: /\b(vokasi|vokasional|vocational|remaja)\b/i,
  },
  'vokasional': {
    category: 'pv',
    fallbackRegex: /\b(vokasi|vokasional|vocational|remaja)\b/i,
  },
  'kelas-persiapan-khusus': {
    category: 'kpk',
    fallbackRegex: /\b(persiapan|transisi|sekolah)\b/i,
  },
  'kelas-persiapan': {
    category: 'kpk',
    fallbackRegex: /\b(persiapan|transisi|sekolah)\b/i,
  },
}

const serviceTherapists = computed(() => {
  const currentSlug = route.params.slug || 'terapi-wicara'
  const filterConfig = serviceCategoryMap[currentSlug]

  if (apiTeam.value && apiTeam.value.length > 0) {
    const matched = apiTeam.value.filter((member) => {
      if (member.is_active === false || member.is_active === 0) return false

      if (filterConfig) {
        // 1. Prioritaskan kecocokan kategori resmi dari database/portal admin
        if (member.category) {
          return String(member.category).toLowerCase().trim() === filterConfig.category
        }

        // 2. Fallback hanya jika data lama tidak memiliki kolom kategori
        const combined = [
          member.role,
          member.specialization,
          Array.isArray(member.tags) ? member.tags.join(' ') : member.tags
        ].filter(Boolean).join(' ')

        return filterConfig.fallbackRegex ? filterConfig.fallbackRegex.test(combined) : false
      }
      return false
    })

    if (matched.length > 0) {
      return matched.slice(0, 3).map((m) => {
        let certText = ''
        if (Array.isArray(m.certifications) && m.certifications.length > 0) {
          certText = m.certifications[0]
        } else if (typeof m.certifications === 'string' && m.certifications.trim()) {
          try {
            const parsed = JSON.parse(m.certifications)
            certText = Array.isArray(parsed) && parsed.length > 0 ? parsed[0] : m.certifications
          } catch {
            certText = m.certifications
          }
        }
        if (!certText) {
          certText = m.edu || m.specialization || 'Terapis Berlisensi'
        }

        const isPsi = (m.category && m.category.toLowerCase() === 'psi') ||
          ((m.role || '').toLowerCase().includes('psikolog'))

        const strBadge = isPsi
          ? (m.str_number ? 'SIPP Terdaftar HIMPSI' : 'Psikolog Anak')
          : (m.str_number ? 'STR Aktif Kemenkes' : 'Praktisi Terverifikasi')

        let expText = ''
        if (m.experience_years) {
          expText = m.experience_years.includes('Tahun')
            ? m.experience_years
            : `${m.experience_years} Pengalaman`
        } else {
          expText = 'Praktisi Berpengalaman'
        }

        return {
          id: m.id,
          name: m.name,
          role: m.role || m.specialization || 'Terapis Klinis ATC',
          bio: m.bio || 'Praktisi terapis di Amanah Tin\'s Center yang berdedikasi mendampingi tumbuh kembang optimal anak.',
          image: m.image || 'https://images.unsplash.com/photo-1594824813576-641505c87e5b?auto=format&fit=crop&q=80&w=600',
          strBadge,
          strNumber: m.str_number || null,
          cert: certText,
          rating: m.rating || null,
          experience: expText,
          schedule: m.schedule || null
        }
      })
    }
  }

  // Graceful fallback to static mock data in allServicesData (maksimal 3)
  return (service.value?.therapists || []).slice(0, 3)
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
  grid-template-columns: minmax(0, 1.15fr) minmax(360px, 0.85fr);
  gap: 2.5rem;
  align-items: center;
  position: relative;
  z-index: 2;
}

.hero-content {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
  min-width: 0;
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
  grid-template-columns: repeat(4, minmax(0, 1fr));
  gap: 0.625rem;
  background: var(--surface-container-lowest);
  padding: 0.75rem;
  border-radius: 1rem;
  border: 1px solid rgba(191, 200, 206, 0.4);
  box-shadow: 0 8px 24px -4px rgba(58, 134, 168, 0.08);
  min-width: 0;
}

.spec-card {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.625rem 0.625rem;
  border-radius: 0.75rem;
  background: var(--surface-container-low);
  min-width: 0;
}

.spec-icon {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.spec-icon .material-symbols-outlined {
  font-size: 19px;
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
  min-width: 0;
  overflow: hidden;
}

.spec-label {
  font-size: 11px;
  color: var(--on-surface-variant);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.spec-val {
  font-size: 12.5px;
  font-weight: 700;
  color: var(--on-surface);
  line-height: 1.3;
  word-break: normal;
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
  min-width: 0;
  width: 100%;
}

.visual-frame {
  position: relative;
  border-radius: 1.5rem;
  overflow: hidden;
  background: rgba(209, 228, 251, 0.5);
  border: 4px solid var(--surface-container-lowest);
  box-shadow: 0 16px 36px -6px rgba(43, 61, 79, 0.12);
  width: 100%;
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
  background: rgba(255, 255, 255, 0.96);
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
  padding: 0.875rem 1rem;
  border-radius: 1rem;
  border: 1px solid rgba(191, 200, 206, 0.4);
  box-shadow: 0 10px 24px rgba(0, 0, 0, 0.1);
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 0.75rem;
  box-sizing: border-box;
}

.float-tag-left {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  min-width: 0;
  flex: 1;
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
  font-size: 13.5px;
  font-weight: 700;
  color: var(--on-surface);
  margin-bottom: 2px;
  line-height: 1.25;
}

.float-tag-sub {
  font-size: 11.5px;
  color: var(--on-surface-variant);
  line-height: 1.35;
}

.float-loc-pill {
  font-size: 11px;
  font-weight: 700;
  color: var(--primary);
  background: rgba(193, 232, 255, 0.75);
  padding: 0.35rem 0.65rem;
  border-radius: 9999px;
  white-space: nowrap;
  flex-shrink: 0;
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

.therapists-action-wrap {
  margin-top: 2.5rem;
  display: flex;
  justify-content: center;
}

.btn-all-team {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.75rem 1.75rem;
  border-radius: 9999px;
  background: var(--surface-container-lowest);
  border: 1.5px solid rgba(0, 99, 132, 0.25);
  color: var(--primary);
  font-weight: 700;
  font-size: 14px;
  text-decoration: none;
  transition: all 0.2s ease;
}

.btn-all-team:hover {
  background: var(--primary);
  color: #ffffff;
  border-color: var(--primary);
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 99, 132, 0.2);
}

/* Skeleton Loading Shimmer */
.skeleton-shimmer {
  background: linear-gradient(90deg, #f0f3f6 0%, #e6ebf0 50%, #f0f3f6 100%);
  background-size: 200% 100%;
  animation: shimmer 1.5s infinite;
}

@keyframes shimmer {
  0% { background-position: 200% 0; }
  100% { background-position: -200% 0; }
}

.skeleton-title {
  height: 18px;
  width: 75%;
  border-radius: 6px;
  margin-bottom: 8px;
}

.skeleton-sub {
  height: 14px;
  width: 50%;
  border-radius: 4px;
}

.skeleton-bio {
  height: 13px;
  width: 100%;
  border-radius: 4px;
  margin-top: 6px;
}

.skeleton-bio2 {
  height: 13px;
  width: 85%;
  border-radius: 4px;
  margin-top: 4px;
}

.skeleton-badge {
  height: 14px;
  width: 40%;
  border-radius: 4px;
}

.skeleton-star {
  height: 14px;
  width: 25%;
  border-radius: 4px;
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
@media (max-width: 1200px) {
  .specs-bento {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }
}

@media (max-width: 1024px) {
  .hero-grid {
    grid-template-columns: 1fr;
    gap: 2rem;
  }
  .specs-bento {
    grid-template-columns: repeat(2, minmax(0, 1fr));
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
/* ==================== SECTION AGE CATEGORIES (3 KATEGORI PSIKOLOGI) ==================== */
.section-age-categories {
  padding: 4.5rem 0;
  background: linear-gradient(180deg, var(--surface) 0%, var(--surface-container-low) 100%);
  border-bottom: 1px solid rgba(191, 200, 206, 0.3);
}

.age-categories-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.75rem;
}

.age-cat-card {
  background: var(--surface);
  border: 1px solid rgba(191, 200, 206, 0.4);
  border-radius: 1.25rem;
  padding: 2rem 1.75rem;
  display: flex;
  flex-direction: column;
  transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
  position: relative;
}

.age-cat-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 28px -6px rgba(0, 48, 73, 0.1);
  border-color: var(--primary);
}

.age-cat-top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 1.25rem;
}

.age-cat-icon-wrap {
  width: 48px;
  height: 48px;
  border-radius: 0.875rem;
  display: flex;
  align-items: center;
  justify-content: center;
}

.age-cat-icon-wrap .material-symbols-outlined {
  font-size: 26px;
}

.icon-bg-blue {
  background: rgba(0, 99, 132, 0.12);
  color: var(--primary);
}

.icon-bg-green {
  background: rgba(75, 103, 22, 0.12);
  color: var(--secondary);
}

.icon-bg-orange {
  background: rgba(136, 78, 3, 0.12);
  color: var(--tertiary);
}

.age-cat-badge {
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  padding: 0.25rem 0.625rem;
  border-radius: 999px;
}

.badge-cat-blue {
  background: rgba(0, 99, 132, 0.08);
  color: var(--primary);
  border: 1px solid rgba(0, 99, 132, 0.2);
}

.badge-cat-green {
  background: rgba(75, 103, 22, 0.08);
  color: var(--secondary);
  border: 1px solid rgba(75, 103, 22, 0.2);
}

.badge-cat-orange {
  background: rgba(136, 78, 3, 0.08);
  color: var(--tertiary);
  border: 1px solid rgba(136, 78, 3, 0.2);
}

.age-cat-title {
  font-family: var(--font-headline);
  font-size: 1.25rem;
  font-weight: 700;
  color: var(--on-surface);
  margin-bottom: 0.35rem;
}

.age-cat-target {
  display: flex;
  align-items: center;
  gap: 0.375rem;
  font-size: 13px;
  color: var(--on-surface-variant);
  margin-bottom: 0.875rem;
}

.age-cat-target .target-icon {
  font-size: 16px;
  color: var(--primary);
}

.age-cat-desc {
  font-size: 14px;
  line-height: 1.55;
  color: var(--on-surface-variant);
  margin-bottom: 1.25rem;
}

.age-cat-focus-box {
  background: var(--surface-container-low);
  border-radius: 0.875rem;
  padding: 1rem;
  margin-bottom: 1.5rem;
  flex: 1;
}

.focus-box-title {
  display: flex;
  align-items: center;
  gap: 0.375rem;
  font-size: 12px;
  font-weight: 700;
  color: var(--on-surface);
  text-transform: uppercase;
  letter-spacing: 0.04em;
  margin-bottom: 0.625rem;
}

.focus-box-title .material-symbols-outlined {
  font-size: 16px;
  color: var(--primary);
}

.age-cat-list {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.age-cat-list li {
  display: flex;
  align-items: flex-start;
  gap: 0.5rem;
  font-size: 13px;
  line-height: 1.4;
  color: var(--on-surface);
}

.point-check {
  font-size: 16px;
  color: var(--secondary);
  flex-shrink: 0;
  margin-top: 1px;
}

.age-cat-footer {
  margin-top: auto;
}

.btn-cat-wa {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  width: 100%;
  padding: 0.75rem 1rem;
  border-radius: 0.75rem;
  font-size: 13px;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.2s ease;
}

.btn-cat-blue {
  background: rgba(0, 99, 132, 0.1);
  color: var(--primary);
  border: 1px solid rgba(0, 99, 132, 0.25);
}
.btn-cat-blue:hover {
  background: var(--primary);
  color: var(--on-primary);
  border-color: var(--primary);
}

.btn-cat-green {
  background: rgba(75, 103, 22, 0.1);
  color: var(--secondary);
  border: 1px solid rgba(75, 103, 22, 0.25);
}
.btn-cat-green:hover {
  background: var(--secondary);
  color: var(--on-secondary);
  border-color: var(--secondary);
}

.btn-cat-orange {
  background: rgba(136, 78, 3, 0.1);
  color: var(--tertiary);
  border: 1px solid rgba(136, 78, 3, 0.25);
}
.btn-cat-orange:hover {
  background: var(--tertiary);
  color: #fff;
  border-color: var(--tertiary);
}

@media (max-width: 1024px) {
  .age-categories-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 768px) {
  .age-categories-grid {
    grid-template-columns: 1fr;
    max-width: 480px;
    margin: 0 auto;
  }
}
</style>
