<template>
  <AdminLayout title="Kelola Tim Kami">
    <!-- Header Row -->
    <div class="page-top-bar">
      <div class="page-top-info">
        <div class="meta-tag">Tenaga Medis &amp; Terapis</div>
        <h1 class="page-heading">Manajemen Tim Terapis Spesialis</h1>
        <p class="page-subheading">
          Kelola data dokter anak, terapis wicara, terapis okupasi, sensori integrasi, dan fisioterapis yang bertugas di klinik.
        </p>
      </div>
      <div class="top-actions">
        <button @click="openCreateModal" class="btn-create" type="button">
          <span class="material-symbols-outlined btn-icon-main">person_add</span>
          <span>+ Tambah Anggota Tim</span>
        </button>
      </div>
    </div>

    <!-- Filter Controls Toolbar (Count Note, Quick Search, Category Tabs) -->
    <div class="filter-controls-wrap">
      <div class="filter-toolbar-row">
        <!-- Quick Search Bar (Prominent on Mobile) -->
        <div class="search-input-box">
          <span class="material-symbols-outlined search-icon">search</span>
          <input
            v-model="searchQuery"
            type="text"
            class="search-input"
            placeholder="Cari nama terapis atau spesialisasi..."
            aria-label="Cari nama terapis atau keahlian"
          />
          <button
            v-if="searchQuery"
            @click="searchQuery = ''"
            class="btn-clear-search"
            title="Hapus pencarian"
            type="button"
          >
            <span class="material-symbols-outlined">close</span>
          </button>
        </div>

        <!-- Count Note -->
        <div class="team-count-note">
          <span class="material-symbols-outlined count-icon">badge</span>
          <span>Menampilkan <strong>{{ filteredTeam.length }}</strong> dari {{ team.length }} Tenaga Ahli</span>
        </div>
      </div>

      <!-- Category Filter Tabs (Swipeable on Mobile) -->
      <div class="category-tabs-container">
        <div class="category-tabs-nav" role="tablist">
          <button
            v-for="cat in categories"
            :key="cat.id"
            @click="selectedCategory = cat.id"
            class="cat-tab-btn"
            :class="{ 'is-active': selectedCategory === cat.id }"
            type="button"
            role="tab"
            :aria-selected="selectedCategory === cat.id"
          >
            <span class="material-symbols-outlined cat-tab-icon">{{ cat.icon }}</span>
            <span>{{ cat.label }}</span>
            <span class="cat-tab-badge">{{ getCategoryCount(cat.id) }}</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="loading-state">
      <div class="spinner-small"></div>
      <span>Memuat data tim terapis...</span>
    </div>

    <!-- Empty State -->
    <div v-else-if="filteredTeam.length === 0" class="empty-state-box">
      <div class="empty-icon-wrap">
        <span class="material-symbols-outlined">person_search</span>
      </div>
      <h3 class="empty-title">Tidak Ditemukan Anggota Tim</h3>
      <p class="empty-desc" v-if="searchQuery || selectedCategory !== 'all'">
        Tidak ada data terapis yang cocok dengan pencarian "<strong>{{ searchQuery }}</strong>".
      </p>
      <p class="empty-desc" v-else>
        Belum ada data anggota tim terapis di sistem klinik.
      </p>
      <button v-if="searchQuery || selectedCategory !== 'all'" @click="resetFilters" class="btn-reset-filter" type="button">
        <span class="material-symbols-outlined">restart_alt</span>
        <span>Reset Filter &amp; Tampilkan Semua</span>
      </button>
      <button v-else @click="openCreateModal" class="btn-primary mt-3" type="button">+ Tambah Terapis Pertama</button>
    </div>

    <!-- Team Cards Grid (Responsive 1-col on Mobile, 2-col on Tablet, 3-4 col on Desktop) -->
    <div v-else class="team-grid">
      <div
        v-for="member in filteredTeam"
        :key="member.id"
        class="member-card"
      >
        <!-- Photo with overlay badges -->
        <div class="member-photo-wrap">
          <img
            :src="member.image || 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=600'"
            :alt="member.name"
            class="member-photo"
            loading="lazy"
          />
          <div class="photo-overlay-gradient"></div>

          <!-- Specialty badge (Top-Left) -->
          <span class="badge-specialty" :class="`badge-${getMemberColor(member)}`">
            <span class="material-symbols-outlined badge-spec-icon">{{ getMemberIcon(member) }}</span>
            <span class="badge-spec-text">{{ member.role }}</span>
          </span>

          <!-- Status chip (Bottom-Right) -->
          <span
            class="badge-str"
            :class="{ 'badge-str-inactive': !member.is_active }"
            @click.stop="toggleStatus(member)"
            :title="member.is_active ? 'Klik untuk non-aktifkan' : 'Klik untuk aktifkan'"
            role="button"
            tabindex="0"
          >
            <span :class="member.is_active ? 'pulse-dot-green' : 'pulse-dot-gray'"></span>
            <span>{{ member.is_active ? 'Praktik Aktif' : 'Non-Aktif' }}</span>
          </span>
        </div>

        <!-- Member info body -->
        <div class="member-info-body">
          <h3 class="member-name">{{ member.name }}</h3>
          <p class="member-edu">{{ member.edu || member.specialization }}</p>

          <!-- Schedule Chip -->
          <div class="member-schedule-chip">
            <span class="material-symbols-outlined sched-icon">event_available</span>
            <span class="sched-text">{{ member.schedule || (member.experience_years ? member.experience_years + ' Klinis' : 'Jadwal Reguler') }}</span>
          </div>

          <!-- Bio (Brief Description) -->
          <p v-if="member.bio" class="member-bio">
            {{ member.bio }}
          </p>

          <!-- Focus & Certifications Tags -->
          <div class="member-focus">
            <span class="focus-label">Fokus &amp; Sertifikasi:</span>
            <div class="focus-tags">
              <span class="focus-tag" :class="`tag-${getMemberColor(member)}`">
                {{ member.role }}
              </span>
              <span
                v-for="(cert, idx) in (member.certifications || []).slice(0, 3)"
                :key="idx"
                class="focus-tag tag-cert"
              >
                {{ cert }}
              </span>
              <span v-if="(member.certifications || []).length > 3" class="focus-tag tag-more">
                +{{ member.certifications.length - 3 }} lainnya
              </span>
            </div>
          </div>
        </div>

        <!-- Card Action Buttons -->
        <div class="member-actions-row">
          <button
            type="button"
            @click="openEditModal(member)"
            class="btn-card-edit"
            title="Edit Profil Terapis"
          >
            <span class="material-symbols-outlined action-icon">edit_square</span>
            <span>Edit Profil</span>
          </button>

          <button
            type="button"
            @click="deleteMember(member)"
            class="btn-card-delete"
            title="Hapus Terapis"
          >
            <span class="material-symbols-outlined action-icon">delete</span>
            <span>Hapus</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Modal Form Tambah/Edit Terapis (Fully Responsive) -->
    <div v-if="showModal" class="modal-backdrop" @click.self="closeModal">
      <div class="modal-card">
        <div class="modal-header">
          <div class="modal-header-left">
            <span class="material-symbols-outlined modal-header-icon">{{ isEditModal ? 'edit_note' : 'person_add' }}</span>
            <h2 class="modal-title">{{ isEditModal ? 'Edit Data Terapis' : 'Tambah Anggota Tim Baru' }}</h2>
          </div>
          <button @click="closeModal" class="modal-close-btn" type="button" aria-label="Tutup form modal">
            <span class="material-symbols-outlined">close</span>
          </button>
        </div>

        <form @submit.prevent="saveMember" class="modal-body" novalidate>
          <div class="form-row">
            <div class="form-group flex-1">
              <label>Nama Lengkap &amp; Gelar Medis <span class="req">*</span></label>
              <input
                v-model="form.name"
                type="text"
                required
                placeholder="Contoh: dr. Nurul Aini, Sp.A / Rahmat Hidayat, S.Tr.Kes"
                class="form-input"
              />
            </div>
            <div class="form-group flex-1">
              <label>Kategori Praktisi <span class="req">*</span></label>
              <select v-model="form.category" class="form-select" required>
                <option value="tw">Terapi Wicara (TW)</option>
                <option value="ot">Terapi Okupasi (OT)</option>
                <option value="si">Sensori Integrasi (SI)</option>
                <option value="psi">Psikologi Anak / Dokter Spesialis</option>
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group flex-1">
              <label>Jabatan / Peran Klinis <span class="req">*</span></label>
              <input
                v-model="form.role"
                type="text"
                required
                placeholder="Contoh: Terapi Wicara (TW) / Spesialis Anak"
                class="form-input"
              />
            </div>
            <div class="form-group flex-1">
              <label>Pengalaman Klinis <span class="req">*</span></label>
              <input
                v-model="form.experience_years"
                type="text"
                placeholder="Contoh: 6+ Tahun"
                class="form-input"
              />
            </div>
          </div>

          <div class="form-row">
            <div class="form-group flex-1">
              <label>Pendidikan / Almamater</label>
              <input
                v-model="form.edu"
                type="text"
                placeholder="Contoh: Lulusan Akademi Terapi Wicara (ATW) Jakarta"
                class="form-input"
              />
            </div>
            <div class="form-group flex-1">
              <label>Nomor STR Kemenkes</label>
              <input
                v-model="form.str_number"
                type="text"
                placeholder="Contoh: STR.12.04.5.2.20-09821"
                class="form-input"
              />
            </div>
          </div>

          <div class="form-group">
            <label>Jadwal Praktik di Klinik</label>
            <input
              v-model="form.schedule"
              type="text"
              placeholder="Contoh: Senin, Rabu, Jumat (08.30 – 16.00 WIB)"
              class="form-input"
            />
          </div>

          <div class="form-group">
            <label>Fokus Spesialisasi <span class="req">*</span></label>
            <input
              v-model="form.specialization"
              type="text"
              required
              placeholder="Speech Delay, Sensori Integrasi, Disfagia, dsb."
              class="form-input"
            />
          </div>

          <div class="form-group">
            <label>Tag Intervensi (Pisahkan tanda koma)</label>
            <input
              v-model="tagsInput"
              type="text"
              placeholder="Speech Delay, Artikulasi & Gagap, Oral Motor"
              class="form-input"
            />
          </div>

          <div class="form-group">
            <label>Filosofi / Motto Terapi</label>
            <input
              v-model="form.philosophy"
              type="text"
              placeholder='"Komunikasi adalah hak setiap anak..."'
              class="form-input"
            />
          </div>

          <div class="form-group">
            <label>Profil Singkat / Ringkasan Klinis</label>
            <textarea
              v-model="form.bio"
              rows="3"
              placeholder="Ringkasan dedikasi, keahlian khusus, dan pendekatan terapi..."
              class="form-textarea"
            ></textarea>
          </div>

          <div class="form-group">
            <label>Foto Profil</label>
            <input
              ref="photoInput"
              type="file"
              accept="image/jpeg,image/png,image/webp"
              class="photo-up-hidden"
              @change="onPhotoSelected"
            />

            <!-- Belum ada foto: dropzone -->
            <div
              v-if="!displayPhoto"
              class="photo-up-drop"
              :class="{ 'is-dragging': isDraggingPhoto }"
              role="button"
              tabindex="0"
              @click="photoInput?.click()"
              @keydown.enter.prevent="photoInput?.click()"
              @dragover.prevent="isDraggingPhoto = true"
              @dragleave.prevent="isDraggingPhoto = false"
              @drop.prevent="onPhotoDrop"
            >
              <span class="material-symbols-outlined photo-up-icon">add_a_photo</span>
              <strong>Tarik foto ke sini atau klik untuk memilih</strong>
              <small>JPG, PNG, WEBP &bull; maks. 5 MB &bull; otomatis dipotong rasio 4:3</small>
            </div>

            <!-- Sudah ada foto: pratinjau -->
            <div v-else class="photo-up-card">
              <div class="photo-up-frame">
                <img :src="displayPhoto" alt="Pratinjau foto terapis" />
                <span v-if="pendingPhoto" class="photo-up-badge">Belum disimpan</span>
              </div>
              <div class="photo-up-actions">
                <button type="button" class="photo-up-btn" @click="photoInput?.click()">
                  <span class="material-symbols-outlined">swap_horiz</span> Ganti
                </button>
                <button type="button" class="photo-up-btn photo-up-btn-danger" @click="removePhoto">
                  <span class="material-symbols-outlined">delete</span> Hapus
                </button>
              </div>
              <div v-if="rawPhoto" class="photo-up-focal">
                <span>Fokus foto:</span>
                <button
                  v-for="opt in focalOptions"
                  :key="opt.id"
                  type="button"
                  class="photo-up-chip"
                  :class="{ active: photoFocal === opt.id }"
                  @click="setPhotoFocal(opt.id)"
                >{{ opt.label }}</button>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label>Sertifikasi &amp; Lisensi (Pisahkan dengan tanda koma)</label>
            <input
              v-model="certInput"
              type="text"
              placeholder="STR IKATWI, Denver II, Certified PECS Level 1"
              class="form-input"
            />
          </div>

          <div class="form-group">
            <label class="toggle-checkbox">
              <input type="checkbox" v-model="form.is_active" />
              <span>Status Praktik Aktif di Website</span>
            </label>
          </div>

          <div class="modal-footer">
            <button type="button" @click="closeModal" class="btn-secondary">Batal</button>
            <button type="submit" class="btn-primary" :disabled="isSaving">
              <span v-if="isSaving" class="spinner-small"></span>
              <span v-else>{{ isEditModal ? 'Simpan Perubahan' : 'Tambah Terapis' }}</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, reactive, computed, onMounted, onUnmounted } from 'vue'
import AdminLayout from '../../layouts/AdminLayout.vue'
import api from '../../services/api'

const team = ref([])
const loading = ref(true)
const showModal = ref(false)
const isEditModal = ref(false)
const isSaving = ref(false)
const currentMemberId = ref(null)
const certInput = ref('')
const tagsInput = ref('')

// ===== Upload foto profil terapis =====
const photoInput = ref(null)
const isDraggingPhoto = ref(false)
const rawPhoto = ref(null)       // berkas asli yang dipilih admin
const pendingPhoto = ref(null)   // hasil potong 4:3, diunggah saat Simpan
const pendingPreviewUrl = ref('')
const photoFocal = ref('top')
const focalOptions = [
  { id: 'top', label: 'Atas' },
  { id: 'center', label: 'Tengah' },
  { id: 'bottom', label: 'Bawah' },
]
const displayPhoto = computed(() => pendingPreviewUrl.value || form.image)

const searchQuery = ref('')
const selectedCategory = ref('all')

const categories = [
  { id: 'all', label: 'Semua Praktisi', icon: 'groups' },
  { id: 'tw', label: 'Terapi Wicara (TW)', icon: 'record_voice_over' },
  { id: 'ot', label: 'Terapi Okupasi (OT)', icon: 'front_hand' },
  { id: 'si', label: 'Sensori Integrasi (SI)', icon: 'spa' },
  { id: 'psi', label: 'Psikologi Anak', icon: 'psychology' },
]

const form = reactive({
  name: '',
  role: '',
  category: 'tw',
  edu: '',
  specialization: '',
  schedule: '',
  str_number: '',
  experience_years: '3+ Tahun',
  bio: '',
  philosophy: '',
  image: '',
  is_active: true,
  order: 0,
})

function clearPendingPhoto() {
  if (pendingPreviewUrl.value) URL.revokeObjectURL(pendingPreviewUrl.value)
  pendingPreviewUrl.value = ''
  pendingPhoto.value = null
  rawPhoto.value = null
  photoFocal.value = 'top'
}

// Potong gambar ke rasio 4:3 (sesuai kartu terapis) di browser
function cropTo4x3(file, focal) {
  return new Promise((resolve, reject) => {
    const url = URL.createObjectURL(file)
    const img = new Image()
    img.onload = () => {
      URL.revokeObjectURL(url)
      const ratio = 4 / 3
      const w = img.naturalWidth
      const h = img.naturalHeight
      let sx = 0, sy = 0, sw = w, sh = h
      if (w / h > ratio) {
        sw = h * ratio
        sx = (w - sw) / 2
      } else {
        sh = w / ratio
        sy = focal === 'top' ? 0 : focal === 'bottom' ? h - sh : (h - sh) / 2
      }
      const outW = Math.round(Math.min(1200, sw))
      const canvas = document.createElement('canvas')
      canvas.width = outW
      canvas.height = Math.round(outW / ratio)
      canvas.getContext('2d').drawImage(img, sx, sy, sw, sh, 0, 0, canvas.width, canvas.height)
      canvas.toBlob((blob) => {
        if (!blob) return reject(new Error('Gagal memproses gambar'))
        resolve(new File([blob], 'terapis.webp', { type: 'image/webp' }))
      }, 'image/webp', 0.9)
    }
    img.onerror = () => {
      URL.revokeObjectURL(url)
      reject(new Error('Berkas gambar tidak dapat dibaca'))
    }
    img.src = url
  })
}

async function applyCrop() {
  try {
    const cropped = await cropTo4x3(rawPhoto.value, photoFocal.value)
    if (pendingPreviewUrl.value) URL.revokeObjectURL(pendingPreviewUrl.value)
    pendingPhoto.value = cropped
    pendingPreviewUrl.value = URL.createObjectURL(cropped)
  } catch (err) {
    alert(err.message)
  }
}

async function handlePhotoFile(file) {
  if (!file) return
  if (!/^image\/(jpeg|png|webp)$/.test(file.type)) {
    alert('Format foto harus JPG, PNG, atau WEBP.')
    return
  }
  if (file.size > 5 * 1024 * 1024) {
    alert('Ukuran foto maksimal 5 MB.')
    return
  }
  rawPhoto.value = file
  await applyCrop()
}

function onPhotoSelected(e) {
  handlePhotoFile(e.target.files?.[0])
  e.target.value = ''
}

function onPhotoDrop(e) {
  isDraggingPhoto.value = false
  handlePhotoFile(e.dataTransfer.files?.[0])
}

function setPhotoFocal(pos) {
  if (photoFocal.value === pos || !rawPhoto.value) return
  photoFocal.value = pos
  applyCrop()
}

function removePhoto() {
  clearPendingPhoto()
  form.image = ''
}

function getMemberColor(member) {
  const cat = member.category
  if (cat === 'tw') return 'blue'
  if (cat === 'ot') return 'amber'
  if (cat === 'si') return 'green'
  if (cat === 'psi') return 'purple'
  if (cat === 'ft') return 'amber'

  const text = ((member.role || '') + ' ' + (member.specialization || '')).toLowerCase()
  if (text.includes('wicara') || text.includes('tw') || text.includes('speech')) return 'blue'
  if (text.includes('okupasi') || text.includes('ot')) return 'amber'
  if (text.includes('sensori') || text.includes('si')) return 'green'
  if (text.includes('psikolog') || text.includes('psi')) return 'purple'
  if (text.includes('fisioterapi') || text.includes('ft')) return 'amber'
  if (text.includes('dokter') || text.includes('anak') || text.includes('sp.a')) return 'teal'
  return 'blue'
}

function getMemberIcon(member) {
  const cat = member.category
  if (cat === 'tw') return 'record_voice_over'
  if (cat === 'ot') return 'front_hand'
  if (cat === 'si') return 'spa'
  if (cat === 'psi') return 'psychology'
  if (cat === 'ft') return 'accessibility_new'

  const text = ((member.role || '') + ' ' + (member.specialization || '')).toLowerCase()
  if (text.includes('wicara') || text.includes('tw') || text.includes('speech')) return 'record_voice_over'
  if (text.includes('okupasi') || text.includes('ot')) return 'front_hand'
  if (text.includes('sensori') || text.includes('si')) return 'spa'
  if (text.includes('psikolog') || text.includes('psi')) return 'psychology'
  if (text.includes('fisioterapi') || text.includes('ft')) return 'accessibility_new'
  if (text.includes('dokter') || text.includes('anak') || text.includes('sp.a')) return 'stethoscope'
  return 'workspace_premium'
}

function getCategoryCount(catId) {
  if (catId === 'all') return team.value.length
  return team.value.filter(m => {
    if (m.category) return m.category === catId
    const text = ((m.role || '') + ' ' + (m.specialization || '')).toLowerCase()
    if (catId === 'tw') return text.includes('wicara') || text.includes('tw') || text.includes('speech')
    if (catId === 'ot') return text.includes('okupasi') || text.includes('ot')
    if (catId === 'si') return text.includes('sensori') || text.includes('si')
    if (catId === 'psi') return text.includes('psikolog') || text.includes('psi')
    if (catId === 'ft') return text.includes('fisioterapi') || text.includes('ft')
    return false
  }).length
}

const filteredTeam = computed(() => {
  return team.value.filter(member => {
    // Kategori
    if (selectedCategory.value !== 'all') {
      if (member.category) {
        if (member.category !== selectedCategory.value) return false
      } else {
        const text = ((member.role || '') + ' ' + (member.specialization || '')).toLowerCase()
        if (selectedCategory.value === 'tw' && !(text.includes('wicara') || text.includes('tw') || text.includes('speech'))) return false
        if (selectedCategory.value === 'ot' && !(text.includes('okupasi') || text.includes('ot'))) return false
        if (selectedCategory.value === 'si' && !(text.includes('sensori') || text.includes('si'))) return false
        if (selectedCategory.value === 'psi' && !(text.includes('psikolog') || text.includes('psi'))) return false
        if (selectedCategory.value === 'ft' && !(text.includes('fisioterapi') || text.includes('ft'))) return false
      }
    }

    // Pencarian
    if (searchQuery.value.trim()) {
      const q = searchQuery.value.toLowerCase().trim()
      const matchName = member.name?.toLowerCase().includes(q)
      const matchRole = member.role?.toLowerCase().includes(q)
      const matchSpec = member.specialization?.toLowerCase().includes(q)
      const matchEdu = member.edu?.toLowerCase().includes(q)
      const matchSched = member.schedule?.toLowerCase().includes(q)
      const matchBio = member.bio?.toLowerCase().includes(q)
      const matchTags = Array.isArray(member.tags) && member.tags.some(t => t.toLowerCase().includes(q))
      const matchCert = Array.isArray(member.certifications) && member.certifications.some(c => c.toLowerCase().includes(q))
      return matchName || matchRole || matchSpec || matchEdu || matchSched || matchBio || matchTags || matchCert
    }

    return true
  })
})

function resetFilters() {
  searchQuery.value = ''
  selectedCategory.value = 'all'
}

async function fetchTeam() {
  loading.value = true
  try {
    const res = await api.get('/admin/team')
    team.value = res.data || []
  } catch (err) {
    console.error('Error fetching team', err)
  } finally {
    loading.value = false
  }
}

async function toggleStatus(member) {
  try {
    const updatedStatus = !member.is_active
    await api.put(`/admin/team/${member.id}`, {
      ...member,
      is_active: updatedStatus
    })
    member.is_active = updatedStatus
  } catch (err) {
    alert('Gagal memperbarui status praktik terapis.')
  }
}

function openCreateModal() {
  isEditModal.value = false
  currentMemberId.value = null
  form.name = ''
  form.role = ''
  form.category = 'tw'
  form.edu = ''
  form.specialization = ''
  form.schedule = ''
  form.str_number = ''
  form.bio = ''
  form.philosophy = ''
  form.experience_years = '3+ Tahun'
  form.image = ''
  clearPendingPhoto()
  form.is_active = true
  form.order = team.value.length + 1
  certInput.value = ''
  tagsInput.value = ''
  showModal.value = true
  document.body.style.overflow = 'hidden'
}

function openEditModal(member) {
  isEditModal.value = true
  currentMemberId.value = member.id
  form.name = member.name
  form.role = member.role
  form.category = member.category || 'tw'
  form.edu = member.edu || ''
  form.specialization = member.specialization || ''
  form.schedule = member.schedule || ''
  form.str_number = member.str_number || ''
  form.bio = member.bio || ''
  form.philosophy = member.philosophy || ''
  form.experience_years = member.experience_years || ''
  form.image = member.image || ''
  clearPendingPhoto()
  form.is_active = !!member.is_active
  form.order = member.order || 0
  certInput.value = Array.isArray(member.certifications) ? member.certifications.join(', ') : ''
  tagsInput.value = Array.isArray(member.tags) ? member.tags.join(', ') : (typeof member.tags === 'string' ? member.tags : '')
  showModal.value = true
  document.body.style.overflow = 'hidden'
}

function closeModal() {
  showModal.value = false
  clearPendingPhoto()
  document.body.style.overflow = ''
}

async function saveMember() {
  isSaving.value = true
  const certs = certInput.value
    ? certInput.value.split(',').map(s => s.trim()).filter(Boolean)
    : []
  const parsedTags = tagsInput.value
    ? tagsInput.value.split(',').map(s => s.trim()).filter(Boolean)
    : (form.specialization ? form.specialization.split(',').map(s => s.trim()).filter(Boolean) : [])

  const payload = {
    ...form,
    tags: parsedTags,
    certifications: certs,
  }

  try {
    // Unggah foto baru (jika ada) lebih dulu, lalu simpan datanya
    if (pendingPhoto.value) {
      const fd = new FormData()
      fd.append('image', pendingPhoto.value)
      const up = await api.post('/admin/team/upload-image', fd, {
        headers: { 'Content-Type': 'multipart/form-data' },
      })
      payload.image = up.data.url
    }

    if (isEditModal.value) {
      const res = await api.put(`/admin/team/${currentMemberId.value}`, payload)
      const idx = team.value.findIndex(m => m.id === currentMemberId.value)
      if (idx !== -1) team.value[idx] = res.data.data
      alert('Data terapis berhasil diperbarui!')
    } else {
      const res = await api.post('/admin/team', payload)
      team.value.push(res.data.data)
      alert('Terapis baru berhasil ditambahkan!')
    }
    closeModal()
  } catch (err) {
    alert(err.response?.data?.message || 'Gagal menyimpan data terapis.')
  } finally {
    isSaving.value = false
  }
}

async function deleteMember(member) {
  if (confirm(`Yakin ingin menghapus ${member.name} dari tim?`)) {
    try {
      await api.delete(`/admin/team/${member.id}`)
      team.value = team.value.filter(m => m.id !== member.id)
    } catch (err) {
      alert('Gagal menghapus anggota tim.')
    }
  }
}

onMounted(() => {
  fetchTeam()
})

onUnmounted(() => {
  clearPendingPhoto()
  document.body.style.overflow = ''
})
</script>

<style scoped>
/* ============================================================
   PAGE TOP BAR
   ============================================================ */
.page-top-bar {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 1.5rem;
  margin-bottom: 1.75rem;
}

.page-top-info {
  flex: 1;
  min-width: 0;
}

.meta-tag {
  display: inline-block;
  background: rgba(204, 239, 142, 0.45);
  color: #354e00;
  padding: 0.25rem 0.75rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 700;
  margin-bottom: 0.5rem;
  letter-spacing: 0.02em;
}

.page-heading {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 1.75rem;
  font-weight: 800;
  color: var(--on-surface, #091d2e);
  letter-spacing: -0.015em;
  margin: 0;
  line-height: 1.25;
}

.page-subheading {
  font-size: 0.9375rem;
  color: var(--on-surface-variant, #40484d);
  max-width: 650px;
  margin-top: 0.35rem;
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
  padding: 0.75rem 1.5rem;
  border-radius: 9999px;
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-weight: 700;
  font-size: 0.9375rem;
  border: none;
  cursor: pointer;
  box-shadow: 0 4px 12px rgba(0, 99, 132, 0.25);
  transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
  white-space: nowrap;
}

.btn-create:hover {
  background: #00839e;
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(0, 99, 132, 0.35);
}

.btn-create:active {
  transform: translateY(0);
}

.btn-icon-main {
  font-size: 20px;
}

/* ============================================================
   FILTER CONTROLS & TOOLBAR
   ============================================================ */
.filter-controls-wrap {
  display: flex;
  flex-direction: column;
  gap: 1.15rem;
  margin-bottom: 2rem;
}

.filter-toolbar-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1.25rem;
  flex-wrap: wrap;
}

.team-count-note {
  font-size: 13.5px;
  color: #475569;
  background: #ffffff;
  padding: 0.5rem 1rem;
  border-radius: 999px;
  border: 1px solid rgba(191, 200, 206, 0.45);
  display: inline-flex;
  align-items: center;
  gap: 0.45rem;
  font-weight: 500;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
}

.count-icon {
  font-size: 18px;
  color: #006384;
}

.team-count-note strong {
  color: #006384;
  font-weight: 800;
}

.search-input-box {
  position: relative;
  min-width: 280px;
  max-width: 420px;
  width: 100%;
}

.search-icon {
  position: absolute;
  left: 1rem;
  top: 50%;
  transform: translateY(-50%);
  color: #94a3b8;
  font-size: 20px;
  pointer-events: none;
}

.search-input {
  width: 100%;
  padding: 0.65rem 2.25rem 0.65rem 2.75rem;
  border-radius: 999px;
  border: 1.5px solid rgba(191, 200, 206, 0.45);
  background: #ffffff;
  font-size: 13.5px;
  color: #091d2e;
  outline: none;
  transition: all 0.2s;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
}

.search-input:focus {
  border-color: #006384;
  box-shadow: 0 0 0 3px rgba(0, 99, 132, 0.15);
}

.btn-clear-search {
  position: absolute;
  right: 0.75rem;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  color: #94a3b8;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0.25rem;
  border-radius: 50%;
}

.btn-clear-search:hover {
  color: #091d2e;
}

/* Category Filter Tabs (Swipeable) */
.category-tabs-container {
  position: relative;
  width: 100%;
}

.category-tabs-nav {
  display: flex;
  flex-wrap: nowrap;
  gap: 0.65rem;
  padding: 0.35rem 0.15rem 0.6rem 0.15rem;
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
  scrollbar-width: none;
}

.category-tabs-nav::-webkit-scrollbar {
  display: none;
}

.cat-tab-btn {
  display: inline-flex;
  align-items: center;
  gap: 0.45rem;
  flex-shrink: 0;
  white-space: nowrap;
  background: #ffffff;
  color: #334155;
  border: 1.5px solid rgba(191, 200, 206, 0.45);
  padding: 0.55rem 1.15rem;
  border-radius: 999px;
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 13px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
  user-select: none;
}

.cat-tab-btn:hover {
  border-color: #006384;
  color: #006384;
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(0, 99, 132, 0.12);
}

.cat-tab-btn.is-active {
  background: #006384;
  color: #ffffff;
  border-color: #006384;
  box-shadow: 0 4px 14px rgba(0, 99, 132, 0.25);
}

.cat-tab-icon {
  font-size: 18px;
}

.cat-tab-badge {
  background: rgba(0, 0, 0, 0.08);
  color: inherit;
  font-size: 11px;
  font-weight: 800;
  padding: 0.15rem 0.45rem;
  border-radius: 999px;
}

.cat-tab-btn.is-active .cat-tab-badge {
  background: rgba(255, 255, 255, 0.25);
  color: #ffffff;
}

/* ============================================================
   TEAM GRID & MEMBER CARDS
   ============================================================ */
.team-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
  gap: 1.75rem;
}

.member-card {
  background: #ffffff;
  border: 1.5px solid rgba(191, 200, 206, 0.35);
  border-radius: 1.25rem;
  overflow: hidden;
  padding: 1.25rem;
  display: flex;
  flex-direction: column;
  box-shadow: 0 6px 20px -4px rgba(9, 29, 46, 0.06);
  transition: all 0.25s ease;
  position: relative;
}

.member-card:hover {
  transform: translateY(-5px);
  border-color: #006384;
  box-shadow: 0 16px 36px -6px rgba(0, 99, 132, 0.15);
}

.member-photo-wrap {
  position: relative;
  margin-bottom: 1rem;
  border-radius: 1rem;
  overflow: hidden;
  background: #f1f5f9;
}

.member-photo {
  width: 100%;
  height: 210px;
  object-fit: cover;
  display: block;
  transition: transform 0.4s ease;
}

.member-card:hover .member-photo {
  transform: scale(1.04);
}

.photo-overlay-gradient {
  position: absolute;
  inset: 0;
  background: linear-gradient(180deg, rgba(0,0,0,0) 60%, rgba(9, 29, 46, 0.45) 100%);
  pointer-events: none;
}

/* Specialty badge (Top-Left) */
.badge-specialty {
  position: absolute;
  top: 0.75rem;
  left: 0.75rem;
  display: flex;
  align-items: center;
  gap: 0.35rem;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
  border-radius: 9999px;
  padding: 0.3rem 0.75rem;
  font-size: 11.5px;
  font-weight: 800;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
  border: 1px solid rgba(255, 255, 255, 0.85);
  max-width: calc(100% - 1.5rem);
  white-space: nowrap;
}

.badge-spec-icon {
  font-size: 15px;
  flex-shrink: 0;
}

.badge-spec-text {
  overflow: hidden;
  text-overflow: ellipsis;
}

.badge-blue   { color: #006384; }
.badge-amber  { color: #d97706; }
.badge-green  { color: #16a34a; }
.badge-purple { color: #7c3aed; }
.badge-teal   { color: #0f766e; }

/* Status Chip (Bottom-Right) */
.badge-str {
  position: absolute;
  bottom: 0.75rem;
  right: 0.75rem;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
  color: #065f46;
  border-radius: 9999px;
  padding: 0.28rem 0.65rem;
  font-size: 11px;
  font-weight: 700;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
  display: flex;
  align-items: center;
  gap: 0.35rem;
  cursor: pointer;
  transition: transform 0.15s ease, background 0.2s ease;
  user-select: none;
}

.badge-str:hover {
  transform: scale(1.05);
  background: #ffffff;
}

.badge-str:active {
  transform: scale(0.96);
}

.badge-str-inactive {
  color: #64748b;
}

.pulse-dot-green {
  width: 6px;
  height: 6px;
  background: #10b981;
  border-radius: 50%;
  box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.3);
}

.pulse-dot-gray {
  width: 6px;
  height: 6px;
  background: #94a3b8;
  border-radius: 50%;
  box-shadow: 0 0 0 2px rgba(148, 163, 184, 0.3);
}

/* Member Body Details */
.member-info-body {
  flex: 1;
  display: flex;
  flex-direction: column;
}

.member-name {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 16.5px;
  font-weight: 800;
  color: #091d2e;
  margin: 0 0 0.25rem;
  line-height: 1.3;
}

.member-edu {
  font-size: 12px;
  color: #556066;
  margin: 0 0 0.75rem;
  line-height: 1.45;
  font-weight: 600;
}

/* Schedule / Experience Chip */
.member-schedule-chip {
  display: flex;
  align-items: center;
  gap: 0.4rem;
  background: #f1f5f9;
  border-radius: 8px;
  padding: 0.4rem 0.65rem;
  margin-bottom: 0.85rem;
}

.sched-icon {
  font-size: 16px;
  color: #006384;
}

.sched-text {
  font-size: 11.5px;
  color: #334155;
  line-height: 1.3;
}

.member-bio {
  font-size: 12px;
  color: #475569;
  line-height: 1.5;
  margin: 0 0 0.85rem;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Focus Tags */
.member-focus {
  margin-top: auto;
  margin-bottom: 1.15rem;
}

.focus-label {
  display: block;
  font-size: 11px;
  font-weight: 800;
  color: #64748b;
  text-transform: uppercase;
  letter-spacing: 0.02em;
  margin-bottom: 0.4rem;
}

.focus-tags {
  display: flex;
  flex-wrap: wrap;
  gap: 0.35rem;
}

.focus-tag {
  font-size: 11.5px;
  padding: 0.2rem 0.6rem;
  border-radius: 9999px;
  font-weight: 600;
}

.tag-blue   { background: #e0f2fe; color: #006384; }
.tag-amber  { background: #fef3c7; color: #b45309; }
.tag-green  { background: #dcfce7; color: #15803d; }
.tag-purple { background: #f3e8ff; color: #7c3aed; }
.tag-teal   { background: #ccfbf1; color: #0f766e; }
.tag-cert   { background: #f1f5f9; color: #475569; border: 1px solid rgba(191, 200, 206, 0.4); }
.tag-more   { background: #f8fafc; color: #64748b; font-weight: 700; }

/* Member Card Action Buttons */
.member-actions-row {
  display: grid;
  grid-template-columns: 1fr auto;
  gap: 0.5rem;
  padding-top: 1rem;
  border-top: 1px solid rgba(191, 200, 206, 0.25);
}

.btn-card-edit {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.35rem;
  background: #f8fafc;
  color: #006384;
  border: 1px solid #cbd5e1;
  border-radius: 999px;
  padding: 0.55rem 0.85rem;
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 12.5px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.2s;
  min-height: 38px;
}

.btn-card-edit:hover {
  background: #e0f2fe;
  border-color: #006384;
  transform: translateY(-1px);
}

.btn-card-delete {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.3rem;
  background: #ffffff;
  color: #ba1a1a;
  border: 1px solid #fecaca;
  border-radius: 999px;
  padding: 0.55rem 0.85rem;
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 12.5px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.2s;
  min-height: 38px;
}

.btn-card-delete:hover {
  background: #fee2e2;
  border-color: #ba1a1a;
  transform: translateY(-1px);
}

.action-icon {
  font-size: 16px;
}

/* ============================================================
   EMPTY & LOADING STATES
   ============================================================ */
.loading-state {
  text-align: center;
  padding: 4rem 1rem;
  color: var(--on-surface-variant, #40484d);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1rem;
}

.empty-state-box {
  background: #ffffff;
  border-radius: 20px;
  border: 1.5px dashed rgba(191, 200, 206, 0.6);
  padding: 3.5rem 1.5rem;
  text-align: center;
  max-width: 540px;
  margin: 2rem auto;
}

.empty-icon-wrap {
  width: 64px;
  height: 64px;
  border-radius: 50%;
  background: #f1f5f9;
  color: #006384;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 1.25rem;
}

.empty-icon-wrap .material-symbols-outlined {
  font-size: 32px;
}

.empty-title {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 1.25rem;
  font-weight: 800;
  color: #091d2e;
  margin: 0 0 0.5rem;
}

.empty-desc {
  font-size: 0.875rem;
  color: #64748b;
  line-height: 1.5;
  margin: 0 0 1.25rem;
}

.btn-reset-filter {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  background: #f0f7ff;
  color: #006384;
  border: 1px solid #bfdbfe;
  padding: 0.55rem 1.15rem;
  border-radius: 999px;
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 0.85rem;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-reset-filter:hover {
  background: #dbeafe;
}

/* ============================================================
   MODAL DIALOG
   ============================================================ */
.modal-backdrop {
  position: fixed;
  inset: 0;
  background: rgba(9, 29, 46, 0.65);
  backdrop-filter: blur(4px);
  -webkit-backdrop-filter: blur(4px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 100;
  padding: 1rem;
}

.modal-card {
  background: #ffffff;
  border-radius: 20px;
  max-width: 580px;
  width: 100%;
  max-height: 90vh;
  overflow-y: auto;
  scrollbar-width: none; /* Firefox */
  -ms-overflow-style: none; /* IE & Edge */
  box-shadow: 0 20px 48px rgba(9, 29, 46, 0.25);
}

.modal-card::-webkit-scrollbar {
  display: none; /* Chrome, Safari, Opera */
}

.modal-header {
  padding: 1.25rem 1.75rem;
  border-bottom: 1px solid rgba(191, 200, 206, 0.3);
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
}

.modal-header-left {
  display: flex;
  align-items: center;
  gap: 0.6rem;
}

.modal-header-icon {
  font-size: 24px;
  color: #006384;
}

.modal-title {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 1.25rem;
  font-weight: 800;
  color: #091d2e;
  margin: 0;
}

.modal-close-btn {
  background: none;
  border: none;
  cursor: pointer;
  color: #64748b;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0.35rem;
  border-radius: 50%;
  transition: background 0.2s;
}

.modal-close-btn:hover {
  background: #f1f5f9;
  color: #091d2e;
}

.modal-body {
  padding: 1.75rem;
}

.form-group {
  margin-bottom: 1rem;
}

.form-row {
  display: flex;
  gap: 1rem;
}

.flex-1 {
  flex: 1;
}

.form-group label {
  display: block;
  font-size: 0.8125rem;
  font-weight: 700;
  color: #1e293b;
  margin-bottom: 0.35rem;
}

.req {
  color: #ba1a1a;
}

.form-input, .form-textarea, .form-select {
  width: 100%;
  padding: 0.7rem 0.875rem;
  border-radius: 10px;
  border: 1px solid rgba(191, 200, 206, 0.6);
  background: #f8fafc;
  font-family: inherit;
  font-size: 0.9rem;
  color: #091d2e;
  transition: all 0.2s;
}

.form-input:focus, .form-textarea:focus, .form-select:focus {
  outline: none;
  border-color: #006384;
  background: #ffffff;
  box-shadow: 0 0 0 3px rgba(0, 99, 132, 0.12);
}

.toggle-checkbox {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  cursor: pointer;
  font-size: 0.875rem;
  font-weight: 600;
  color: #334155;
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 0.75rem;
  margin-top: 1.5rem;
  padding-top: 1rem;
  border-top: 1px solid rgba(191, 200, 206, 0.3);
}

.btn-secondary {
  padding: 0.65rem 1.25rem;
  border-radius: 9999px;
  border: 1px solid rgba(191, 200, 206, 0.6);
  background: #ffffff;
  color: #334155;
  cursor: pointer;
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-weight: 700;
  transition: all 0.2s;
}

.btn-secondary:hover {
  background: #f1f5f9;
}

.btn-primary {
  padding: 0.65rem 1.5rem;
  border-radius: 9999px;
  border: none;
  background: #006384;
  color: #ffffff;
  cursor: pointer;
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-weight: 700;
  transition: all 0.2s;
  box-shadow: 0 4px 12px rgba(0, 99, 132, 0.25);
}

.btn-primary:hover {
  background: #00839e;
}

/* ============================================================
   RESPONSIVE MEDIA QUERIES (MOBILE & TABLET UI/UX)
   ============================================================ */

/* Tablet & iPad (<= 1024px) */
@media (max-width: 1024px) {
  .team-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 1.35rem;
  }
}

/* Tablet Portrait & Large Phones (<= 768px) */
@media (max-width: 768px) {
  .page-top-bar {
    flex-direction: column;
    align-items: stretch;
    gap: 1.15rem;
    margin-bottom: 1.35rem;
  }

  .top-actions {
    width: 100%;
  }

  .btn-create {
    width: 100%;
    justify-content: center;
    padding: 0.8rem 1.25rem;
    font-size: 0.9rem;
  }

  .page-heading {
    font-size: 1.45rem;
  }

  .page-subheading {
    font-size: 0.875rem;
  }

  .filter-controls-wrap {
    gap: 0.85rem;
    margin-bottom: 1.5rem;
  }

  .filter-toolbar-row {
    flex-direction: column;
    align-items: stretch;
    gap: 0.75rem;
  }

  .search-input-box {
    max-width: 100%;
    min-width: 100%;
    order: 1;
  }

  .team-count-note {
    order: 2;
    width: 100%;
    justify-content: center;
    font-size: 12.5px;
    padding: 0.45rem 0.85rem;
  }

  .category-tabs-nav {
    padding: 0.25rem 0.15rem 0.5rem 0.15rem;
    gap: 0.5rem;
  }

  .cat-tab-btn {
    padding: 0.5rem 0.9rem;
    font-size: 12.5px;
    min-height: 40px;
  }

  .modal-backdrop {
    padding: 0.75rem;
  }

  .modal-card {
    border-radius: 16px;
    max-height: 92vh;
  }

  .modal-header {
    padding: 1rem 1.25rem;
  }

  .modal-title {
    font-size: 1.125rem;
  }

  .modal-body {
    padding: 1.25rem;
  }

  .form-row {
    flex-direction: column;
    gap: 0;
  }

  .modal-footer {
    flex-direction: column-reverse;
    gap: 0.6rem;
  }

  .btn-secondary, .btn-primary {
    width: 100%;
    justify-content: center;
    text-align: center;
    min-height: 44px;
  }
}

/* Mobile Screens (<= 640px) */
@media (max-width: 640px) {
  .team-grid {
    grid-template-columns: 1fr;
    gap: 1.15rem;
  }

  .member-card {
    padding: 1rem;
    border-radius: 1.15rem;
  }

  .member-photo {
    height: 200px;
  }

  .badge-specialty {
    font-size: 11px;
    padding: 0.25rem 0.65rem;
  }

  .badge-str {
    font-size: 10.5px;
    padding: 0.25rem 0.6rem;
  }

  .member-name {
    font-size: 16px;
  }

  .member-edu {
    font-size: 12px;
    margin-bottom: 0.65rem;
  }

  .member-schedule-chip {
    padding: 0.35rem 0.6rem;
    font-size: 11px;
    margin-bottom: 0.75rem;
  }

  .member-actions-row {
    grid-template-columns: 1fr 1fr;
    gap: 0.5rem;
    padding-top: 0.85rem;
  }

  .btn-card-edit, .btn-card-delete {
    min-height: 42px;
    font-size: 12px;
    padding: 0.55rem 0.5rem;
  }

  .empty-state-box {
    padding: 2.5rem 1.25rem;
    margin: 1.5rem auto;
    border-radius: 16px;
  }

  .empty-icon-wrap {
    width: 52px;
    height: 52px;
    margin-bottom: 1rem;
  }

  .empty-icon-wrap .material-symbols-outlined {
    font-size: 28px;
  }

  .empty-title {
    font-size: 1.125rem;
  }
}

/* Small Smartphone Screens (<= 380px) */
@media (max-width: 380px) {
  .page-heading {
    font-size: 1.3rem;
  }

  .member-photo {
    height: 180px;
  }

  .btn-card-edit, .btn-card-delete {
    font-size: 11.5px;
    gap: 0.25rem;
  }
}

/* ============================================================
   UPLOAD FOTO PROFIL TERAPIS
   ============================================================ */
.photo-up-hidden {
  display: none;
}

.photo-up-drop {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.35rem;
  padding: 1.5rem 1rem;
  border: 2px dashed rgba(0, 99, 132, 0.35);
  border-radius: 14px;
  background: #f7f9ff;
  text-align: center;
  cursor: pointer;
  transition: all 0.2s;
}

.photo-up-drop:hover,
.photo-up-drop:focus-visible,
.photo-up-drop.is-dragging {
  border-color: #006384;
  background: rgba(0, 99, 132, 0.05);
  outline: none;
}

.photo-up-drop.is-dragging {
  box-shadow: 0 0 0 4px rgba(0, 99, 132, 0.12);
}

.photo-up-icon {
  font-size: 34px;
  color: #006384;
}

.photo-up-drop strong {
  font-size: 0.875rem;
  color: #091d2e;
}

.photo-up-drop small {
  font-size: 0.75rem;
  color: #70787e;
}

.photo-up-card {
  display: flex;
  flex-direction: column;
  gap: 0.65rem;
  padding: 0.75rem;
  border: 1px solid rgba(191, 200, 206, 0.6);
  border-radius: 14px;
  background: #f7f9ff;
}

.photo-up-frame {
  position: relative;
  width: 100%;
  aspect-ratio: 4 / 3;
  border-radius: 10px;
  overflow: hidden;
  background: #e2e8f0;
}

.photo-up-frame img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.photo-up-badge {
  position: absolute;
  top: 0.5rem;
  left: 0.5rem;
  padding: 0.2rem 0.6rem;
  border-radius: 9999px;
  background: rgba(9, 29, 46, 0.78);
  color: #fff;
  font-size: 0.6875rem;
  font-weight: 700;
}

.photo-up-actions {
  display: flex;
  gap: 0.5rem;
}

.photo-up-btn {
  flex: 1;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.3rem;
  padding: 0.5rem 0.75rem;
  border: 1px solid rgba(0, 99, 132, 0.3);
  border-radius: 10px;
  background: #fff;
  color: #006384;
  font-size: 0.8125rem;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.2s;
}

.photo-up-btn .material-symbols-outlined {
  font-size: 1.1rem;
}

.photo-up-btn:hover {
  background: #006384;
  color: #fff;
}

.photo-up-btn-danger {
  border-color: rgba(186, 26, 26, 0.3);
  color: #ba1a1a;
}

.photo-up-btn-danger:hover {
  background: #ba1a1a;
  color: #fff;
}

.photo-up-focal {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 0.4rem;
  font-size: 0.75rem;
  font-weight: 700;
  color: #40484d;
}

.photo-up-chip {
  padding: 0.25rem 0.75rem;
  border: 1px solid rgba(191, 200, 206, 0.8);
  border-radius: 9999px;
  background: #fff;
  color: #40484d;
  font-size: 0.75rem;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.2s;
}

.photo-up-chip:hover {
  border-color: #006384;
  color: #006384;
}

.photo-up-chip.active {
  background: #006384;
  border-color: #006384;
  color: #fff;
}
</style>