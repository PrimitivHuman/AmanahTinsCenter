<template>
  <AdminLayout title="Kelola Artikel & Tips">
    <!-- Header Top Row -->
    <div class="page-top-bar">
      <div class="top-title-group">
        <div class="meta-tag">
          <span class="material-symbols-outlined tag-icon">menu_book</span>
          <span>Pusat Edukasi Orang Tua</span>
        </div>
        <h1 class="page-heading">Manajemen Artikel &amp; Tips Edukasi</h1>
        <p class="page-subheading">
          Publikasikan panduan perkembangan anak, tips stimulasi di rumah, dan informasi klinis terpercaya untuk orang tua.
        </p>
      </div>
      <div class="top-actions">
        <router-link to="/admin/artikel/baru" class="btn-create">
          <span class="material-symbols-outlined">edit_note</span>
          <span>Tulis Artikel Baru</span>
        </router-link>
      </div>
    </div>

    <!-- Ringkasan Metrik Konten (4 Stat Cards) -->
    <div class="stats-grid">
      <!-- Stat 1: Total Artikel -->
      <div class="stat-card stat-card-hover" @click="setStatusFilter('')" role="button" tabindex="0">
        <div class="stat-top">
          <div class="stat-icon-wrap teal-bg">
            <span class="material-symbols-outlined">library_books</span>
          </div>
          <span class="stat-badge blue-badge">Semua Konten</span>
        </div>
        <div class="stat-value">{{ formatNumber(stats.total || 0) }}</div>
        <div class="stat-label">Total Artikel Terdata</div>
        <div class="stat-subtext">Katalog edukasi lengkap klinik</div>
      </div>

      <!-- Stat 2: Artikel Terbit -->
      <div class="stat-card stat-card-hover" @click="setStatusFilter('published')" role="button" tabindex="0">
        <div class="stat-top">
          <div class="stat-icon-wrap green-bg">
            <span class="material-symbols-outlined">check_circle</span>
          </div>
          <span class="stat-badge green-badge">Tayang Publik</span>
        </div>
        <div class="stat-value">{{ formatNumber(stats.published || 0) }}</div>
        <div class="stat-label">Artikel Diterbitkan</div>
        <div class="stat-subtext">Dapat diakses langsung orang tua</div>
      </div>

      <!-- Stat 3: Draf / Menunggu -->
      <div class="stat-card stat-card-hover" @click="setStatusFilter('draft')" role="button" tabindex="0">
        <div class="stat-top">
          <div class="stat-icon-wrap amber-bg">
            <span class="material-symbols-outlined">edit_document</span>
          </div>
          <span class="stat-badge orange-badge">Dalam Penulisan</span>
        </div>
        <div class="stat-value">{{ formatNumber(stats.draft || 0) }}</div>
        <div class="stat-label">Draf Belum Terbit</div>
        <div class="stat-subtext">Perlu ditinjau atau dilengkapi</div>
      </div>

      <!-- Stat 4: Total Pembaca -->
      <div class="stat-card">
        <div class="stat-top">
          <div class="stat-icon-wrap cyan-bg">
            <span class="material-symbols-outlined">visibility</span>
          </div>
          <span class="stat-badge cyan-badge">Akumulasi Interaksi</span>
        </div>
        <div class="stat-value">{{ formatNumber(stats.total_views || 0) }}</div>
        <div class="stat-label">Total Pembaca Artikel</div>
        <div class="stat-subtext">Total tayangan di website publik</div>
      </div>
    </div>

    <!-- Filter & Search Toolbar Card -->
    <div class="toolbar-box">
      <!-- Baris Atas Toolbar: Status Tabs & Search Bar -->
      <div class="toolbar-primary-row">
        <!-- Status Filter Tabs -->
        <div class="status-tab-group" role="tablist" aria-label="Filter Status Artikel">
          <button
            type="button"
            :class="['status-tab-btn', { 'status-tab-active': statusFilter === '' }]"
            @click="setStatusFilter('')"
          >
            <span>Semua</span>
            <span class="tab-count">{{ stats.total || 0 }}</span>
          </button>
          <button
            type="button"
            :class="['status-tab-btn', { 'status-tab-active': statusFilter === 'published' }]"
            @click="setStatusFilter('published')"
          >
            <span class="status-dot dot-published"></span>
            <span>Terbit</span>
            <span class="tab-count">{{ stats.published || 0 }}</span>
          </button>
          <button
            type="button"
            :class="['status-tab-btn', { 'status-tab-active': statusFilter === 'draft' }]"
            @click="setStatusFilter('draft')"
          >
            <span class="status-dot dot-draft"></span>
            <span>Draf</span>
            <span class="tab-count">{{ stats.draft || 0 }}</span>
          </button>
        </div>

        <!-- Search Input -->
        <div class="search-box">
          <span class="material-symbols-outlined search-icon">search</span>
          <input
            v-model="searchQuery"
            @input="debounceSearch"
            type="text"
            placeholder="Cari judul, topik, penulis, ringkasan..."
            class="search-input"
            aria-label="Cari artikel"
          />
          <button
            v-if="searchQuery"
            type="button"
            @click="clearSearch"
            class="search-clear-btn"
            title="Bersihkan pencarian"
          >
            <span class="material-symbols-outlined">close</span>
          </button>
        </div>
      </div>

      <!-- Baris Bawah Toolbar: Category Filter Chips & Reset Filter -->
      <div class="toolbar-secondary-row">
        <div class="category-header-row">
          <div class="category-title-label">
            <span class="material-symbols-outlined text-sm">filter_alt</span>
            <span>Kategori Terapi:</span>
          </div>

          <button
            v-if="hasActiveFilter"
            type="button"
            @click="resetAllFilters"
            class="btn-reset-filter"
            title="Kembalikan semua filter ke awal"
          >
            <span class="material-symbols-outlined text-sm">restart_alt</span>
            <span>Reset Semua Filter</span>
          </button>
        </div>

        <div class="category-chips-wrap">
          <button
            v-for="cat in categories"
            :key="cat.value"
            type="button"
            :class="['chip-btn', { 'chip-btn-active': selectedCategory === cat.value }]"
            @click="selectCategory(cat.value)"
          >
            <span
              class="chip-dot"
              :style="{ backgroundColor: selectedCategory === cat.value ? '#ffffff' : cat.color }"
            ></span>
            <span>{{ cat.label }}</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Main Content Container Card -->
    <div class="table-card">
      <!-- Loading State -->
      <div v-if="loading" class="state-container">
        <div class="spinner-small"></div>
        <span class="state-text">Memuat daftar artikel...</span>
      </div>

      <!-- Empty State -->
      <div v-else-if="articles.length === 0" class="empty-state">
        <div class="empty-icon-wrap">
          <span class="material-symbols-outlined">auto_stories</span>
        </div>
        <h3 class="empty-title">Tidak Ada Artikel Ditemukan</h3>
        <p class="empty-desc">
          <span v-if="hasActiveFilter">
            Tidak ada artikel yang cocok dengan filter atau kata kunci pencarian Anda. Silakan ubah filter atau reset pencarian.
          </span>
          <span v-else>
            Belum ada artikel edukasi yang dibuat di sistem. Mulai tulis materi edukasi pertama untuk orang tua sekarang.
          </span>
        </p>
        <div class="empty-actions">
          <button v-if="hasActiveFilter" @click="resetAllFilters" class="btn-secondary-state">
            <span class="material-symbols-outlined">refresh</span>
            <span>Reset Semua Filter</span>
          </button>
          <router-link to="/admin/artikel/baru" class="btn-primary-state">
            <span class="material-symbols-outlined">add</span>
            <span>Tulis Artikel Pertama</span>
          </router-link>
        </div>
      </div>

      <!-- Content State (Desktop & Mobile) -->
      <template v-else>
        <!-- 1. DESKTOP TABLE VIEW (>= 768px) -->
        <div class="table-desktop-wrap">
          <table class="article-table">
            <thead>
              <tr>
                <th class="th-art">Artikel &amp; Topik</th>
                <th class="th-cat">Kategori</th>
                <th class="th-author">Penulis</th>
                <th class="th-views">Pembaca</th>
                <th class="th-status">Status</th>
                <th class="th-actions">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in articles" :key="item.id">
                <!-- Artikel & Topik -->
                <td class="td-art">
                  <div class="art-cell-flex">
                    <div class="art-thumb-wrapper">
                      <img
                        v-if="item.image && !item.imgError"
                        :src="item.image"
                        :alt="item.title"
                        class="art-cell-thumb"
                        loading="lazy"
                        @error="item.imgError = true"
                      />
                      <div v-else class="art-thumb-fallback">
                        <span class="material-symbols-outlined">menu_book</span>
                      </div>
                    </div>
                    <div class="art-text-meta">
                      <router-link :to="`/admin/artikel/${item.id}/edit`" class="art-title-link">
                        {{ item.title }}
                      </router-link>
                      <p class="art-cell-excerpt">{{ item.excerpt || 'Tidak ada ringkasan teks singkat...' }}</p>
                      <div class="art-meta-pills">
                        <span class="art-date-text">
                          <span class="material-symbols-outlined mini-icon">calendar_today</span>
                          <span>{{ formatDate(item.created_at || item.updated_at) }}</span>
                        </span>
                        <span class="art-time-text" v-if="item.read_time">
                          <span class="material-symbols-outlined mini-icon">schedule</span>
                          <span>{{ item.read_time }}</span>
                        </span>
                      </div>
                    </div>
                  </div>
                </td>

                <!-- Kategori -->
                <td class="td-cat">
                  <span :class="['category-badge', getCategoryBadgeClass(item.category)]">
                    {{ item.category || 'Umum' }}
                  </span>
                </td>

                <!-- Penulis -->
                <td class="td-author">
                  <div class="author-cell">
                    <span class="material-symbols-outlined author-icon">person</span>
                    <span class="author-name">{{ item.author || 'Tim Ahli ATC' }}</span>
                  </div>
                </td>

                <!-- Pembaca -->
                <td class="td-views">
                  <div class="views-meta">
                    <span class="material-symbols-outlined views-icon">visibility</span>
                    <strong class="views-num">{{ formatNumber(item.views_count || 0) }}</strong>
                  </div>
                </td>

                <!-- Status Pill Toggle -->
                <td class="td-status">
                  <button
                    type="button"
                    @click="togglePublish(item)"
                    :class="['status-pill-btn', item.is_published ? 'published-pill' : 'draft-pill']"
                    :disabled="togglingId === item.id"
                    :title="item.is_published ? 'Klik untuk simpan sebagai draf' : 'Klik untuk publikasikan artikel'"
                  >
                    <span v-if="togglingId === item.id" class="mini-spinner"></span>
                    <span v-else class="dot-indicator"></span>
                    <span>{{ item.is_published ? 'Terbit' : 'Draf' }}</span>
                  </button>
                </td>

                <!-- Aksi -->
                <td class="td-actions">
                  <div class="actions-flex">
                    <router-link
                      :to="`/artikel/${item.slug}`"
                      target="_blank"
                      class="action-btn-icon view-action"
                      title="Lihat Tampilan Publik (Tab Baru)"
                      aria-label="Lihat Tampilan Publik"
                    >
                      <span class="material-symbols-outlined">visibility</span>
                    </router-link>
                    <router-link
                      :to="`/admin/artikel/${item.id}/edit`"
                      class="action-btn-icon edit-action"
                      title="Edit Isi Artikel"
                      aria-label="Edit Isi Artikel"
                    >
                      <span class="material-symbols-outlined">edit</span>
                    </router-link>
                    <button
                      type="button"
                      @click="confirmDelete(item)"
                      class="action-btn-icon delete-action"
                      title="Hapus Artikel"
                      aria-label="Hapus Artikel"
                    >
                      <span class="material-symbols-outlined">delete</span>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- 2. MOBILE CARD LIST VIEW (< 768px) -->
        <div class="mobile-card-list">
          <div
            v-for="item in articles"
            :key="'mobile-' + item.id"
            class="mobile-art-card"
          >
            <!-- Card Header: Category & Status -->
            <div class="m-card-header">
              <span :class="['category-badge', getCategoryBadgeClass(item.category)]">
                {{ item.category || 'Umum' }}
              </span>

              <button
                type="button"
                @click="togglePublish(item)"
                :class="['status-pill-btn', item.is_published ? 'published-pill' : 'draft-pill']"
                :disabled="togglingId === item.id"
                :title="item.is_published ? 'Klik untuk ubah ke draf' : 'Klik untuk terbitkan'"
              >
                <span v-if="togglingId === item.id" class="mini-spinner"></span>
                <span v-else class="dot-indicator"></span>
                <span>{{ item.is_published ? 'Terbit' : 'Draf' }}</span>
              </button>
            </div>

            <!-- Card Body: Thumbnail & Main Info -->
            <div class="m-card-body">
              <div class="m-thumb-wrap">
                <img
                  v-if="item.image && !item.imgError"
                  :src="item.image"
                  :alt="item.title"
                  class="m-thumb-img"
                  loading="lazy"
                  @error="item.imgError = true"
                />
                <div v-else class="art-thumb-fallback m-fallback">
                  <span class="material-symbols-outlined">menu_book</span>
                </div>
              </div>

              <div class="m-info-wrap">
                <router-link :to="`/admin/artikel/${item.id}/edit`" class="m-art-title">
                  {{ item.title }}
                </router-link>
                <p class="m-art-excerpt">{{ item.excerpt || 'Tidak ada ringkasan teks...' }}</p>
                <div class="m-meta-row">
                  <span class="m-meta-item">
                    <span class="material-symbols-outlined mini-icon">person</span>
                    <span>{{ item.author || 'Tim Ahli ATC' }}</span>
                  </span>
                  <span class="m-meta-item">
                    <span class="material-symbols-outlined mini-icon">visibility</span>
                    <span>{{ formatNumber(item.views_count || 0) }} kali dibaca</span>
                  </span>
                </div>
              </div>
            </div>

            <!-- Card Footer: Mobile Action Buttons -->
            <div class="m-card-footer">
              <span class="m-date-text">
                <span class="material-symbols-outlined mini-icon">calendar_today</span>
                <span>{{ formatDate(item.created_at || item.updated_at) }}</span>
              </span>

              <div class="m-actions-wrap">
                <router-link
                  :to="`/artikel/${item.slug}`"
                  target="_blank"
                  class="m-btn-action m-btn-view"
                  title="Lihat Publik"
                >
                  <span class="material-symbols-outlined">visibility</span>
                  <span>Lihat</span>
                </router-link>
                <router-link
                  :to="`/admin/artikel/${item.id}/edit`"
                  class="m-btn-action m-btn-edit"
                  title="Edit Artikel"
                >
                  <span class="material-symbols-outlined">edit</span>
                  <span>Edit</span>
                </router-link>
                <button
                  type="button"
                  @click="confirmDelete(item)"
                  class="m-btn-action m-btn-delete"
                  title="Hapus Artikel"
                >
                  <span class="material-symbols-outlined">delete</span>
                  <span>Hapus</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </template>

      <!-- Pagination Bar -->
      <div class="pagination-bar" v-if="pagination.total > 0">
        <div class="pagination-info">
          Menampilkan <strong>{{ pagination.from || 0 }}</strong> - <strong>{{ pagination.to || 0 }}</strong> dari <strong>{{ pagination.total }}</strong> artikel
        </div>

        <div class="pagination-nav">
          <button
            type="button"
            :disabled="pagination.current_page <= 1"
            @click="fetchArticles(pagination.current_page - 1)"
            class="page-nav-btn"
          >
            <span class="material-symbols-outlined">chevron_left</span>
            <span class="btn-label-desktop">Sebelumnya</span>
          </button>

          <span class="page-indicator">
            Hal. <strong>{{ pagination.current_page }}</strong> / {{ pagination.last_page }}
          </span>

          <button
            type="button"
            :disabled="pagination.current_page >= pagination.last_page"
            @click="fetchArticles(pagination.current_page + 1)"
            class="page-nav-btn"
          >
            <span class="btn-label-desktop">Berikutnya</span>
            <span class="material-symbols-outlined">chevron_right</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Modal Konfirmasi Hapus Artikel -->
    <div v-if="showDeleteModal" class="modal-backdrop" @click.self="closeDeleteModal">
      <div class="modal-dialog" role="dialog" aria-modal="true">
        <div class="modal-icon-badge error-badge">
          <span class="material-symbols-outlined">delete_forever</span>
        </div>
        <h3 class="modal-dialog-title">Hapus Artikel Edukasi?</h3>
        <p class="modal-dialog-desc">
          Artikel <strong>"{{ articleToDelete?.title }}"</strong> akan dihapus permanen dari sistem dan tidak dapat dipulihkan.
        </p>

        <div class="modal-actions">
          <button
            type="button"
            @click="closeDeleteModal"
            class="modal-btn-cancel"
            :disabled="isDeleting"
          >
            Batal
          </button>
          <button
            type="button"
            @click="handleDelete"
            class="modal-btn-danger"
            :disabled="isDeleting"
          >
            <span v-if="isDeleting" class="mini-spinner spinner-white"></span>
            <span v-else>Hapus Permanen</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Toast Feedback Notification -->
    <transition name="toast-fade">
      <div v-if="toast.show" :class="['toast-box', `toast-${toast.type}`]" role="alert">
        <span class="material-symbols-outlined toast-icon">{{ toast.icon }}</span>
        <div class="toast-content">
          <strong class="toast-title">{{ toast.title }}</strong>
          <p class="toast-message">{{ toast.message }}</p>
        </div>
        <button type="button" @click="toast.show = false" class="toast-close-btn" aria-label="Tutup notifikasi">
          <span class="material-symbols-outlined">close</span>
        </button>
      </div>
    </transition>
  </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import AdminLayout from '../../layouts/AdminLayout.vue'
import api from '../../services/api'
import { ARTICLE_CATEGORIES } from '../../constants/categories'

// Kategori Filter Options
const categories = [
  { label: 'Semua Kategori', value: 'Semua', color: '#006384' },
  ...ARTICLE_CATEGORIES.map(c => ({
    label: c.label,
    value: c.value,
    color: c.color,
  }))
]

// State data
const articles = ref([])
const selectedCategory = ref('Semua')
const statusFilter = ref('') // '' (Semua), 'published', 'draft'
const searchQuery = ref('')
const loading = ref(true)
const togglingId = ref(null)

// Stats Ringkasan Konten
const stats = ref({
  total: 0,
  published: 0,
  draft: 0,
  total_views: 0,
})

// Pagination Object
const pagination = ref({
  current_page: 1,
  last_page: 1,
  total: 0,
  per_page: 10,
  from: 0,
  to: 0,
})

// Delete Modal State
const showDeleteModal = ref(false)
const articleToDelete = ref(null)
const isDeleting = ref(false)

// Toast Notification State
const toast = ref({
  show: false,
  title: '',
  message: '',
  type: 'success', // 'success', 'error', 'info'
  icon: 'check_circle',
})
let toastTimer = null

let searchTimeout = null

// Helper computed: apakah ada filter aktif selain default
const hasActiveFilter = computed(() => {
  return selectedCategory.value !== 'Semua' || statusFilter.value !== '' || searchQuery.value.trim() !== ''
})

// Menampilkan Toast
function showToast({ title, message, type = 'success', icon = 'check_circle' }) {
  if (toastTimer) clearTimeout(toastTimer)
  toast.value = { show: true, title, message, type, icon }
  toastTimer = setTimeout(() => {
    toast.value.show = false
  }, 3200)
}

// Format Angka Ribuan
function formatNumber(val) {
  if (val === null || val === undefined || isNaN(val)) return '0'
  return Number(val).toLocaleString('id-ID')
}

// Format Tanggal Indonesia
function formatDate(dateStr) {
  if (!dateStr) return '-'
  try {
    const d = new Date(dateStr)
    if (isNaN(d.getTime())) return '-'
    return d.toLocaleDateString('id-ID', {
      day: 'numeric',
      month: 'short',
      year: 'numeric',
    })
  } catch {
    return '-'
  }
}

// Warna Badge Kategori
function getCategoryBadgeClass(category) {
  switch (category) {
    case 'Terapi Wicara':
      return 'badge-cat-blue'
    case 'Sensori Integrasi':
      return 'badge-cat-green'
    case 'Terapi Okupasi':
      return 'badge-cat-teal'
    case 'Fisioterapi Pediatrik':
      return 'badge-cat-purple'
    case 'Tumbuh Kembang':
      return 'badge-cat-amber'
    case 'Parenting':
    case 'Parenting & Pola Asuh':
      return 'badge-cat-amber'
    default:
      return 'badge-cat-default'
  }
}

// Handler Filter
function selectCategory(cat) {
  selectedCategory.value = cat
  fetchArticles(1)
}

function setStatusFilter(status) {
  statusFilter.value = status
  fetchArticles(1)
}

function clearSearch() {
  searchQuery.value = ''
  fetchArticles(1)
}

function resetAllFilters() {
  selectedCategory.value = 'Semua'
  statusFilter.value = ''
  searchQuery.value = ''
  fetchArticles(1)
}

function debounceSearch() {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    fetchArticles(1)
  }, 350)
}

// Ambil data artikel dari API
async function fetchArticles(page = 1) {
  loading.value = true
  try {
    const params = {
      page,
      per_page: 10,
    }
    if (selectedCategory.value !== 'Semua') {
      params.category = selectedCategory.value
    }
    if (statusFilter.value) {
      params.status = statusFilter.value
    }
    if (searchQuery.value.trim()) {
      params.search = searchQuery.value.trim()
    }

    const res = await api.get('/admin/articles', { params })
    articles.value = (res.data.data || []).map(a => ({
      ...a,
      imgError: false,
    }))

    pagination.value = {
      current_page: res.data.current_page || 1,
      last_page: res.data.last_page || 1,
      total: res.data.total || 0,
      per_page: res.data.per_page || 10,
      from: res.data.from || 0,
      to: res.data.to || 0,
    }

    if (res.data.stats) {
      stats.value = res.data.stats
    }
  } catch (err) {
    console.error('Error fetching articles', err)
    showToast({
      title: 'Gagal Memuat Data',
      message: 'Tidak dapat mengambil daftar artikel dari server.',
      type: 'error',
      icon: 'error',
    })
  } finally {
    loading.value = false
  }
}

// Toggle status publish secara langsung
async function togglePublish(item) {
  if (togglingId.value === item.id) return
  togglingId.value = item.id

  const previousStatus = item.is_published
  const updatedStatus = !previousStatus

  try {
    await api.put(`/admin/articles/${item.id}`, {
      is_published: updatedStatus,
    })

    item.is_published = updatedStatus

    // Update counter lokal
    if (stats.value) {
      if (updatedStatus) {
        stats.value.published = (stats.value.published || 0) + 1
        stats.value.draft = Math.max(0, (stats.value.draft || 1) - 1)
      } else {
        stats.value.published = Math.max(0, (stats.value.published || 1) - 1)
        stats.value.draft = (stats.value.draft || 0) + 1
      }
    }

    showToast({
      title: updatedStatus ? 'Artikel Diterbitkan' : 'Disimpan Sebagai Draf',
      message: `Status artikel "${item.title}" berhasil diubah menjadi ${updatedStatus ? 'Terbit' : 'Draf'}.`,
      type: 'success',
      icon: updatedStatus ? 'check_circle' : 'drafts',
    })
  } catch (err) {
    console.error('Error toggling publish status', err)
    showToast({
      title: 'Gagal Memperbarui Status',
      message: 'Terjadi kendala saat mengubah status publikasi artikel.',
      type: 'error',
      icon: 'error',
    })
  } finally {
    togglingId.value = null
  }
}

// Buka Modal Konfirmasi Hapus
function confirmDelete(item) {
  articleToDelete.value = item
  showDeleteModal.value = true
}

// Tutup Modal Konfirmasi Hapus
function closeDeleteModal() {
  if (isDeleting.value) return
  showDeleteModal.value = false
  articleToDelete.value = null
}

// Eksekusi Hapus Artikel
async function handleDelete() {
  if (!articleToDelete.value) return
  isDeleting.value = true
  const target = articleToDelete.value

  try {
    await api.delete(`/admin/articles/${target.id}`)

    articles.value = articles.value.filter(a => a.id !== target.id)
    if (pagination.value.total > 0) pagination.value.total -= 1

    // Update stats counter
    if (stats.value) {
      stats.value.total = Math.max(0, (stats.value.total || 1) - 1)
      if (target.is_published) {
        stats.value.published = Math.max(0, (stats.value.published || 1) - 1)
      } else {
        stats.value.draft = Math.max(0, (stats.value.draft || 1) - 1)
      }
      stats.value.total_views = Math.max(0, (stats.value.total_views || 0) - (target.views_count || 0))
    }

    showToast({
      title: 'Artikel Dihapus',
      message: `Artikel "${target.title}" telah berhasil dihapus secara permanen.`,
      type: 'success',
      icon: 'delete',
    })

    closeDeleteModal()

    // Jika list halaman ini kosong dan masih ada halaman sebelumnya, ambil halaman sebelumnya
    if (articles.value.length === 0 && pagination.value.current_page > 1) {
      fetchArticles(pagination.value.current_page - 1)
    }
  } catch (err) {
    console.error('Error deleting article', err)
    showToast({
      title: 'Gagal Menghapus Artikel',
      message: 'Terjadi kendala pada server saat menghapus artikel.',
      type: 'error',
      icon: 'error',
    })
  } finally {
    isDeleting.value = false
  }
}

onMounted(() => {
  fetchArticles(1)
})
</script>

<style scoped>
/* =============================================
   PAGE TOP BAR & HEADERS
   ============================================= */
.page-top-bar {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 1.5rem;
  margin-bottom: 1.75rem;
}

.top-title-group {
  flex: 1;
  min-width: 0;
}

.meta-tag {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  background: rgba(0, 99, 132, 0.08);
  color: var(--primary, #006384);
  padding: 0.25rem 0.75rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 700;
  letter-spacing: 0.02em;
  margin-bottom: 0.5rem;
  border: 1px solid rgba(0, 99, 132, 0.15);
}

.tag-icon {
  font-size: 0.95rem;
}

.page-heading {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 1.75rem;
  font-weight: 800;
  color: var(--on-surface, #091d2e);
  line-height: 1.25;
  margin-bottom: 0.35rem;
  letter-spacing: -0.01em;
}

.page-subheading {
  font-size: 0.9375rem;
  color: var(--on-surface-variant, #40484d);
  max-width: 680px;
  line-height: 1.5;
}

.top-actions {
  flex-shrink: 0;
}

.btn-create {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  background: var(--primary, #006384);
  color: #ffffff;
  padding: 0.75rem 1.4rem;
  border-radius: 9999px;
  font-weight: 700;
  font-size: 0.9375rem;
  text-decoration: none;
  box-shadow: 0 4px 14px rgba(0, 99, 132, 0.25);
  transition: all 0.2s ease;
  white-space: nowrap;
}

.btn-create:hover {
  background: var(--primary-container, #2e7c9e);
  transform: translateY(-2px);
  box-shadow: 0 6px 18px rgba(0, 99, 132, 0.3);
}

/* =============================================
   STAT METRIC CARDS (4 CARDS)
   ============================================= */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1.25rem;
  margin-bottom: 1.75rem;
}

.stat-card {
  background: #ffffff;
  padding: 1.35rem;
  border-radius: 20px;
  border: 1px solid rgba(191, 200, 206, 0.4);
  box-shadow: 0 4px 14px rgba(9, 29, 46, 0.03);
  display: flex;
  flex-direction: column;
  transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
  user-select: none;
}

.stat-card-hover {
  cursor: pointer;
}

.stat-card-hover:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 24px rgba(9, 29, 46, 0.07);
  border-color: rgba(0, 99, 132, 0.3);
}

.stat-top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 0.5rem;
  margin-bottom: 0.85rem;
}

.stat-icon-wrap {
  width: 42px;
  height: 42px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.teal-bg { background: #c1e8ff; color: #006384; }
.green-bg { background: #d7f5a8; color: #354e00; }
.amber-bg { background: #ffe2c7; color: #884e03; }
.cyan-bg { background: #d3f3f7; color: #006874; }

.stat-badge {
  padding: 0.25rem 0.65rem;
  border-radius: 9999px;
  font-size: 0.6875rem;
  font-weight: 700;
  white-space: nowrap;
}

.blue-badge { background: #e0f2fe; color: #0369a1; }
.green-badge { background: #d7f5a8; color: #2e4400; }
.orange-badge { background: #ffdcbf; color: #7a3e00; }
.cyan-badge { background: #cffafe; color: #0e7490; }

.stat-value {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 2rem;
  font-weight: 800;
  color: var(--on-surface, #091d2e);
  line-height: 1.1;
  margin-bottom: 0.25rem;
  letter-spacing: -0.02em;
}

.stat-label {
  font-size: 0.875rem;
  font-weight: 700;
  color: var(--on-surface, #091d2e);
  margin-bottom: 0.2rem;
}

.stat-subtext {
  font-size: 0.75rem;
  color: var(--on-surface-variant, #40484d);
}

/* =============================================
   ENHANCED TOOLBAR & SEARCH
   ============================================= */
.toolbar-box {
  background: #ffffff;
  border-radius: 20px;
  border: 1px solid rgba(191, 200, 206, 0.4);
  padding: 1.25rem 1.5rem;
  margin-bottom: 1.5rem;
  box-shadow: 0 4px 14px rgba(9, 29, 46, 0.03);
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.toolbar-primary-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1.25rem;
  flex-wrap: wrap;
}

/* Status Tab Pills */
.status-tab-group {
  display: flex;
  align-items: center;
  background: var(--surface-bright, #f7f9ff);
  padding: 0.3rem;
  border-radius: 9999px;
  border: 1px solid rgba(191, 200, 206, 0.5);
  gap: 0.25rem;
}

.status-tab-btn {
  display: inline-flex;
  align-items: center;
  gap: 0.45rem;
  padding: 0.4rem 0.95rem;
  border-radius: 9999px;
  border: none;
  background: transparent;
  font-size: 0.8125rem;
  font-weight: 700;
  color: var(--on-surface-variant, #40484d);
  cursor: pointer;
  transition: all 0.2s ease;
  white-space: nowrap;
}

.status-tab-btn:hover {
  color: var(--primary, #006384);
}

.status-tab-active {
  background: #ffffff !important;
  color: var(--primary, #006384) !important;
  box-shadow: 0 2px 8px rgba(9, 29, 46, 0.08);
}

.status-dot {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  display: inline-block;
}

.dot-published { background: #4b6716; }
.dot-draft { background: #e67700; }

.tab-count {
  background: rgba(0, 99, 132, 0.08);
  color: var(--primary, #006384);
  font-size: 0.6875rem;
  font-weight: 800;
  padding: 0.15rem 0.45rem;
  border-radius: 9999px;
}

.status-tab-active .tab-count {
  background: var(--primary, #006384);
  color: #ffffff;
}

/* Search Box */
.search-box {
  position: relative;
  flex: 1;
  max-width: 420px;
  min-width: 260px;
}

.search-icon {
  position: absolute;
  left: 0.95rem;
  top: 50%;
  transform: translateY(-50%);
  color: var(--outline, #70787e);
  font-size: 1.2rem;
  pointer-events: none;
}

.search-input {
  width: 100%;
  padding: 0.6rem 2.4rem 0.6rem 2.6rem;
  border-radius: 9999px;
  border: 1px solid rgba(191, 200, 206, 0.6);
  background: var(--surface-bright, #f7f9ff);
  font-size: 0.875rem;
  color: var(--on-surface, #091d2e);
  transition: all 0.2s;
  box-sizing: border-box;
}

.search-input:focus {
  outline: none;
  border-color: var(--primary, #006384);
  background: #ffffff;
  box-shadow: 0 0 0 3px rgba(0, 99, 132, 0.1);
}

.search-clear-btn {
  position: absolute;
  right: 0.65rem;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  cursor: pointer;
  color: var(--outline, #70787e);
  padding: 0.25rem;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.search-clear-btn:hover {
  color: var(--on-surface, #091d2e);
}

/* Secondary Toolbar Row: Categories */
.toolbar-secondary-row {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  border-top: 1px solid rgba(191, 200, 206, 0.3);
  padding-top: 0.85rem;
  width: 100%;
}

.category-header-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 0.75rem;
  width: 100%;
}

.category-title-label {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  font-size: 0.8125rem;
  font-weight: 700;
  color: var(--on-surface-variant, #40484d);
}

.category-chips-wrap {
  display: flex;
  align-items: center;
  gap: 0.45rem;
  flex-wrap: wrap;
  width: 100%;
}

.chip-btn {
  background: var(--surface-bright, #f7f9ff);
  border: 1px solid rgba(191, 200, 206, 0.6);
  padding: 0.4rem 0.85rem;
  border-radius: 9999px;
  font-size: 0.7813rem;
  font-weight: 600;
  color: var(--on-surface-variant, #40484d);
  cursor: pointer;
  transition: all 0.2s ease;
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  user-select: none;
}

.chip-dot {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  display: inline-block;
  flex-shrink: 0;
  transition: background-color 0.2s ease;
}

.chip-btn:hover {
  background: var(--surface-container-low, #edf4ff);
  color: var(--primary, #006384);
  border-color: rgba(0, 99, 132, 0.35);
}

.chip-btn-active {
  background: var(--primary, #006384) !important;
  color: #ffffff !important;
  border-color: var(--primary, #006384) !important;
  font-weight: 700;
  box-shadow: 0 2px 8px rgba(0, 99, 132, 0.25);
}

.btn-reset-filter {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  background: transparent;
  border: 1px dashed rgba(186, 26, 26, 0.4);
  color: var(--error, #ba1a1a);
  padding: 0.3rem 0.75rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.2s;
  white-space: nowrap;
}

.btn-reset-filter:hover {
  background: #ffdad6;
}

/* =============================================
   MAIN CARD & DESKTOP TABLE VIEW
   ============================================= */
.table-card {
  background: #ffffff;
  border-radius: 20px;
  border: 1px solid rgba(191, 200, 206, 0.4);
  box-shadow: 0 4px 14px rgba(9, 29, 46, 0.03);
  overflow: hidden;
}

.table-desktop-wrap {
  display: block;
  overflow-x: auto;
  width: 100%;
}

.article-table {
  width: 100%;
  border-collapse: collapse;
  text-align: left;
}

.article-table th {
  padding: 0.95rem 1.25rem;
  background: var(--surface-container-low, #edf4ff);
  font-size: 0.75rem;
  font-weight: 800;
  color: var(--on-surface-variant, #40484d);
  text-transform: uppercase;
  letter-spacing: 0.03em;
  border-bottom: 1px solid rgba(191, 200, 206, 0.4);
  white-space: nowrap;
}

.article-table td {
  padding: 1.15rem 1.25rem;
  border-bottom: 1px solid rgba(191, 200, 206, 0.25);
  vertical-align: middle;
}

.article-table tr:last-child td {
  border-bottom: none;
}

.article-table tr:hover td {
  background: rgba(247, 249, 255, 0.6);
}

/* Kolom Artikel & Topik */
.th-art { width: 44%; min-width: 320px; }
.th-cat { width: 15%; min-width: 140px; }
.th-author { width: 14%; min-width: 130px; }
.th-views { width: 10%; min-width: 90px; }
.th-status { width: 9%; min-width: 90px; }
.th-actions { width: 8%; min-width: 110px; text-align: center; }

.art-cell-flex {
  display: flex;
  align-items: center;
  gap: 1rem;
  min-width: 0;
}

.art-thumb-wrapper {
  width: 60px;
  height: 60px;
  border-radius: 12px;
  overflow: hidden;
  flex-shrink: 0;
  background: var(--surface-container-low, #edf4ff);
  border: 1px solid rgba(191, 200, 206, 0.4);
}

.art-cell-thumb {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.art-thumb-fallback {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #c1e8ff 0%, #e3efff 100%);
  color: var(--primary, #006384);
}

.art-text-meta {
  flex: 1;
  min-width: 0;
}

.art-title-link {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 0.9375rem;
  font-weight: 700;
  color: var(--on-surface, #091d2e);
  text-decoration: none;
  line-height: 1.35;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  margin-bottom: 0.25rem;
  transition: color 0.15s;
}

.art-title-link:hover {
  color: var(--primary, #006384);
}

.art-cell-excerpt {
  font-size: 0.7813rem;
  color: var(--on-surface-variant, #40484d);
  line-height: 1.4;
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
  margin-bottom: 0.35rem;
}

.art-meta-pills {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  font-size: 0.7188rem;
  color: var(--outline, #70787e);
}

.art-date-text, .art-time-text {
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
}

.mini-icon {
  font-size: 0.85rem;
}

/* Kolom Kategori Badges */
.category-badge {
  display: inline-block;
  padding: 0.25rem 0.7rem;
  border-radius: 8px;
  font-size: 0.75rem;
  font-weight: 700;
  white-space: nowrap;
}

.badge-cat-blue { background: #e0f2fe; color: #0284c7; }
.badge-cat-green { background: #dcfce7; color: #15803d; }
.badge-cat-teal { background: #ccfbf1; color: #0f766e; }
.badge-cat-purple { background: #f3e8ff; color: #7e22ce; }
.badge-cat-amber { background: #fef3c7; color: #b45309; }
.badge-cat-default { background: #f1f5f9; color: #475569; }

/* Kolom Penulis */
.author-cell {
  display: flex;
  align-items: center;
  gap: 0.35rem;
  font-size: 0.8125rem;
  color: var(--on-surface, #091d2e);
  font-weight: 600;
}

.author-icon {
  font-size: 1rem;
  color: var(--outline, #70787e);
}

/* Kolom Pembaca */
.views-meta {
  display: inline-flex;
  align-items: center;
  gap: 0.3rem;
  font-size: 0.8125rem;
  color: var(--outline, #70787e);
}

.views-icon {
  font-size: 1rem;
  color: var(--primary, #006384);
}

.views-num {
  font-weight: 700;
  color: var(--on-surface, #091d2e);
}

/* Status Pill Toggle Button */
.status-pill-btn {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  padding: 0.3rem 0.8rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 700;
  cursor: pointer;
  border: none;
  transition: all 0.2s ease;
  white-space: nowrap;
}

.status-pill-btn:disabled {
  opacity: 0.65;
  cursor: wait;
}

.published-pill {
  background: #d7f5a8;
  color: #2e4400;
}

.published-pill:hover:not(:disabled) {
  background: #cbf094;
}

.draft-pill {
  background: #f1f3f5;
  color: #5c646a;
}

.draft-pill:hover:not(:disabled) {
  background: #e9ecef;
}

.dot-indicator {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: currentColor;
}

/* Actions Cell */
.actions-flex {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.4rem;
}

.action-btn-icon {
  background: #ffffff;
  border: 1px solid rgba(191, 200, 206, 0.6);
  color: var(--on-surface-variant, #40484d);
  padding: 0.45rem;
  border-radius: 10px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  text-decoration: none;
  transition: all 0.15s ease;
}

.action-btn-icon span {
  font-size: 1.1rem;
}

.view-action:hover {
  background: var(--surface-container-low, #edf4ff);
  color: var(--primary, #006384);
  border-color: var(--primary, #006384);
}

.edit-action:hover {
  background: #e0f2fe;
  color: #0284c7;
  border-color: #0284c7;
}

.delete-action:hover {
  background: #ffdad6;
  color: #ba1a1a;
  border-color: #ffdad6;
}

/* =============================================
   MOBILE CARD LIST VIEW (< 768px)
   ============================================= */
.mobile-card-list {
  display: none;
  flex-direction: column;
  gap: 1rem;
  padding: 1rem;
  width: 100%;
  box-sizing: border-box;
}

.mobile-art-card {
  background: #ffffff;
  border-radius: 16px;
  border: 1px solid rgba(191, 200, 206, 0.45);
  box-shadow: 0 2px 10px rgba(9, 29, 46, 0.03);
  padding: 1.15rem;
  display: flex;
  flex-direction: column;
  gap: 0.85rem;
  width: 100%;
  box-sizing: border-box;
  min-width: 0;
}

.m-card-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 0.5rem;
  min-width: 0;
}

.m-card-body {
  display: flex;
  align-items: flex-start;
  gap: 0.85rem;
  min-width: 0;
}

.m-thumb-wrap {
  width: 64px;
  height: 64px;
  border-radius: 12px;
  overflow: hidden;
  flex-shrink: 0;
  background: var(--surface-container-low, #edf4ff);
  border: 1px solid rgba(191, 200, 206, 0.4);
}

.m-thumb-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.m-fallback {
  font-size: 1.25rem;
}

.m-info-wrap {
  flex: 1;
  min-width: 0;
  word-break: break-word;
}

.m-art-title {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 0.9375rem;
  font-weight: 700;
  color: var(--on-surface, #091d2e);
  text-decoration: none;
  line-height: 1.35;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  margin-bottom: 0.25rem;
}

.m-art-excerpt {
  font-size: 0.75rem;
  color: var(--on-surface-variant, #40484d);
  line-height: 1.4;
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
  margin-bottom: 0.35rem;
}

.m-meta-row {
  display: flex;
  flex-wrap: wrap;
  gap: 0.65rem;
  font-size: 0.7188rem;
  color: var(--outline, #70787e);
}

.m-meta-item {
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
}

.m-card-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 0.75rem;
  padding-top: 0.75rem;
  border-top: 1px solid rgba(191, 200, 206, 0.3);
  flex-wrap: wrap;
  min-width: 0;
}

.m-date-text {
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
  font-size: 0.7188rem;
  color: var(--outline, #70787e);
}

.m-actions-wrap {
  display: flex;
  align-items: center;
  gap: 0.4rem;
}

.m-btn-action {
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
  padding: 0.4rem 0.65rem;
  border-radius: 8px;
  font-size: 0.75rem;
  font-weight: 700;
  text-decoration: none;
  border: 1px solid rgba(191, 200, 206, 0.6);
  background: #ffffff;
  color: var(--on-surface-variant, #40484d);
  cursor: pointer;
  transition: all 0.15s;
}

.m-btn-action span.material-symbols-outlined {
  font-size: 0.95rem;
}

.m-btn-view:hover {
  background: var(--surface-container-low, #edf4ff);
  color: var(--primary, #006384);
}

.m-btn-edit:hover {
  background: #e0f2fe;
  color: #0284c7;
}

.m-btn-delete:hover {
  background: #ffdad6;
  color: #ba1a1a;
  border-color: #ffdad6;
}

/* =============================================
   PAGINATION BAR
   ============================================= */
.pagination-bar {
  padding: 1.15rem 1.5rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-top: 1px solid rgba(191, 200, 206, 0.3);
  font-size: 0.8125rem;
  color: var(--on-surface-variant, #40484d);
  flex-wrap: wrap;
  gap: 1rem;
}

.pagination-info strong {
  color: var(--on-surface, #091d2e);
}

.pagination-nav {
  display: flex;
  align-items: center;
  gap: 0.65rem;
}

.page-nav-btn {
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
  padding: 0.4rem 0.85rem;
  border-radius: 9999px;
  border: 1px solid rgba(191, 200, 206, 0.6);
  background: #ffffff;
  cursor: pointer;
  font-weight: 700;
  font-size: 0.8125rem;
  color: var(--on-surface, #091d2e);
  transition: all 0.2s ease;
}

.page-nav-btn:hover:not(:disabled) {
  background: var(--surface-container-low, #edf4ff);
  border-color: var(--primary, #006384);
  color: var(--primary, #006384);
}

.page-nav-btn:disabled {
  opacity: 0.45;
  cursor: not-allowed;
}

.page-indicator {
  font-size: 0.8125rem;
  padding: 0 0.35rem;
}

/* =============================================
   STATES: LOADING & EMPTY
   ============================================= */
.state-container {
  padding: 4rem 1.5rem;
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.85rem;
  color: var(--on-surface-variant, #40484d);
}

.state-text {
  font-size: 0.875rem;
  font-weight: 600;
}

.empty-state {
  padding: 4rem 1.5rem;
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
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
  margin-bottom: 1rem;
}

.empty-icon-wrap span {
  font-size: 2.25rem;
}

.empty-title {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 1.25rem;
  font-weight: 700;
  color: var(--on-surface, #091d2e);
  margin-bottom: 0.35rem;
}

.empty-desc {
  font-size: 0.875rem;
  color: var(--on-surface-variant, #40484d);
  max-width: 460px;
  line-height: 1.5;
  margin-bottom: 1.5rem;
}

.empty-actions {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  flex-wrap: wrap;
  justify-content: center;
}

.btn-primary-state {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  background: var(--primary, #006384);
  color: #ffffff;
  padding: 0.65rem 1.35rem;
  border-radius: 9999px;
  font-weight: 700;
  font-size: 0.875rem;
  text-decoration: none;
  transition: all 0.2s;
}

.btn-primary-state:hover {
  background: var(--primary-container, #2e7c9e);
  transform: translateY(-2px);
}

.btn-secondary-state {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  background: #ffffff;
  color: var(--on-surface, #091d2e);
  border: 1px solid rgba(191, 200, 206, 0.6);
  padding: 0.65rem 1.25rem;
  border-radius: 9999px;
  font-weight: 700;
  font-size: 0.875rem;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-secondary-state:hover {
  background: var(--surface-container-low, #edf4ff);
  color: var(--primary, #006384);
}

/* =============================================
   MODAL KONFIRMASI HAPUS
   ============================================= */
.modal-backdrop {
  position: fixed;
  inset: 0;
  background: rgba(9, 29, 46, 0.55);
  backdrop-filter: blur(4px);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1.5rem;
  z-index: 999;
}

.modal-dialog {
  background: #ffffff;
  width: 100%;
  max-width: 440px;
  border-radius: 24px;
  padding: 2rem;
  text-align: center;
  box-shadow: 0 16px 40px rgba(9, 29, 46, 0.2);
  display: flex;
  flex-direction: column;
  align-items: center;
  animation: modalPopIn 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes modalPopIn {
  from {
    opacity: 0;
    transform: scale(0.92) translateY(10px);
  }
  to {
    opacity: 1;
    transform: scale(1) translateY(0);
  }
}

.modal-icon-badge {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 1.25rem;
}

.error-badge {
  background: #ffdad6;
  color: #ba1a1a;
}

.error-badge span {
  font-size: 2rem;
}

.modal-dialog-title {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 1.35rem;
  font-weight: 800;
  color: var(--on-surface, #091d2e);
  margin-bottom: 0.5rem;
}

.modal-dialog-desc {
  font-size: 0.875rem;
  color: var(--on-surface-variant, #40484d);
  line-height: 1.5;
  margin-bottom: 1.75rem;
}

.modal-dialog-desc strong {
  color: var(--on-surface, #091d2e);
  word-break: break-word;
}

.modal-actions {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.75rem;
  width: 100%;
}

.modal-btn-cancel {
  flex: 1;
  padding: 0.7rem 1.25rem;
  border-radius: 9999px;
  border: 1px solid rgba(191, 200, 206, 0.6);
  background: #ffffff;
  color: var(--on-surface, #091d2e);
  font-weight: 700;
  font-size: 0.875rem;
  cursor: pointer;
  transition: all 0.2s;
}

.modal-btn-cancel:hover:not(:disabled) {
  background: var(--surface-bright, #f7f9ff);
}

.modal-btn-danger {
  flex: 1;
  padding: 0.7rem 1.25rem;
  border-radius: 9999px;
  border: none;
  background: #ba1a1a;
  color: #ffffff;
  font-weight: 700;
  font-size: 0.875rem;
  cursor: pointer;
  box-shadow: 0 4px 12px rgba(186, 26, 26, 0.25);
  display: inline-flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s;
}

.modal-btn-danger:hover:not(:disabled) {
  background: #93000a;
  transform: translateY(-1px);
}

.modal-btn-danger:disabled,
.modal-btn-cancel:disabled {
  opacity: 0.55;
  cursor: wait;
}

/* =============================================
   TOAST FEEDBACK
   ============================================= */
.toast-box {
  position: fixed;
  bottom: 2rem;
  right: 2rem;
  max-width: 380px;
  background: #ffffff;
  border-radius: 16px;
  padding: 1rem 1.25rem;
  box-shadow: 0 10px 30px rgba(9, 29, 46, 0.15);
  display: flex;
  align-items: flex-start;
  gap: 0.85rem;
  z-index: 1000;
  border-left: 5px solid;
}

.toast-success {
  border-left-color: #2e4400;
}

.toast-success .toast-icon {
  color: #4b6716;
}

.toast-error {
  border-left-color: #ba1a1a;
}

.toast-error .toast-icon {
  color: #ba1a1a;
}

.toast-content {
  flex: 1;
  min-width: 0;
}

.toast-title {
  display: block;
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 0.875rem;
  font-weight: 700;
  color: var(--on-surface, #091d2e);
  margin-bottom: 0.15rem;
}

.toast-message {
  font-size: 0.8125rem;
  color: var(--on-surface-variant, #40484d);
  line-height: 1.4;
  margin: 0;
  word-break: break-word;
}

.toast-close-btn {
  background: none;
  border: none;
  color: var(--outline, #70787e);
  cursor: pointer;
  padding: 0;
}

.toast-fade-enter-active,
.toast-fade-leave-active {
  transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.toast-fade-enter-from,
.toast-fade-leave-to {
  opacity: 0;
  transform: translateY(12px) scale(0.95);
}

/* Spinners */
.mini-spinner {
  width: 12px;
  height: 12px;
  border: 2px solid rgba(0, 99, 132, 0.2);
  border-top-color: currentColor;
  border-radius: 50%;
  animation: spin 0.6s linear infinite;
  display: inline-block;
}

.spinner-white {
  width: 16px;
  height: 16px;
  border-color: rgba(255, 255, 255, 0.3);
  border-top-color: #ffffff;
}

.spinner-small {
  width: 28px;
  height: 28px;
  border: 3px solid rgba(0, 99, 132, 0.15);
  border-top-color: var(--primary, #006384);
  border-radius: 50%;
  animation: spin 0.7s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

/* =============================================
   RESPONSIVE BREAKPOINTS
   ============================================= */
/* Tablet & Small Desktop (<= 1024px) */
@media (max-width: 1024px) {
  .stats-grid {
    grid-template-columns: repeat(2, 1fr);
  }

  .th-art { width: 38%; }
}

/* Mobile & Tablet Portrait (< 768px) */
@media (max-width: 767px) {
  .page-top-bar {
    flex-direction: column;
    align-items: stretch;
    gap: 1.25rem;
  }

  .btn-create {
    width: 100%;
    justify-content: center;
  }

  .stats-grid {
    grid-template-columns: 1fr;
    gap: 1rem;
  }

  .toolbar-box {
    padding: 1rem;
  }

  .toolbar-primary-row {
    flex-direction: column;
    align-items: stretch;
    gap: 0.85rem;
  }

  .status-tab-group {
    width: 100%;
    justify-content: space-between;
  }

  .status-tab-btn {
    flex: 1;
    justify-content: center;
    padding: 0.4rem 0.5rem;
    font-size: 0.75rem;
  }

  .search-box {
    max-width: 100%;
    min-width: 0;
    width: 100%;
  }

  .toolbar-secondary-row {
    flex-direction: column;
    align-items: stretch;
    gap: 0.65rem;
  }

  .category-header-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
  }

  .category-chips-wrap {
    display: flex;
    flex-wrap: wrap;
    gap: 0.4rem;
    width: 100%;
    overflow-x: visible;
  }

  .chip-btn {
    padding: 0.35rem 0.75rem;
    font-size: 0.75rem;
  }

  .btn-reset-filter {
    padding: 0.25rem 0.65rem;
    font-size: 0.6875rem;
  }

  /* Sembunyikan desktop table, tampilkan mobile card list */
  .table-desktop-wrap {
    display: none;
  }

  .mobile-card-list {
    display: flex;
  }

  .pagination-bar {
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 1rem;
    gap: 0.75rem;
  }

  .btn-label-desktop {
    display: none;
  }

  .toast-box {
    left: 1rem;
    right: 1rem;
    bottom: 1rem;
    max-width: none;
  }
}

/* Small Smartphone (<= 480px) */
@media (max-width: 480px) {
  .page-heading {
    font-size: 1.45rem;
  }

  .stat-value {
    font-size: 1.75rem;
  }

  .category-chips-wrap {
    gap: 0.35rem;
  }

  .chip-btn {
    padding: 0.32rem 0.65rem;
    font-size: 0.72rem;
  }

  .m-card-body {
    flex-direction: column;
    align-items: stretch;
  }

  .m-thumb-wrap {
    width: 100%;
    height: 140px;
  }

  .m-card-footer {
    flex-direction: column;
    align-items: stretch;
    gap: 0.65rem;
  }

  .m-actions-wrap {
    width: 100%;
    justify-content: space-between;
  }

  .m-btn-action {
    flex: 1;
    justify-content: center;
  }
}
</style>
