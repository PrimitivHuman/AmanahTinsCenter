<template>
  <AdminLayout :title="isEdit ? 'Edit Artikel' : 'Tulis Artikel Baru'">
    <!-- Top Bar Navigation & Actions -->
    <div class="page-top-bar">
      <div class="top-title-group">
        <router-link to="/admin/artikel" class="back-link">
          <span class="material-symbols-outlined back-icon">arrow_back</span>
          <span>Kembali ke Daftar Artikel</span>
        </router-link>
        <div class="heading-row">
          <h1 class="page-heading">
            {{ isEdit ? 'Perbarui Artikel Edukasi' : 'Tulis Artikel Edukasi Baru' }}
          </h1>
          <span :class="['mode-badge', form.is_published ? 'badge-published' : 'badge-draft']">
            {{ form.is_published ? 'Tayang Publik' : 'Draf Tersimpan' }}
          </span>
        </div>
        <p class="page-subheading">
          Tulis panduan tumbuh kembang terpercaya untuk orang tua. Artikel akan ditampilkan di halaman publik <strong>/artikel</strong> dan <strong>/artikel/:slug</strong>.
        </p>
      </div>

      <!-- Action Buttons -->
      <div class="top-actions">
        <!-- Tab Mode Switcher -->
        <div class="view-mode-tabs" role="tablist">
          <button
            type="button"
            :class="['mode-tab-btn', { 'mode-tab-active': activeTab === 'editor' }]"
            @click="activeTab = 'editor'"
          >
            <span class="material-symbols-outlined text-sm">edit_document</span>
            <span>Editor</span>
          </button>
          <button
            type="button"
            :class="['mode-tab-btn', { 'mode-tab-active': activeTab === 'preview' }]"
            @click="activeTab = 'preview'"
          >
            <span class="material-symbols-outlined text-sm">visibility</span>
            <span>Pratinjau Publik</span>
          </button>
        </div>

        <a
          v-if="isEdit && form.slug"
          :href="`/artikel/${form.slug}`"
          target="_blank"
          class="btn-public-link"
          title="Buka Halaman Publik di Tab Baru"
        >
          <span class="material-symbols-outlined text-sm">open_in_new</span>
          <span class="btn-text-desktop">Halaman Publik</span>
        </a>

        <button
          type="button"
          @click="submitForm(false)"
          class="btn-secondary"
          :disabled="isSubmitting"
          title="Simpan sebagai draf (belum tayang ke orang tua)"
        >
          <span>Simpan Draf</span>
        </button>

        <button
          type="button"
          @click="submitForm(true)"
          class="btn-primary"
          :disabled="isSubmitting"
          title="Simpan dan terbitkan artikel ke website utama"
        >
          <span v-if="isSubmitting" class="spinner-small"></span>
          <span v-else>{{ isEdit ? 'Simpan & Publikasikan' : 'Terbitkan Sekarang' }}</span>
        </button>
      </div>
    </div>

    <!-- TAB 1: FORMULIR EDITOR -->
    <div v-show="activeTab === 'editor'" class="form-grid">
      <!-- Kolom Kiri: Konten Utama Artikel -->
      <div class="main-column">
        <!-- Card 1: Judul, Slug & Excerpt -->
        <div class="card-box">
          <div class="form-group">
            <div class="label-row">
              <label for="title">Judul Artikel Edukasi <span class="req">*</span></label>
              <span class="char-count">{{ form.title.length }}/200</span>
            </div>
            <input
              id="title"
              v-model="form.title"
              @input="onTitleInput"
              type="text"
              required
              maxlength="200"
              placeholder="Contoh: Mengenal Tanda Speech Delay pada Balita Usia 1-3 Tahun"
              class="form-input text-lg font-bold"
            />
          </div>

          <!-- URL Slug Preview & Edit -->
          <div class="slug-preview-row">
            <span class="material-symbols-outlined slug-icon">link</span>
            <span class="slug-prefix">atc.id/artikel/</span>
            <input
              v-model="form.slug"
              type="text"
              placeholder="slug-artikel"
              class="slug-input"
            />
            <button
              type="button"
              @click="generateSlug"
              class="btn-slug-regen"
              title="Perbarui slug otomatis dari judul"
            >
              <span class="material-symbols-outlined text-sm">refresh</span>
            </button>
          </div>

          <!-- Excerpt / Paragraf Pembuka -->
          <div class="form-group mt-4">
            <div class="label-row">
              <label for="excerpt">
                Paragraf Pembuka / Excerpt Ringkas
                <span class="label-tip">(Tampil sebagai kartu di katalog &amp; lead-card berbingkai di awal artikel)</span>
              </label>
              <span class="char-count">{{ form.excerpt.length }}/350</span>
            </div>
            <textarea
              id="excerpt"
              v-model="form.excerpt"
              rows="3"
              maxlength="350"
              placeholder="Ketahui tonggak capaian bicara dan bahasa anak serta tanda bahaya (red flags) yang memerlukan evaluasi terapis wicara profesional sejak dini..."
              class="form-textarea lead-textarea"
            ></textarea>
          </div>
        </div>

        <!-- Card 2: Isi Lengkap Artikel dengan Rich Toolbar -->
        <div class="card-box">
          <div class="editor-header">
            <label for="content">Isi Lengkap Artikel (Mendukung Format Publik ATC) <span class="req">*</span></label>
            <div class="editor-stats">
              <span>{{ wordCount }} Kata</span>
              <span class="stat-sep">•</span>
              <span>{{ form.content.length }} Karakter</span>
            </div>
          </div>

          <!-- Rich Formatting Toolbar -->
          <div class="editor-toolbar" role="toolbar" aria-label="Alat format teks artikel">
            <button type="button" @click="insertHeading(2)" class="tb-btn" title="Heading 2 (Judul Bagian)">
              <strong>H2</strong>
            </button>
            <button type="button" @click="insertHeading(3)" class="tb-btn" title="Heading 3 (Sub-bagian)">
              <strong>H3</strong>
            </button>
            <div class="tb-divider"></div>
            <button type="button" @click="wrapSelection('strong')" class="tb-btn" title="Tebal (Bold)">
              <span class="material-symbols-outlined">format_bold</span>
            </button>
            <button type="button" @click="wrapSelection('em')" class="tb-btn" title="Miring (Italic)">
              <span class="material-symbols-outlined">format_italic</span>
            </button>
            <button type="button" @click="wrapSelection('u')" class="tb-btn" title="Garis Bawah (Underline)">
              <span class="material-symbols-outlined">format_underlined</span>
            </button>
            <div class="tb-divider"></div>
            <button type="button" @click="insertParagraph" class="tb-btn" title="Paragraf Baru">
              <span class="material-symbols-outlined">format_paragraph</span>
            </button>
            <button type="button" @click="insertList('ul')" class="tb-btn" title="Daftar Poin (Bullet List)">
              <span class="material-symbols-outlined">format_list_bulleted</span>
            </button>
            <button type="button" @click="insertList('ol')" class="tb-btn" title="Daftar Angka (Numbered List)">
              <span class="material-symbols-outlined">format_list_numbered</span>
            </button>
            <div class="tb-divider"></div>
            <button type="button" @click="insertCallout" class="tb-btn tb-btn-highlight" title="Kotak Sorotan / Catatan Medis (Callout Box)">
              <span class="material-symbols-outlined">lightbulb</span>
              <span class="tb-label">Kotak Sorotan</span>
            </button>
            <button type="button" @click="insertQuote" class="tb-btn" title="Kutipan Penting (Blockquote)">
              <span class="material-symbols-outlined">format_quote</span>
            </button>
            <button type="button" @click="insertLink" class="tb-btn" title="Sisipkan Tautan Web">
              <span class="material-symbols-outlined">link</span>
            </button>
            <button type="button" @click="insertDivider" class="tb-btn" title="Garis Pembatas Horizontal">
              <span class="material-symbols-outlined">horizontal_rule</span>
            </button>
          </div>

          <textarea
            id="content"
            ref="contentArea"
            v-model="form.content"
            rows="18"
            required
            placeholder="Tuliskan isi artikel lengkap di sini. Gunakan tombol toolbar di atas untuk menyisipkan judul bagian (H2), sub-bagian (H3), kotak sorotan, atau daftar poin..."
            class="form-textarea font-editorial"
          ></textarea>

          <!-- Footer Editor Toolbar -->
          <div class="editor-footer-bar">
            <div class="editor-shortcuts-tip">
              <span class="material-symbols-outlined tip-icon">help</span>
              <span>Gunakan H2 untuk bab utama artikel, dan Kotak Sorotan untuk tips klinis terapis.</span>
            </div>
            <button
              type="button"
              @click="autoCalculateReadTime"
              class="btn-calc-time"
              title="Hitung estimasi waktu baca otomatis dari jumlah kata"
            >
              <span class="material-symbols-outlined text-sm">schedule</span>
              <span>Hitung Waktu Baca Otomatis</span>
            </button>
          </div>
        </div>
      </div>

      <!-- Kolom Kanan: Metadata, Kategori, Penulis, & Sampul -->
      <div class="sidebar-column">
        <!-- 1. Status Publikasi Card -->
        <div class="card-box">
          <h3 class="card-title">Status Publikasi</h3>
          <div class="publish-switch-card">
            <label class="switch-container">
              <input type="checkbox" v-model="form.is_published" />
              <span class="switch-slider"></span>
            </label>
            <div class="switch-info">
              <strong class="switch-title">
                {{ form.is_published ? 'Publikasikan Terbuka' : 'Simpan sebagai Draf' }}
              </strong>
              <p class="switch-desc">
                {{ form.is_published ? 'Dapat diakses dan dibaca oleh semua orang tua di website.' : 'Hanya tersimpan di panel admin untuk ditinjau lebih lanjut.' }}
              </p>
            </div>
          </div>
        </div>

        <!-- 2. Detail Kategori & Waktu Baca -->
        <div class="card-box">
          <h3 class="card-title">Detail Meta &amp; Kategori</h3>

          <!-- Kategori Terapi -->
          <div class="form-group">
            <label for="category">Kategori Terapi <span class="req">*</span></label>
            <select id="category" v-model="form.category" class="form-select" required>
              <option v-for="cat in ARTICLE_CATEGORIES" :key="cat.value" :value="cat.value">
                {{ cat.label }}
              </option>
            </select>
          </div>

          <!-- Penulis Artikel -->
          <div class="form-group">
            <label for="author">Nama Penulis / Tenaga Ahli</label>
            <input
              id="author"
              v-model="form.author"
              type="text"
              placeholder="Contoh: Nabila Maharani, S.Tr.Kes / dr. Raden Sarah, Sp.A"
              class="form-input"
            />
            <div class="quick-author-chips">
              <button
                type="button"
                @click="form.author = 'Tim Ahli Amanah Tin\'s Center'"
                class="author-chip"
              >
                + Tim Ahli ATC
              </button>
              <button
                type="button"
                @click="form.author = 'dr. Raden Sarah Amalia, Sp.A'"
                class="author-chip"
              >
                + dr. Sarah, Sp.A
              </button>
            </div>
          </div>

          <!-- Estimasi Waktu Baca -->
          <div class="form-group">
            <div class="label-row">
              <label for="read_time">Estimasi Waktu Baca</label>
              <button type="button" @click="autoCalculateReadTime" class="link-calc">Auto</button>
            </div>
            <div class="input-with-icon">
              <span class="material-symbols-outlined input-icon">schedule</span>
              <input
                id="read_time"
                v-model="form.read_time"
                type="text"
                placeholder="Contoh: 5 Menit Baca"
                class="form-input with-icon-input"
              />
            </div>
          </div>
        </div>

        <!-- 3. Gambar Sampul Utama (Featured Image) -->
        <div class="card-box cover-image-box">
          <div class="card-title-row">
            <h3 class="card-title">Gambar Sampul (Cover Image)</h3>
            <span class="aspect-badge">Rasio Standar 16:9</span>
          </div>
          <p class="section-help-text">
            Unggah foto berkualitas baik dari perangkat Anda. Gambar akan otomatis disesuaikan dengan rasio 16:9 agar tampil presisi dan tidak terpotong di halaman publik.
          </p>

          <!-- Input File Tersembunyi -->
          <input
            type="file"
            ref="fileInputRef"
            accept="image/jpeg,image/png,image/webp,image/gif"
            @change="handleFileSelected"
            class="hidden-file-input"
          />

          <!-- Area Dropzone Jika Belum Ada Gambar atau Sedang Ganti -->
          <div
            v-if="!form.image || showUploadDropzone"
            class="upload-dropzone"
            :class="{ 'is-dragging': isDragging, 'is-uploading': isUploading }"
            @dragover.prevent="isDragging = true"
            @dragleave.prevent="isDragging = false"
            @drop.prevent="handleFileDrop"
            @click="triggerFileInput"
          >
            <div v-if="isUploading" class="uploading-state">
              <div class="upload-spinner"></div>
              <span class="uploading-text">Mengunggah &amp; Menyesuaikan Gambar...</span>
              <span class="uploading-sub">Memproses rasio 16:9 dan menyimpan ke server ATC</span>
            </div>
            <div v-else class="dropzone-idle">
              <div class="dropzone-icon-circle">
                <span class="material-symbols-outlined">cloud_upload</span>
              </div>
              <h4 class="dropzone-title">Tarik &amp; Lepaskan Gambar di Sini</h4>
              <p class="dropzone-sub">atau <button type="button" class="btn-browse-file">Pilih Berkas dari Perangkat</button></p>
              <div class="dropzone-meta">
                <span>Format: JPG, PNG, WEBP</span>
                <span class="dot-sep">•</span>
                <span>Maks. 5 MB</span>
              </div>
            </div>
          </div>

          <!-- Pratinjau & Penyesuaian Gambar Aktif -->
          <div v-if="form.image" class="active-image-card">
            <!-- Header Kontrol Pratinjau -->
            <div class="preview-ctrl-header">
              <div class="preview-mode-tabs">
                <button
                  type="button"
                  @click="previewMode = 'detail'"
                  class="btn-mode-tab"
                  :class="{ 'is-active': previewMode === 'detail' }"
                  title="Simulasi tampilan banner hero di Halaman Detail Artikel"
                >
                  <span class="material-symbols-outlined text-sm">desktop_windows</span>
                  <span>Banner Detail</span>
                </button>
                <button
                  type="button"
                  @click="previewMode = 'card'"
                  class="btn-mode-tab"
                  :class="{ 'is-active': previewMode === 'card' }"
                  title="Simulasi tampilan kartu di Halaman Katalog Artikel"
                >
                  <span class="material-symbols-outlined text-sm">grid_view</span>
                  <span>Kartu Katalog</span>
                </button>
              </div>

              <div class="image-actions-row">
                <button
                  type="button"
                  @click="triggerFileInput"
                  class="btn-img-action btn-img-change"
                  title="Ganti dengan foto lain dari perangkat"
                >
                  <span class="material-symbols-outlined text-sm">swap_horiz</span>
                  <span>Ganti</span>
                </button>
                <button
                  type="button"
                  @click="removeCoverImage"
                  class="btn-img-action btn-img-delete"
                  title="Hapus gambar sampul"
                >
                  <span class="material-symbols-outlined text-sm">delete</span>
                </button>
              </div>
            </div>

            <!-- Frame Pratinjau Menyesuaikan dengan Apa yang Akan Ditampilkan -->
            <div
              class="fitted-preview-frame"
              :class="{
                'frame-detail-mode': previewMode === 'detail',
                'frame-card-mode': previewMode === 'card'
              }"
            >
              <img
                :src="form.image"
                alt="Pratinjau Sampul"
                :style="{ objectPosition: currentFocalPosition }"
                @error="onImgError"
              />
              <div class="frame-tag-badge">
                <span class="material-symbols-outlined text-xs">aspect_ratio</span>
                <span>{{ previewMode === 'detail' ? 'Tampilan Detail (16:9 Hero)' : 'Tampilan Kartu (16:9 Card)' }}</span>
              </div>
            </div>

            <!-- Penyesuaian Posisi Fokus (Focal Adjustment) -->
            <div class="focal-adjust-strip">
              <span class="focal-label">
                <span class="material-symbols-outlined text-sm">center_focus_strong</span>
                <span>Sesuaikan Fokus Tampilan:</span>
              </span>
              <div class="focal-buttons">
                <button
                  type="button"
                  @click="setFocalPoint('top')"
                  class="btn-focal"
                  :class="{ 'focal-active': focalPoint === 'top' }"
                  title="Fokus ke bagian atas gambar (cocok untuk wajah/orang agar kepala tidak terpotong)"
                >
                  <span class="material-symbols-outlined text-xs">arrow_upward</span>
                  <span>Atas</span>
                </button>
                <button
                  type="button"
                  @click="setFocalPoint('center')"
                  class="btn-focal"
                  :class="{ 'focal-active': focalPoint === 'center' }"
                  title="Fokus ke bagian tengah (simetris default)"
                >
                  <span class="material-symbols-outlined text-xs">radio_button_checked</span>
                  <span>Tengah</span>
                </button>
                <button
                  type="button"
                  @click="setFocalPoint('bottom')"
                  class="btn-focal"
                  :class="{ 'focal-active': focalPoint === 'bottom' }"
                  title="Fokus ke bagian bawah gambar"
                >
                  <span class="material-symbols-outlined text-xs">arrow_downward</span>
                  <span>Bawah</span>
                </button>
              </div>
            </div>

            <!-- Indikator Status Penyimpanan Server -->
            <div class="server-status-pill" v-if="isLocalUploaded">
              <span class="material-symbols-outlined status-pill-icon">verified</span>
              <span>{{ pendingCroppedBlob ? 'Pratinjau Siap (Akan diunggah saat disimpan)' : 'Tersimpan di Penyimpanan Server ATC' }}</span>
            </div>
          </div>

          <!-- Opsi Tambahan: URL Eksternal & Koleksi Cepat -->
          <div class="extra-options-accordion">
            <button
              type="button"
              @click="showAltOptions = !showAltOptions"
              class="btn-toggle-alt"
            >
              <div class="toggle-alt-left">
                <span class="material-symbols-outlined text-sm">tune</span>
                <span>Opsi Lain: Masukkan URL atau Gunakan Preset Foto</span>
              </div>
              <span class="material-symbols-outlined toggle-chevron" :class="{ 'is-rotated': showAltOptions }">
                expand_more
              </span>
            </button>

            <div v-show="showAltOptions" class="alt-options-body">
              <div class="form-group mb-2">
                <label for="image-url-input">URL Gambar Eksternal</label>
                <div class="input-with-action">
                  <input
                    id="image-url-input"
                    v-model="customUrlInput"
                    type="url"
                    placeholder="https://images.unsplash.com/..."
                    class="form-input"
                  />
                  <button type="button" @click="applyCustomUrl" class="btn-apply-url">
                    Terapkan
                  </button>
                </div>
              </div>

              <!-- Pilihan Cepat Koleksi Gambar Klinik ATC -->
              <div class="preset-images-section">
                <span class="preset-label">Pilihan Cepat Foto Bertema Terapi:</span>
                <div class="preset-grid">
                  <button
                    v-for="(preset, idx) in presetImages"
                    :key="idx"
                    type="button"
                    @click="applyPreset(preset.url)"
                    class="preset-thumb-btn"
                    :class="{ 'preset-selected': form.image === preset.url }"
                    :title="preset.label"
                  >
                    <img :src="preset.url" :alt="preset.label" />
                    <span class="preset-name">{{ preset.label }}</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- TAB 2: PRATINJAU TAMPILAN PUBLIK (LIVE PREVIEW SEPERTI HALAMAN PUBLIK) -->
    <div v-show="activeTab === 'preview'" class="public-preview-container">
      <div class="preview-banner-strip">
        <span class="material-symbols-outlined">preview</span>
        <span>Pratinjau Halaman Publik: Artikel akan ditampilkan kepada orang tua dengan tampilan di bawah ini.</span>
      </div>

      <!-- Simulasi Halaman Publik Artikel -->
      <div class="public-preview-paper">
        <!-- Breadcrumbs -->
        <div class="sim-breadcrumbs">
          <span>Beranda</span>
          <span class="sim-sep">/</span>
          <span>Artikel &amp; Tips</span>
          <span class="sim-sep">/</span>
          <span class="sim-bc-active">{{ form.title || 'Judul Artikel Anda' }}</span>
        </div>

        <!-- Badges Kategori & Waktu Baca -->
        <div class="sim-badges-row">
          <span class="sim-badge sim-badge-cat">
            <span class="material-symbols-outlined text-sm">record_voice_over</span>
            <span>{{ form.category || 'Terapi Wicara' }}</span>
          </span>
          <span class="sim-badge sim-badge-read">
            <span class="material-symbols-outlined text-sm">schedule</span>
            <span>{{ form.read_time || '5 Menit Baca' }}</span>
          </span>
          <span class="sim-badge sim-badge-tag">
            <span>Tumbuh Kembang Anak</span>
          </span>
        </div>

        <!-- Judul Headline -->
        <h1 class="sim-headline">
          {{ form.title || 'Judul Artikel Edukasi Akan Tampil di Sini' }}
        </h1>

        <!-- Meta Bar Penulis -->
        <div class="sim-meta-bar">
          <div class="sim-author-info">
            <div class="sim-avatar">
              <span class="material-symbols-outlined">person</span>
            </div>
            <div>
              <strong class="sim-author-name">{{ form.author || 'Tim Ahli Amanah Tin\'s Center' }}</strong>
              <div class="sim-author-role">Tenaga Medis &amp; Terapis Spesialis ATC</div>
            </div>
          </div>
          <div class="sim-date-info">
            <span class="material-symbols-outlined text-sm">calendar_today</span>
            <span>{{ currentFormattedDate }}</span>
          </div>
        </div>

        <!-- Featured Image Card -->
        <div class="sim-featured-frame">
          <img
            :src="form.image || 'https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?auto=format&fit=crop&q=80&w=1200'"
            :alt="form.title"
            :style="{ objectPosition: currentFocalPosition }"
          />
          <div class="sim-image-caption">
            <span class="material-symbols-outlined text-xs">photo_camera</span>
            <span>Ilustrasi materi edukasi klinis Amanah Tin's Center</span>
          </div>
        </div>

        <!-- Lead Paragraph Card -->
        <div class="sim-lead-card" v-if="form.excerpt">
          <p class="sim-lead-text">{{ form.excerpt }}</p>
        </div>

        <!-- Isi Artikel Utama -->
        <div class="sim-editorial-body" v-html="renderedContent"></div>

        <!-- CTA Box Asesmen Klinik Jagakarsa -->
        <div class="sim-cta-box">
          <div class="sim-cta-icon">
            <span class="material-symbols-outlined">medical_services</span>
          </div>
          <div class="sim-cta-content">
            <h3 class="sim-cta-title">Khawatir dengan Perkembangan Si Kecil?</h3>
            <p class="sim-cta-desc">
              Jadwalkan sesi konsultasi dan asesmen komprehensif bersama tim terapis profesional di klinik Amanah Tin's Center.
            </p>
          </div>
          <button type="button" class="sim-btn-cta">
            <span>Konsultasi via WhatsApp</span>
            <span class="material-symbols-outlined text-sm">arrow_forward</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Toast Notification -->
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
import { ref, reactive, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import AdminLayout from '../../layouts/AdminLayout.vue'
import api from '../../services/api'
import { sanitizeHtml } from '../../utils/sanitize'
import { ARTICLE_CATEGORIES } from '../../constants/categories'

const route = useRoute()
const router = useRouter()

const isEdit = computed(() => !!route.params.id)
const isSubmitting = ref(false)
const activeTab = ref('editor') // 'editor' atau 'preview'
const contentArea = ref(null)

// State Upload & Penyesuaian Gambar Sampul
const fileInputRef = ref(null)
const isDragging = ref(false)
const isUploading = ref(false)
const showUploadDropzone = ref(false)
const previewMode = ref('detail') // 'detail' (Hero) atau 'card' (Katalog)
const focalPoint = ref('center') // 'top', 'center', 'bottom'
const rawFile = ref(null)
const pendingCroppedBlob = ref(null)
const pendingPreviewUrl = ref('')
const showAltOptions = ref(false)
const customUrlInput = ref('')

const currentFocalPosition = computed(() => {
  if (focalPoint.value === 'top') return 'center top'
  if (focalPoint.value === 'bottom') return 'center bottom'
  return 'center center'
})

const isLocalUploaded = computed(() => {
  return (typeof form.image === 'string' && form.image.startsWith('/storage/')) || !!pendingCroppedBlob.value
})

// Pilihan Cepat Gambar Sampul Bertema Klinik & Terapi (Terverifikasi Aktif)
const presetImages = [
  {
    label: 'Terapi Wicara',
    url: 'https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?auto=format&fit=crop&q=80&w=1200',
  },
  {
    label: 'Sensori Motorik',
    url: 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?auto=format&fit=crop&q=80&w=1200',
  },
  {
    label: 'Bermain Edukatif',
    url: 'https://images.unsplash.com/photo-1596464716127-f2a82984de30?auto=format&fit=crop&q=80&w=1200',
  },
  {
    label: 'Fisioterapi Anak',
    url: 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&q=80&w=1200',
  },
]

// Form State
const form = reactive({
  title: '',
  slug: '',
  category: 'Terapi Wicara',
  author: "Tim Ahli Amanah Tin's Center",
  read_time: '5 Menit Baca',
  image: 'https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?auto=format&fit=crop&q=80&w=1200',
  excerpt: '',
  content: '',
  is_published: true,
})

// Toast Feedback State
const toast = ref({
  show: false,
  title: '',
  message: '',
  type: 'success',
  icon: 'check_circle',
})
let toastTimer = null

function showToast({ title, message, type = 'success', icon = 'check_circle' }) {
  if (toastTimer) clearTimeout(toastTimer)
  toast.value = { show: true, title, message, type, icon }
  toastTimer = setTimeout(() => {
    toast.value.show = false
  }, 3200)
}

// Tanggal Hari Ini (Format Indonesia)
const currentFormattedDate = computed(() => {
  return new Date().toLocaleDateString('id-ID', {
    day: 'numeric',
    month: 'long',
    year: 'numeric',
  })
})

// Hitung Jumlah Kata
const wordCount = computed(() => {
  const plainText = form.content.replace(/<[^>]*>/g, ' ').trim()
  if (!plainText) return 0
  return plainText.split(/\s+/).filter(Boolean).length
})

// Render HTML untuk Tab Pratinjau (disanitasi dengan DOMPurify anti-XSS)
const renderedContent = computed(() => {
  if (!form.content.trim()) {
    return '<p class="sim-empty-hint">Konten artikel masih kosong. Tuliskan teks di tab Editor untuk melihat pratinjau lengkap di sini...</p>'
  }
  return sanitizeHtml(form.content)
})

// Generator Slug
function slugify(text) {
  return text
    .toString()
    .toLowerCase()
    .trim()
    .replace(/\s+/g, '-')
    .replace(/[^\w-]+/g, '')
    .replace(/--+/g, '-')
}

function onTitleInput() {
  if (!isEdit.value || !form.slug) {
    form.slug = slugify(form.title)
  }
}

function generateSlug() {
  form.slug = slugify(form.title)
}

// Auto Calculate Read Time
function autoCalculateReadTime() {
  const words = wordCount.value
  const minutes = Math.max(1, Math.ceil(words / 160))
  form.read_time = `${minutes} Menit Baca`
  showToast({
    title: 'Waktu Baca Dihitung',
    message: `Estimasi diperbarui menjadi "${form.read_time}" berdasarkan ${words} kata.`,
    type: 'success',
    icon: 'schedule',
  })
}

// Image error fallback
function onImgError() {
  showToast({
    title: 'Gambar Tidak Dapat Dimuat',
    message: 'Periksa kembali berkas atau URL gambar sampul Anda.',
    type: 'error',
    icon: 'broken_image',
  })
}

// =============================================
// HANDLER UPLOAD & PENYESUAIAN GAMBAR SAMPUL (16:9)
// =============================================
function triggerFileInput() {
  if (fileInputRef.value) {
    fileInputRef.value.click()
  }
}

function handleFileSelected(event) {
  const file = event.target.files && event.target.files[0]
  if (file) {
    processSelectedFile(file)
  }
  event.target.value = ''
}

function handleFileDrop(event) {
  isDragging.value = false
  const file = event.dataTransfer.files && event.dataTransfer.files[0]
  if (file) {
    processSelectedFile(file)
  }
}

function processSelectedFile(file) {
  if (!file.type.startsWith('image/')) {
    showToast({
      title: 'Berkas Tidak Valid',
      message: 'Silakan pilih berkas gambar (JPG, PNG, WEBP, atau GIF).',
      type: 'error',
      icon: 'error',
    })
    return
  }

  // Batas 5MB
  if (file.size > 5 * 1024 * 1024) {
    showToast({
      title: 'Ukuran Terlalu Besar',
      message: 'Ukuran gambar maksimal adalah 5 MB.',
      type: 'error',
      icon: 'warning',
    })
    return
  }

  rawFile.value = file
  executeCropPreview(file, focalPoint.value)
}

// Potong presisi rasio 16:9 secara lokal di browser (tanpa upload ke server)
async function executeCropPreview(fileOrUrl, position = 'center') {
  isUploading.value = true
  try {
    const croppedFile = await cropImageTo16x9(fileOrUrl, position)
    pendingCroppedBlob.value = croppedFile

    // Bersihkan URL blob lama jika ada
    if (pendingPreviewUrl.value && pendingPreviewUrl.value.startsWith('blob:')) {
      URL.revokeObjectURL(pendingPreviewUrl.value)
    }

    pendingPreviewUrl.value = URL.createObjectURL(croppedFile)
    form.image = pendingPreviewUrl.value
    showUploadDropzone.value = false
  } catch (err) {
    console.error('Gagal memproses pratinjau gambar:', err)
    showToast({
      title: 'Gagal Memproses Gambar',
      message: err.message || 'Terjadi kesalahan saat memotong gambar.',
      type: 'error',
      icon: 'error',
    })
  } finally {
    isUploading.value = false
  }
}

function setFocalPoint(pos) {
  if (focalPoint.value === pos) return
  focalPoint.value = pos

  // Potong ulang secara instan di browser (zero network, tidak membuat file di server)
  if (rawFile.value) {
    executeCropPreview(rawFile.value, pos)
  } else if (form.image) {
    executeCropPreview(form.image, pos)
  }
}

function removeCoverImage() {
  if (pendingPreviewUrl.value && pendingPreviewUrl.value.startsWith('blob:')) {
    URL.revokeObjectURL(pendingPreviewUrl.value)
  }
  pendingPreviewUrl.value = ''
  pendingCroppedBlob.value = null
  rawFile.value = null
  form.image = ''
  showUploadDropzone.value = true
  showToast({
    title: 'Sampul Dihapus',
    message: 'Gambar sampul artikel telah dibersihkan.',
    type: 'info',
    icon: 'delete',
  })
}

function applyCustomUrl() {
  if (!customUrlInput.value.trim()) return
  if (pendingPreviewUrl.value && pendingPreviewUrl.value.startsWith('blob:')) {
    URL.revokeObjectURL(pendingPreviewUrl.value)
  }
  pendingPreviewUrl.value = ''
  pendingCroppedBlob.value = null
  rawFile.value = null
  form.image = customUrlInput.value.trim()
  showUploadDropzone.value = false
  showToast({
    title: 'URL Diterapkan',
    message: 'Gambar eksternal siap digunakan sebagai sampul.',
    type: 'success',
    icon: 'link',
  })
}

function applyPreset(url) {
  if (pendingPreviewUrl.value && pendingPreviewUrl.value.startsWith('blob:')) {
    URL.revokeObjectURL(pendingPreviewUrl.value)
  }
  pendingPreviewUrl.value = ''
  pendingCroppedBlob.value = null
  rawFile.value = null
  form.image = url
  showUploadDropzone.value = false
  showToast({
    title: 'Preset Foto Dipilih',
    message: 'Foto koleksi klinik berhasil diterapkan.',
    type: 'success',
    icon: 'photo_library',
  })
}

// Algoritma Canvas Smart Crop 16:9
function cropImageTo16x9(fileOrUrl, position = 'center') {
  return new Promise((resolve, reject) => {
    const img = new Image()
    img.crossOrigin = 'anonymous'
    img.onload = () => {
      const targetRatio = 16 / 9
      const imgWidth = img.naturalWidth
      const imgHeight = img.naturalHeight
      const currentRatio = imgWidth / imgHeight

      let srcX = 0, srcY = 0, srcW = imgWidth, srcH = imgHeight

      if (currentRatio > targetRatio) {
        // Gambar lebih lebar dari 16:9 -> potong sisi kiri/kanan
        srcW = imgHeight * targetRatio
        if (position === 'top' || position === 'left') {
          srcX = 0
        } else if (position === 'bottom' || position === 'right') {
          srcX = imgWidth - srcW
        } else {
          srcX = (imgWidth - srcW) / 2
        }
      } else {
        // Gambar lebih tinggi (portrait) dari 16:9 -> potong atas/bawah sesuai focal point
        srcH = imgWidth / targetRatio
        if (position === 'top') {
          srcY = 0
        } else if (position === 'bottom') {
          srcY = imgHeight - srcH
        } else {
          srcY = (imgHeight - srcH) / 2
        }
      }

      const canvas = document.createElement('canvas')
      // Target resolusi standar 1280x720 (atau resolusi asli jika lebih kecil)
      const outW = Math.min(1920, Math.max(1280, Math.round(srcW)))
      const outH = Math.round(outW / targetRatio)

      canvas.width = outW
      canvas.height = outH
      const ctx = canvas.getContext('2d')

      // Gambar potongan ke canvas
      ctx.drawImage(img, srcX, srcY, srcW, srcH, 0, 0, outW, outH)

      canvas.toBlob(blob => {
        if (!blob) {
          reject(new Error('Gagal memproses gambar'))
          return
        }
        const fileName = (typeof fileOrUrl === 'object' && fileOrUrl.name)
          ? fileOrUrl.name.replace(/\.[^/.]+$/, '') + '_16_9.webp'
          : 'cover_16_9.webp'
        const croppedFile = new File([blob], fileName, { type: 'image/webp' })
        resolve(croppedFile)
      }, 'image/webp', 0.90)
    }

    img.onerror = () => {
      reject(new Error('Gagal memuat berkas gambar'))
    }

    if (typeof fileOrUrl === 'string') {
      img.src = fileOrUrl
    } else {
      const reader = new FileReader()
      reader.onload = e => { img.src = e.target.result }
      reader.onerror = reject
      reader.readAsDataURL(fileOrUrl)
    }
  })
}

// Rich Formatting Toolbar Actions
function wrapSelection(tag) {
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

  area.focus()
}

function insertHeading(level) {
  const area = contentArea.value
  if (!area) return

  const start = area.selectionStart
  const end = area.selectionEnd
  const selectedText = form.content.substring(start, end)
  const replacement = `\n<h${level}>${selectedText || `Judul Bagian H${level}`}</h${level}>\n`

  form.content =
    form.content.substring(0, start) +
    replacement +
    form.content.substring(end)

  area.focus()
}

function insertParagraph() {
  const area = contentArea.value
  if (!area) return

  const start = area.selectionStart
  const end = area.selectionEnd
  const selectedText = form.content.substring(start, end)
  const replacement = `\n<p>${selectedText || 'Tuliskan paragraf penjelasan baru di sini...'}</p>\n`

  form.content =
    form.content.substring(0, start) +
    replacement +
    form.content.substring(end)

  area.focus()
}

function insertList(type) {
  const area = contentArea.value
  if (!area) return

  const start = area.selectionStart
  const end = area.selectionEnd
  const selectedText = form.content.substring(start, end)
  const items = selectedText
    ? selectedText.split('\n').map(line => `  <li>${line}</li>`).join('\n')
    : '  <li>Poin pertama</li>\n  <li>Poin kedua</li>\n  <li>Poin ketiga</li>'

  const replacement = `\n<${type}>\n${items}\n</${type}>\n`

  form.content =
    form.content.substring(0, start) +
    replacement +
    form.content.substring(end)

  area.focus()
}

function insertCallout() {
  const area = contentArea.value
  if (!area) return

  const start = area.selectionStart
  const end = area.selectionEnd
  const selectedText = form.content.substring(start, end)
  const replacement = `\n<div class="callout-card">\n  <p><strong>💡 Catatan Penting Terapis:</strong> ${selectedText || 'Konsultasikan segera jika anak menunjukkan salah satu tanda bahaya di atas.'}</p>\n</div>\n`

  form.content =
    form.content.substring(0, start) +
    replacement +
    form.content.substring(end)

  area.focus()
}

function insertQuote() {
  const area = contentArea.value
  if (!area) return

  const start = area.selectionStart
  const end = area.selectionEnd
  const selectedText = form.content.substring(start, end)
  const replacement = `\n<blockquote>${selectedText || 'Setiap anak berkembang dengan kecepatan uniknya masing-masing, namun intervensi dini adalah kunci utama.'}</blockquote>\n`

  form.content =
    form.content.substring(0, start) +
    replacement +
    form.content.substring(end)

  area.focus()
}

function insertLink() {
  const url = prompt('Masukkan URL tautan:', 'https://')
  if (!url) return

  const area = contentArea.value
  const start = area.selectionStart
  const end = area.selectionEnd
  const selectedText = form.content.substring(start, end) || 'Kunjungi Tautan'
  const replacement = `<a href="${url}" class="text-link" target="_blank">${selectedText}</a>`

  form.content =
    form.content.substring(0, start) +
    replacement +
    form.content.substring(end)

  area.focus()
}

function insertDivider() {
  const area = contentArea.value
  if (!area) return

  const start = area.selectionStart
  const replacement = '\n<hr />\n'

  form.content =
    form.content.substring(0, start) +
    replacement +
    form.content.substring(start)

  area.focus()
}

// Fetch Article Details when Edit Mode
async function fetchArticleDetails() {
  if (!isEdit.value) return
  try {
    const res = await api.get(`/admin/articles/${route.params.id}`)
    const data = res.data
    form.title = data.title || ''
    form.slug = data.slug || ''
    form.category = data.category || 'Terapi Wicara'
    form.author = data.author || "Tim Ahli Amanah Tin's Center"
    form.read_time = data.read_time || '5 Menit Baca'
    form.image = data.image || ''
    form.excerpt = data.excerpt || ''
    form.content = data.content || ''
    form.is_published = !!data.is_published
  } catch (err) {
    console.error('Error fetching article', err)
    showToast({
      title: 'Gagal Memuat Data',
      message: 'Tidak dapat mengambil detail artikel dari server.',
      type: 'error',
      icon: 'error',
    })
    setTimeout(() => {
      router.push('/admin/artikel')
    }, 1500)
  }
}

// Submit Form Handler
async function submitForm(publishStatus) {
  if (!form.title.trim()) {
    showToast({
      title: 'Judul Wajib Diisi',
      message: 'Mohon masukkan judul artikel terlebih dahulu.',
      type: 'error',
      icon: 'warning',
    })
    return
  }

  if (!form.content.trim()) {
    showToast({
      title: 'Konten Wajib Diisi',
      message: 'Tuliskan isi artikel lengkap sebelum menyimpan.',
      type: 'error',
      icon: 'warning',
    })
    return
  }

  isSubmitting.value = true
  form.is_published = publishStatus

  if (!form.slug.trim()) {
    form.slug = slugify(form.title)
  }

  try {
    // Unggah gambar ke server HANYA saat tombol simpan / terbitkan diklik
    if (pendingCroppedBlob.value) {
      const formData = new FormData()
      formData.append('image', pendingCroppedBlob.value)

      const uploadRes = await api.post('/admin/articles/upload-image', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      })

      if (uploadRes.data && uploadRes.data.url) {
        form.image = uploadRes.data.url
        pendingCroppedBlob.value = null
      }
    }
    if (isEdit.value) {
      await api.put(`/admin/articles/${route.params.id}`, form)
      showToast({
        title: 'Artikel Diperbarui!',
        message: `Artikel "${form.title}" berhasil disimpan (${publishStatus ? 'Terbit' : 'Draf'}).`,
        type: 'success',
        icon: 'check_circle',
      })
    } else {
      await api.post('/admin/articles', form)
      showToast({
        title: 'Artikel Dibuat!',
        message: `Artikel baru "${form.title}" berhasil diterbitkan.`,
        type: 'success',
        icon: 'check_circle',
      })
    }

    setTimeout(() => {
      router.push('/admin/artikel')
    }, 1200)
  } catch (err) {
    console.error('Error submitting article', err)
    showToast({
      title: 'Gagal Menyimpan',
      message: err.response?.data?.message || 'Terjadi kesalahan saat menyimpan artikel.',
      type: 'error',
      icon: 'error',
    })
  } finally {
    isSubmitting.value = false
  }
}

onMounted(() => {
  fetchArticleDetails()
})
</script>

<style scoped>
/* =============================================
   PAGE TOP BAR & HEADER ACTIONS
   ============================================= */
.page-top-bar {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 1.5rem;
  margin-bottom: 2rem;
  flex-wrap: wrap;
}

.top-title-group {
  flex: 1;
  min-width: 0;
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
  transition: opacity 0.2s;
}

.back-link:hover {
  opacity: 0.8;
}

.back-icon {
  font-size: 1.05rem;
}

.heading-row {
  display: flex;
  align-items: center;
  gap: 0.85rem;
  flex-wrap: wrap;
  margin-bottom: 0.35rem;
}

.page-heading {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 1.75rem;
  font-weight: 800;
  color: var(--on-surface, #091d2e);
  letter-spacing: -0.01em;
  margin: 0;
}

.mode-badge {
  padding: 0.25rem 0.65rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 700;
}

.badge-published {
  background: #d7f5a8;
  color: #2e4400;
}

.badge-draft {
  background: #ffdcbf;
  color: #7a3e00;
}

.page-subheading {
  font-size: 0.9375rem;
  color: var(--on-surface-variant, #40484d);
  max-width: 680px;
  margin: 0;
  line-height: 1.5;
}

.top-actions {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  flex-wrap: wrap;
}

/* Tab Switcher: Editor vs Live Preview */
.view-mode-tabs {
  display: flex;
  align-items: center;
  background: #ffffff;
  border: 1px solid rgba(191, 200, 206, 0.6);
  border-radius: 9999px;
  padding: 0.25rem;
  box-shadow: 0 2px 8px rgba(9, 29, 46, 0.04);
}

.mode-tab-btn {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  padding: 0.45rem 0.95rem;
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

.mode-tab-active {
  background: var(--primary, #006384) !important;
  color: #ffffff !important;
  box-shadow: 0 2px 8px rgba(0, 99, 132, 0.25);
}

.btn-public-link {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  padding: 0.6rem 1rem;
  border-radius: 9999px;
  border: 1px solid rgba(0, 99, 132, 0.3);
  background: var(--surface-container-low, #edf4ff);
  color: var(--primary, #006384);
  font-weight: 700;
  font-size: 0.8125rem;
  text-decoration: none;
  transition: all 0.2s;
  white-space: nowrap;
}

.btn-public-link:hover {
  background: #c1e8ff;
}

.btn-secondary {
  padding: 0.65rem 1.25rem;
  border-radius: 9999px;
  border: 1px solid rgba(191, 200, 206, 0.7);
  background: #ffffff;
  color: var(--on-surface, #091d2e);
  font-weight: 700;
  font-size: 0.875rem;
  cursor: pointer;
  transition: all 0.2s;
  white-space: nowrap;
}

.btn-secondary:hover:not(:disabled) {
  background: var(--surface-container-low, #edf4ff);
  border-color: var(--primary, #006384);
  color: var(--primary, #006384);
}

.btn-primary {
  padding: 0.65rem 1.5rem;
  border-radius: 9999px;
  border: none;
  background: var(--primary, #006384);
  color: #ffffff;
  font-weight: 700;
  font-size: 0.875rem;
  cursor: pointer;
  box-shadow: 0 4px 14px rgba(0, 99, 132, 0.25);
  transition: all 0.2s;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  white-space: nowrap;
}

.btn-primary:hover:not(:disabled) {
  background: var(--primary-container, #2e7c9e);
  transform: translateY(-1px);
}

.btn-primary:disabled,
.btn-secondary:disabled {
  opacity: 0.55;
  cursor: wait;
}

/* =============================================
   FORM GRID LAYOUT
   ============================================= */
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
  box-shadow: 0 4px 14px rgba(9, 29, 46, 0.03);
  margin-bottom: 1.5rem;
}

.card-title {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 1.15rem;
  font-weight: 700;
  color: var(--on-surface, #091d2e);
  margin-top: 0;
  margin-bottom: 1.25rem;
  padding-bottom: 0.5rem;
  border-bottom: 1px solid rgba(191, 200, 206, 0.3);
}

.form-group {
  margin-bottom: 1.25rem;
}

.label-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 0.4rem;
}

.form-group label {
  font-size: 0.8438rem;
  font-weight: 700;
  color: var(--on-surface, #091d2e);
}

.label-tip {
  font-size: 0.75rem;
  font-weight: 500;
  color: var(--outline, #70787e);
  margin-left: 0.35rem;
}

.req {
  color: var(--error, #ba1a1a);
}

.char-count {
  font-size: 0.7188rem;
  color: var(--outline, #70787e);
}

.form-input,
.form-textarea,
.form-select {
  width: 100%;
  padding: 0.7rem 1rem;
  border-radius: 12px;
  border: 1px solid rgba(191, 200, 206, 0.7);
  background: var(--surface-bright, #f7f9ff);
  font-family: inherit;
  font-size: 0.9375rem;
  color: var(--on-surface, #091d2e);
  transition: all 0.2s;
  box-sizing: border-box;
}

.form-input:focus,
.form-textarea:focus,
.form-select:focus {
  outline: none;
  border-color: var(--primary, #006384);
  background: #ffffff;
  box-shadow: 0 0 0 3px rgba(0, 99, 132, 0.1);
}

.lead-textarea {
  line-height: 1.6;
}

/* Slug Row */
.slug-preview-row {
  display: flex;
  align-items: center;
  gap: 0.35rem;
  background: rgba(0, 99, 132, 0.05);
  border: 1px dashed rgba(0, 99, 132, 0.3);
  padding: 0.4rem 0.75rem;
  border-radius: 8px;
  margin-top: 0.5rem;
  font-size: 0.8125rem;
  color: var(--on-surface-variant, #40484d);
}

.slug-icon {
  font-size: 1rem;
  color: var(--primary, #006384);
}

.slug-prefix {
  font-weight: 700;
  color: var(--primary, #006384);
}

.slug-input {
  border: none;
  background: transparent;
  font-family: monospace;
  font-size: 0.8125rem;
  color: var(--on-surface, #091d2e);
  flex: 1;
  min-width: 0;
  outline: none;
}

.btn-slug-regen {
  background: none;
  border: none;
  cursor: pointer;
  color: var(--primary, #006384);
  padding: 0.15rem;
}

/* =============================================
   RICH EDITOR TOOLBAR
   ============================================= */
.editor-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 0.65rem;
}

.editor-header label {
  font-size: 0.875rem;
  font-weight: 700;
  color: var(--on-surface, #091d2e);
}

.editor-stats {
  font-size: 0.75rem;
  color: var(--outline, #70787e);
}

.stat-sep {
  margin: 0 0.35rem;
}

.editor-toolbar {
  display: flex;
  align-items: center;
  gap: 0.35rem;
  background: var(--surface-container-low, #edf4ff);
  border: 1px solid rgba(191, 200, 206, 0.6);
  border-radius: 12px 12px 0 0;
  padding: 0.45rem 0.65rem;
  flex-wrap: wrap;
}

.tb-btn {
  background: #ffffff;
  border: 1px solid rgba(191, 200, 206, 0.5);
  border-radius: 8px;
  padding: 0.35rem 0.6rem;
  font-size: 0.8125rem;
  color: var(--on-surface-variant, #40484d);
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  transition: all 0.15s ease;
}

.tb-btn:hover {
  background: var(--primary, #006384);
  color: #ffffff;
  border-color: var(--primary, #006384);
}

.tb-btn span.material-symbols-outlined {
  font-size: 1.05rem;
}

.tb-divider {
  width: 1px;
  height: 20px;
  background: rgba(191, 200, 206, 0.6);
  margin: 0 0.25rem;
}

.tb-btn-highlight {
  background: #fff3cd;
  color: #856404;
  border-color: #ffeeba;
  font-weight: 700;
}

.tb-btn-highlight:hover {
  background: #ffe8a1;
  color: #533f03;
  border-color: #ffd875;
}

.tb-label {
  font-size: 0.75rem;
}

.font-editorial {
  border-radius: 0 0 12px 12px;
  border-top: none;
  font-family: inherit;
  line-height: 1.7;
  font-size: 0.95rem;
  min-height: 380px;
}

.editor-footer-bar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: 0.75rem;
  flex-wrap: wrap;
  gap: 0.75rem;
}

.editor-shortcuts-tip {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  font-size: 0.75rem;
  color: var(--outline, #70787e);
}

.tip-icon {
  font-size: 0.95rem;
  color: var(--primary, #006384);
}

.btn-calc-time {
  background: transparent;
  border: 1px dashed rgba(0, 99, 132, 0.4);
  color: var(--primary, #006384);
  padding: 0.35rem 0.75rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 700;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  transition: all 0.2s;
}

.btn-calc-time:hover {
  background: var(--surface-container-low, #edf4ff);
}

/* =============================================
   SIDEBAR SETTINGS & PRESETS
   ============================================= */
.publish-switch-card {
  display: flex;
  align-items: flex-start;
  gap: 0.85rem;
  background: var(--surface-bright, #f7f9ff);
  padding: 1rem;
  border-radius: 12px;
  border: 1px solid rgba(191, 200, 206, 0.5);
}

.switch-container {
  position: relative;
  display: inline-block;
  width: 44px;
  height: 24px;
  flex-shrink: 0;
  margin-top: 2px;
}

.switch-container input {
  opacity: 0;
  width: 0;
  height: 0;
}

.switch-slider {
  position: absolute;
  cursor: pointer;
  inset: 0;
  background-color: #cbd5e1;
  transition: 0.3s;
  border-radius: 24px;
}

.switch-slider:before {
  position: absolute;
  content: "";
  height: 18px;
  width: 18px;
  left: 3px;
  bottom: 3px;
  background-color: white;
  transition: 0.3s;
  border-radius: 50%;
  box-shadow: 0 1px 3px rgba(0,0,0,0.2);
}

input:checked + .switch-slider {
  background-color: #4b6716;
}

input:checked + .switch-slider:before {
  transform: translateX(20px);
}

.switch-info {
  flex: 1;
}

.switch-title {
  display: block;
  font-size: 0.875rem;
  color: var(--on-surface, #091d2e);
  margin-bottom: 0.2rem;
}

.switch-desc {
  font-size: 0.75rem;
  color: var(--on-surface-variant, #40484d);
  line-height: 1.4;
  margin: 0;
}

.quick-author-chips {
  display: flex;
  gap: 0.4rem;
  margin-top: 0.45rem;
  flex-wrap: wrap;
}

.author-chip {
  background: var(--surface-container-low, #edf4ff);
  border: 1px solid rgba(0, 99, 132, 0.2);
  color: var(--primary, #006384);
  padding: 0.2rem 0.6rem;
  border-radius: 9999px;
  font-size: 0.6875rem;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.2s;
}

.author-chip:hover {
  background: var(--primary, #006384);
  color: #ffffff;
}

.input-with-icon {
  position: relative;
}

.input-icon {
  position: absolute;
  left: 0.85rem;
  top: 50%;
  transform: translateY(-50%);
  color: var(--outline, #70787e);
  font-size: 1.1rem;
}

.with-icon-input {
  padding-left: 2.4rem;
}

.link-calc {
  background: none;
  border: none;
  color: var(--primary, #006384);
  font-size: 0.75rem;
  font-weight: 700;
  cursor: pointer;
  text-decoration: underline;
}

/* =============================================
   SECTION: GAMBAR SAMPUL (COVER IMAGE) 16:9 ADAPTIVE
   ============================================= */
.cover-image-box {
  position: relative;
}

.card-title-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 0.25rem;
}

.card-title-row .card-title {
  margin-bottom: 0;
  border-bottom: none;
  padding-bottom: 0;
}

.aspect-badge {
  background: rgba(0, 99, 132, 0.1);
  color: var(--primary, #006384);
  font-size: 0.6875rem;
  font-weight: 800;
  padding: 0.2rem 0.6rem;
  border-radius: 9999px;
  letter-spacing: 0.02em;
}

.section-help-text {
  font-size: 0.7813rem;
  color: var(--on-surface-variant, #40484d);
  line-height: 1.45;
  margin-top: 0.4rem;
  margin-bottom: 1.25rem;
}

.hidden-file-input {
  display: none;
}

/* Upload Dropzone */
.upload-dropzone {
  border: 2px dashed rgba(0, 99, 132, 0.35);
  background: var(--surface-bright, #f7f9ff);
  border-radius: 16px;
  padding: 1.75rem 1rem;
  text-align: center;
  cursor: pointer;
  transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  margin-bottom: 1rem;
}

.upload-dropzone:hover {
  border-color: var(--primary, #006384);
  background: rgba(0, 99, 132, 0.03);
  transform: translateY(-2px);
}

.upload-dropzone.is-dragging {
  border-color: var(--secondary, #4b6716);
  background: rgba(75, 103, 22, 0.06);
  box-shadow: 0 0 0 4px rgba(75, 103, 22, 0.15);
}

.dropzone-idle {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.dropzone-icon-circle {
  width: 52px;
  height: 52px;
  border-radius: 50%;
  background: rgba(0, 99, 132, 0.08);
  color: var(--primary, #006384);
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 0.85rem;
  transition: all 0.2s;
}

.dropzone-icon-circle span {
  font-size: 28px;
}

.upload-dropzone:hover .dropzone-icon-circle {
  background: var(--primary, #006384);
  color: #ffffff;
  transform: scale(1.06);
}

.dropzone-title {
  font-size: 0.9375rem;
  font-weight: 700;
  color: var(--on-surface, #091d2e);
  margin: 0 0 0.3rem 0;
}

.dropzone-sub {
  font-size: 0.8125rem;
  color: var(--outline, #70787e);
  margin: 0 0 0.65rem 0;
}

.btn-browse-file {
  background: none;
  border: none;
  color: var(--primary, #006384);
  font-weight: 700;
  text-decoration: underline;
  cursor: pointer;
  padding: 0;
  font-size: inherit;
}

.dropzone-meta {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  font-size: 0.6875rem;
  color: var(--outline, #70787e);
  background: rgba(191, 200, 206, 0.25);
  padding: 0.2rem 0.65rem;
  border-radius: 9999px;
}

.dot-sep {
  opacity: 0.6;
}

/* Uploading State */
.uploading-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 1rem 0;
}

.upload-spinner {
  width: 36px;
  height: 36px;
  border: 3px solid rgba(0, 99, 132, 0.15);
  border-top-color: var(--primary, #006384);
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
  margin-bottom: 0.75rem;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.uploading-text {
  font-size: 0.875rem;
  font-weight: 700;
  color: var(--primary, #006384);
}

.uploading-sub {
  font-size: 0.75rem;
  color: var(--outline, #70787e);
  margin-top: 0.2rem;
}

/* Active Image Card */
.active-image-card {
  background: var(--surface-bright, #f7f9ff);
  border: 1px solid rgba(191, 200, 206, 0.5);
  border-radius: 16px;
  padding: 1rem;
  margin-bottom: 1.25rem;
}

.preview-ctrl-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 0.75rem;
  flex-wrap: wrap;
  gap: 0.5rem;
}

.preview-mode-tabs {
  display: inline-flex;
  background: rgba(191, 200, 206, 0.3);
  padding: 0.2rem;
  border-radius: 9999px;
  gap: 0.2rem;
}

.btn-mode-tab {
  background: transparent;
  border: none;
  border-radius: 9999px;
  padding: 0.3rem 0.75rem;
  font-size: 0.75rem;
  font-weight: 700;
  color: var(--on-surface-variant, #40484d);
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 0.3rem;
  transition: all 0.2s;
}

.btn-mode-tab.is-active {
  background: #ffffff;
  color: var(--primary, #006384);
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
}

.image-actions-row {
  display: flex;
  align-items: center;
  gap: 0.35rem;
}

.btn-img-action {
  border: 1px solid rgba(191, 200, 206, 0.6);
  background: #ffffff;
  border-radius: 8px;
  padding: 0.3rem 0.65rem;
  font-size: 0.75rem;
  font-weight: 700;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
  transition: all 0.2s;
}

.btn-img-change {
  color: var(--primary, #006384);
}

.btn-img-change:hover {
  background: var(--primary, #006384);
  color: #ffffff;
  border-color: var(--primary, #006384);
}

.btn-img-delete {
  color: var(--error, #ba1a1a);
  padding: 0.3rem 0.5rem;
}

.btn-img-delete:hover {
  background: var(--error, #ba1a1a);
  color: #ffffff;
  border-color: var(--error, #ba1a1a);
}

/* Fitted Preview Frame: Presisi 16:9 Sesuai Publik */
.fitted-preview-frame {
  position: relative;
  width: 100%;
  aspect-ratio: 16 / 9;
  border-radius: 12px;
  overflow: hidden;
  background: #091d2e;
  border: 1px solid rgba(191, 200, 206, 0.6);
  box-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
  transition: all 0.3s;
}

.fitted-preview-frame img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: object-position 0.25s ease-out;
}

.frame-detail-mode {
  box-shadow: 0 6px 18px rgba(0, 99, 132, 0.12);
}

.frame-card-mode {
  border-color: rgba(75, 103, 22, 0.4);
}

.frame-tag-badge {
  position: absolute;
  bottom: 0.5rem;
  left: 0.5rem;
  background: rgba(9, 29, 46, 0.78);
  backdrop-filter: blur(4px);
  -webkit-backdrop-filter: blur(4px);
  color: #ffffff;
  font-size: 0.6875rem;
  font-weight: 700;
  padding: 0.2rem 0.6rem;
  border-radius: 6px;
  display: inline-flex;
  align-items: center;
  gap: 0.3rem;
}

/* Focal Adjustment Strip */
.focal-adjust-strip {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: 0.85rem;
  padding-top: 0.75rem;
  border-top: 1px solid rgba(191, 200, 206, 0.4);
  flex-wrap: wrap;
  gap: 0.5rem;
}

.focal-label {
  display: inline-flex;
  align-items: center;
  gap: 0.3rem;
  font-size: 0.75rem;
  font-weight: 700;
  color: var(--on-surface-variant, #40484d);
}

.focal-buttons {
  display: inline-flex;
  gap: 0.3rem;
}

.btn-focal {
  background: #ffffff;
  border: 1px solid rgba(191, 200, 206, 0.7);
  border-radius: 8px;
  padding: 0.25rem 0.65rem;
  font-size: 0.7188rem;
  font-weight: 700;
  color: var(--on-surface-variant, #40484d);
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
  transition: all 0.2s;
}

.btn-focal:hover {
  border-color: var(--primary, #006384);
  color: var(--primary, #006384);
}

.btn-focal.focal-active {
  background: var(--primary, #006384);
  color: #ffffff;
  border-color: var(--primary, #006384);
  box-shadow: 0 2px 6px rgba(0, 99, 132, 0.25);
}

/* Status Pill */
.server-status-pill {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  background: rgba(75, 103, 22, 0.1);
  color: var(--secondary, #4b6716);
  font-size: 0.6875rem;
  font-weight: 800;
  padding: 0.3rem 0.75rem;
  border-radius: 9999px;
  margin-top: 0.75rem;
}

.status-pill-icon {
  font-size: 14px;
}

/* Extra Options Accordion */
.extra-options-accordion {
  border-top: 1px solid rgba(191, 200, 206, 0.35);
  padding-top: 0.75rem;
  margin-top: 0.75rem;
}

.btn-toggle-alt {
  width: 100%;
  background: none;
  border: none;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0.35rem 0;
  color: var(--outline, #70787e);
  font-size: 0.75rem;
  font-weight: 700;
  cursor: pointer;
  transition: color 0.2s;
}

.btn-toggle-alt:hover {
  color: var(--primary, #006384);
}

.toggle-alt-left {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
}

.toggle-chevron {
  font-size: 1.1rem;
  transition: transform 0.2s;
}

.toggle-chevron.is-rotated {
  transform: rotate(180deg);
}

.alt-options-body {
  margin-top: 0.85rem;
  padding: 0.85rem;
  background: var(--surface-bright, #f7f9ff);
  border-radius: 12px;
  border: 1px solid rgba(191, 200, 206, 0.4);
}

.input-with-action {
  display: flex;
  gap: 0.4rem;
  margin-top: 0.35rem;
}

.btn-apply-url {
  background: var(--primary, #006384);
  color: #ffffff;
  border: none;
  border-radius: 10px;
  padding: 0 0.85rem;
  font-size: 0.75rem;
  font-weight: 700;
  cursor: pointer;
  white-space: nowrap;
  transition: all 0.2s;
}

.btn-apply-url:hover {
  background: var(--primary-container, #2e7c9e);
}

/* Preset Images Grid */
.preset-images-section {
  margin-top: 0.85rem;
  padding-top: 0.75rem;
  border-top: 1px solid rgba(191, 200, 206, 0.3);
}

.preset-label {
  display: block;
  font-size: 0.75rem;
  font-weight: 700;
  color: var(--on-surface-variant, #40484d);
  margin-bottom: 0.5rem;
}

.preset-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 0.5rem;
}

.preset-thumb-btn {
  background: #ffffff;
  border: 2px solid rgba(191, 200, 206, 0.4);
  border-radius: 10px;
  overflow: hidden;
  padding: 0;
  cursor: pointer;
  display: flex;
  flex-direction: column;
  transition: all 0.2s;
  text-align: left;
}

.preset-thumb-btn img {
  width: 100%;
  height: 52px;
  object-fit: cover;
  display: block;
}

.preset-name {
  padding: 0.25rem 0.4rem;
  font-size: 0.6875rem;
  font-weight: 700;
  color: var(--on-surface, #091d2e);
  background: var(--surface-bright, #f7f9ff);
  display: block;
}

.preset-thumb-btn:hover {
  border-color: var(--primary, #006384);
  transform: translateY(-1px);
}

.preset-selected {
  border-color: var(--primary, #006384) !important;
  box-shadow: 0 0 0 2px rgba(0, 99, 132, 0.25);
}

/* =============================================
   TAB 2: PRATINJAU TAMPILAN PUBLIK (LIVE SIMULATION)
   ============================================= */
.public-preview-container {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
}

.preview-banner-strip {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  background: linear-gradient(90deg, #006384 0%, #2e7c9e 100%);
  color: #ffffff;
  padding: 0.75rem 1.25rem;
  border-radius: 16px;
  font-size: 0.8438rem;
  font-weight: 700;
  box-shadow: 0 4px 14px rgba(0, 99, 132, 0.2);
}

.public-preview-paper {
  background: #ffffff;
  border-radius: 24px;
  border: 1px solid rgba(191, 200, 206, 0.4);
  box-shadow: 0 6px 24px rgba(9, 29, 46, 0.06);
  padding: 2.5rem;
  max-width: 900px;
  margin: 0 auto;
  width: 100%;
  box-sizing: border-box;
}

/* Simulation Public Elements */
.sim-breadcrumbs {
  display: flex;
  align-items: center;
  gap: 0.45rem;
  font-size: 0.8125rem;
  color: var(--outline, #70787e);
  margin-bottom: 1.5rem;
}

.sim-sep {
  color: rgba(191, 200, 206, 0.7);
}

.sim-bc-active {
  color: var(--primary, #006384);
  font-weight: 700;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 380px;
}

.sim-badges-row {
  display: flex;
  align-items: center;
  gap: 0.6rem;
  margin-bottom: 1rem;
  flex-wrap: wrap;
}

.sim-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.3rem;
  padding: 0.3rem 0.85rem;
  border-radius: 9999px;
  font-size: 0.7813rem;
  font-weight: 700;
}

.sim-badge-cat {
  background: #e0f2fe;
  color: #0284c7;
}

.sim-badge-read {
  background: #f1f5f9;
  color: #475569;
}

.sim-badge-tag {
  background: #dcfce7;
  color: #15803d;
}

.sim-headline {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 2.2rem;
  font-weight: 800;
  color: var(--on-surface, #091d2e);
  line-height: 1.25;
  margin: 0 0 1.5rem 0;
  letter-spacing: -0.02em;
}

.sim-meta-bar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1rem 1.25rem;
  background: var(--surface-bright, #f7f9ff);
  border: 1px solid rgba(191, 200, 206, 0.4);
  border-radius: 16px;
  margin-bottom: 1.75rem;
  flex-wrap: wrap;
  gap: 1rem;
}

.sim-author-info {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.sim-avatar {
  width: 44px;
  height: 44px;
  border-radius: 50%;
  background: var(--surface-container-low, #edf4ff);
  color: var(--primary, #006384);
  display: flex;
  align-items: center;
  justify-content: center;
}

.sim-author-name {
  font-size: 0.9375rem;
  color: var(--on-surface, #091d2e);
}

.sim-author-role {
  font-size: 0.75rem;
  color: var(--on-surface-variant, #40484d);
}

.sim-date-info {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  font-size: 0.8125rem;
  color: var(--outline, #70787e);
}

.sim-featured-frame {
  position: relative;
  width: 100%;
  height: 380px;
  border-radius: 20px;
  overflow: hidden;
  margin-bottom: 1.75rem;
  box-shadow: 0 6px 20px rgba(9, 29, 46, 0.08);
}

.sim-featured-frame img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.sim-image-caption {
  position: absolute;
  bottom: 0.85rem;
  left: 0.85rem;
  background: rgba(9, 29, 46, 0.75);
  backdrop-filter: blur(8px);
  color: #ffffff;
  padding: 0.35rem 0.85rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
}

.sim-lead-card {
  background: rgba(217, 234, 255, 0.45);
  border: 1.5px solid rgba(0, 99, 132, 0.25);
  border-radius: 18px;
  padding: 1.5rem 1.75rem;
  margin-bottom: 2rem;
}

.sim-lead-text {
  font-size: 1.1rem;
  line-height: 1.7;
  color: var(--on-surface, #091d2e);
  font-weight: 600;
  margin: 0;
}

.sim-editorial-body {
  font-size: 1.05rem;
  line-height: 1.8;
  color: var(--on-surface-variant, #40484d);
}

.sim-empty-hint {
  font-style: italic;
  color: var(--outline, #70787e);
  text-align: center;
  padding: 2.5rem 1rem;
}

/* Deep Styles for Rendered HTML */
.sim-editorial-body :deep(h2) {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 1.5rem;
  font-weight: 800;
  color: var(--on-surface, #091d2e);
  margin-top: 2rem;
  margin-bottom: 0.75rem;
  padding-bottom: 0.35rem;
  border-bottom: 2px solid rgba(0, 99, 132, 0.1);
}

.sim-editorial-body :deep(h3) {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 1.25rem;
  font-weight: 700;
  color: var(--on-surface, #091d2e);
  margin-top: 1.5rem;
  margin-bottom: 0.5rem;
}

.sim-editorial-body :deep(p) {
  margin-bottom: 1.25rem;
}

.sim-editorial-body :deep(ul),
.sim-editorial-body :deep(ol) {
  margin-bottom: 1.5rem;
  padding-left: 1.75rem;
}

.sim-editorial-body :deep(li) {
  margin-bottom: 0.5rem;
}

.sim-editorial-body :deep(blockquote) {
  margin: 1.5rem 0;
  padding: 1.25rem 1.75rem;
  border-left: 4px solid var(--primary, #006384);
  background: rgba(0, 99, 132, 0.05);
  border-radius: 0 16px 16px 0;
  font-style: italic;
  font-size: 1.05rem;
  color: var(--on-surface, #091d2e);
}

.sim-editorial-body :deep(.callout-card) {
  margin: 1.75rem 0;
  padding: 1.25rem 1.5rem;
  border-radius: 16px;
  background: linear-gradient(135deg, rgba(193, 232, 255, 0.45) 0%, rgba(227, 239, 255, 0.6) 100%);
  border: 1px solid rgba(0, 99, 132, 0.25);
}

.sim-editorial-body :deep(a) {
  color: var(--primary, #006384);
  font-weight: 700;
  text-decoration: underline;
}

.sim-cta-box {
  margin-top: 2.5rem;
  padding: 1.75rem;
  border-radius: 20px;
  background: linear-gradient(135deg, #005a78 0%, #00769a 100%);
  color: #ffffff;
  display: flex;
  align-items: center;
  gap: 1.25rem;
  flex-wrap: wrap;
}

.sim-cta-icon {
  width: 50px;
  height: 50px;
  border-radius: 14px;
  background: rgba(255, 255, 255, 0.2);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.sim-cta-content {
  flex: 1;
  min-width: 240px;
}

.sim-cta-title {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 1.15rem;
  font-weight: 800;
  margin: 0 0 0.25rem 0;
}

.sim-cta-desc {
  font-size: 0.8125rem;
  opacity: 0.95;
  margin: 0;
  line-height: 1.4;
}

.sim-btn-cta {
  background: #ffffff;
  color: var(--primary, #006384);
  padding: 0.65rem 1.25rem;
  border-radius: 9999px;
  border: none;
  font-weight: 800;
  font-size: 0.8125rem;
  cursor: default;
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  white-space: nowrap;
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

.spinner-small {
  width: 18px;
  height: 18px;
  border: 2px solid rgba(255, 255, 255, 0.3);
  border-top-color: #ffffff;
  border-radius: 50%;
  animation: spin 0.6s linear infinite;
  display: inline-block;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

/* =============================================
   RESPONSIVE BREAKPOINTS
   ============================================= */
@media (max-width: 1024px) {
  .form-grid {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 767px) {
  .page-top-bar {
    flex-direction: column;
    align-items: stretch;
    gap: 1rem;
  }

  .top-actions {
    width: 100%;
    justify-content: flex-start;
  }

  .view-mode-tabs {
    width: 100%;
    justify-content: space-between;
  }

  .mode-tab-btn {
    flex: 1;
    justify-content: center;
  }

  .btn-primary, .btn-secondary {
    flex: 1;
    justify-content: center;
  }

  .btn-text-desktop {
    display: none;
  }

  .card-box {
    padding: 1.25rem;
  }

  .public-preview-paper {
    padding: 1.25rem;
  }

  .sim-headline {
    font-size: 1.55rem;
  }

  .sim-featured-frame {
    height: 220px;
  }

  .toast-box {
    left: 1rem;
    right: 1rem;
    bottom: 1rem;
    max-width: none;
  }
}
</style>
