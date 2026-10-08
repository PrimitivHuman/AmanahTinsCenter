<template>
  <PublicLayout>

    <!-- ===== HERO SECTION ===== -->
    <section class="hero-section">
      <div class="container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb" aria-label="Breadcrumb">
          <router-link to="/" class="bc-link">
            <span class="material-symbols-outlined" style="font-size:14px">home</span>
            Beranda
          </router-link>
          <span class="bc-sep">/</span>
          <span class="bc-active">Artikel &amp; Tips</span>
        </nav>

        <div class="hero-card">
          <div class="hero-badge">
            <span class="material-symbols-outlined fill" style="font-size:16px">menu_book</span>
            <span>Panduan Terpercaya Orang Tua</span>
          </div>
          <h1 class="hero-title">Artikel &amp; Tips Tumbuh Kembang</h1>
          <p class="hero-desc">
            Informasi seputar tumbuh kembang anak, terapi wicara, sensori motorik, dan parenting terpercaya dari tim terapis &amp; psikolog Amanah Tin's Center.
          </p>

          <!-- Search Bar -->
          <div class="search-wrap">
            <span class="material-symbols-outlined search-icon" style="font-size:20px">search</span>
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Cari topik atau kata kunci artikel..."
              class="search-input"
              @input="onSearch"
            />
          </div>
        </div>
      </div>
    </section>

    <!-- ===== CATEGORY FILTER PILLS ===== -->
    <section class="filter-section">
      <div class="container">
        <div class="filter-pills">
          <button
            v-for="cat in categoryTabs"
            :key="cat.label"
            :class="['filter-pill', { 'filter-pill--active': activeCategory === cat.label }]"
            @click="activeCategory = cat.label"
          >
            <span class="material-symbols-outlined" style="font-size:16px" :class="cat.iconColor">{{ cat.icon }}</span>
            <span>{{ cat.label }}</span>
          </button>
        </div>
      </div>
    </section>

    <!-- ===== ARTICLES GRID ===== -->
    <section class="articles-section">
      <div class="container">

        <!-- Loading Skeleton -->
        <div class="articles-grid" v-if="loading">
          <div v-for="i in 4" :key="i" class="article-card skeleton-card">
            <div class="sk-img"></div>
            <div class="sk-body">
              <div class="sk-line sk-short"></div>
              <div class="sk-line"></div>
              <div class="sk-line sk-medium"></div>
            </div>
          </div>
        </div>

        <!-- Articles from API -->
        <div class="articles-grid" v-else-if="filteredArticles.length">
          <article
            v-for="article in filteredArticles"
            :key="article.id"
            class="article-card"
          >
            <!-- Thumbnail -->
            <div class="card-thumb-wrap">
              <img
                :src="article.thumbnail || getDefaultThumb(article.category)"
                :alt="article.title"
                class="card-thumb"
              />
              <!-- Category overlay badge -->
              <div class="thumb-cat-badge" :class="getCatClass(article.category)">
                <span class="material-symbols-outlined" style="font-size:12px">{{ getCatIcon(article.category) }}</span>
                <span>{{ article.category }}</span>
              </div>
              <!-- Bookmark button -->
              <button class="thumb-bookmark" aria-label="Simpan Artikel">
                <span class="material-symbols-outlined" style="font-size:18px">bookmark</span>
              </button>
            </div>

            <!-- Card Content -->
            <div class="card-body">
              <div class="card-meta">
                <span class="meta-item">
                  <span class="material-symbols-outlined" style="font-size:12px; color: var(--outline)">calendar_today</span>
                  {{ formatDate(article.published_at || article.created_at) }}
                </span>
                <span class="meta-dot">•</span>
                <span class="meta-item">
                  <span class="material-symbols-outlined" style="font-size:12px; color: var(--outline)">schedule</span>
                  {{ article.read_time || '4 min baca' }}
                </span>
              </div>
              <h2 class="card-title">{{ article.title }}</h2>
              <p class="card-excerpt">{{ article.excerpt }}</p>
            </div>

            <!-- Card Footer -->
            <div class="card-footer">
              <router-link :to="`/artikel/${article.slug}`" class="read-more-link">
                <span>Baca Selengkapnya</span>
                <span class="material-symbols-outlined read-more-arrow" style="font-size:16px">arrow_forward</span>
              </router-link>
            </div>
          </article>
        </div>

        <!-- Empty state -->
        <div v-else class="empty-state">
          <span class="material-symbols-outlined" style="font-size:64px; color: var(--outline)">article</span>
          <p>Belum ada artikel dalam kategori ini.</p>
        </div>

      </div>
    </section>

    <!-- ===== CONSULTATION CTA ===== -->
    <section class="cta-section">
      <div class="container">
        <div class="cta-card">
          <div class="cta-content">
            <div class="cta-eyebrow">
              <span class="material-symbols-outlined" style="font-size:18px">support_agent</span>
              <span>Konsultasi Awal Ramah &amp; Terbuka</span>
            </div>
            <h3 class="cta-title">Ragu dengan Tahap Tumbuh Kembang Si Kecil?</h3>
            <p class="cta-desc">
              Jangan ragu untuk berdiskusi bersama tim kami. Dapatkan asesmen dini yang hangat, profesional, dan berorientasi pada kenyamanan ananda.
            </p>
          </div>
          <div class="cta-actions">
            <a href="https://wa.me/6281234567890" target="_blank" rel="noopener" class="btn-wa">
              <span class="material-symbols-outlined" style="font-size:20px">chat</span>
              <span>Konsultasi via WhatsApp</span>
            </a>
            <router-link to="/jadwal-pendaftaran" class="btn-schedule">
              <span>Jadwal Screening</span>
            </router-link>
          </div>
        </div>
      </div>
    </section>

  </PublicLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import PublicLayout from '../layouts/PublicLayout.vue'
import api from '../services/api'

const articles = ref([])
const loading = ref(true)
const activeCategory = ref('Semua Topik')
const searchQuery = ref('')

const categoryTabs = [
  { label: 'Semua Topik',     icon: 'apps',               iconColor: '' },
  { label: 'Terapi Wicara',   icon: 'record_voice_over',  iconColor: 'icon-blue' },
  { label: 'Sensori & Motorik', icon: 'front_hand',       iconColor: 'icon-green' },
  { label: 'Parenting Positif', icon: 'favorite',         iconColor: 'icon-amber' },
  { label: 'Psikologi Anak',  icon: 'psychology',         iconColor: 'icon-blue' },
]

const catIconMap = {
  'Terapi Wicara':    'record_voice_over',
  'Sensori Motorik':  'front_hand',
  'Sensori & Motorik':'front_hand',
  'Tumbuh Kembang':   'psychology',
  'Parenting':        'favorite',
  'Parenting Positif':'favorite',
  'Psikologi Anak':   'psychology',
}
const catClassMap = {
  'Terapi Wicara':    'badge-blue',
  'Sensori Motorik':  'badge-green',
  'Tumbuh Kembang':   'badge-amber',
  'Parenting':        'badge-green',
  'Parenting Positif':'badge-green',
  'Psikologi Anak':   'badge-amber',
}

function getCatIcon(cat) { return catIconMap[cat] || 'article' }
function getCatClass(cat) { return catClassMap[cat] || 'badge-blue' }

function getDefaultThumb(cat) {
  return `https://placehold.co/400x240/e3efff/006384?text=${encodeURIComponent(cat || 'Artikel')}`
}

const filteredArticles = computed(() => {
  let list = articles.value
  if (activeCategory.value !== 'Semua Topik') {
    // Map tab labels to possible category values
    const labelMap = {
      'Terapi Wicara':    ['Terapi Wicara'],
      'Sensori & Motorik':['Sensori Motorik', 'Sensori & Motorik', 'Motorik'],
      'Parenting Positif':['Parenting', 'Parenting Positif'],
      'Psikologi Anak':   ['Psikologi Anak', 'Psikologi', 'Tumbuh Kembang'],
    }
    const allowed = labelMap[activeCategory.value] || [activeCategory.value]
    list = list.filter(a => allowed.includes(a.category))
  }
  if (searchQuery.value.trim()) {
    const q = searchQuery.value.toLowerCase()
    list = list.filter(a =>
      (a.title || '').toLowerCase().includes(q) ||
      (a.excerpt || '').toLowerCase().includes(q)
    )
  }
  return list
})

function onSearch() {
  // Reactivity handles it via computed
}

function formatDate(dateStr) {
  if (!dateStr) return ''
  return new Date(dateStr).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })
}

// Fallback static articles if API is empty
const defaultArticles = [
  {
    id: 1, slug: 'tanda-anak-butuh-terapi-wicara',
    category: 'Terapi Wicara',
    title: 'Tanda-Tanda Anak Membutuhkan Terapi Wicara',
    excerpt: 'Kenali red flags keterlambatan bicara sejak dini, mulai dari minimnya babbling hingga kesulitan mengekspresikan kosakata sehari-hari.',
    published_at: '2025-05-12', read_time: '4 min baca',
    thumbnail: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDndS1MEqhUoM1jUcloTszQuiVyvZQQTdkWTSuBfJTiomzP1PM9XqIRCM9jqFGt1cW7d3Leb19e2RyIVFI-ZAZVTtp0cqgL1J5nVzOeM9xb3jMOsV1syIVqmGBEzTpxgNh7DR4Bmof0JjfqdICLKa4vueP7V49v6bJx6jBVOILCbqk-mUAQWiGEt6MTKP0dWcxjtDpTGkGPMvUKtluVegL-I7DXLjkf67qRXyeHcC4',
  },
  {
    id: 2, slug: 'tips-stimulasi-motorik-anak',
    category: 'Sensori Motorik',
    title: 'Tips Stimulasi Motorik Anak di Rumah',
    excerpt: 'Aktivitas bermain sederhana tanpa gawai untuk melatih koordinasi tangan-mata, keseimbangan tubuh, dan kekuatan jari jemari balita.',
    published_at: '2025-05-05', read_time: '3 min baca',
    thumbnail: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBVAjj2_99GAssxWy4C6hTn27yt7kYZe2i0qsUsgpGRLAq1dsRAzKGQN9PngQD-eLgAv_j19Tc3Y1D2ZOwLi17idZKvk6tEW5EYD5j4V8Oe2WTWmHgj3NaktVCavHdsCMDaZc0kG5owNajF4MGnh7xHWInfth-r3HLBjrJLLF9X1s1PkwXpVZ-HNaJ4IhQ-ZtKXIBikWwNr1SHDHiavrHJb5bQYR-fQgncvJVq9oPU',
  },
  {
    id: 3, slug: 'pentingnya-konsistensi-terapi',
    category: 'Tumbuh Kembang',
    title: 'Pentingnya Konsistensi dalam Terapi Tumbuh Kembang',
    excerpt: 'Mengapa kesinambungan sesi klinik dan pengulangan stimulasi terarah di rumah memegang peranan krusial bagi kemandirian anak.',
    published_at: '2025-04-28', read_time: '5 min baca',
    thumbnail: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDA6AxaP_1sTKsevX0SNiWyRLSqBTmdOpthTzKUtdw2629F_zlaMj9qXVWQgswk5vS1vNJB6lex_af6gpEcXS26Q6i1UNwwm-hOYueJc0NUuz0KofHGQ4UIEKYpCwrZ0cN_dRkzJP0Xb_XZ19fdPzVRbHxXP_JNQQCjs57FaWxRIxDKyIzA8Itfn7C3kP0upzOwvfBovYcWgXxj-wyKin6fV78ESnwPCkweevSPvAM',
  },
  {
    id: 4, slug: 'komunikasi-positif-dengan-anak',
    category: 'Parenting',
    title: 'Cara Membangun Komunikasi Positif dengan Anak',
    excerpt: 'Langkah empati untuk mendengarkan tanpa menghakimi, merespons tantrum dengan tenang, dan memperkuat ikatan emosional keluarga.',
    published_at: '2025-04-20', read_time: '4 min baca',
    thumbnail: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCFnIGzFbZWa4l3SIk50aPn96KY27lU07tg9J5Jx2GS_IK0XvHXN-2DDskmjdAgWOWRof4YXiVpYcRdhAdGrHhLFY3kJeCrzAorWZhl9avFTC8Hz5N_hpNtpCjKHHW91WlUmRhbZG_Aa3ixQ3e6CjcMYtNQySfL50xEvTnG-4h6gNvGwU-HS77DVP5oW_jepXXh6PH-6aB_jyVORKqhzbEEd6cUG95ve4rUHJm8_Dg',
  },
]

onMounted(async () => {
  try {
    const res = await api.get('/articles?published=1&per_page=20')
    const data = res.data.data || []
    articles.value = data.length ? data : defaultArticles
  } catch {
    articles.value = defaultArticles
  } finally {
    loading.value = false
  }
})
</script>

<style scoped>
/* ============================================================
   HERO SECTION
   ============================================================ */
.hero-section {
  padding: 1.5rem 0 2rem;
  background: var(--background);
}
.breadcrumb {
  display: flex; align-items: center; gap: 0.5rem;
  font-size: 12px; color: var(--on-surface-variant);
  margin-bottom: 1.25rem;
}
.bc-link {
  display: flex; align-items: center; gap: 0.25rem;
  color: var(--on-surface-variant); text-decoration: none;
  transition: color 0.2s;
}
.bc-link:hover { color: var(--primary); }
.bc-sep { color: var(--on-surface-variant); }
.bc-active { color: var(--primary); font-weight: 600; }

.hero-card {
  background: var(--surface-container-low);
  border: 1px solid rgba(191,200,206,0.3);
  border-radius: var(--radius-lg);
  padding: 2.5rem 2rem;
  display: flex; flex-direction: column; gap: 1rem;
}
.hero-badge {
  display: inline-flex; align-items: center; gap: 0.5rem;
  background: var(--secondary-fixed);
  color: var(--on-secondary-fixed);
  padding: 0.375rem 0.875rem;
  border-radius: 9999px;
  font-size: 13px; font-weight: 600;
  width: fit-content;
}
.hero-title {
  font-family: var(--font-headline);
  font-size: 36px; font-weight: 700;
  color: var(--on-surface); margin: 0;
  letter-spacing: -0.015em;
}
.hero-desc {
  font-size: 16px; line-height: 1.7;
  color: var(--on-surface-variant); margin: 0;
  max-width: 640px;
}

/* Search bar */
.search-wrap {
  display: flex; align-items: center;
  background: #fff;
  border: 1.5px solid rgba(191,200,206,0.5);
  border-radius: 9999px;
  padding: 0.625rem 1.25rem;
  gap: 0.75rem;
  max-width: 400px;
  margin-top: 0.5rem;
  transition: border-color 0.2s;
}
.search-wrap:focus-within { border-color: var(--primary); }
.search-icon { color: var(--on-surface-variant); flex-shrink: 0; }
.search-input {
  border: none; outline: none; background: transparent;
  font-size: 14px; color: var(--on-surface);
  font-family: var(--font-body);
  width: 100%;
}
.search-input::placeholder { color: var(--on-surface-variant); }

/* ============================================================
   FILTER PILLS
   ============================================================ */
.filter-section {
  padding: 1.5rem 0;
  border-bottom: 1px solid rgba(191,200,206,0.15);
}
.filter-pills {
  display: flex; align-items: center; gap: 0.75rem;
  overflow-x: auto; padding-bottom: 0.25rem;
  scrollbar-width: none;
}
.filter-pills::-webkit-scrollbar { display: none; }

.filter-pill {
  display: inline-flex; align-items: center; gap: 0.5rem;
  padding: 0.625rem 1.25rem;
  border-radius: 9999px;
  font-size: 15px; font-weight: 700;
  border: 1.5px solid rgba(191,200,206,0.3);
  background: #fff;
  color: var(--on-surface-variant);
  cursor: pointer;
  white-space: nowrap;
  transition: all 0.15s;
  font-family: var(--font-body);
}
.filter-pill:hover { background: var(--surface-container-low); color: var(--primary); }
.filter-pill--active {
  background: var(--primary);
  color: #fff;
  border-color: var(--primary);
  box-shadow: 0 2px 8px rgba(0, 99, 132, 0.2);
}
.icon-blue  { color: var(--primary); }
.icon-green { color: var(--secondary); }
.icon-amber { color: var(--tertiary); }
.filter-pill--active .icon-blue,
.filter-pill--active .icon-green,
.filter-pill--active .icon-amber { color: #fff; }

/* ============================================================
   ARTICLES GRID
   ============================================================ */
.articles-section { padding: var(--space-xl) 0; }

.articles-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1.5rem;
  margin-bottom: var(--space-xl);
}

/* Article Card */
.article-card {
  background: #fff;
  border: 1px solid rgba(191,200,206,0.3);
  border-radius: var(--radius);
  overflow: hidden;
  display: flex; flex-direction: column; justify-content: space-between;
  transition: all 0.2s ease;
}
.article-card:hover {
  box-shadow: 0 8px 24px rgba(0,0,0,0.1);
  transform: translateY(-3px);
}

/* Thumbnail */
.card-thumb-wrap {
  position: relative;
  width: 100%; height: 208px;
  overflow: hidden;
  background: var(--surface-container-low);
  flex-shrink: 0;
}
.card-thumb {
  width: 100%; height: 100%; object-fit: cover;
  display: block;
  transition: transform 0.3s;
}
.article-card:hover .card-thumb { transform: scale(1.05); }

.thumb-cat-badge {
  position: absolute; top: 0.75rem; left: 0.75rem;
  display: flex; align-items: center; gap: 0.25rem;
  background: rgba(255,255,255,0.9);
  backdrop-filter: blur(4px);
  border: 1px solid rgba(191,200,206,0.2);
  border-radius: 9999px;
  padding: 0.25rem 0.75rem;
  font-size: 12px; font-weight: 700;
  box-shadow: 0 1px 4px rgba(0,0,0,0.08);
}
.badge-blue  { color: var(--primary); }
.badge-green { color: var(--secondary); }
.badge-amber { color: var(--tertiary); }

.thumb-bookmark {
  position: absolute; top: 0.75rem; right: 0.75rem;
  width: 32px; height: 32px;
  border-radius: 50%;
  background: rgba(255,255,255,0.9);
  backdrop-filter: blur(4px);
  border: none; cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  color: var(--on-surface-variant);
  box-shadow: 0 1px 4px rgba(0,0,0,0.08);
  transition: color 0.2s;
}
.thumb-bookmark:hover { color: var(--primary); }

/* Card body */
.card-body { padding: 1.5rem; flex: 1; }
.card-meta {
  display: flex; align-items: center; gap: 0.5rem;
  font-size: 12px; color: var(--on-surface-variant);
  margin-bottom: 0.75rem;
}
.meta-item { display: flex; align-items: center; gap: 0.25rem; }
.meta-dot { color: var(--on-surface-variant); }
.card-title {
  font-family: var(--font-headline);
  font-size: 18px; font-weight: 700;
  color: var(--on-surface);
  line-height: 1.4; margin: 0 0 0.625rem;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  transition: color 0.2s;
}
.article-card:hover .card-title { color: var(--primary); }
.card-excerpt {
  font-size: 14px; line-height: 1.6;
  color: var(--on-surface-variant); margin: 0;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Card footer */
.card-footer {
  padding: 0 1.5rem 1.5rem;
}
.read-more-link {
  display: inline-flex; align-items: center; gap: 0.375rem;
  font-size: 15px; font-weight: 700;
  color: var(--primary); text-decoration: none;
  transition: gap 0.2s;
}
.read-more-link:hover { gap: 0.625rem; }
.read-more-arrow { transition: transform 0.2s; }
.read-more-link:hover .read-more-arrow { transform: translateX(4px); }

/* Skeleton */
.skeleton-card { pointer-events: none; }
.sk-img { height: 208px; background: linear-gradient(90deg, #e3efff 25%, #d1e4fb 50%, #e3efff 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; }
.sk-body { padding: 1.5rem; }
.sk-line { height: 14px; background: linear-gradient(90deg, #e3efff 25%, #d1e4fb 50%, #e3efff 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; border-radius: 99px; margin: 0.5rem 0; }
.sk-short  { width: 40%; }
.sk-medium { width: 70%; }
@keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }

/* Empty */
.empty-state { display: flex; flex-direction: column; align-items: center; gap: 1rem; padding: 4rem; color: var(--on-surface-variant); font-size: 16px; }

/* ============================================================
   CTA SECTION
   ============================================================ */
.cta-section { padding-bottom: var(--space-xl); }
.cta-card {
  background: linear-gradient(to right, var(--surface-container-low), var(--surface-container), rgba(209, 228, 251, 0.4));
  border: 1px solid rgba(191,200,206,0.3);
  border-radius: var(--radius);
  padding: 3rem;
  display: flex; flex-direction: row;
  align-items: center; justify-content: space-between;
  gap: 2rem;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
  flex-wrap: wrap;
}
.cta-eyebrow {
  display: flex; align-items: center; gap: 0.5rem;
  font-size: 13px; font-weight: 600;
  color: var(--secondary);
  margin-bottom: 0.75rem;
}
.cta-title {
  font-family: var(--font-headline);
  font-size: 24px; font-weight: 700;
  color: var(--on-surface); margin: 0 0 0.75rem;
  line-height: 1.3;
}
.cta-desc { font-size: 16px; line-height: 1.6; color: var(--on-surface-variant); margin: 0; }
.cta-content { max-width: 560px; }

.cta-actions {
  display: flex; flex-direction: row; gap: 1rem; flex-shrink: 0; flex-wrap: wrap;
}
.btn-wa, .btn-schedule {
  display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;
  padding: 0.875rem 1.75rem;
  border-radius: 9999px;
  font-size: 15px; font-weight: 700;
  text-decoration: none; white-space: nowrap;
  transition: all 0.2s;
}
.btn-wa {
  background: var(--secondary);
  color: #fff;
  box-shadow: 0 2px 8px rgba(0,0,0,0.12);
}
.btn-wa:hover { background: var(--secondary-container); color: var(--on-secondary-container); }
.btn-schedule {
  background: #fff;
  color: var(--primary);
  border: 1.5px solid rgba(191,200,206,0.4);
}
.btn-schedule:hover { background: var(--surface-container-low); }

/* ============================================================
   RESPONSIVE
   ============================================================ */
@media (max-width: 1200px) { .articles-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 900px)  { .articles-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 600px) {
  .articles-grid { grid-template-columns: 1fr; }
  .hero-title { font-size: 26px; }
  .cta-card { flex-direction: column; padding: 2rem 1.5rem; }
  .cta-actions { flex-direction: column; width: 100%; }
  .btn-wa, .btn-schedule { width: 100%; }
}
</style>
