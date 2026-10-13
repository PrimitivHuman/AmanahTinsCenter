<template>
  <AdminLayout title="Pengaturan Klinik">
    <!-- Header Row -->
    <div class="page-top-bar">
      <div>
        <div class="meta-tag">Konfigurasi & Profil Publik</div>
        <h1 class="page-heading">Pengaturan & Informasi Klinik</h1>
        <p class="page-subheading">
          Kelola kontak WhatsApp pendaftaran, jam operasional, alamat lengkap, dan profil resmi Amanah Tin's Center.
        </p>
      </div>

      <div class="top-actions">
        <button
          type="button"
          @click="saveSettings"
          class="btn-primary"
          :disabled="isSaving"
        >
          <span v-if="isSaving" class="spinner-small"></span>
          <span v-else class="flex-btn">
            <span class="material-symbols-outlined text-lg">save</span>
            <span>Simpan Semua Pengaturan</span>
          </span>
        </button>
      </div>
    </div>

    <!-- Loading -->
    <div v-if="loading" class="loading-state">
      <div class="spinner-small"></div>
      <span>Memuat pengaturan klinik...</span>
    </div>

    <!-- Form Sections -->
    <form v-else @submit.prevent="saveSettings" class="settings-grid">
      <!-- Left Column: Form Details -->
      <div class="main-column">
        <!-- Bagian 1: Identitas Klinik -->
        <div class="card-box">
          <div class="card-header">
            <div class="header-icon teal-bg">
              <span class="material-symbols-outlined">apartment</span>
            </div>
            <div>
              <h2 class="card-title">Bagian 1: Identitas Dasar Klinik</h2>
              <p class="card-sub">Nama resmi dan tagline yang ditampilkan pada situs publik.</p>
            </div>
          </div>

          <div class="form-group">
            <label>Nama Klinik <span class="req">*</span></label>
            <input v-model="form.clinic_name" type="text" required class="form-input" />
          </div>

          <div class="form-group">
            <label>Tagline / Slogan Klinik</label>
            <input v-model="form.tagline" type="text" class="form-input" />
          </div>

          <div class="form-group">
            <label>Ringkasan Profil Klinik</label>
            <textarea v-model="form.about_summary" rows="3" class="form-textarea"></textarea>
          </div>
        </div>

        <!-- Bagian 2: Kontak & WhatsApp -->
        <div class="card-box">
          <div class="card-header">
            <div class="header-icon green-bg">
              <span class="material-symbols-outlined">chat</span>
            </div>
            <div>
              <h2 class="card-title">Bagian 2: Kontak & Tautan WhatsApp</h2>
              <p class="card-sub">Nomor WhatsApp tujuan untuk floating button dan form pendaftaran.</p>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group flex-1">
              <label>Nomor WhatsApp (Format: 628xxxx) <span class="req">*</span></label>
              <input v-model="form.whatsapp" type="text" required placeholder="6282188899900" class="form-input" />
            </div>
            <div class="form-group flex-1">
              <label>Telepon Kantor / Klinik</label>
              <input v-model="form.phone" type="text" placeholder="+62 717 9101234" class="form-input" />
            </div>
          </div>

          <div class="form-group">
            <label>Email Resmi Klinik</label>
            <input v-model="form.email" type="email" placeholder="info@amanahtinscenter.com" class="form-input" />
          </div>

          <div class="form-group">
            <label>Alamat Lengkap</label>
            <textarea v-model="form.address" rows="2" class="form-textarea"></textarea>
          </div>

          <div class="form-group">
            <label>URL Google Maps</label>
            <input v-model="form.maps_url" type="url" placeholder="https://maps.google.com/?q=..." class="form-input" />
          </div>
        </div>

        <!-- Bagian 3: Jam Operasional -->
        <div class="card-box">
          <div class="card-header">
            <div class="header-icon blue-bg">
              <span class="material-symbols-outlined">schedule</span>
            </div>
            <div>
              <h2 class="card-title">Bagian 3: Jam Operasional & Layanan</h2>
              <p class="card-sub">Jadwal buka klinik untuk panduan kunjungan orang tua.</p>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group flex-1">
              <label>Hari Kerja (Senin - Jumat)</label>
              <input v-model="form.weekday_hours" type="text" placeholder="Senin - Jumat: 08:00 - 17:00 WIB" class="form-input" />
            </div>
            <div class="form-group flex-1">
              <label>Akhir Pekan (Sabtu / Minggu)</label>
              <input v-model="form.weekend_hours" type="text" placeholder="Sabtu: 08:00 - 15:00, Minggu: Tutup" class="form-input" />
            </div>
          </div>
        </div>

        <!-- Bagian 4: Media Sosial -->
        <div class="card-box">
          <div class="card-header">
            <div class="header-icon amber-bg">
              <span class="material-symbols-outlined">share</span>
            </div>
            <div>
              <h2 class="card-title">Bagian 4: Tautan Media Sosial</h2>
              <p class="card-sub">Kanal informasi dan edukasi media sosial resmi.</p>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group flex-1">
              <label>Instagram</label>
              <input v-model="form.instagram" type="text" placeholder="@amanahtinscenter" class="form-input" />
            </div>
            <div class="form-group flex-1">
              <label>Facebook</label>
              <input v-model="form.facebook" type="text" placeholder="Amanah Tins Center" class="form-input" />
            </div>
          </div>

          <div class="form-group">
            <label>YouTube</label>
            <input v-model="form.youtube" type="text" placeholder="Amanah Tins Center Official" class="form-input" />
          </div>
        </div>
      </div>

      <!-- Right Column: Live Summary Card -->
      <div class="sidebar-column">
        <div class="card-box sticky-card">
          <h3 class="card-title mb-3">Ringkasan Kontak Publik</h3>
          <div class="preview-item">
            <span class="p-label">WhatsApp:</span>
            <span class="p-value highlight">{{ form.whatsapp || '-' }}</span>
          </div>
          <div class="preview-item">
            <span class="p-label">Telepon:</span>
            <span class="p-value">{{ form.phone || '-' }}</span>
          </div>
          <div class="preview-item">
            <span class="p-label">Email:</span>
            <span class="p-value">{{ form.email || '-' }}</span>
          </div>
          <div class="preview-item">
            <span class="p-label">Operasional:</span>
            <span class="p-value">{{ form.weekday_hours || '-' }}</span>
          </div>
          <div class="preview-item">
            <span class="p-label">Alamat:</span>
            <span class="p-value">{{ form.address || '-' }}</span>
          </div>

          <div class="pt-4 border-t mt-4">
            <a
              :href="`https://wa.me/${form.whatsapp}`"
              target="_blank"
              class="btn-wa-preview"
            >
              <span class="material-symbols-outlined">chat</span>
              <span>Uji Coba Hubungi WhatsApp</span>
            </a>
          </div>
        </div>
      </div>
    </form>
  </AdminLayout>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import AdminLayout from '../../layouts/AdminLayout.vue'
import api from '../../services/api'

const loading = ref(true)
const isSaving = ref(false)

const form = reactive({
  clinic_name: "Amanah Tin's Center",
  tagline: '',
  about_summary: '',
  whatsapp: '6282188899900',
  phone: '+62 717 9101234',
  email: 'admin@amanahtinscenter.com',
  address: '',
  maps_url: '',
  weekday_hours: 'Senin - Jumat: 08:00 - 17:00 WIB',
  weekend_hours: 'Sabtu: 08:00 - 15:00 WIB',
  instagram: '',
  facebook: '',
  youtube: '',
})

async function fetchSettings() {
  loading.value = true
  try {
    const res = await api.get('/settings')
    if (res.data) {
      Object.assign(form, res.data)
    }
  } catch (err) {
    console.error('Error fetching settings', err)
  } finally {
    loading.value = false
  }
}

async function saveSettings() {
  isSaving.value = true
  try {
    await api.put('/admin/settings', form)
    alert('Pengaturan klinik berhasil diperbarui!')
  } catch (err) {
    alert('Gagal menyimpan pengaturan.')
  } finally {
    isSaving.value = false
  }
}

onMounted(() => {
  fetchSettings()
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
}

.page-subheading {
  font-size: 0.9375rem;
  color: var(--on-surface-variant, #40484d);
  max-width: 650px;
  margin-top: 0.25rem;
}

.btn-primary {
  padding: 0.75rem 1.75rem;
  border-radius: 9999px;
  border: none;
  background: var(--primary, #006384);
  color: #ffffff;
  font-weight: 700;
  cursor: pointer;
  font-size: 0.9375rem;
  box-shadow: 0 4px 12px rgba(0, 99, 132, 0.25);
  transition: all 0.2s;
}

.btn-primary:hover:not(:disabled) {
  background: var(--primary-container, #2e7c9e);
  transform: translateY(-2px);
}

.flex-btn {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.settings-grid {
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

.card-header {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding-bottom: 1.25rem;
  border-bottom: 1px solid rgba(191, 200, 206, 0.3);
  margin-bottom: 1.25rem;
}

.header-icon {
  width: 44px;
  height: 44px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.teal-bg { background: #c1e8ff; color: #006384; }
.green-bg { background: #ccef8e; color: #4b6716; }
.blue-bg { background: #d9eaff; color: #004d67; }
.amber-bg { background: #ffdcbf; color: #884e03; }

.card-title {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 1.125rem;
  font-weight: 700;
  color: var(--on-surface, #091d2e);
}

.card-sub {
  font-size: 0.8125rem;
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
  color: var(--on-surface, #091d2e);
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
  color: var(--on-surface, #091d2e);
}

.form-input:focus, .form-textarea:focus {
  outline: none;
  border-color: var(--primary, #006384);
  background: #ffffff;
}

.sticky-card {
  position: sticky;
  top: 5.5rem;
}

.preview-item {
  display: flex;
  flex-direction: column;
  margin-bottom: 0.75rem;
  font-size: 0.8125rem;
}

.p-label {
  color: var(--outline, #70787e);
  font-size: 0.75rem;
  font-weight: 600;
}

.p-value {
  color: var(--on-surface, #091d2e);
  font-weight: 600;
}

.highlight {
  color: #128c7e;
  font-weight: 700;
}

.btn-wa-preview {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  background: #128c7e;
  color: #ffffff;
  padding: 0.65rem 1rem;
  border-radius: 9999px;
  text-decoration: none;
  font-size: 0.8125rem;
  font-weight: 700;
}

.loading-state {
  text-align: center;
  padding: 4rem 1rem;
  color: var(--on-surface-variant, #40484d);
}

/* ============================================================
   BOX-SIZING FIX — Ensure inputs don't overflow cards
   ============================================================ */
.form-input, .form-textarea {
  box-sizing: border-box;
}

/* ============================================================
   RESPONSIVE: TABLET  (≤ 900px)
   ============================================================ */
@media (max-width: 900px) {
  .settings-grid {
    grid-template-columns: 1fr;
  }

  /* Sidebar summary card: stop sticking, reorder to bottom */
  .sidebar-column {
    order: 2;
  }

  .sticky-card {
    position: static;
  }

  .page-heading {
    font-size: 1.5rem;
  }

  .page-subheading {
    font-size: 0.875rem;
  }

  .card-box {
    padding: 1.25rem;
    border-radius: 16px;
  }
}

/* ============================================================
   RESPONSIVE: MOBILE  (≤ 600px)
   ============================================================ */
@media (max-width: 600px) {
  /* Header bar: stack vertically */
  .page-top-bar {
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 1.25rem;
  }

  .top-actions {
    width: 100%;
  }

  .btn-primary {
    width: 100%;
    justify-content: center;
    display: flex;
    padding: 0.875rem 1rem;
    font-size: 0.875rem;
  }

  .flex-btn {
    justify-content: center;
    width: 100%;
  }

  .page-heading {
    font-size: 1.25rem;
    line-height: 1.3;
  }

  .page-subheading {
    font-size: 0.8125rem;
    line-height: 1.5;
  }

  .meta-tag {
    font-size: 0.6875rem;
    padding: 0.15rem 0.5rem;
  }

  /* Form rows: stack on mobile */
  .form-row {
    flex-direction: column;
    gap: 0;
  }

  .form-row .flex-1 {
    flex: unset;
    width: 100%;
  }

  /* Card boxes: tighter on mobile */
  .card-box {
    padding: 1rem;
    border-radius: 14px;
    margin-bottom: 1rem;
  }

  .card-header {
    gap: 0.75rem;
    padding-bottom: 0.875rem;
    margin-bottom: 1rem;
  }

  .header-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
  }

  .header-icon .material-symbols-outlined {
    font-size: 20px;
  }

  .card-title {
    font-size: 1rem;
  }

  .card-sub {
    font-size: 0.75rem;
  }

  /* Form spacing */
  .form-group {
    margin-bottom: 1rem;
  }

  .form-group label {
    font-size: 0.75rem;
    margin-bottom: 0.3rem;
  }

  .form-input, .form-textarea {
    padding: 0.6rem 0.75rem;
    font-size: 0.8125rem;
    border-radius: 8px;
  }

  /* Settings grid gap */
  .settings-grid {
    gap: 0;
  }

  /* WhatsApp preview button */
  .btn-wa-preview {
    padding: 0.6rem 0.875rem;
    font-size: 0.75rem;
  }

  /* Preview items */
  .preview-item {
    margin-bottom: 0.6rem;
  }

  .p-label {
    font-size: 0.6875rem;
  }

  .p-value {
    font-size: 0.8125rem;
    word-break: break-all;
  }

  /* Loading state */
  .loading-state {
    padding: 2.5rem 1rem;
  }
}
</style>
