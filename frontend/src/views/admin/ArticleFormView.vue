<template>
  <AdminLayout :title="isEdit ? 'Edit Artikel' : 'Tulis Artikel Baru'">
    <!-- Header -->
    <div class="page-top-bar">
      <div>
        <router-link to="/admin/artikel" class="back-link">
          <span class="material-symbols-outlined">arrow_back</span>
          <span>Kembali ke Daftar Artikel</span>
        </router-link>
        <h1 class="page-heading">
          {{ isEdit ? 'Perbarui Artikel Edukasi' : 'Tulis Artikel Edukasi Baru' }}
        </h1>
        <p class="page-subheading">
          Pastikan informasi yang ditulis akurat, berbasis panduan klinis tumbuh kembang, dan mudah dipahami orang tua.
        </p>
      </div>

      <div class="top-actions">
        <button
          type="button"
          @click="submitForm(false)"
          class="btn-secondary"
          :disabled="isSubmitting"
        >
          <span>Simpan Draf</span>
        </button>
        <button
          type="button"
          @click="submitForm(true)"
          class="btn-primary"
          :disabled="isSubmitting"
        >
          <span v-if="isSubmitting" class="spinner-small"></span>
          <span v-else>{{ isEdit ? 'Simpan & Publikasikan' : 'Terbitkan Sekarang' }}</span>
        </button>
      </div>
    </div>

    <!-- Form Body -->
    <form @submit.prevent="submitForm(form.is_published)" class="form-grid">
      <!-- Main Content Column -->
      <div class="main-column">
        <div class="card-box">
          <div class="form-group">
            <label for="title">Judul Artikel <span class="req">*</span></label>
            <input
              id="title"
              v-model="form.title"
              type="text"
              required
              placeholder="Contoh: Mengenal Tanda Speech Delay pada Balita Usia 2 Tahun"
              class="form-input text-lg"
            />
          </div>

          <div class="form-group">
            <label for="excerpt">Ringkasan / Excerpt Singkat</label>
            <textarea
              id="excerpt"
              v-model="form.excerpt"
              rows="3"
              placeholder="Ringkasan 1-2 kalimat untuk pratinjau kartu artikel..."
              class="form-textarea"
            ></textarea>
          </div>

          <div class="form-group">
            <label for="content">Isi Lengkap Artikel (Mendukung HTML) <span class="req">*</span></label>
            <div class="editor-toolbar">
              <button type="button" @click="insertTag('h3')">H3</button>
              <button type="button" @click="insertTag('strong')">Tebal</button>
              <button type="button" @click="insertTag('em')">Miring</button>
              <button type="button" @click="insertTag('p')">Paragraf</button>
              <button type="button" @click="insertTag('li')">Poin List</button>
            </div>
            <textarea
              id="content"
              ref="contentArea"
              v-model="form.content"
              rows="15"
              required
              placeholder="Tuliskan isi artikel lengkap di sini..."
              class="form-textarea font-mono"
            ></textarea>
          </div>
        </div>
      </div>

      <!-- Sidebar Metadata Column -->
      <div class="sidebar-column">
        <!-- Publish Status Card -->
        <div class="card-box">
          <h3 class="card-title">Status Publikasi</h3>
          <div class="status-toggle-wrap">
            <label class="toggle-label">
              <input type="checkbox" v-model="form.is_published" />
              <span class="toggle-slider"></span>
              <span class="toggle-text">
                {{ form.is_published ? 'Publikasikan Terbuka' : 'Simpan sebagai Draf' }}
              </span>
            </label>
          </div>
        </div>

        <!-- Meta Details Card -->
        <div class="card-box">
          <h3 class="card-title">Detail Meta & Kategori</h3>

          <div class="form-group">
            <label for="category">Kategori Terapi <span class="req">*</span></label>
            <select id="category" v-model="form.category" class="form-select" required>
              <option value="Terapi Wicara">Terapi Wicara</option>
              <option value="Sensori Integrasi">Sensori Integrasi</option>
              <option value="Terapi Okupasi">Terapi Okupasi</option>
              <option value="Fisioterapi Pediatrik">Fisioterapi Pediatrik</option>
              <option value="Tumbuh Kembang">Tumbuh Kembang Umum</option>
              <option value="Parenting">Parenting & Pola Asuh</option>
            </select>
          </div>

          <div class="form-group">
            <label for="author">Nama Penulis</label>
            <input
              id="author"
              v-model="form.author"
              type="text"
              placeholder="dr. Nurul Aini / Tim Ahli ATC"
              class="form-input"
            />
          </div>

          <div class="form-group">
            <label for="read_time">Estimasi Waktu Baca</label>
            <input
              id="read_time"
              v-model="form.read_time"
              type="text"
              placeholder="Contoh: 5 Menit Baca"
              class="form-input"
            />
          </div>

          <div class="form-group">
            <label for="image">URL Gambar Sampul</label>
            <input
              id="image"
              v-model="form.image"
              type="url"
              placeholder="https://images.unsplash.com/..."
              class="form-input"
            />
          </div>

          <div v-if="form.image" class="image-preview-wrap">
            <span class="preview-label">Pratinjau Sampul:</span>
            <img :src="form.image" alt="Preview" class="image-preview" />
          </div>
        </div>
      </div>
    </form>
  </AdminLayout>
</template>

<script setup>
import { ref, reactive, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import AdminLayout from '../../layouts/AdminLayout.vue'
import api from '../../services/api'

const route = useRoute()
const router = useRouter()

const isEdit = computed(() => !!route.params.id)
const isSubmitting = ref(false)
const contentArea = ref(null)

const form = reactive({
  title: '',
  category: 'Terapi Wicara',
  author: "Tim Ahli Amanah Tin's Center",
  read_time: '5 Menit Baca',
  image: 'https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?auto=format&fit=crop&q=80&w=800',
  excerpt: '',
  content: '',
  is_published: true,
})

function insertTag(tag) {
  const area = contentArea.value
  if (!area) return

  const start = area.selectionStart
  const end = area.selectionEnd
  const selectedText = form.content.substring(start, end)
  const replacement = `<${tag}>${selectedText || 'Teks'}</${tag}>`

  form.content =
    form.content.substring(0, start) +
    replacement +
    form.content.substring(end)
}

async function fetchArticleDetails() {
  if (!isEdit.value) return
  try {
    const res = await api.get(`/admin/articles/${route.params.id}`)
    const data = res.data
    form.title = data.title
    form.category = data.category
    form.author = data.author
    form.read_time = data.read_time
    form.image = data.image
    form.excerpt = data.excerpt || ''
    form.content = data.content
    form.is_published = !!data.is_published
  } catch (err) {
    alert('Gagal memuat data artikel.')
    router.push('/admin/artikel')
  }
}

async function submitForm(publishStatus) {
  if (!form.title || !form.content) {
    alert('Mohon isi Judul dan Konten artikel.')
    return
  }

  isSubmitting.value = true
  form.is_published = publishStatus

  try {
    if (isEdit.value) {
      await api.put(`/admin/articles/${route.params.id}`, form)
      alert('Artikel berhasil diperbarui!')
    } else {
      await api.post('/admin/articles', form)
      alert('Artikel baru berhasil dibuat!')
    }
    router.push('/admin/artikel')
  } catch (err) {
    alert(err.response?.data?.message || 'Gagal menyimpan artikel.')
  } finally {
    isSubmitting.value = false
  }
}

onMounted(() => {
  fetchArticleDetails()
})
</script>

<style scoped>
.page-top-bar {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 1.5rem;
  margin-bottom: 2rem;
}

.back-link {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  color: var(--primary, #006384);
  font-size: 0.8125rem;
  font-weight: 700;
  text-decoration: none;
  margin-bottom: 0.5rem;
}

.page-heading {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 1.75rem;
  font-weight: 700;
  color: var(--on-surface, #091d2e);
}

.page-subheading {
  font-size: 0.9375rem;
  color: var(--on-surface-variant, #40484d);
  max-width: 650px;
  margin-top: 0.25rem;
}

.top-actions {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.btn-secondary {
  padding: 0.65rem 1.25rem;
  border-radius: 9999px;
  border: 1px solid rgba(191, 200, 206, 0.6);
  background: #ffffff;
  color: var(--on-surface, #091d2e);
  font-weight: 700;
  cursor: pointer;
  font-size: 0.875rem;
  transition: all 0.2s;
}

.btn-secondary:hover {
  background: var(--surface-container-low, #edf4ff);
}

.btn-primary {
  padding: 0.65rem 1.5rem;
  border-radius: 9999px;
  border: none;
  background: var(--primary, #006384);
  color: #ffffff;
  font-weight: 700;
  cursor: pointer;
  font-size: 0.875rem;
  box-shadow: 0 4px 12px rgba(0, 99, 132, 0.25);
  transition: all 0.2s;
}

.btn-primary:hover:not(:disabled) {
  background: var(--primary-container, #2e7c9e);
}

.form-grid {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 1.75rem;
}

.card-box {
  background: #ffffff;
  padding: 1.75rem;
  border-radius: 20px;
  border: 1px solid rgba(191, 200, 206, 0.4);
  box-shadow: 0 4px 12px rgba(43, 61, 79, 0.04);
  margin-bottom: 1.5rem;
}

.card-title {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 1.125rem;
  font-weight: 700;
  color: var(--on-surface, #091d2e);
  margin-bottom: 1.25rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.4rem;
  margin-bottom: 1.25rem;
}

.form-group label {
  font-size: 0.875rem;
  font-weight: 700;
  color: var(--on-surface, #091d2e);
}

.req {
  color: var(--error, #ba1a1a);
}

.form-input, .form-textarea, .form-select {
  width: 100%;
  padding: 0.75rem 1rem;
  border-radius: 12px;
  border: 1px solid rgba(191, 200, 206, 0.6);
  background: var(--surface-bright, #f7f9ff);
  font-family: inherit;
  font-size: 0.9375rem;
  color: var(--on-surface, #091d2e);
  transition: border-color 0.2s;
}

.form-input:focus, .form-textarea:focus, .form-select:focus {
  outline: none;
  border-color: var(--primary, #006384);
  background: #ffffff;
}

.editor-toolbar {
  display: flex;
  gap: 0.5rem;
  margin-bottom: 0.5rem;
}

.editor-toolbar button {
  background: var(--surface-container-low, #edf4ff);
  border: 1px solid rgba(191, 200, 206, 0.5);
  border-radius: 6px;
  padding: 0.25rem 0.6rem;
  font-size: 0.75rem;
  font-weight: 700;
  cursor: pointer;
}

.font-mono {
  font-family: monospace;
  font-size: 0.875rem;
  line-height: 1.6;
}

.image-preview-wrap {
  margin-top: 1rem;
}

.preview-label {
  display: block;
  font-size: 0.75rem;
  font-weight: 700;
  color: var(--on-surface-variant, #40484d);
  margin-bottom: 0.35rem;
}

.image-preview {
  width: 100%;
  height: 160px;
  object-fit: cover;
  border-radius: 12px;
  border: 1px solid rgba(191, 200, 206, 0.4);
}

.status-toggle-wrap {
  display: flex;
  align-items: center;
}

.toggle-label {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  cursor: pointer;
  user-select: none;
}

.toggle-label input {
  width: 20px;
  height: 20px;
  accent-color: var(--primary, #006384);
}

.toggle-text {
  font-weight: 700;
  font-size: 0.875rem;
  color: var(--on-surface, #091d2e);
}

@media (max-width: 900px) {
  .form-grid {
    grid-template-columns: 1fr;
  }
}
</style>
