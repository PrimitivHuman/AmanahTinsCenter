<template>
  <AdminLayout title="Kelola Artikel & Tips">
    <!-- Header Row -->
    <div class="page-top-bar">
      <div>
        <div class="meta-tag">Pusat Edukasi Orang Tua</div>
        <h1 class="page-heading">Manajemen Artikel & Tips Edukasi</h1>
        <p class="page-subheading">
          Publikasikan panduan perkembangan anak, tips stimulasi di rumah, dan informasi klinis terpercaya untuk orang tua.
        </p>
      </div>
      <div class="top-actions">
        <router-link to="/admin/artikel/baru" class="btn-create">
          <span class="material-symbols-outlined">edit_note</span>
          <span>+ Tulis Artikel Baru</span>
        </router-link>
      </div>
    </div>

    <!-- Filters & Search Toolbar -->
    <div class="toolbar-box">
      <!-- Category Chips -->
      <div class="category-chips">
        <button
          v-for="cat in categories"
          :key="cat"
          :class="['chip-btn', { 'chip-btn-active': selectedCategory === cat }]"
          @click="selectCategory(cat)"
        >
          {{ cat }}
        </button>
      </div>

      <!-- Search Input -->
      <div class="search-box">
        <span class="material-symbols-outlined search-icon">search</span>
        <input
          v-model="searchQuery"
          @input="debounceSearch"
          type="text"
          placeholder="Cari judul, topik, atau penulis..."
          class="search-input"
        />
      </div>
    </div>

    <!-- Main Content Table -->
    <div class="table-card">
      <div v-if="loading" class="loading-state">
        <div class="spinner-small"></div>
        <span>Memuat daftar artikel...</span>
      </div>

      <div v-else-if="articles.length === 0" class="empty-state">
        <span class="material-symbols-outlined empty-icon">menu_book</span>
        <p>Tidak ada artikel yang sesuai kriteria pencarian.</p>
        <router-link to="/admin/artikel/baru" class="btn-text-link">+ Buat Artikel Pertama</router-link>
      </div>

      <div v-else class="table-responsive">
        <table class="article-table">
          <thead>
            <tr>
              <th>Artikel & Topik</th>
              <th>Kategori</th>
              <th>Penulis</th>
              <th>Pembaca</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in articles" :key="item.id">
              <td>
                <div class="art-cell-flex">
                  <img
                    :src="item.image || 'https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?w=150'"
                    alt=""
                    class="art-cell-thumb"
                  />
                  <div>
                    <router-link :to="`/admin/artikel/${item.id}/edit`" class="art-title-link">
                      {{ item.title }}
                    </router-link>
                    <div class="art-cell-excerpt">{{ item.excerpt || 'Tidak ada ringkasan teks...' }}</div>
                  </div>
                </div>
              </td>
              <td>
                <span class="category-badge">{{ item.category }}</span>
              </td>
              <td>
                <span class="author-name">{{ item.author || "Tim Ahli ATC" }}</span>
              </td>
              <td>
                <div class="views-meta">
                  <span class="material-symbols-outlined text-sm">visibility</span>
                  <span>{{ item.views_count || 0 }}</span>
                </div>
              </td>
              <td>
                <button
                  @click="togglePublish(item)"
                  :class="['status-pill-btn', item.is_published ? 'published-pill' : 'draft-pill']"
                  :title="item.is_published ? 'Klik untuk simpan sebagai draf' : 'Klik untuk terbitkan'"
                >
                  <span class="dot-indicator"></span>
                  <span>{{ item.is_published ? 'Terbit' : 'Draf' }}</span>
                </button>
              </td>
              <td>
                <div class="actions-flex">
                  <router-link
                    :to="`/artikel/${item.slug}`"
                    target="_blank"
                    class="action-btn-icon"
                    title="Lihat Halaman Publik"
                  >
                    <span class="material-symbols-outlined">visibility</span>
                  </router-link>
                  <router-link
                    :to="`/admin/artikel/${item.id}/edit`"
                    class="action-btn-icon"
                    title="Edit Artikel"
                  >
                    <span class="material-symbols-outlined">edit</span>
                  </router-link>
                  <button
                    @click="deleteArticle(item)"
                    class="action-btn-icon delete-btn"
                    title="Hapus Artikel"
                  >
                    <span class="material-symbols-outlined">delete</span>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="pagination-bar" v-if="pagination.total > pagination.per_page">
        <span class="pagination-info">
          Menampilkan {{ pagination.from }}-{{ pagination.to }} dari {{ pagination.total }} artikel
        </span>
        <div class="pagination-nav">
          <button
            :disabled="pagination.current_page === 1"
            @click="fetchArticles(pagination.current_page - 1)"
            class="page-btn"
          >
            Sebelumnya
          </button>
          <span class="page-num">Halaman {{ pagination.current_page }} dari {{ pagination.last_page }}</span>
          <button
            :disabled="pagination.current_page === pagination.last_page"
            @click="fetchArticles(pagination.current_page + 1)"
            class="page-btn"
          >
            Berikutnya
          </button>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import AdminLayout from '../../layouts/AdminLayout.vue'
import api from '../../services/api'

const categories = [
  'Semua',
  'Terapi Wicara',
  'Sensori Integrasi',
  'Terapi Okupasi',
  'Fisioterapi Pediatrik',
  'Tumbuh Kembang'
]

const articles = ref([])
const selectedCategory = ref('Semua')
const searchQuery = ref('')
const loading = ref(true)
const pagination = ref({
  current_page: 1,
  last_page: 1,
  total: 0,
  per_page: 10,
  from: 0,
  to: 0,
})

let searchTimeout = null

function selectCategory(cat) {
  selectedCategory.value = cat
  fetchArticles(1)
}

function debounceSearch() {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    fetchArticles(1)
  }, 400)
}

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
    if (searchQuery.value.trim()) {
      params.search = searchQuery.value.trim()
    }

    const res = await api.get('/admin/articles', { params })
    articles.value = res.data.data || []
    pagination.value = {
      current_page: res.data.current_page,
      last_page: res.data.last_page,
      total: res.data.total,
      per_page: res.data.per_page,
      from: res.data.from || 0,
      to: res.data.to || 0,
    }
  } catch (err) {
    console.error('Error fetching articles', err)
  } finally {
    loading.value = false
  }
}

async function togglePublish(item) {
  try {
    const updatedStatus = !item.is_published
    await api.put(`/admin/articles/${item.id}`, {
      ...item,
      is_published: updatedStatus,
    })
    item.is_published = updatedStatus
  } catch (err) {
    alert('Gagal memperbarui status publikasi artikel.')
  }
}

async function deleteArticle(item) {
  if (confirm(`Yakin ingin menghapus artikel "${item.title}"?`)) {
    try {
      await api.delete(`/admin/articles/${item.id}`)
      articles.value = articles.value.filter(a => a.id !== item.id)
      pagination.value.total -= 1
    } catch (err) {
      alert('Gagal menghapus artikel.')
    }
  }
}

onMounted(() => {
  fetchArticles(1)
})
</script>

<style scoped>
.page-top-bar {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 1.5rem;
  margin-bottom: 1.75rem;
}

.meta-tag {
  display: inline-block;
  background: rgba(0, 99, 132, 0.1);
  color: var(--primary, #006384);
  padding: 0.2rem 0.65rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 700;
  margin-bottom: 0.5rem;
}

.page-heading {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 1.75rem;
  font-weight: 700;
  color: var(--on-surface, #091d2e);
  margin-bottom: 0.35rem;
}

.page-subheading {
  font-size: 0.9375rem;
  color: var(--on-surface-variant, #40484d);
  max-width: 650px;
}

.btn-create {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  background: var(--primary, #006384);
  color: #ffffff;
  padding: 0.75rem 1.5rem;
  border-radius: 9999px;
  font-weight: 700;
  font-size: 0.9375rem;
  text-decoration: none;
  box-shadow: 0 4px 12px rgba(0, 99, 132, 0.25);
  transition: all 0.2s;
  white-space: nowrap;
}

.btn-create:hover {
  background: var(--primary-container, #2e7c9e);
  transform: translateY(-2px);
}

.toolbar-box {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
  margin-bottom: 1.5rem;
  flex-wrap: wrap;
}

.category-chips {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  flex-wrap: wrap;
}

.chip-btn {
  background: #ffffff;
  border: 1px solid rgba(191, 200, 206, 0.5);
  padding: 0.45rem 1rem;
  border-radius: 9999px;
  font-size: 0.8125rem;
  font-weight: 600;
  color: var(--on-surface-variant, #40484d);
  cursor: pointer;
  transition: all 0.2s;
}

.chip-btn:hover {
  background: var(--surface-container-low, #edf4ff);
  color: var(--primary, #006384);
}

.chip-btn-active {
  background: var(--primary, #006384) !important;
  color: #ffffff !important;
  border-color: var(--primary, #006384) !important;
}

.search-box {
  position: relative;
  min-width: 280px;
}

.search-icon {
  position: absolute;
  left: 0.875rem;
  top: 50%;
  transform: translateY(-50%);
  color: var(--outline, #70787e);
}

.search-input {
  width: 100%;
  padding: 0.55rem 1rem 0.55rem 2.5rem;
  border-radius: 9999px;
  border: 1px solid rgba(191, 200, 206, 0.5);
  background: #ffffff;
  font-size: 0.875rem;
  color: var(--on-surface, #091d2e);
  transition: border-color 0.2s;
}

.search-input:focus {
  outline: none;
  border-color: var(--primary, #006384);
}

.table-card {
  background: #ffffff;
  border-radius: 20px;
  border: 1px solid rgba(191, 200, 206, 0.4);
  box-shadow: 0 4px 12px rgba(43, 61, 79, 0.04);
  overflow: hidden;
}

.table-responsive {
  overflow-x: auto;
}

.article-table {
  width: 100%;
  border-collapse: collapse;
  text-align: left;
}

.article-table th {
  padding: 0.875rem 1.25rem;
  background: var(--surface-container-low, #edf4ff);
  font-size: 0.75rem;
  font-weight: 700;
  color: var(--on-surface-variant, #40484d);
  text-transform: uppercase;
  letter-spacing: 0.03em;
  border-bottom: 1px solid rgba(191, 200, 206, 0.4);
}

.article-table td {
  padding: 1.25rem;
  border-bottom: 1px solid rgba(191, 200, 206, 0.25);
  vertical-align: middle;
}

.art-cell-flex {
  display: flex;
  align-items: center;
  gap: 1rem;
  max-width: 420px;
}

.art-cell-thumb {
  width: 64px;
  height: 64px;
  border-radius: 12px;
  object-fit: cover;
  flex-shrink: 0;
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
}

.art-title-link:hover {
  color: var(--primary, #006384);
}

.art-cell-excerpt {
  font-size: 0.75rem;
  color: var(--on-surface-variant, #40484d);
  margin-top: 0.25rem;
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.category-badge {
  display: inline-block;
  padding: 0.25rem 0.65rem;
  border-radius: 6px;
  background: var(--surface-container, #e3efff);
  color: var(--primary, #006384);
  font-size: 0.75rem;
  font-weight: 700;
}

.author-name {
  font-size: 0.8125rem;
  color: var(--on-surface, #091d2e);
  font-weight: 600;
}

.views-meta {
  display: flex;
  align-items: center;
  gap: 0.25rem;
  font-size: 0.8125rem;
  color: var(--outline, #70787e);
}

.status-pill-btn {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  padding: 0.25rem 0.75rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 700;
  cursor: pointer;
  border: none;
  transition: opacity 0.2s;
}

.published-pill {
  background: rgba(204, 239, 142, 0.4);
  color: #354e00;
}

.draft-pill {
  background: #f0f0f0;
  color: #70787e;
}

.dot-indicator {
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: currentColor;
}

.actions-flex {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.action-btn-icon {
  background: none;
  border: 1px solid rgba(191, 200, 206, 0.4);
  color: var(--on-surface-variant, #40484d);
  padding: 0.4rem;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  text-decoration: none;
  transition: all 0.2s;
}

.action-btn-icon:hover {
  background: var(--surface-container-low, #edf4ff);
  color: var(--primary, #006384);
}

.delete-btn:hover {
  background: #ffdad6 !important;
  color: #ba1a1a !important;
  border-color: #ffdad6 !important;
}

.pagination-bar {
  padding: 1.25rem 1.5rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-top: 1px solid rgba(191, 200, 206, 0.25);
  font-size: 0.8125rem;
  color: var(--on-surface-variant, #40484d);
}

.pagination-nav {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.page-btn {
  padding: 0.35rem 0.875rem;
  border-radius: 8px;
  border: 1px solid rgba(191, 200, 206, 0.5);
  background: #ffffff;
  cursor: pointer;
  font-weight: 600;
  color: var(--on-surface, #091d2e);
}

.page-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.loading-state, .empty-state {
  padding: 3.5rem 1rem;
  text-align: center;
  color: var(--on-surface-variant, #40484d);
}

.empty-icon {
  font-size: 3rem;
  color: var(--outline, #70787e);
  margin-bottom: 0.5rem;
}

.btn-text-link {
  color: var(--primary, #006384);
  font-weight: 700;
  text-decoration: none;
  margin-top: 0.5rem;
  display: inline-block;
}
</style>
