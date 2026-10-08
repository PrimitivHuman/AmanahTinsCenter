<template>
  <AdminLayout title="Janji & Pendaftaran">
    <!-- Header -->
    <div class="page-top-bar">
      <div>
        <div class="meta-tag">Registrasi & Rekam Konsultasi</div>
        <h1 class="page-heading">Kelola Janji Temu & Pendaftaran</h1>
        <p class="page-subheading">
          Daftar orang tua yang mengajukan jadwal konsultasi skrining dan terapi tumbuh kembang anak secara online.
        </p>
      </div>

      <div class="top-actions">
        <a href="/jadwal-pendaftaran" target="_blank" class="btn-create">
          <span class="material-symbols-outlined">add</span>
          <span>Buka Form Pendaftaran</span>
        </a>
      </div>
    </div>

    <!-- Filters & Search Toolbar -->
    <div class="toolbar-box">
      <div class="status-tabs">
        <button
          v-for="st in statusTabs"
          :key="st.key"
          :class="['tab-btn', { 'tab-btn-active': selectedStatus === st.key }]"
          @click="selectStatus(st.key)"
        >
          <span>{{ st.label }}</span>
        </button>
      </div>

      <div class="search-box">
        <span class="material-symbols-outlined search-icon">search</span>
        <input
          v-model="searchQuery"
          @input="debounceSearch"
          type="text"
          placeholder="Cari nama anak, orang tua, nomor HP..."
          class="search-input"
        />
      </div>
    </div>

    <!-- Appointments Table Card -->
    <div class="table-card">
      <div v-if="loading" class="loading-state">
        <div class="spinner-small"></div>
        <span>Memuat data janji temu...</span>
      </div>

      <div v-else-if="appointments.length === 0" class="empty-state">
        <span class="material-symbols-outlined empty-icon">event_busy</span>
        <p>Belum ada data pendaftaran janji temu.</p>
      </div>

      <div v-else class="table-responsive">
        <table class="schedule-table">
          <thead>
            <tr>
              <th>Anak & Usia</th>
              <th>Orang Tua / Kontak</th>
              <th>Pilihan Layanan</th>
              <th>Jadwal Diminta</th>
              <th>Status</th>
              <th>Catatan Admin</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in appointments" :key="item.id">
              <td>
                <div class="child-info">
                  <span class="child-name">{{ item.child_name }}</span>
                  <span class="child-age">Usia: {{ item.child_age || 'Belum diisi' }}</span>
                </div>
              </td>
              <td>
                <div class="contact-info">
                  <span class="parent-name">{{ item.parent_name }}</span>
                  <div class="contact-links">
                    <span class="phone-text">{{ item.phone }}</span>
                    <a
                      :href="`https://wa.me/${cleanPhone(item.phone)}?text=Halo%20Bapak%2FIbu%20${encodeURIComponent(item.parent_name)}%2C%20kami%20dari%20Amanah%20Tin's%20Center%20mengenai%20jadwal%20terapi%20${encodeURIComponent(item.child_name)}.`"
                      target="_blank"
                      class="wa-link"
                      title="Kirim Pesan WhatsApp"
                    >
                      <span class="material-symbols-outlined text-sm">chat</span>
                    </a>
                  </div>
                </div>
              </td>
              <td>
                <span class="service-chip">{{ item.service_type }}</span>
                <p v-if="item.notes" class="user-notes-text" :title="item.notes">
                  "{{ item.notes }}"
                </p>
              </td>
              <td>
                <div class="date-time-box">
                  <span class="date-text">{{ formatDate(item.preferred_date) }}</span>
                  <span class="time-text">{{ item.preferred_time || 'Fleksibel' }}</span>
                </div>
              </td>
              <td>
                <span :class="['status-chip', getStatusClass(item.status)]">
                  {{ getStatusLabel(item.status) }}
                </span>
              </td>
              <td>
                <span class="admin-notes">{{ item.admin_notes || '-' }}</span>
              </td>
              <td>
                <div class="actions-flex">
                  <button @click="openEditModal(item)" class="action-btn" title="Ubah Status & Catatan">
                    <span class="material-symbols-outlined">edit_calendar</span>
                  </button>
                  <button @click="deleteAppointment(item)" class="action-btn delete-btn" title="Hapus Data">
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
          Menampilkan {{ pagination.from }}-{{ pagination.to }} dari {{ pagination.total }} data
        </span>
        <div class="pagination-nav">
          <button
            :disabled="pagination.current_page === 1"
            @click="fetchAppointments(pagination.current_page - 1)"
            class="page-btn"
          >
            Sebelumnya
          </button>
          <span class="page-num">Halaman {{ pagination.current_page }} dari {{ pagination.last_page }}</span>
          <button
            :disabled="pagination.current_page === pagination.last_page"
            @click="fetchAppointments(pagination.current_page + 1)"
            class="page-btn"
          >
            Berikutnya
          </button>
        </div>
      </div>
    </div>

    <!-- Modal Update Janji Temu -->
    <div v-if="showModal" class="modal-backdrop" @click.self="closeModal">
      <div class="modal-card">
        <div class="modal-header">
          <h2 class="modal-title">Perbarui Status & Jadwal Konsultasi</h2>
          <button @click="closeModal" class="modal-close-btn">
            <span class="material-symbols-outlined">close</span>
          </button>
        </div>

        <form @submit.prevent="updateAppointment" class="modal-body">
          <div class="patient-summary-box">
            <div>
              <strong>{{ currentItem?.child_name }}</strong> ({{ currentItem?.child_age }})
            </div>
            <div class="text-sm text-sub">
              Orang Tua: {{ currentItem?.parent_name }} • {{ currentItem?.phone }}
            </div>
            <div class="text-sm mt-1">
              Layanan: <strong>{{ currentItem?.service_type }}</strong>
            </div>
          </div>

          <div class="form-group">
            <label>Status Janji Temu <span class="req">*</span></label>
            <select v-model="editForm.status" class="form-select" required>
              <option value="pending">Menunggu Konfirmasi</option>
              <option value="confirmed">Dikonfirmasi (Jadwal Terkunci)</option>
              <option value="completed">Selesai (Sudah Terapi)</option>
              <option value="cancelled">Dibatalkan</option>
            </select>
          </div>

          <div class="form-row">
            <div class="form-group flex-1">
              <label>Tanggal Pelaksanaan</label>
              <input v-model="editForm.preferred_date" type="date" class="form-input" />
            </div>
            <div class="form-group flex-1">
              <label>Sesi / Waktu</label>
              <input v-model="editForm.preferred_time" type="text" placeholder="Contoh: Sesi 1 (09:00 - 10:00)" class="form-input" />
            </div>
          </div>

          <div class="form-group">
            <label>Catatan Terapis / Admin Klinik</label>
            <textarea
              v-model="editForm.admin_notes"
              rows="3"
              placeholder="Catatan hasil konfirmasi dengan orang tua, instruksi kedatangan, terapis yang ditugaskan..."
              class="form-textarea"
            ></textarea>
          </div>

          <div class="modal-footer">
            <button type="button" @click="closeModal" class="btn-secondary">Batal</button>
            <button type="submit" class="btn-primary" :disabled="isSaving">
              <span v-if="isSaving" class="spinner-small"></span>
              <span v-else>Simpan Perubahan</span>
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

const statusTabs = [
  { key: 'all', label: 'Semua Janji' },
  { key: 'pending', label: 'Menunggu' },
  { key: 'confirmed', label: 'Dikonfirmasi' },
  { key: 'completed', label: 'Selesai' },
  { key: 'cancelled', label: 'Dibatalkan' },
]

const appointments = ref([])
const selectedStatus = ref('all')
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

const showModal = ref(false)
const currentItem = ref(null)
const isSaving = ref(false)

const editForm = reactive({
  status: 'pending',
  preferred_date: '',
  preferred_time: '',
  admin_notes: '',
})

let searchTimeout = null

function selectStatus(key) {
  selectedStatus.value = key
  fetchAppointments(1)
}

function debounceSearch() {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    fetchAppointments(1)
  }, 400)
}

async function fetchAppointments(page = 1) {
  loading.value = true
  try {
    const params = {
      page,
      per_page: 10,
    }
    if (selectedStatus.value !== 'all') {
      params.status = selectedStatus.value
    }
    if (searchQuery.value.trim()) {
      params.search = searchQuery.value.trim()
    }

    const res = await api.get('/admin/appointments', { params })
    appointments.value = res.data.data || []
    pagination.value = {
      current_page: res.data.current_page,
      last_page: res.data.last_page,
      total: res.data.total,
      per_page: res.data.per_page,
      from: res.data.from || 0,
      to: res.data.to || 0,
    }
  } catch (err) {
    console.error('Error fetching appointments', err)
  } finally {
    loading.value = false
  }
}

function openEditModal(item) {
  currentItem.value = item
  editForm.status = item.status
  editForm.preferred_date = item.preferred_date ? item.preferred_date.substring(0, 10) : ''
  editForm.preferred_time = item.preferred_time || ''
  editForm.admin_notes = item.admin_notes || ''
  showModal.value = true
}

function closeModal() {
  showModal.value = false
  currentItem.value = null
}

async function updateAppointment() {
  if (!currentItem.value) return
  isSaving.value = true
  try {
    const res = await api.put(`/admin/appointments/${currentItem.value.id}`, editForm)
    const idx = appointments.value.findIndex(a => a.id === currentItem.value.id)
    if (idx !== -1) appointments.value[idx] = res.data.data
    alert('Status janji temu berhasil diperbarui!')
    closeModal()
  } catch (err) {
    alert('Gagal memperbarui status janji temu.')
  } finally {
    isSaving.value = false
  }
}

async function deleteAppointment(item) {
  if (confirm(`Yakin ingin menghapus pendaftaran untuk ananda "${item.child_name}"?`)) {
    try {
      await api.delete(`/admin/appointments/${item.id}`)
      appointments.value = appointments.value.filter(a => a.id !== item.id)
      pagination.value.total -= 1
    } catch (err) {
      alert('Gagal menghapus janji temu.')
    }
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
  fetchAppointments(1)
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

.status-tabs {
  display: flex;
  gap: 0.5rem;
  flex-wrap: wrap;
}

.tab-btn {
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

.tab-btn:hover {
  background: var(--surface-container-low, #edf4ff);
  color: var(--primary, #006384);
}

.tab-btn-active {
  background: var(--primary, #006384) !important;
  color: #ffffff !important;
  border-color: var(--primary, #006384) !important;
}

.search-box {
  position: relative;
  min-width: 300px;
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

.schedule-table {
  width: 100%;
  border-collapse: collapse;
  text-align: left;
}

.schedule-table th {
  padding: 0.875rem 1.25rem;
  background: var(--surface-container-low, #edf4ff);
  font-size: 0.75rem;
  font-weight: 700;
  color: var(--on-surface-variant, #40484d);
  text-transform: uppercase;
  letter-spacing: 0.03em;
  border-bottom: 1px solid rgba(191, 200, 206, 0.4);
}

.schedule-table td {
  padding: 1.25rem;
  border-bottom: 1px solid rgba(191, 200, 206, 0.25);
  vertical-align: middle;
}

.child-name {
  font-weight: 700;
  color: var(--on-surface, #091d2e);
  display: block;
}

.child-age {
  font-size: 0.75rem;
  color: var(--on-surface-variant, #40484d);
}

.parent-name {
  font-weight: 600;
  color: var(--on-surface, #091d2e);
  font-size: 0.875rem;
  display: block;
}

.contact-links {
  display: flex;
  align-items: center;
  gap: 0.35rem;
  margin-top: 0.15rem;
}

.phone-text {
  font-size: 0.75rem;
  color: var(--outline, #70787e);
}

.wa-link {
  color: #128c7e;
  text-decoration: none;
  display: flex;
}

.service-chip {
  display: inline-block;
  padding: 0.2rem 0.6rem;
  border-radius: 6px;
  background: var(--surface-container, #e3efff);
  color: var(--primary, #006384);
  font-size: 0.75rem;
  font-weight: 700;
}

.user-notes-text {
  font-size: 0.6875rem;
  color: var(--outline, #70787e);
  font-style: italic;
  margin-top: 0.25rem;
  max-width: 220px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.date-time-box {
  display: flex;
  flex-direction: column;
}

.date-text {
  font-weight: 700;
  font-size: 0.8125rem;
  color: var(--on-surface, #091d2e);
}

.time-text {
  font-size: 0.75rem;
  color: var(--on-surface-variant, #40484d);
}

.status-chip {
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

.admin-notes {
  font-size: 0.75rem;
  color: var(--on-surface-variant, #40484d);
  max-width: 180px;
  display: block;
}

.actions-flex {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.action-btn {
  background: none;
  border: 1px solid rgba(191, 200, 206, 0.4);
  color: var(--on-surface-variant, #40484d);
  padding: 0.4rem;
  border-radius: 8px;
  display: flex;
  cursor: pointer;
  transition: all 0.2s;
}

.action-btn:hover {
  background: var(--surface-container-low, #edf4ff);
  color: var(--primary, #006384);
}

.delete-btn:hover {
  background: #ffdad6;
  color: #ba1a1a;
  border-color: #ffdad6;
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
}

.page-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
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
  max-width: 540px;
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

.patient-summary-box {
  background: var(--surface-container-low, #edf4ff);
  padding: 1rem;
  border-radius: 12px;
  margin-bottom: 1.25rem;
}

.text-sub {
  color: var(--on-surface-variant, #40484d);
}

.form-group {
  margin-bottom: 1.25rem;
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

.form-input, .form-textarea, .form-select {
  width: 100%;
  padding: 0.65rem 0.875rem;
  border-radius: 10px;
  border: 1px solid rgba(191, 200, 206, 0.6);
  background: var(--surface-bright, #f7f9ff);
  font-family: inherit;
  font-size: 0.875rem;
}

.form-input:focus, .form-textarea:focus, .form-select:focus {
  outline: none;
  border-color: var(--primary, #006384);
  background: #ffffff;
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
