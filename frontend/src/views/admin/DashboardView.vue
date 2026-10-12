<template>
  <AdminLayout title="Dashboard Ringkasan">
    <!-- Welcome Banner -->
    <div class="dash-welcome-card">
      <div class="dash-welcome-content">
        <span class="welcome-chip">Pusat Kendali Administrasi</span>
        <h1 class="welcome-title">Selamat Datang, {{ auth.user?.name || 'Administrator' }} 👋</h1>
        <p class="welcome-desc">
          Kelola artikel edukasi, profil tim terapis, serta kontak WhatsApp klinik Amanah Tin's Center.
          Pendaftaran dan konsultasi orang tua kini langsung masuk melalui WhatsApp.
        </p>
      </div>
      <div class="dash-welcome-action">
        <router-link to="/admin/artikel/baru" class="btn-primary-pill">
          <span class="material-symbols-outlined">edit_note</span>
          <span>Tulis Artikel Baru</span>
        </router-link>
      </div>
    </div>

    <!-- Error state -->
    <div v-if="error" class="error-banner" role="alert">
      <span class="material-symbols-outlined">error</span>
      <span>{{ error }}</span>
      <button class="btn-retry" @click="fetchDashboardData">Coba Lagi</button>
    </div>

    <!-- Settings completeness warning -->
    <div v-if="!loading && missingSettings.length" class="warn-banner" role="status">
      <span class="material-symbols-outlined">warning</span>
      <div class="warn-text">
        <strong>Pengaturan klinik belum lengkap:</strong>
        {{ missingSettings.join(', ') }}.
      </div>
      <router-link to="/admin/pengaturan" class="link-more">Lengkapi</router-link>
    </div>

    <!-- Stat Cards Grid -->
    <div class="stats-grid">
      <template v-if="loading">
        <div v-for="n in 4" :key="n" class="stat-card">
          <div class="skeleton sk-icon"></div>
          <div class="skeleton sk-value"></div>
          <div class="skeleton sk-label"></div>
        </div>
      </template>

      <template v-else>
        <!-- Stat 1: Published Articles -->
        <div class="stat-card">
          <div class="stat-top">
            <div class="stat-icon-wrap teal-bg">
              <span class="material-symbols-outlined">menu_book</span>
            </div>
            <span class="stat-badge orange-badge" v-if="stats.draft_articles > 0">
              {{ stats.draft_articles }} Draft
            </span>
          </div>
          <div class="stat-value">{{ stats.published_articles ?? 0 }}</div>
          <div class="stat-label">Artikel Terbit</div>
        </div>

        <!-- Stat 2: Active Therapists -->
        <div class="stat-card">
          <div class="stat-top">
            <div class="stat-icon-wrap green-bg">
              <span class="material-symbols-outlined">clinical_notes</span>
            </div>
            <span class="stat-badge orange-badge" v-if="health.team_without_photo > 0">
              {{ health.team_without_photo }} tanpa foto
            </span>
          </div>
          <div class="stat-value">{{ stats.total_team ?? 0 }}</div>
          <div class="stat-label">Terapis Aktif</div>
        </div>

        <!-- Stat 3: Total views -->
        <div class="stat-card">
          <div class="stat-top">
            <div class="stat-icon-wrap amber-bg">
              <span class="material-symbols-outlined">visibility</span>
            </div>
          </div>
          <div class="stat-value">{{ formatNumber(stats.total_views) }}</div>
          <div class="stat-label">Total Pembaca Artikel</div>
        </div>

        <!-- Stat 4: WhatsApp -->
        <div class="stat-card">
          <div class="stat-top">
            <div class="stat-icon-wrap blue-bg">
              <span class="material-symbols-outlined">chat</span>
            </div>
            <span :class="['stat-badge', whatsapp ? 'green-badge' : 'orange-badge']">
              {{ whatsapp ? 'Aktif' : 'Belum diatur' }}
            </span>
          </div>
          <div class="stat-value stat-value-sm">{{ displayWhatsapp }}</div>
          <div class="stat-label">WhatsApp Pendaftaran</div>
          <div class="wa-actions">
            <a :href="waLink('Halo Admin Amanah Tin\'s Center, ini pesan uji dari portal admin.')"
               target="_blank" rel="noopener noreferrer" class="wa-test">
              <span class="material-symbols-outlined">send</span> Uji Chat
            </a>
            <router-link to="/admin/pengaturan" class="wa-edit">Ubah</router-link>
          </div>
        </div>
      </template>
    </div>

    <!-- Main Content Split -->
    <div class="dash-split-grid">
      <!-- Left: Popular & content health -->
      <div class="dash-main-col">
        <div class="dash-box">
          <div class="box-header">
            <div>
              <h2 class="box-title">Artikel Terpopuler</h2>
              <p class="box-sub">5 artikel terbit dengan pembaca terbanyak</p>
            </div>
            <router-link to="/admin/artikel" class="link-more">
              <span>Kelola Artikel</span>
              <span class="material-symbols-outlined">chevron_right</span>
            </router-link>
          </div>

          <div v-if="loading" class="loading-wrap">
            <div class="spinner-small"></div>
            <span>Memuat data...</span>
          </div>

          <div v-else-if="popularArticles.length === 0" class="empty-state">
            <span class="material-symbols-outlined empty-icon">article</span>
            <p>Belum ada artikel terbit.</p>
          </div>

          <div v-else class="table-responsive">
            <table class="data-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Judul</th>
                  <th>Kategori</th>
                  <th>Pembaca</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(art, i) in popularArticles" :key="art.id">
                  <td class="rank-cell">{{ i + 1 }}</td>
                  <td>
                    <div class="patient-name">{{ art.title }}</div>
                    <div class="parent-meta">{{ art.author }}</div>
                  </td>
                  <td><span class="service-pill">{{ art.category }}</span></td>
                  <td><strong>{{ formatNumber(art.views_count) }}</strong></td>
                  <td>
                    <router-link :to="`/admin/artikel/${art.id}/edit`" class="btn-icon-check" title="Edit artikel" aria-label="Edit artikel">
                      <span class="material-symbols-outlined">edit</span>
                    </router-link>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Content health -->
        <div class="dash-box">
          <h2 class="box-title mb-3">Kesehatan Konten</h2>
          <ul class="health-list">
            <li :class="['health-item', stats.draft_articles > 0 ? 'is-warn' : 'is-ok']">
              <span class="material-symbols-outlined">{{ stats.draft_articles > 0 ? 'edit_document' : 'check_circle' }}</span>
              <span v-if="stats.draft_articles > 0">{{ stats.draft_articles }} artikel masih draft dan belum terbit</span>
              <span v-else>Semua artikel sudah terbit</span>
            </li>
            <li :class="['health-item', health.articles_without_image > 0 ? 'is-warn' : 'is-ok']">
              <span class="material-symbols-outlined">{{ health.articles_without_image > 0 ? 'image_not_supported' : 'check_circle' }}</span>
              <span v-if="health.articles_without_image > 0">{{ health.articles_without_image }} artikel belum memiliki gambar</span>
              <span v-else>Semua artikel memiliki gambar</span>
            </li>
            <li :class="['health-item', health.team_without_photo > 0 ? 'is-warn' : 'is-ok']">
              <span class="material-symbols-outlined">{{ health.team_without_photo > 0 ? 'person_alert' : 'check_circle' }}</span>
              <span v-if="health.team_without_photo > 0">{{ health.team_without_photo }} terapis aktif belum memiliki foto</span>
              <span v-else>Semua terapis aktif memiliki foto</span>
            </li>
            <li :class="['health-item', missingSettings.length ? 'is-warn' : 'is-ok']">
              <span class="material-symbols-outlined">{{ missingSettings.length ? 'settings_alert' : 'check_circle' }}</span>
              <span v-if="missingSettings.length">Pengaturan belum lengkap: {{ missingSettings.join(', ') }}</span>
              <span v-else>Pengaturan klinik sudah lengkap</span>
            </li>
          </ul>
        </div>
      </div>

      <!-- Right: Quick Actions & Recent Articles -->
      <div class="dash-side-col">
        <div class="dash-box">
          <h2 class="box-title mb-3">Aksi Cepat</h2>
          <div class="quick-links-list">
            <router-link to="/admin/artikel/baru" class="quick-action-item">
              <div class="action-icon teal-bg">
                <span class="material-symbols-outlined">edit_note</span>
              </div>
              <div class="action-text">
                <div class="action-title">Tulis Artikel Baru</div>
                <div class="action-sub">Publikasikan materi edukasi</div>
              </div>
              <span class="material-symbols-outlined arrow">chevron_right</span>
            </router-link>

            <router-link to="/admin/tim-kami" class="quick-action-item">
              <div class="action-icon green-bg">
                <span class="material-symbols-outlined">person_add</span>
              </div>
              <div class="action-text">
                <div class="action-title">Tambah Terapis</div>
                <div class="action-sub">Update profil tenaga ahli</div>
              </div>
              <span class="material-symbols-outlined arrow">chevron_right</span>
            </router-link>

            <router-link to="/admin/pengaturan" class="quick-action-item">
              <div class="action-icon amber-bg">
                <span class="material-symbols-outlined">tune</span>
              </div>
              <div class="action-text">
                <div class="action-title">WhatsApp &amp; Jam Operasional</div>
                <div class="action-sub">Kontak, jam kerja, sosmed</div>
              </div>
              <span class="material-symbols-outlined arrow">chevron_right</span>
            </router-link>

            <a href="/" target="_blank" rel="noopener noreferrer" class="quick-action-item">
              <div class="action-icon blue-bg">
                <span class="material-symbols-outlined">open_in_new</span>
              </div>
              <div class="action-text">
                <div class="action-title">Tinjau Website</div>
                <div class="action-sub">Lihat tampilan publik</div>
              </div>
              <span class="material-symbols-outlined arrow">chevron_right</span>
            </a>
          </div>
        </div>

        <!-- Recent Articles Mini List -->
        <div class="dash-box">
          <div class="box-header">
            <h2 class="box-title">Artikel Terbaru</h2>
            <router-link to="/admin/artikel" class="link-more">
              <span>Semua</span>
            </router-link>
          </div>

          <div v-if="!loading && recentArticles.length === 0" class="empty-state">
            <p>Belum ada artikel.</p>
          </div>

          <div class="recent-articles-list">
            <div
              v-for="art in recentArticles"
              :key="art.id"
              class="recent-art-item"
            >
              <div class="art-thumb-wrap">
                <img v-if="art.image" :src="art.image" :alt="art.title" class="art-thumb" loading="lazy" />
                <div v-else class="art-thumb art-thumb-empty" aria-hidden="true">
                  <span class="material-symbols-outlined">image</span>
                </div>
              </div>
              <div class="art-details">
                <span class="art-cat-label">
                  {{ art.category }}
                  <span v-if="!art.is_published" class="draft-tag">Draft</span>
                </span>
                <router-link :to="`/admin/artikel/${art.id}/edit`" class="art-link-title">
                  {{ art.title }}
                </router-link>
                <div class="art-meta-row">
                  <span>{{ art.views_count }} dilihat</span>
                  <span>•</span>
                  <span>{{ art.author }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
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
const recentArticles = ref([])
const health = ref({ articles_without_image: 0, team_without_photo: 0 })
const missingSettings = ref([])
const whatsapp = ref('')
const loading = ref(true)
const error = ref('')

const displayWhatsapp = computed(() => {
  if (!whatsapp.value) return '-'
  const d = String(whatsapp.value).replace(/[^0-9]/g, '')
  if (d.startsWith('62')) return '+62 ' + d.slice(2).replace(/(\d{3})(\d{4})(\d+)/, '$1-$2-$3')
  return whatsapp.value
})

async function fetchDashboardData() {
  loading.value = true
  error.value = ''
  try {
    const res = await api.get('/admin/stats')
    stats.value = res.data.stats || {}
    popularArticles.value = res.data.popular_articles || []
    recentArticles.value = res.data.recent_articles || []
    health.value = res.data.health || health.value
    missingSettings.value = res.data.missing_settings || []
    whatsapp.value = res.data.whatsapp || ''
  } catch (err) {
    console.error('Failed to load dashboard stats', err)
    error.value = 'Gagal memuat data dashboard. Periksa koneksi atau server, lalu coba lagi.'
  } finally {
    loading.value = false
  }
}

function formatNumber(n) {
  return new Intl.NumberFormat('id-ID').format(n || 0)
}

onMounted(() => {
  fetchDashboardData()
})
</script>

<style scoped>
.dash-welcome-card {
  background: linear-gradient(135deg, #006384 0%, #2e7c9e 100%);
  color: #ffffff;
  padding: 2.25rem;
  border-radius: 24px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 2rem;
  margin-bottom: 2rem;
  box-shadow: 0 10px 24px rgba(0, 99, 132, 0.18);
}

.welcome-chip {
  display: inline-block;
  background: rgba(255, 255, 255, 0.2);
  padding: 0.25rem 0.75rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 700;
  margin-bottom: 0.75rem;
}

.welcome-title {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 1.75rem;
  font-weight: 700;
  margin-bottom: 0.5rem;
}

.welcome-desc {
  font-size: 0.9375rem;
  opacity: 0.9;
  max-width: 650px;
  line-height: 1.6;
}

.btn-primary-pill {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  background: #ffffff;
  color: var(--primary, #006384);
  padding: 0.75rem 1.5rem;
  border-radius: 9999px;
  font-weight: 700;
  font-size: 0.9375rem;
  text-decoration: none;
  white-space: nowrap;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s;
}

.btn-primary-pill:hover {
  transform: translateY(-2px);
}

/* Banners */
.error-banner,
.warn-banner {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 0.875rem 1.25rem;
  border-radius: 14px;
  margin-bottom: 1.5rem;
  font-size: 0.875rem;
}

.error-banner {
  background: #ffdad6;
  color: #93000a;
}

.warn-banner {
  background: #ffdcbf;
  color: #6b3b00;
}

.warn-text {
  flex: 1;
}

.btn-retry {
  margin-left: auto;
  border: none;
  background: #ba1a1a;
  color: #fff;
  padding: 0.4rem 1rem;
  border-radius: 9999px;
  font-weight: 700;
  cursor: pointer;
}

/* Stats */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
  gap: 1.5rem;
  margin-bottom: 2rem;
}

.stat-card {
  background: #ffffff;
  padding: 1.5rem;
  border-radius: 20px;
  border: 1px solid rgba(191, 200, 206, 0.4);
  box-shadow: 0 4px 12px rgba(43, 61, 79, 0.04);
}

.stat-top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 1rem;
}

.stat-icon-wrap {
  width: 44px;
  height: 44px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.teal-bg { background: #c1e8ff; color: #006384; }
.green-bg { background: #ccef8e; color: #4b6716; }
.blue-bg { background: #d9eaff; color: #004d67; }
.amber-bg { background: #ffdcbf; color: #884e03; }

.stat-badge {
  padding: 0.2rem 0.6rem;
  border-radius: 9999px;
  font-size: 0.6875rem;
  font-weight: 700;
}

.orange-badge { background: #ffdcbf; color: #6b3b00; }
.green-badge { background: #ccef8e; color: #354e00; }

.stat-value {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 2rem;
  font-weight: 800;
  color: var(--on-surface, #091d2e);
  line-height: 1.1;
  margin-bottom: 0.25rem;
}

.stat-value-sm {
  font-size: 1.35rem;
  padding: 0.35rem 0;
}

.stat-label {
  font-size: 0.8125rem;
  color: var(--on-surface-variant, #40484d);
  font-weight: 600;
}

.wa-actions {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  margin-top: 0.75rem;
}

.wa-test {
  display: inline-flex;
  align-items: center;
  gap: 0.3rem;
  font-size: 0.75rem;
  font-weight: 700;
  color: #0b6b5c;
  text-decoration: none;
}

.wa-test .material-symbols-outlined {
  font-size: 1rem;
}

.wa-edit {
  font-size: 0.75rem;
  font-weight: 700;
  color: var(--primary, #006384);
  text-decoration: none;
}

/* Skeleton */
.skeleton {
  background: linear-gradient(90deg, #eaf1fa 25%, #f6f9fd 50%, #eaf1fa 75%);
  background-size: 200% 100%;
  animation: shimmer 1.4s infinite;
  border-radius: 8px;
}

.sk-icon { width: 44px; height: 44px; border-radius: 12px; margin-bottom: 1rem; }
.sk-value { width: 55%; height: 32px; margin-bottom: 0.5rem; }
.sk-label { width: 80%; height: 14px; }

@keyframes shimmer {
  0% { background-position: 200% 0; }
  100% { background-position: -200% 0; }
}

/* Split grid */
.dash-split-grid {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 1.75rem;
}

.dash-main-col {
  display: flex;
  flex-direction: column;
  gap: 1.75rem;
  min-width: 0;
}

.dash-box {
  background: #ffffff;
  padding: 1.75rem;
  border-radius: 20px;
  border: 1px solid rgba(191, 200, 206, 0.4);
  box-shadow: 0 4px 12px rgba(43, 61, 79, 0.04);
}

.box-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 1.25rem;
}

.box-title {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 1.125rem;
  font-weight: 700;
  color: var(--on-surface, #091d2e);
}

.box-sub {
  font-size: 0.8125rem;
  color: var(--on-surface-variant, #40484d);
  margin-top: 0.15rem;
}

.link-more {
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
  color: var(--primary, #006384);
  font-size: 0.8125rem;
  font-weight: 700;
  text-decoration: none;
}

.link-more:hover {
  text-decoration: underline;
}

/* Table */
.table-responsive {
  overflow-x: auto;
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

.data-table td {
  padding: 1rem;
  border-bottom: 1px solid rgba(191, 200, 206, 0.25);
  font-size: 0.875rem;
}

.rank-cell {
  font-weight: 800;
  color: var(--primary, #006384);
  width: 40px;
}

.patient-name {
  font-weight: 700;
  color: var(--on-surface, #091d2e);
}

.parent-meta {
  font-size: 0.75rem;
  color: var(--on-surface-variant, #40484d);
  margin-top: 0.15rem;
}

.service-pill {
  display: inline-block;
  padding: 0.2rem 0.6rem;
  border-radius: 6px;
  background: var(--surface-container, #e3efff);
  color: var(--primary, #006384);
  font-size: 0.75rem;
  font-weight: 600;
}

.btn-icon-check {
  background: none;
  border: none;
  color: var(--secondary, #4b6716);
  cursor: pointer;
  padding: 0.25rem;
  border-radius: 6px;
  display: inline-flex;
  text-decoration: none;
}

/* Content health */
.health-list {
  list-style: none;
  margin: 0;
  padding: 0;
  display: flex;
  flex-direction: column;
  gap: 0.625rem;
}

.health-item {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 0.75rem 1rem;
  border-radius: 12px;
  font-size: 0.875rem;
  font-weight: 600;
}

.health-item.is-ok { background: #eef7dc; color: #354e00; }
.health-item.is-warn { background: #fff1e0; color: #6b3b00; }

/* Quick links */
.dash-side-col {
  display: flex;
  flex-direction: column;
  gap: 1.75rem;
  min-width: 0;
}

.quick-links-list {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.quick-action-item {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 0.875rem 1rem;
  border-radius: 14px;
  background: var(--surface-bright, #f7f9ff);
  border: 1px solid rgba(191, 200, 206, 0.4);
  text-decoration: none;
  color: inherit;
  transition: all 0.2s;
}

.quick-action-item:hover {
  background: var(--surface-container-low, #edf4ff);
  transform: translateX(3px);
}

.action-icon {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.action-title {
  font-weight: 700;
  font-size: 0.875rem;
  color: var(--on-surface, #091d2e);
}

.action-sub {
  font-size: 0.75rem;
  color: var(--on-surface-variant, #40484d);
}

.arrow {
  margin-left: auto;
  color: var(--outline, #70787e);
}

/* Recent articles list */
.recent-articles-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.recent-art-item {
  display: flex;
  gap: 0.875rem;
  align-items: center;
}

.art-thumb-wrap {
  width: 60px;
  height: 60px;
  border-radius: 10px;
  overflow: hidden;
  flex-shrink: 0;
}

.art-thumb {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.art-thumb-empty {
  display: flex;
  align-items: center;
  justify-content: center;
  background: var(--surface-container, #e3efff);
  color: var(--outline, #70787e);
}

.art-cat-label {
  font-size: 0.6875rem;
  font-weight: 700;
  color: var(--primary, #006384);
  text-transform: uppercase;
}

.draft-tag {
  margin-left: 0.4rem;
  padding: 0.05rem 0.4rem;
  border-radius: 9999px;
  background: #ffdcbf;
  color: #6b3b00;
  font-size: 0.625rem;
}

.art-link-title {
  display: block;
  font-size: 0.8125rem;
  font-weight: 700;
  color: var(--on-surface, #091d2e);
  text-decoration: none;
  line-height: 1.3;
  margin: 0.15rem 0;
}

.art-link-title:hover {
  color: var(--primary, #006384);
}

.art-meta-row {
  font-size: 0.6875rem;
  color: var(--outline, #70787e);
  display: flex;
  gap: 0.35rem;
}

.empty-state {
  text-align: center;
  padding: 2.5rem 1rem;
  color: var(--on-surface-variant, #40484d);
}

.empty-icon {
  font-size: 2.5rem;
  color: var(--outline, #70787e);
  margin-bottom: 0.5rem;
}

.loading-wrap {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.75rem;
  padding: 2.5rem;
  color: var(--on-surface-variant, #40484d);
}

@media (max-width: 1024px) {
  .dash-split-grid {
    grid-template-columns: 1fr;
  }
}
</style>
