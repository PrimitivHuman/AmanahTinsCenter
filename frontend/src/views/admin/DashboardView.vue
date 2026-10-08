<template>
  <AdminLayout title="Dashboard Ringkasan">
    <!-- Welcome Banner -->
    <div class="dash-welcome-card">
      <div class="dash-welcome-content">
        <span class="welcome-chip">Pusat Kendali Administrasi</span>
        <h1 class="welcome-title">Selamat Datang, {{ auth.user?.name || 'Administrator' }} 👋</h1>
        <p class="welcome-desc">
          Pantau perkembangan pendaftaran janji terapi, jadwal konsultasi, serta statistik edukasi klinik Amanah Tin's Center secara real-time.
        </p>
      </div>
      <div class="dash-welcome-action">
        <router-link to="/admin/jadwal" class="btn-primary-pill">
          <span class="material-symbols-outlined">event_available</span>
          <span>Lihat Semua Janji</span>
        </router-link>
      </div>
    </div>

    <!-- Stat Cards Grid -->
    <div class="stats-grid">
      <!-- Stat 1: Total Appointments -->
      <div class="stat-card">
        <div class="stat-top">
          <div class="stat-icon-wrap teal-bg">
            <span class="material-symbols-outlined">calendar_month</span>
          </div>
          <span class="stat-badge orange-badge" v-if="stats.pending_appointments > 0">
            {{ stats.pending_appointments }} Menunggu
          </span>
        </div>
        <div class="stat-value">{{ stats.total_appointments || 0 }}</div>
        <div class="stat-label">Total Pendaftaran Terapi</div>
      </div>

      <!-- Stat 2: Active Therapists -->
      <div class="stat-card">
        <div class="stat-top">
          <div class="stat-icon-wrap green-bg">
            <span class="material-symbols-outlined">clinical_notes</span>
          </div>
          <span class="stat-badge green-badge">4 Layanan Utama</span>
        </div>
        <div class="stat-value">{{ stats.total_team || 0 }}</div>
        <div class="stat-label">Terapis Medis Terdaftar</div>
      </div>

      <!-- Stat 3: Total Articles -->
      <div class="stat-card">
        <div class="stat-top">
          <div class="stat-icon-wrap blue-bg">
            <span class="material-symbols-outlined">menu_book</span>
          </div>
          <span class="stat-badge blue-badge">Edukasi Ortu</span>
        </div>
        <div class="stat-value">{{ stats.total_articles || 0 }}</div>
        <div class="stat-label">Artikel & Tips Diterbitkan</div>
      </div>

      <!-- Stat 4: Total Article Views -->
      <div class="stat-card">
        <div class="stat-top">
          <div class="stat-icon-wrap amber-bg">
            <span class="material-symbols-outlined">visibility</span>
          </div>
          <span class="stat-badge green-badge">Interaksi</span>
        </div>
        <div class="stat-value">{{ stats.total_views || 0 }}</div>
        <div class="stat-label">Total Pembaca Artikel</div>
      </div>
    </div>

    <!-- Main Content Split: Appointments & Quick Actions -->
    <div class="dash-split-grid">
      <!-- Left: Recent Appointments Table -->
      <div class="dash-box">
        <div class="box-header">
          <div>
            <h2 class="box-title">Pendaftaran Janji Temu Terbaru</h2>
            <p class="box-sub">5 permohonan konsultasi & skrining terakhir masuk</p>
          </div>
          <router-link to="/admin/jadwal" class="link-more">
            <span>Kelola Semua</span>
            <span class="material-symbols-outlined">chevron_right</span>
          </router-link>
        </div>

        <div v-if="loading" class="loading-wrap">
          <div class="spinner-small"></div>
          <span>Memuat data...</span>
        </div>

        <div v-else-if="recentAppointments.length === 0" class="empty-state">
          <span class="material-symbols-outlined empty-icon">event_busy</span>
          <p>Belum ada janji temu pendaftaran masuk.</p>
        </div>

        <div v-else class="table-responsive">
          <table class="data-table">
            <thead>
              <tr>
                <th>Pasien / Orang Tua</th>
                <th>Layanan Terapi</th>
                <th>Jadwal Sesi</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in recentAppointments" :key="item.id">
                <td>
                  <div class="patient-info">
                    <div class="patient-name">{{ item.child_name }} ({{ item.child_age || '-' }})</div>
                    <div class="parent-meta">{{ item.parent_name }} • {{ item.phone }}</div>
                  </div>
                </td>
                <td>
                  <span class="service-pill">{{ item.service_type }}</span>
                </td>
                <td>
                  <div class="date-meta">
                    <strong>{{ formatDate(item.preferred_date) }}</strong>
                    <span>{{ item.preferred_time || 'Fleksibel' }}</span>
                  </div>
                </td>
                <td>
                  <span :class="['status-badge', getStatusClass(item.status)]">
                    {{ getStatusLabel(item.status) }}
                  </span>
                </td>
                <td>
                  <div class="action-btns">
                    <button
                      v-if="item.status === 'pending'"
                      @click="quickUpdateStatus(item, 'confirmed')"
                      class="btn-icon-check"
                      title="Konfirmasi Janji"
                    >
                      <span class="material-symbols-outlined">check_circle</span>
                    </button>
                    <a
                      :href="`https://wa.me/${cleanPhone(item.phone)}?text=Halo%20Bapak%2FIbu%20${encodeURIComponent(item.parent_name)}%2C%20kami%20dari%20Amanah%20Tin's%20Center%20mengenai%20janji%20terapi%20untuk%20${encodeURIComponent(item.child_name)}.`"
                      target="_blank"
                      class="btn-icon-wa"
                      title="Hubungi via WhatsApp"
                    >
                      <span class="material-symbols-outlined">chat</span>
                    </a>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Right: Recent Articles & Quick Actions -->
      <div class="dash-side-col">
        <!-- Quick Actions Card -->
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
                <div class="action-title">Konfigurasi Klinik</div>
                <div class="action-sub">Jam kerja, kontak, sosmed</div>
              </div>
              <span class="material-symbols-outlined arrow">chevron_right</span>
            </router-link>
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

          <div class="recent-articles-list">
            <div
              v-for="art in recentArticles"
              :key="art.id"
              class="recent-art-item"
            >
              <div class="art-thumb-wrap">
                <img :src="art.image || 'https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?w=200'" alt="" class="art-thumb" />
              </div>
              <div class="art-details">
                <span class="art-cat-label">{{ art.category }}</span>
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
import { ref, onMounted } from 'vue'
import AdminLayout from '../../layouts/AdminLayout.vue'
import { useAuthStore } from '../../stores/auth'
import api from '../../services/api'

const auth = useAuthStore()

const stats = ref({})
const recentAppointments = ref([])
const recentArticles = ref([])
const loading = ref(true)

async function fetchDashboardData() {
  loading.value = true
  try {
    const res = await api.get('/admin/stats')
    stats.value = res.data.stats || {}
    recentAppointments.value = res.data.recent_appointments || []
    recentArticles.value = res.data.recent_articles || []
  } catch (err) {
    console.error('Failed to load dashboard stats', err)
  } finally {
    loading.value = false
  }
}

async function quickUpdateStatus(item, newStatus) {
  try {
    await api.put(`/admin/appointments/${item.id}`, {
      status: newStatus,
    })
    item.status = newStatus
  } catch (err) {
    alert('Gagal memperbarui status janji.')
  }
}

function formatDate(dateStr) {
  if (!dateStr) return '-'
  const d = new Date(dateStr)
  return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })
}

function cleanPhone(phone) {
  if (!phone) return ''
  let cleaned = phone.replace(/[^0-9]/g, '')
  if (cleaned.startsWith('0')) {
    cleaned = '62' + cleaned.slice(1)
  }
  return cleaned
}

function getStatusClass(status) {
  switch (status) {
    case 'pending': return 'badge-pending'
    case 'confirmed': return 'badge-confirmed'
    case 'completed': return 'badge-completed'
    case 'cancelled': return 'badge-cancelled'
    default: return ''
  }
}

function getStatusLabel(status) {
  switch (status) {
    case 'pending': return 'Menunggu'
    case 'confirmed': return 'Dikonfirmasi'
    case 'completed': return 'Selesai'
    case 'cancelled': return 'Dibatalkan'
    default: return status
  }
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

.orange-badge { background: #ffdad6; color: #ba1a1a; }
.green-badge { background: #ccef8e; color: #354e00; }
.blue-badge { background: #c1e8ff; color: #004d67; }

.stat-value {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 2rem;
  font-weight: 800;
  color: var(--on-surface, #091d2e);
  line-height: 1.1;
  margin-bottom: 0.25rem;
}

.stat-label {
  font-size: 0.8125rem;
  color: var(--on-surface-variant, #40484d);
  font-weight: 600;
}

/* Split grid */
.dash-split-grid {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 1.75rem;
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

.date-meta {
  display: flex;
  flex-direction: column;
  font-size: 0.8125rem;
}

.status-badge {
  display: inline-block;
  padding: 0.25rem 0.65rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 700;
}

.badge-pending { background: #ffdad6; color: #ba1a1a; }
.badge-confirmed { background: #c1e8ff; color: #004d67; }
.badge-completed { background: #ccef8e; color: #354e00; }
.badge-cancelled { background: #f0f0f0; color: #70787e; }

.action-btns {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.btn-icon-check {
  background: none;
  border: none;
  color: var(--secondary, #4b6716);
  cursor: pointer;
  padding: 0.25rem;
  border-radius: 6px;
  display: flex;
}

.btn-icon-wa {
  color: #128c7e;
  text-decoration: none;
  padding: 0.25rem;
  display: flex;
}

/* Quick links */
.dash-side-col {
  display: flex;
  flex-direction: column;
  gap: 1.75rem;
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

.art-cat-label {
  font-size: 0.6875rem;
  font-weight: 700;
  color: var(--primary, #006384);
  text-transform: uppercase;
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
