<template>
  <AdminLayout title="Kelola Tim Kami">
    <!-- Header Row -->
    <div class="page-top-bar">
      <div>
        <div class="meta-tag">Tenaga Medis & Terapis</div>
        <h1 class="page-heading">Manajemen Tim Terapis Spesialis</h1>
        <p class="page-subheading">
          Kelola data dokter anak, terapis wicara, terapis okupasi, sensori integrasi, dan fisioterapis yang bertugas di klinik.
        </p>
      </div>
      <div class="top-actions">
        <button @click="openCreateModal" class="btn-create">
          <span class="material-symbols-outlined">person_add</span>
          <span>+ Tambah Anggota Tim</span>
        </button>
      </div>
    </div>

    <!-- Team Cards Grid -->
    <div v-if="loading" class="loading-state">
      <div class="spinner-small"></div>
      <span>Memuat data tim terapis...</span>
    </div>

    <div v-else-if="team.length === 0" class="empty-state">
      <span class="material-symbols-outlined empty-icon">group</span>
      <p>Belum ada data anggota tim terapis.</p>
      <button @click="openCreateModal" class="btn-primary mt-3">+ Tambah Terapis Pertama</button>
    </div>

    <div v-else class="team-grid">
      <div v-for="member in team" :key="member.id" class="member-card">
        <div class="member-card-top">
          <img
            :src="member.image || 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=300'"
            :alt="member.name"
            class="member-photo"
          />
          <div class="member-status-chip" :class="member.is_active ? 'active-chip' : 'inactive-chip'">
            {{ member.is_active ? 'Praktik Aktif' : 'Non-Aktif' }}
          </div>
        </div>

        <div class="member-body">
          <h3 class="member-name">{{ member.name }}</h3>
          <div class="member-role">{{ member.role }}</div>
          <div class="member-spec">
            <span class="material-symbols-outlined text-sm">workspace_premium</span>
            <span>{{ member.specialization }}</span>
          </div>

          <p class="member-bio">{{ member.bio || 'Terapis profesional berlisensi.' }}</p>

          <div class="member-certs" v-if="member.certifications && member.certifications.length">
            <span v-for="(cert, idx) in member.certifications" :key="idx" class="cert-pill">
              {{ cert }}
            </span>
          </div>
        </div>

        <div class="member-footer">
          <span class="exp-text">Pengalaman: <strong>{{ member.experience_years || '3+ Tahun' }}</strong></span>
          <div class="member-actions">
            <button @click="openEditModal(member)" class="btn-icon" title="Edit Profil">
              <span class="material-symbols-outlined">edit</span>
            </button>
            <button @click="deleteMember(member)" class="btn-icon btn-delete" title="Hapus Terapis">
              <span class="material-symbols-outlined">delete</span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Form Tambah/Edit Terapis -->
    <div v-if="showModal" class="modal-backdrop" @click.self="closeModal">
      <div class="modal-card">
        <div class="modal-header">
          <h2 class="modal-title">{{ isEditModal ? 'Edit Data Terapis' : 'Tambah Anggota Tim Baru' }}</h2>
          <button @click="closeModal" class="modal-close-btn">
            <span class="material-symbols-outlined">close</span>
          </button>
        </div>

        <form @submit.prevent="saveMember" class="modal-body">
          <div class="form-group">
            <label>Nama Lengkap & Gelar Medis <span class="req">*</span></label>
            <input v-model="form.name" type="text" required placeholder="dr. Nurul Aini, Sp.A / Rahmat Hidayat, S.Tr.Kes" class="form-input" />
          </div>

          <div class="form-row">
            <div class="form-group flex-1">
              <label>Jabatan / Peran <span class="req">*</span></label>
              <input v-model="form.role" type="text" required placeholder="Kepala Terapis Wicara" class="form-input" />
            </div>
            <div class="form-group flex-1">
              <label>Pengalaman <span class="req">*</span></label>
              <input v-model="form.experience_years" type="text" placeholder="Contoh: 5+ Tahun" class="form-input" />
            </div>
          </div>

          <div class="form-group">
            <label>Fokus Spesialisasi <span class="req">*</span></label>
            <input v-model="form.specialization" type="text" required placeholder="Speech Delay, Sensori Integrasi, dsb." class="form-input" />
          </div>

          <div class="form-group">
            <label>Profil Singkat / Bio</label>
            <textarea v-model="form.bio" rows="3" placeholder="Ringkasan dedikasi dan pengalaman klinis..." class="form-textarea"></textarea>
          </div>

          <div class="form-group">
            <label>URL Foto Profil</label>
            <input v-model="form.image" type="url" placeholder="https://images.unsplash.com/..." class="form-input" />
          </div>

          <div class="form-group">
            <label>Sertifikasi & Lisensi (Pisahkan dengan koma)</label>
            <input v-model="certInput" type="text" placeholder="STR IKATWI, Denver II, Certified PECS" class="form-input" />
          </div>

          <div class="form-group">
            <label class="toggle-checkbox">
              <input type="checkbox" v-model="form.is_active" />
              <span>Jadwal Praktik Aktif di Website</span>
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
import { ref, reactive, onMounted } from 'vue'
import AdminLayout from '../../layouts/AdminLayout.vue'
import api from '../../services/api'

const team = ref([])
const loading = ref(true)
const showModal = ref(false)
const isEditModal = ref(false)
const isSaving = ref(false)
const currentMemberId = ref(null)
const certInput = ref('')

const form = reactive({
  name: '',
  role: '',
  specialization: '',
  bio: '',
  experience_years: '3+ Tahun',
  image: '',
  is_active: true,
  order: 0,
})

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

function openCreateModal() {
  isEditModal.value = false
  currentMemberId.value = null
  form.name = ''
  form.role = ''
  form.specialization = ''
  form.bio = ''
  form.experience_years = '3+ Tahun'
  form.image = 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=300'
  form.is_active = true
  form.order = team.value.length + 1
  certInput.value = ''
  showModal.value = true
}

function openEditModal(member) {
  isEditModal.value = true
  currentMemberId.value = member.id
  form.name = member.name
  form.role = member.role
  form.specialization = member.specialization
  form.bio = member.bio || ''
  form.experience_years = member.experience_years || ''
  form.image = member.image || ''
  form.is_active = !!member.is_active
  form.order = member.order || 0
  certInput.value = Array.isArray(member.certifications) ? member.certifications.join(', ') : ''
  showModal.value = true
}

function closeModal() {
  showModal.value = false
}

async function saveMember() {
  isSaving.value = true
  const certs = certInput.value
    ? certInput.value.split(',').map(s => s.trim()).filter(Boolean)
    : []

  const payload = {
    ...form,
    certifications: certs,
  }

  try {
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
</script>

<style scoped>
.page-top-bar {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 1.5rem;
  margin-bottom: 2rem;
}

.meta-tag {
  display: inline-block;
  background: rgba(204, 239, 142, 0.4);
  color: #354e00;
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
}

.page-subheading {
  font-size: 0.9375rem;
  color: var(--on-surface-variant, #40484d);
  max-width: 650px;
  margin-top: 0.25rem;
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
  border: none;
  cursor: pointer;
  box-shadow: 0 4px 12px rgba(0, 99, 132, 0.25);
  transition: all 0.2s;
  white-space: nowrap;
}

.btn-create:hover {
  background: var(--primary-container, #2e7c9e);
  transform: translateY(-2px);
}

.team-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
  gap: 1.75rem;
}

.member-card {
  background: #ffffff;
  border-radius: 20px;
  border: 1px solid rgba(191, 200, 206, 0.4);
  box-shadow: 0 4px 12px rgba(43, 61, 79, 0.04);
  overflow: hidden;
  display: flex;
  flex-direction: column;
}

.member-card-top {
  position: relative;
  height: 220px;
  background: var(--surface-container-low, #edf4ff);
}

.member-photo {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.member-status-chip {
  position: absolute;
  top: 1rem;
  right: 1rem;
  padding: 0.25rem 0.65rem;
  border-radius: 9999px;
  font-size: 0.6875rem;
  font-weight: 700;
}

.active-chip {
  background: rgba(204, 239, 142, 0.9);
  color: #354e00;
}

.inactive-chip {
  background: rgba(255, 255, 255, 0.85);
  color: #70787e;
}

.member-body {
  padding: 1.25rem;
  flex: 1;
}

.member-name {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 1.125rem;
  font-weight: 700;
  color: var(--on-surface, #091d2e);
  line-height: 1.3;
}

.member-role {
  font-size: 0.8125rem;
  font-weight: 600;
  color: var(--primary, #006384);
  margin-top: 0.2rem;
}

.member-spec {
  display: flex;
  align-items: center;
  gap: 0.35rem;
  font-size: 0.75rem;
  color: var(--secondary, #4b6716);
  font-weight: 600;
  margin: 0.5rem 0 0.75rem 0;
}

.member-bio {
  font-size: 0.8125rem;
  color: var(--on-surface-variant, #40484d);
  line-height: 1.5;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.member-certs {
  display: flex;
  flex-wrap: wrap;
  gap: 0.35rem;
  margin-top: 0.75rem;
}

.cert-pill {
  font-size: 0.6875rem;
  background: var(--surface-container-low, #edf4ff);
  padding: 0.2rem 0.5rem;
  border-radius: 6px;
  color: var(--primary, #006384);
  font-weight: 600;
}

.member-footer {
  padding: 1rem 1.25rem;
  background: var(--surface-bright, #f7f9ff);
  border-top: 1px solid rgba(191, 200, 206, 0.3);
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.exp-text {
  font-size: 0.75rem;
  color: var(--on-surface-variant, #40484d);
}

.member-actions {
  display: flex;
  gap: 0.35rem;
}

.btn-icon {
  background: #ffffff;
  border: 1px solid rgba(191, 200, 206, 0.4);
  padding: 0.35rem;
  border-radius: 8px;
  cursor: pointer;
  color: var(--on-surface-variant, #40484d);
  display: flex;
}

.btn-icon:hover {
  color: var(--primary, #006384);
  background: var(--surface-container-low, #edf4ff);
}

.btn-delete:hover {
  color: var(--error, #ba1a1a);
  background: #ffdad6;
}

/* Modal */
.modal-backdrop {
  position: fixed;
  inset: 0;
  background: rgba(9, 29, 46, 0.6);
  backdrop-filter: blur(4px);
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
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
}

.modal-header {
  padding: 1.25rem 1.75rem;
  border-bottom: 1px solid rgba(191, 200, 206, 0.3);
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.modal-title {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 1.25rem;
  font-weight: 700;
}

.modal-close-btn {
  background: none;
  border: none;
  cursor: pointer;
  color: var(--outline, #70787e);
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

.form-group label {
  display: block;
  font-size: 0.8125rem;
  font-weight: 700;
  margin-bottom: 0.35rem;
}

.req { color: var(--error, #ba1a1a); }

.form-input, .form-textarea {
  width: 100%;
  padding: 0.65rem 0.875rem;
  border-radius: 10px;
  border: 1px solid rgba(191, 200, 206, 0.6);
  background: var(--surface-bright, #f7f9ff);
  font-family: inherit;
  font-size: 0.875rem;
}

.form-input:focus, .form-textarea:focus {
  outline: none;
  border-color: var(--primary, #006384);
  background: #ffffff;
}

.toggle-checkbox {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  cursor: pointer;
  font-size: 0.875rem;
  font-weight: 600;
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
  padding: 0.6rem 1.25rem;
  border-radius: 9999px;
  border: 1px solid rgba(191, 200, 206, 0.6);
  background: #ffffff;
  cursor: pointer;
  font-weight: 700;
}

.btn-primary {
  padding: 0.6rem 1.5rem;
  border-radius: 9999px;
  border: none;
  background: var(--primary, #006384);
  color: #ffffff;
  cursor: pointer;
  font-weight: 700;
}

.loading-state, .empty-state {
  text-align: center;
  padding: 4rem 1rem;
  color: var(--on-surface-variant, #40484d);
}

.empty-icon {
  font-size: 3rem;
  color: var(--outline, #70787e);
}
</style>
