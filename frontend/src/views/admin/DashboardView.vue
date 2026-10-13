<template>
  <AdminLayout title="Dashboard Ringkasan">
    <!-- Welcome Banner -->
    <div class="dash-welcome-card">
      <div class="welcome-decor-circle circle-1" aria-hidden="true"></div>
      <div class="welcome-decor-circle circle-2" aria-hidden="true"></div>

      <div class="dash-welcome-content">
        <div class="welcome-chip">
          <span class="material-symbols-outlined chip-icon">verified_user</span>
          <span>Pusat Kendali Administrasi</span>
        </div>
        <h1 class="welcome-title">Selamat Datang, {{ auth.user?.name || 'Administrator' }} 👋</h1>
        <p class="welcome-desc">
          Pantau perkembangan konten edukasi, artikel populer, profil tim terapis spesialis, serta kontak WhatsApp klinik Amanah Tin's Center secara terpadu.
        </p>

        <!-- Quick metadata tags on mobile & desktop -->
        <div class="welcome-meta-row">
          <span class="meta-tag">
            <span class="material-symbols-outlined">schedule</span>
            <span>{{ todayFormatted }}</span>
          </span>
          <span class="meta-tag">
            <span class="material-symbols-outlined">chat</span>
            <span>WhatsApp Reservasi Aktif</span>
          </span>
        </div>
      </div>

      <div class="dash-welcome-actions">
        <router-link to="/admin/artikel/baru" class="btn-banner-primary">
          <span class="material-symbols-outlined">edit_note</span>
          <span>Tulis Artikel Baru</span>
        </router-link>
        <router-link to="/admin/tim-kami" class="btn-banner-secondary">
          <span class="material-symbols-outlined">person_add</span>
          <span>Kelola Tim Terapis</span>
        </router-link>
      </div>
    </div>

    <!-- Error State Alert -->
    <div v-if="error" class="alert-banner error-banner" role="alert">
      <div class="alert-icon-wrap">
        <span class="material-symbols-outlined">error</span>
      </div>
      <div class="alert-content">
        <strong class="alert-title">Gagal Memuat Data</strong>
        <p class="alert-desc">{{ error }}</p>
      </div>
      <button class="btn-alert-action" @click="fetchDashboardData">
        <span class="material-symbols-outlined">refresh</span>
        <span>Coba Lagi</span>
      </button>
    </div>

    <!-- Missing Settings Alert -->
    <div v-if="!loading && missingSettings.length" class="alert-banner warn-banner" role="status">
      <div class="alert-icon-wrap">
        <span class="material-symbols-outlined">warning</span>
      </div>
      <div class="alert-content">
        <strong class="alert-title">Lengkapi Konfigurasi Klinik</strong>
        <p class="alert-desc">
          Data berikut belum diisi: <strong>{{ missingSettings.join(', ') }}</strong>.
          Lengkapi agar informasi di website publik dan kontak WhatsApp tampil optimal.
        </p>
      </div>
      <router-link to="/admin/pengaturan" class="btn-alert-action warn-action">
        <span>Lengkapi</span>
        <span class="material-symbols-outlined">arrow_forward</span>
      </router-link>
    </div>

    <!-- 4 Stat Cards Grid -->
    <div class="stats-grid">
      <!-- Skeleton Loading State -->
      <template v-if="loading">
        <div v-for="n in 4" :key="n" class="stat-card skeleton-stat-card">
          <div class="stat-top">
            <div class="skeleton-shimmer sk-icon"></div>
            <div class="skeleton-shimmer sk-badge"></div>
          </div>
          <div class="skeleton-shimmer sk-value"></div>
          <div class="skeleton-shimmer sk-label"></div>
          <div class="skeleton-shimmer sk-footer"></div>
        </div>
      </template>

      <!-- Loaded Stats -->
      <template v-else>
        <!-- Stat 1: Published Articles -->
        <div class="stat-card stat-card-hover">
          <div class="stat-top">
            <div class="stat-icon-wrap teal-bg">
              <span class="material-symbols-outlined">menu_book</span>
            </div>
            <span class="stat-badge orange-badge" v-if="stats.draft_articles > 0">
              {{ stats.draft_articles }} Draft Tersimpan
            </span>
            <span class="stat-badge green-badge" v-else>
              Semua Terbit
            </span>
          </div>
          <div class="stat-value">{{ stats.published_articles ?? 0 }}</div>
          <div class="stat-label">Artikel Edukasi Terbit</div>
          <div class="stat-footer">
            <router-link to="/admin/artikel" class="stat-footer-link">
              <span>Kelola semua artikel</span>
              <span class="material-symbols-outlined">arrow_forward</span>
            </router-link>
          </div>
        </div>

        <!-- Stat 2: Active Therapists -->
        <div class="stat-card stat-card-hover">
          <div class="stat-top">
            <div class="stat-icon-wrap green-bg">
              <span class="material-symbols-outlined">clinical_notes</span>
            </div>
            <span class="stat-badge green-badge">Tenaga Ahli Medis</span>
          </div>
          <div class="stat-value">{{ stats.total_team ?? 0 }}</div>
          <div class="stat-label">Terapis Aktif Terdaftar</div>
          <div class="stat-footer">
            <router-link to="/admin/tim-kami" class="stat-footer-link">
              <span>Kelola data tim terapis</span>
              <span class="material-symbols-outlined">arrow_forward</span>
            </router-link>
          </div>
        </div>

        <!-- Stat 3: Total Views -->
        <div class="stat-card stat-card-hover">
          <div class="stat-top">
            <div class="stat-icon-wrap amber-bg">
              <span class="material-symbols-outlined">visibility</span>
            </div>
            <span class="stat-badge amber-badge">Akumulasi Interaksi</span>
          </div>
          <div class="stat-value">{{ formatNumber(stats.total_views) }}</div>
          <div class="stat-label">Total Pembaca Artikel</div>
          <div class="stat-footer">
            <span class="stat-footer-text">
              <span class="material-symbols-outlined">trending_up</span>
              <span>Minat edukasi orang tua</span>
            </span>
          </div>
        </div>

        <!-- Stat 4: WhatsApp Pendaftaran -->
        <div class="stat-card stat-card-hover stat-card-wa">
          <div class="stat-top">
            <div class="stat-icon-wrap wa-bg">
              <span class="material-symbols-outlined">chat</span>
            </div>
            <span :class="['stat-badge', whatsapp ? 'green-badge' : 'orange-badge']">
              {{ whatsapp ? 'Jalur Aktif' : 'Belum Diatur' }}
            </span>
          </div>
          <div class="stat-value stat-value-wa">{{ displayWhatsapp }}</div>
          <div class="stat-label">WhatsApp Pendaftaran &amp; Konsultasi</div>
          <div class="stat-footer wa-footer-actions">
            <a
              :href="waLink('Halo Admin Amanah Tin\'s Center, ini pesan uji dari portal admin.')"
              target="_blank"
              rel="noopener noreferrer"
              class="btn-wa-test"
              title="Kirim pesan uji coba ke WhatsApp klinik"
            >
              <span class="material-symbols-outlined">send</span>
              <span>Uji Chat</span>
            </a>
            <router-link to="/admin/pengaturan" class="btn-wa-edit">
              <span class="material-symbols-outlined">edit</span>
              <span>Ubah Nomor</span>
            </router-link>
          </div>
        </div>
      </template>
    </div>

    <!-- Main Content: Atas (Artikel Terpopuler) & Bawah (Sekilas Tim Terapis) -->
    <div class="dash-main-grid">
      <!-- Section Atas: Artikel Terpopuler -->
      <section class="dash-card popular-section">
        <div class="card-header">
          <div class="header-titles">
            <div class="header-icon-badge">
              <span class="material-symbols-outlined">hotel_class</span>
            </div>
            <div>
              <h2 class="card-title">Artikel Terpopuler</h2>
              <p class="card-subtitle">5 materi edukasi yang paling sering dibaca oleh orang tua</p>
            </div>
          </div>
          <router-link to="/admin/artikel" class="header-action-link">
            <span>Kelola Artikel</span>
            <span class="material-symbols-outlined">arrow_forward</span>
          </router-link>
        </div>

        <!-- Loading state -->
        <div v-if="loading" class="state-container">
          <div class="spinner-small"></div>
          <span>Memuat artikel terpopuler...</span>
        </div>

        <!-- Empty state -->
        <div v-else-if="popularArticles.length === 0" class="empty-state">
          <div class="empty-icon-wrap">
            <span class="material-symbols-outlined">article</span>
          </div>
          <h3 class="empty-title">Belum Ada Artikel Terbit</h3>
          <p class="empty-desc">
            Publikasikan artikel tips tumbuh kembang anak untuk memberikan edukasi kepada orang tua.
          </p>
          <router-link to="/admin/artikel/baru" class="btn-empty-action">
            <span class="material-symbols-outlined">add</span>
            <span>Tulis Artikel Pertama</span>
          </router-link>
        </div>

        <!-- Desktop Table View (>= 768px) -->
        <div v-else class="table-desktop-wrap">
          <table class="data-table">
            <thead>
              <tr>
                <th class="th-rank">Peringkat</th>
                <th>Judul Artikel</th>
                <th>Kategori</th>
                <th class="th-views">Pembaca</th>
                <th class="th-action">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(art, index) in popularArticles" :key="art.id">
                <td class="td-rank">
                  <span :class="['rank-badge', getRankClass(index)]">
                    #{{ index + 1 }}
                  </span>
                </td>
                <td class="td-main">
                  <div class="art-cell">
                    <div class="art-thumb-mini">
                      <img
                        v-if="art.image && !art.imgError"
                        :src="art.image"
                        :alt="art.title"
                        loading="lazy"
                        @error="art.imgError = true"
                      />
                      <div v-else class="art-thumb-fallback">
                        <span class="material-symbols-outlined">auto_stories</span>
                      </div>
                    </div>
                    <div class="art-meta-text">
                      <router-link :to="`/admin/artikel/${art.id}/edit`" class="art-title-link">
                        {{ art.title }}
                      </router-link>
                      <div class="art-author-line">
                        <span class="material-symbols-outlined">person</span>
                        <span>{{ art.author || 'Tim Ahli ATC' }}</span>
                      </div>
                    </div>
                  </div>
                </td>
                <td>
                  <span class="category-pill">{{ art.category || 'Umum' }}</span>
                </td>
                <td class="td-views">
                  <div class="views-display">
                    <span class="material-symbols-outlined views-icon">visibility</span>
                    <strong class="views-count">{{ formatNumber(art.views_count) }}</strong>
                  </div>
                </td>
                <td class="td-action">
                  <router-link
                    :to="`/admin/artikel/${art.id}/edit`"
                    class="btn-row-action"
                    title="Edit Artikel"
                    aria-label="Edit Artikel"
                  >
                    <span class="material-symbols-outlined">edit</span>
                    <span>Edit</span>
                  </router-link>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Mobile Card List View (< 768px) -->
        <div v-if="popularArticles.length > 0" class="mobile-card-list">
          <div
            v-for="(art, index) in popularArticles"
            :key="art.id"
            class="mobile-art-item"
          >
            <div class="mobile-item-top">
              <span :class="['rank-badge', getRankClass(index)]">
                #{{ index + 1 }} Terpopuler
              </span>
              <span class="category-pill">{{ art.category || 'Umum' }}</span>
            </div>

            <div class="mobile-item-body">
              <div class="art-thumb-mini">
                <img
                  v-if="art.image && !art.imgError"
                  :src="art.image"
                  :alt="art.title"
                  loading="lazy"
                  @error="art.imgError = true"
                />
                <div v-else class="art-thumb-fallback">
                  <span class="material-symbols-outlined">auto_stories</span>
                </div>
              </div>
              <div class="mobile-item-info">
                <router-link :to="`/admin/artikel/${art.id}/edit`" class="art-title-link">
                  {{ art.title }}
                </router-link>
                <div class="mobile-author-row">
                  <span class="material-symbols-outlined">person</span>
                  <span>{{ art.author || 'Tim Ahli ATC' }}</span>
                </div>
              </div>
            </div>

            <div class="mobile-item-footer">
              <div class="views-display">
                <span class="material-symbols-outlined views-icon">visibility</span>
                <strong class="views-count">{{ formatNumber(art.views_count) }} kali dibaca</strong>
              </div>
              <router-link
                :to="`/admin/artikel/${art.id}/edit`"
                class="btn-row-action btn-row-action-mobile"
              >
                <span class="material-symbols-outlined">edit</span>
                <span>Edit</span>
              </router-link>
            </div>
          </div>
        </div>
      </section>

      <!-- Section Bawah: Sekilas Tim Terapis -->
      <section class="dash-card team-preview-section">
        <div class="card-header border-bottom">
          <div class="header-titles">
            <div class="header-icon-badge green-badge-icon">
              <span class="material-symbols-outlined">clinical_notes</span>
            </div>
            <div>
              <h2 class="card-title">Sekilas Tim Terapis</h2>
              <p class="card-subtitle">Tenaga ahli &amp; terapis spesialis aktif di klinik</p>
            </div>
          </div>
          <router-link to="/admin/tim-kami" class="header-action-link">
            <span>Kelola Tim</span>
            <span class="material-symbols-outlined">arrow_forward</span>
          </router-link>
        </div>

        <!-- Loading State -->
        <div v-if="loading" class="state-container">
          <div class="spinner-small"></div>
          <span>Memuat data tim terapis...</span>
        </div>

        <!-- Empty State -->
        <div v-else-if="teamMembers.length === 0" class="empty-state team-empty-state">
          <div class="empty-icon-wrap team-empty-icon">
            <span class="material-symbols-outlined">group</span>
          </div>
          <h3 class="empty-title">Belum Ada Terapis Terdaftar</h3>
          <p class="empty-desc">
            Daftarkan profil terapis wicara, okupasi, atau sensori integrasi untuk ditampilkan di website.
          </p>
          <router-link to="/admin/tim-kami" class="btn-empty-action">
            <span class="material-symbols-outlined">person_add</span>
            <span>+ Tambah Anggota Tim</span>
          </router-link>
        </div>

        <!-- Team Members List -->
        <div v-else class="team-preview-list">
          <router-link
            v-for="member in teamMembers"
            :key="member.id"
            to="/admin/tim-kami"
            class="team-member-item"
            :title="`Kelola profil ${member.name}`"
          >
            <div class="member-avatar-wrap">
              <div class="avatar-frame">
                <img
                  v-if="member.image && !member.imgError"
                  :src="member.image"
                  :alt="member.name"
                  class="member-avatar-img"
                  loading="lazy"
                  @error="member.imgError = true"
                />
                <div v-else class="member-avatar-fallback">
                  <span class="material-symbols-outlined">person</span>
                </div>
              </div>
              <span class="status-indicator-dot" :title="member.is_active ? 'Praktik Aktif' : 'Non-Aktif'"></span>
            </div>

            <div class="member-info-col">
              <div class="member-name-row">
                <strong class="member-name-text" :title="member.name">{{ member.name }}</strong>
                <span class="member-exp-badge" v-if="member.experience_years">
                  {{ member.experience_years }}
                </span>
              </div>
              <div class="member-role-text" :title="member.role">{{ member.role }}</div>
              <div class="member-spec-row" v-if="member.specialization" :title="member.specialization">
                <span class="material-symbols-outlined">verified</span>
                <span class="member-spec-text">{{ member.specialization }}</span>
              </div>
            </div>

            <div class="member-action-col" aria-hidden="true">
              <span class="material-symbols-outlined action-arrow">chevron_right</span>
            </div>
          </router-link>
        </div>

        <!-- Card Footer -->
        <div class="team-preview-footer" v-if="teamMembers.length > 0">
          <div class="footer-team-summary">
            <span class="material-symbols-outlined">groups</span>
            <span><strong>{{ stats.total_team || teamMembers.length }}</strong> Terapis Medis Terdaftar</span>
          </div>
        </div>
      </section>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import AdminLayout from '../../layouts/AdminLayout.vue'
import { useAuthStore } from '../../stores/auth'
import { useClinicSettings } from '../../composables/useClinicSettings'
import api from '../../services/api'

const auth = useAuthStore()
const { waLink } = useClinicSettings()

const stats = ref({})
const popularArticles = ref([])
const teamMembers = ref([])
const missingSettings = ref([])
const whatsapp = ref('')
const loading = ref(true)
const error = ref('')

const todayFormatted = computed(() => {
  const now = new Date()
  return now.toLocaleDateString('id-ID', {
    weekday: 'long',
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  })
})

const displayWhatsapp = computed(() => {
  if (!whatsapp.value) return 'Belum Diatur'
  const d = String(whatsapp.value).replace(/[^0-9]/g, '')
  if (d.startsWith('62')) {
    return '+62 ' + d.slice(2).replace(/(\d{3})(\d{4})(\d+)/, '$1-$2-$3')
  }
  return whatsapp.value
})

function getRankClass(index) {
  if (index === 0) return 'rank-first'
  if (index === 1) return 'rank-second'
  if (index === 2) return 'rank-third'
  return 'rank-other'
}

function formatNumber(n) {
  return new Intl.NumberFormat('id-ID').format(n || 0)
}

async function fetchDashboardData() {
  loading.value = true
  error.value = ''
  try {
    const res = await api.get('/admin/stats')
    stats.value = res.data.stats || {}
    popularArticles.value = res.data.popular_articles || []
    teamMembers.value = res.data.team_members || []
    missingSettings.value = res.data.missing_settings || []
    whatsapp.value = res.data.whatsapp || ''

    // Fallback jika team_members belum ada di stats cache
    if (teamMembers.value.length === 0 && (stats.value.total_team > 0 || !stats.value.total_team)) {
      try {
        const teamRes = await api.get('/team')
        teamMembers.value = (teamRes.data || []).slice(0, 5)
      } catch (e) {
        // Fallback aman
      }
    }
  } catch (err) {
    console.error('Failed to load dashboard stats', err)
    error.value = 'Gagal terhubung ke server. Periksa jaringan Anda lalu coba lagi.'
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchDashboardData()
})
</script>

<style scoped>
/* =============================================
   DASHBOARD RINGKASAN - STYLES & RESPONSIVE UI
   ============================================= */

/* Welcome Banner */
.dash-welcome-card {
  position: relative;
  background: linear-gradient(135deg, #005a78 0%, #00769a 50%, #1789ab 100%);
  color: #ffffff;
  padding: 2.25rem;
  border-radius: 24px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 2rem;
  margin-bottom: 2rem;
  overflow: hidden;
  box-shadow: 0 12px 30px rgba(0, 90, 120, 0.2);
}

.welcome-decor-circle {
  position: absolute;
  border-radius: 50%;
  pointer-events: none;
}

.circle-1 {
  width: 260px;
  height: 260px;
  top: -80px;
  right: -50px;
  background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0) 70%);
}

.circle-2 {
  width: 180px;
  height: 180px;
  bottom: -60px;
  left: 30%;
  background: radial-gradient(circle, rgba(204, 239, 142, 0.15) 0%, rgba(255, 255, 255, 0) 70%);
}

.dash-welcome-content {
  position: relative;
  z-index: 2;
  max-width: 680px;
}

.welcome-chip {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  background: rgba(255, 255, 255, 0.18);
  backdrop-filter: blur(8px);
  padding: 0.3rem 0.85rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 700;
  letter-spacing: 0.02em;
  margin-bottom: 0.85rem;
  border: 1px solid rgba(255, 255, 255, 0.25);
}

.chip-icon {
  font-size: 1rem;
}

.welcome-title {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 1.85rem;
  font-weight: 800;
  line-height: 1.25;
  margin-bottom: 0.65rem;
}

.welcome-desc {
  font-size: 0.9375rem;
  line-height: 1.6;
  opacity: 0.92;
  margin-bottom: 1.15rem;
}

.welcome-meta-row {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 0.75rem;
}

.meta-tag {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  background: rgba(0, 0, 0, 0.15);
  padding: 0.25rem 0.65rem;
  border-radius: 8px;
  font-size: 0.75rem;
  font-weight: 600;
}

.meta-tag .material-symbols-outlined {
  font-size: 0.95rem;
  opacity: 0.85;
}

.dash-welcome-actions {
  position: relative;
  z-index: 2;
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  flex-shrink: 0;
}

.btn-banner-primary,
.btn-banner-secondary {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 0.75rem 1.4rem;
  border-radius: 9999px;
  font-weight: 700;
  font-size: 0.875rem;
  text-decoration: none;
  white-space: nowrap;
  transition: all 0.2s ease;
}

.btn-banner-primary {
  background: #ffffff;
  color: var(--primary, #006384);
  box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
}

.btn-banner-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.16);
}

.btn-banner-secondary {
  background: rgba(255, 255, 255, 0.15);
  color: #ffffff;
  border: 1px solid rgba(255, 255, 255, 0.35);
}

.btn-banner-secondary:hover {
  background: rgba(255, 255, 255, 0.25);
  transform: translateY(-2px);
}

/* Alert Banners */
.alert-banner {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 1rem 1.25rem;
  border-radius: 16px;
  margin-bottom: 1.5rem;
  font-size: 0.875rem;
}

.alert-icon-wrap {
  width: 40px;
  height: 40px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.alert-content {
  flex: 1;
  min-width: 0;
}

.alert-title {
  display: block;
  font-size: 0.9375rem;
  margin-bottom: 0.15rem;
}

.alert-desc {
  font-size: 0.8125rem;
  line-height: 1.5;
  opacity: 0.95;
}

.error-banner {
  background: #ffdad6;
  color: #93000a;
  border: 1px solid rgba(186, 26, 26, 0.2);
}

.error-banner .alert-icon-wrap {
  background: #ba1a1a;
  color: #ffffff;
}

.warn-banner {
  background: #fff3e0;
  color: #7a3e00;
  border: 1px solid rgba(230, 119, 0, 0.25);
}

.warn-banner .alert-icon-wrap {
  background: #ff9800;
  color: #ffffff;
}

.btn-alert-action {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  padding: 0.5rem 1rem;
  border-radius: 9999px;
  font-size: 0.8125rem;
  font-weight: 700;
  border: none;
  cursor: pointer;
  white-space: nowrap;
  text-decoration: none;
  flex-shrink: 0;
  transition: all 0.2s;
}

.error-banner .btn-alert-action {
  background: #ba1a1a;
  color: #ffffff;
}

.warn-banner .btn-alert-action {
  background: #7a3e00;
  color: #ffffff;
}

.btn-alert-action:hover {
  opacity: 0.92;
  transform: translateY(-1px);
}

/* Stat Cards Grid */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1.25rem;
  margin-bottom: 2rem;
}

.stat-card {
  background: #ffffff;
  padding: 1.5rem;
  border-radius: 20px;
  border: 1px solid rgba(191, 200, 206, 0.4);
  box-shadow: 0 4px 14px rgba(9, 29, 46, 0.03);
  display: flex;
  flex-direction: column;
  transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
}

.stat-card-hover:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 24px rgba(9, 29, 46, 0.07);
  border-color: rgba(0, 99, 132, 0.3);
}

.stat-card-wa {
  border-color: rgba(37, 211, 102, 0.35);
  background: linear-gradient(180deg, #ffffff 0%, #f4fbf6 100%);
}

.stat-top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 0.5rem;
  margin-bottom: 1rem;
}

.stat-icon-wrap {
  width: 44px;
  height: 44px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.teal-bg { background: #c1e8ff; color: #006384; }
.green-bg { background: #d7f5a8; color: #354e00; }
.amber-bg { background: #ffe2c7; color: #884e03; }
.wa-bg { background: #d2f8d8; color: #0e7039; }

.stat-badge {
  padding: 0.25rem 0.65rem;
  border-radius: 9999px;
  font-size: 0.6875rem;
  font-weight: 700;
  white-space: nowrap;
}

.orange-badge { background: #ffdcbf; color: #7a3e00; }
.green-badge { background: #d7f5a8; color: #2e4400; }
.amber-badge { background: #ffe8d1; color: #7a3e00; }

.stat-value {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 2.15rem;
  font-weight: 800;
  color: var(--on-surface, #091d2e);
  line-height: 1.1;
  margin-bottom: 0.35rem;
  letter-spacing: -0.02em;
}

.stat-value-wa {
  font-size: 1.35rem;
  color: #0b6b38;
  letter-spacing: 0;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.stat-label {
  font-size: 0.8125rem;
  color: var(--on-surface-variant, #40484d);
  font-weight: 600;
  margin-bottom: 1rem;
}

.stat-footer {
  margin-top: auto;
  padding-top: 0.75rem;
  border-top: 1px solid rgba(191, 200, 206, 0.25);
  font-size: 0.75rem;
}

.stat-footer-link {
  display: inline-flex;
  align-items: center;
  gap: 0.3rem;
  color: var(--primary, #006384);
  font-weight: 700;
  text-decoration: none;
  transition: gap 0.15s ease;
}

.stat-footer-link:hover {
  gap: 0.5rem;
  text-decoration: underline;
}

.stat-footer-link .material-symbols-outlined {
  font-size: 0.95rem;
}

.stat-footer-text {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  color: var(--outline, #70787e);
  font-weight: 600;
}

.stat-footer-text .material-symbols-outlined {
  font-size: 1rem;
  color: var(--secondary, #4b6716);
}

.wa-footer-actions {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 0.5rem;
}

.btn-wa-test {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  color: #0e7039;
  font-weight: 700;
  text-decoration: none;
  font-size: 0.75rem;
  padding: 0.25rem 0.5rem;
  border-radius: 6px;
  background: rgba(37, 211, 102, 0.12);
  transition: all 0.15s;
}

.btn-wa-test:hover {
  background: rgba(37, 211, 102, 0.25);
}

.btn-wa-test .material-symbols-outlined {
  font-size: 0.95rem;
}

.btn-wa-edit {
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
  color: var(--primary, #006384);
  font-weight: 700;
  text-decoration: none;
  font-size: 0.75rem;
}

.btn-wa-edit:hover {
  text-decoration: underline;
}

.btn-wa-edit .material-symbols-outlined {
  font-size: 0.9rem;
}

/* Skeleton Loading Shimmer */
.skeleton-stat-card {
  pointer-events: none;
}

.skeleton-shimmer {
  background: linear-gradient(90deg, #edf3fa 25%, #f6faff 50%, #edf3fa 75%);
  background-size: 200% 100%;
  animation: shimmer 1.5s infinite;
  border-radius: 8px;
}

.sk-icon { width: 44px; height: 44px; border-radius: 12px; }
.sk-badge { width: 70px; height: 20px; border-radius: 9999px; }
.sk-value { width: 60%; height: 36px; margin-bottom: 0.5rem; }
.sk-label { width: 85%; height: 16px; margin-bottom: 1.25rem; }
.sk-footer { width: 50%; height: 14px; margin-top: auto; }

@keyframes shimmer {
  0% { background-position: 200% 0; }
  100% { background-position: -200% 0; }
}

/* Main Content Layout (Vertical Stack: Atas: Artikel Terpopuler, Bawah: Sekilas Tim Terapis) */
.dash-main-grid {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

.dash-card {
  background: #ffffff;
  padding: 1.75rem;
  border-radius: 20px;
  border: 1px solid rgba(191, 200, 206, 0.4);
  box-shadow: 0 4px 14px rgba(9, 29, 46, 0.03);
}

.popular-section,
.team-preview-section {
  min-width: 0;
}

.card-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
  margin-bottom: 1.35rem;
}

.card-header.border-bottom {
  padding-bottom: 1rem;
  border-bottom: 1px solid rgba(191, 200, 206, 0.3);
  margin-bottom: 1.15rem;
}

.header-titles {
  display: flex;
  align-items: center;
  gap: 0.875rem;
  min-width: 0;
}

.header-icon-badge {
  width: 40px;
  height: 40px;
  border-radius: 12px;
  background: #ffe8d1;
  color: #7a3e00;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.green-badge-icon {
  background: #d7f5a8;
  color: #354e00;
}

.card-title {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 1.15rem;
  font-weight: 800;
  color: var(--on-surface, #091d2e);
  line-height: 1.25;
}

.card-subtitle {
  font-size: 0.8125rem;
  color: var(--on-surface-variant, #40484d);
  margin-top: 0.15rem;
}

.header-action-link {
  display: inline-flex;
  align-items: center;
  gap: 0.3rem;
  color: var(--primary, #006384);
  font-size: 0.8125rem;
  font-weight: 700;
  text-decoration: none;
  white-space: nowrap;
  transition: gap 0.15s;
}

.header-action-link:hover {
  gap: 0.5rem;
  text-decoration: underline;
}

.header-action-link .material-symbols-outlined {
  font-size: 1rem;
}

/* State & Empty */
.state-container {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.75rem;
  padding: 3rem 1rem;
  color: var(--on-surface-variant, #40484d);
  font-size: 0.875rem;
}

.spinner-small {
  width: 22px;
  height: 22px;
  border: 2.5px solid rgba(0, 99, 132, 0.2);
  border-top-color: var(--primary, #006384);
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.empty-state {
  text-align: center;
  padding: 3rem 1.5rem;
}

.empty-icon-wrap {
  width: 64px;
  height: 64px;
  border-radius: 50%;
  background: var(--surface-container-low, #edf4ff);
  color: var(--primary, #006384);
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 1rem;
}

.empty-icon-wrap .material-symbols-outlined {
  font-size: 2rem;
}

.empty-title {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 1.1rem;
  font-weight: 700;
  color: var(--on-surface, #091d2e);
  margin-bottom: 0.35rem;
}

.empty-desc {
  font-size: 0.875rem;
  color: var(--on-surface-variant, #40484d);
  max-width: 420px;
  margin: 0 auto 1.5rem;
  line-height: 1.5;
}

.btn-empty-action {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  padding: 0.65rem 1.25rem;
  border-radius: 9999px;
  background: var(--primary, #006384);
  color: #ffffff;
  font-size: 0.875rem;
  font-weight: 700;
  text-decoration: none;
  box-shadow: 0 4px 12px rgba(0, 99, 132, 0.2);
}

/* Desktop Data Table */
.table-desktop-wrap {
  overflow-x: auto;
  border-radius: 12px;
}

.data-table {
  width: 100%;
  border-collapse: collapse;
  text-align: left;
}

.data-table th {
  padding: 0.75rem 1rem;
  background: var(--surface-container-low, #edf4ff);
  font-size: 0.75rem;
  font-weight: 700;
  color: var(--on-surface-variant, #40484d);
  text-transform: uppercase;
  letter-spacing: 0.03em;
  border-bottom: 1px solid rgba(191, 200, 206, 0.4);
}

.th-rank { width: 85px; }
.th-views { width: 120px; }
.th-action { width: 90px; text-align: center; }

.data-table td {
  padding: 0.95rem 1rem;
  border-bottom: 1px solid rgba(191, 200, 206, 0.25);
  font-size: 0.875rem;
  vertical-align: middle;
}

.data-table tr:hover td {
  background: #fbfdff;
}

.td-rank {
  font-weight: 800;
}

.rank-badge {
  display: inline-block;
  padding: 0.2rem 0.55rem;
  border-radius: 6px;
  font-size: 0.75rem;
  font-weight: 800;
}

.rank-first {
  background: #ffe3a3;
  color: #6d4700;
  box-shadow: 0 2px 6px rgba(109, 71, 0, 0.12);
}

.rank-second {
  background: #e2e8f0;
  color: #334155;
}

.rank-third {
  background: #fed7aa;
  color: #7c2d12;
}

.rank-other {
  background: #edf4ff;
  color: var(--primary, #006384);
}

.art-cell {
  display: flex;
  align-items: center;
  gap: 0.875rem;
  min-width: 200px;
}

.art-thumb-mini {
  width: 48px;
  height: 48px;
  border-radius: 10px;
  overflow: hidden;
  flex-shrink: 0;
  background: var(--surface-container, #e3efff);
}

.art-thumb-mini img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.art-thumb-fallback {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--primary, #006384);
}

.art-thumb-fallback .material-symbols-outlined {
  font-size: 1.35rem;
}

.art-meta-text {
  min-width: 0;
}

.art-title-link {
  display: block;
  font-weight: 700;
  color: var(--on-surface, #091d2e);
  text-decoration: none;
  font-size: 0.875rem;
  line-height: 1.35;
  margin-bottom: 0.2rem;
  transition: color 0.15s;
}

.art-title-link:hover {
  color: var(--primary, #006384);
}

.art-author-line {
  display: flex;
  align-items: center;
  gap: 0.25rem;
  font-size: 0.75rem;
  color: var(--on-surface-variant, #40484d);
}

.art-author-line .material-symbols-outlined {
  font-size: 0.875rem;
  color: var(--outline, #70787e);
}

.category-pill {
  display: inline-block;
  padding: 0.25rem 0.65rem;
  border-radius: 6px;
  background: var(--surface-container, #e3efff);
  color: var(--primary, #006384);
  font-size: 0.75rem;
  font-weight: 700;
  white-space: nowrap;
}

.views-display {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
}

.views-icon {
  font-size: 1.05rem;
  color: #b45309;
}

.views-count {
  font-size: 0.9375rem;
  color: var(--on-surface, #091d2e);
  font-weight: 800;
}

.btn-row-action {
  display: inline-flex;
  align-items: center;
  gap: 0.3rem;
  padding: 0.35rem 0.75rem;
  border-radius: 8px;
  background: var(--surface-container-low, #edf4ff);
  color: var(--primary, #006384);
  font-size: 0.75rem;
  font-weight: 700;
  text-decoration: none;
  transition: all 0.15s;
}

.btn-row-action:hover {
  background: var(--primary, #006384);
  color: #ffffff;
}

.btn-row-action .material-symbols-outlined {
  font-size: 0.95rem;
}

/* Mobile Card List (< 768px) */
.mobile-card-list {
  display: none;
  flex-direction: column;
  gap: 0.875rem;
}

.mobile-art-item {
  background: var(--surface-bright, #fbfdff);
  border: 1px solid rgba(191, 200, 206, 0.45);
  border-radius: 14px;
  padding: 1rem;
}

.mobile-item-top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 0.5rem;
  margin-bottom: 0.75rem;
}

.mobile-item-body {
  display: flex;
  gap: 0.75rem;
  align-items: flex-start;
  margin-bottom: 0.85rem;
}

.mobile-item-info {
  flex: 1;
  min-width: 0;
}

.mobile-author-row {
  display: flex;
  align-items: center;
  gap: 0.25rem;
  font-size: 0.75rem;
  color: var(--on-surface-variant, #40484d);
  margin-top: 0.25rem;
}

.mobile-author-row .material-symbols-outlined {
  font-size: 0.85rem;
}

.mobile-item-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 0.75rem;
  padding-top: 0.75rem;
  border-top: 1px solid rgba(191, 200, 206, 0.3);
}

.btn-row-action-mobile {
  padding: 0.45rem 1rem;
  font-size: 0.8125rem;
}

/* =============================================
   SEKILAS TIM TERAPIS SECTION STYLES
   ============================================= */
.team-preview-section {
  display: flex;
  flex-direction: column;
}

.team-preview-list {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 1rem;
  margin-bottom: 1.25rem;
  width: 100%;
  min-width: 0;
}

.team-member-item {
  display: flex;
  align-items: center;
  gap: 0.875rem;
  padding: 0.95rem 1.15rem;
  border-radius: 14px;
  background: var(--surface-bright, #f8faff);
  border: 1px solid rgba(191, 200, 206, 0.35);
  text-decoration: none;
  color: inherit;
  cursor: pointer;
  min-width: 0;
  max-width: 100%;
  width: 100%;
  box-sizing: border-box;
  overflow: hidden;
  transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}

.team-member-item:hover {
  background: var(--surface-container-low, #edf4ff);
  border-color: rgba(0, 99, 132, 0.35);
  transform: translateY(-2px);
  box-shadow: 0 6px 18px rgba(9, 29, 46, 0.06);
}

.team-member-item:hover .action-arrow {
  transform: translateX(3px);
  color: var(--primary, #006384);
}

.member-avatar-wrap {
  position: relative;
  width: 48px;
  height: 48px;
  flex-shrink: 0;
}

.avatar-frame {
  width: 100%;
  height: 100%;
  border-radius: 12px;
  overflow: hidden;
  background: #eaf1f8;
}

.member-avatar-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.member-avatar-fallback {
  width: 100%;
  height: 100%;
  background: #d7f5a8;
  color: #354e00;
  display: flex;
  align-items: center;
  justify-content: center;
}

.member-avatar-fallback .material-symbols-outlined {
  font-size: 1.5rem;
}

.status-indicator-dot {
  position: absolute;
  bottom: -2px;
  right: -2px;
  width: 11px;
  height: 11px;
  border-radius: 50%;
  background: #22c55e;
  border: 2px solid #ffffff;
}

.member-info-col {
  flex: 1;
  min-width: 0;
  width: 100%;
  overflow: hidden;
}

.member-name-row {
  display: flex;
  align-items: center;
  gap: 0.4rem;
  min-width: 0;
  width: 100%;
  margin-bottom: 0.2rem;
}

.member-name-text {
  font-size: 0.875rem;
  color: var(--on-surface, #091d2e);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  font-weight: 700;
  min-width: 0;
  flex: 1;
}

.member-exp-badge {
  font-size: 0.6875rem;
  font-weight: 700;
  color: #354e00;
  background: #e5f8c6;
  padding: 0.12rem 0.5rem;
  border-radius: 9999px;
  white-space: nowrap;
  flex-shrink: 0;
}

.member-role-text {
  font-size: 0.75rem;
  color: var(--primary, #006384);
  font-weight: 700;
  margin-bottom: 0.2rem;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  min-width: 0;
  width: 100%;
}

.member-spec-row {
  display: flex;
  align-items: center;
  gap: 0.25rem;
  font-size: 0.75rem;
  color: var(--on-surface-variant, #40484d);
  min-width: 0;
  width: 100%;
  overflow: hidden;
}

.member-spec-row .material-symbols-outlined {
  font-size: 0.85rem;
  color: #4b6716;
  flex-shrink: 0;
}

.member-spec-text {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  min-width: 0;
  flex: 1;
}

.member-action-col {
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
}

.action-arrow {
  font-size: 1.25rem;
  color: var(--outline, #70787e);
  transition: all 0.2s ease;
  flex-shrink: 0;
}

.team-preview-footer {
  margin-top: 0.25rem;
  padding-top: 0.85rem;
  border-top: 1px solid rgba(191, 200, 206, 0.3);
  display: flex;
  align-items: center;
  justify-content: flex-start;
  gap: 0.5rem;
}

.footer-team-summary {
  display: flex;
  align-items: center;
  gap: 0.4rem;
  font-size: 0.8125rem;
  color: var(--on-surface-variant, #40484d);
}

.footer-team-summary .material-symbols-outlined {
  font-size: 1.15rem;
  color: var(--secondary, #4b6716);
}

/* =============================================
   RESPONSIVE BREAKPOINTS (DESKTOP, TABLET, MOBILE)
   ============================================= */

/* Large Tablets & Medium Desktops (1024px - 1200px) */
@media (max-width: 1200px) {
  .stats-grid {
    grid-template-columns: repeat(2, 1fr);
  }
  .team-preview-list {
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
  }
  .dash-main-grid {
    gap: 1.75rem;
  }
}

/* Tablet (768px - 1024px) */
@media (max-width: 1024px) {
  .dash-main-grid {
    gap: 1.5rem;
  }
  .dash-welcome-card {
    padding: 2rem;
  }
  .welcome-title {
    font-size: 1.65rem;
  }
  .team-preview-list {
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
  }
}

/* Mobile & Small Tablet (< 768px) */
@media (max-width: 768px) {
  .dash-welcome-card {
    padding: 1.5rem 1.25rem;
    flex-direction: column;
    align-items: flex-start;
    gap: 1.5rem;
    border-radius: 20px;
    margin-bottom: 1.5rem;
  }

  .welcome-title {
    font-size: 1.4rem;
  }

  .welcome-desc {
    font-size: 0.875rem;
    margin-bottom: 1rem;
  }

  .dash-welcome-actions {
    width: 100%;
    flex-direction: row;
    flex-wrap: wrap;
  }

  .btn-banner-primary,
  .btn-banner-secondary {
    flex: 1;
    min-width: 140px;
    padding: 0.7rem 1rem;
    font-size: 0.8125rem;
  }

  .stats-grid {
    grid-template-columns: 1fr;
    gap: 1rem;
    margin-bottom: 1.5rem;
  }

  .stat-card {
    padding: 1.25rem;
  }

  .stat-value {
    font-size: 1.85rem;
  }

  .alert-banner {
    flex-direction: column;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 1rem;
  }

  .btn-alert-action {
    width: 100%;
    justify-content: center;
  }

  .dash-card {
    padding: 1.25rem;
    border-radius: 16px;
  }

  /* Switch table to mobile card list */
  .table-desktop-wrap {
    display: none;
  }

  .mobile-card-list {
    display: flex;
  }

  .card-header {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
    flex-wrap: wrap;
    min-width: 0;
    width: 100%;
  }

  .header-titles {
    flex: 1;
    min-width: 0;
  }

  .header-action-link {
    padding: 0.35rem 0.75rem;
    border-radius: 9999px;
    background: var(--surface-container-low, #edf4ff);
    font-size: 0.75rem;
    font-weight: 700;
    white-space: nowrap;
    flex-shrink: 0;
  }

  .team-preview-list {
    grid-template-columns: minmax(0, 1fr);
    gap: 0.75rem;
    width: 100%;
    min-width: 0;
  }

  .team-member-item {
    padding: 0.85rem 0.95rem;
    border-radius: 12px;
    gap: 0.75rem;
    width: 100%;
    min-width: 0;
    max-width: 100%;
    box-sizing: border-box;
  }

  .member-avatar-wrap {
    width: 44px;
    height: 44px;
  }

  .member-name-text {
    font-size: 0.8125rem;
  }

  .member-role-text,
  .member-spec-row {
    font-size: 0.7188rem;
  }

  .team-preview-footer {
    padding-top: 0.75rem;
  }
}

/* Small mobile (< 480px, e.g. iPhone SE 375px) */
@media (max-width: 480px) {
  .dash-card {
    padding: 1rem 0.85rem;
  }

  .dash-welcome-actions {
    flex-direction: column;
  }

  .btn-banner-primary,
  .btn-banner-secondary {
    width: 100%;
  }

  .card-header {
    gap: 0.5rem;
    align-items: flex-start;
  }

  .header-titles {
    gap: 0.5rem;
    min-width: 0;
    flex: 1;
  }

  .header-icon-badge {
    width: 34px;
    height: 34px;
    border-radius: 10px;
  }

  .card-title {
    font-size: 1rem;
    line-height: 1.25;
  }

  .card-subtitle {
    font-size: 0.7188rem;
    line-height: 1.35;
  }

  .header-action-link {
    padding: 0.25rem 0.6rem;
    font-size: 0.6875rem;
  }

  .team-member-item {
    padding: 0.75rem 0.75rem;
    gap: 0.65rem;
  }

  .member-avatar-wrap {
    width: 40px;
    height: 40px;
  }

  .action-arrow {
    font-size: 1.1rem;
  }
}
</style>
