<template>
  <div class="login-wrapper">
    <!-- Ambient Background Lighting -->
    <div class="ambient-glow glow-top-left" aria-hidden="true"></div>
    <div class="ambient-glow glow-bottom-right" aria-hidden="true"></div>

    <!-- Top Navigation Header -->
    <header class="login-header">
      <div class="header-container">
        <!-- Brand Logo with Official ATC Shield Mark -->
        <router-link to="/" class="brand-link" title="Kembali ke Beranda ATC">
          <div class="brand-logo-frame">
            <svg class="brand-svg" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect width="40" height="40" rx="12" fill="url(#brandGradLogin)" />
              <path d="M20 9C20 9 12 14.5 12 21.5C12 26.5 15.8 29.5 20 31.5C24.2 29.5 28 26.5 28 21.5C28 14.5 20 9 20 9Z" fill="white" fill-opacity="0.22" />
              <circle cx="20" cy="17" r="3.2" fill="white" />
              <path d="M14.5 25.5C15.2 22.8 17.4 21.2 20 21.2C22.6 21.2 24.8 22.8 25.5 25.5" stroke="white" stroke-width="2" stroke-linecap="round" />
              <path d="M20 27L18.8 25.9C15.5 23 14 21.6 14 19.8C14 18.2 15.2 17 16.8 17C17.7 17 18.6 17.4 19.1 18.1L20 19.1L20.9 18.1C21.4 17.4 22.3 17 23.2 17C24.8 17 26 18.2 26 19.8C26 21.6 24.5 23 21.2 25.9L20 27Z" fill="#FFC857" />
              <defs>
                <linearGradient id="brandGradLogin" x1="0" y1="0" x2="40" y2="40" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#006384" />
                  <stop offset="1" stop-color="#00839e" />
                </linearGradient>
              </defs>
            </svg>
          </div>
          <div class="brand-text">
            <span class="brand-title">Amanah Tin's Center</span>
            <span class="brand-subtitle">Portal Administrasi &amp; Manajemen Terpadu</span>
          </div>
        </router-link>

        <!-- Back to Public Site Action Pill -->
        <router-link to="/" class="btn-back-home" title="Kembali ke halaman publik">
          <span class="material-symbols-outlined icon-back">arrow_back</span>
          <span class="back-text">Halaman Publik</span>
        </router-link>
      </div>
    </header>

    <!-- Main Content Stage -->
    <main class="login-main">
      <div class="login-card">

        <!-- ==================== LEFT BRANDING PANEL ==================== -->
        <section class="login-left-panel">
          <div class="left-panel-content">
            <!-- Header Tag -->
            <div class="panel-badge">
              <span class="material-symbols-outlined badge-icon">verified_user</span>
              <span>Portal Administrator &amp; Tenaga Medis</span>
            </div>

            <h1 class="panel-headline">
              Sistem Koordinasi Terapi &amp; Manajemen Klinik
            </h1>

            <p class="panel-subtext">
              Pusat kelola janji temu konsultasi, rekam jadwal sesi terapi terpadu (Wicara, Okupasi, Sensori Integrasi), dan publikasi artikel tips tumbuh kembang anak.
            </p>

            <!-- Warm Children Therapy Photo Showcase -->
            <div class="panel-media-wrap">
              <img
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBSomNiaRch3AG4p8CFoFGVtFLAkrg-N8gEtBcoTao1QojSHQ7L-W-vTrweEtaSa424MxTXmSrsRrwJv8eyCWMkH2pUJRG_H8aZbmsl3VV9Nhec_O5jUwNse-qUJ4gIQTGsRYcAk3kHyIklcxIuCrCYGGZRoTOPdifAmBtyIGV9pIGKaOduHdIY6v2MMFMfShJPubKVQxhXLVhj5Sp9I0NISp-fURn8bOJL7FqZpqI"
                alt="Terapis mendampingi anak dalam sesi stimulasi tumbuh kembang"
                class="panel-img"
              />
              <div class="panel-media-overlay">
                <div class="media-badge">
                  <span class="material-symbols-outlined fill text-amber">favorite</span>
                  <span>Peduli Tumbuh Kembang Buah Hati</span>
                </div>
                <p class="media-caption">
                  Fasilitas berstandar klinis ramah anak di Jagakarsa, Jakarta Selatan.
                </p>
              </div>
            </div>

            <!-- 4 Therapy Pillars Mini Grid -->
            <div class="pillars-mini-grid">
              <div class="pillar-mini-chip">
                <span class="material-symbols-outlined chip-icon text-teal">record_voice_over</span>
                <span>Terapi Wicara (TW)</span>
              </div>
              <div class="pillar-mini-chip">
                <span class="material-symbols-outlined chip-icon text-green">front_hand</span>
                <span>Terapi Okupasi (TO)</span>
              </div>
              <div class="pillar-mini-chip">
                <span class="material-symbols-outlined chip-icon text-amber">spa</span>
                <span>Sensori Integrasi (SI)</span>
              </div>
              <div class="pillar-mini-chip">
                <span class="material-symbols-outlined chip-icon text-purple">psychology</span>
                <span>Fisioterapi / Psikologi</span>
              </div>
            </div>
          </div>
        </section>

        <!-- ==================== RIGHT LOGIN FORM PANEL ==================== -->
        <section class="login-right-panel">
          <div class="form-wrapper">

            <!-- Mobile-only Mini Brand Mark -->
            <div class="mobile-brand-banner">
              <div class="mobile-brand-logo">
                <span class="material-symbols-outlined">health_and_safety</span>
              </div>
              <span class="mobile-brand-name">Amanah Tin's Center</span>
            </div>

            <!-- Form Header -->
            <div class="form-title-group">
              <div class="form-icon-bubble">
                <span class="material-symbols-outlined">lock_open_right</span>
              </div>
              <h2 class="form-main-title">Masuk ke Portal Admin</h2>
              <p class="form-subtitle">
                Gunakan kredensial resmi administrator untuk mengelola jadwal klinik dan artikel edukasi.
              </p>
            </div>

            <!-- Interactive Demo Fill Assistant Card -->
            <div class="demo-card" :class="{ 'demo-filled': isDemoFilled }">
              <div class="demo-card-left">
                <div class="demo-icon-circle">
                  <span class="material-symbols-outlined">{{ isDemoFilled ? 'check_circle' : 'key' }}</span>
                </div>
                <div class="demo-info">
                  <span class="demo-label">Akun Pengujian Demo:</span>
                  <div class="demo-details">
                    <span>Email: <code>admin@amanahtinscenter.com</code></span>
                    <span>Sandi: <code>admin123</code></span>
                  </div>
                </div>
              </div>
              <button
                type="button"
                class="btn-demo-fill"
                @click="fillDemoCredentials"
                :title="isDemoFilled ? 'Kredensial sudah terisi' : 'Klik untuk isi otomatis'"
              >
                <span class="material-symbols-outlined text-sm">{{ isDemoFilled ? 'done' : 'magic_button' }}</span>
                <span>{{ isDemoFilled ? 'Terisi' : 'Isi Otomatis' }}</span>
              </button>
            </div>

            <!-- Error Banner -->
            <transition name="alert-fade">
              <div v-if="errorMessage" class="error-banner" role="alert">
                <span class="material-symbols-outlined error-icon">error</span>
                <span class="error-text">{{ errorMessage }}</span>
                <button
                  type="button"
                  class="btn-close-error"
                  @click="errorMessage = ''"
                  aria-label="Tutup pesan kesalahan"
                >
                  <span class="material-symbols-outlined">close</span>
                </button>
              </div>
            </transition>

            <!-- Authentication Form -->
            <form @submit.prevent="handleLogin" class="auth-form" novalidate>
              <!-- Email Input Field -->
              <div class="form-group">
                <label for="admin-email" class="form-label">
                  <span>Alamat Email</span>
                  <span class="required-star">*</span>
                </label>
                <div class="input-container" :class="{ 'has-value': email }">
                  <span class="material-symbols-outlined input-lead-icon">mail</span>
                  <input
                    id="admin-email"
                    v-model.trim="email"
                    type="email"
                    required
                    autocomplete="email"
                    placeholder="nama@amanahtinscenter.com"
                    class="form-field"
                    :disabled="isLoading"
                  />
                  <button
                    v-if="email && !isLoading"
                    type="button"
                    class="btn-clear-input"
                    @click="email = ''"
                    title="Kosongkan email"
                  >
                    <span class="material-symbols-outlined">cancel</span>
                  </button>
                </div>
              </div>

              <!-- Password Input Field -->
              <div class="form-group">
                <div class="password-label-row">
                  <label for="admin-password" class="form-label">
                    <span>Kata Sandi</span>
                    <span class="required-star">*</span>
                  </label>
                </div>
                <div class="input-container" :class="{ 'has-value': password }">
                  <span class="material-symbols-outlined input-lead-icon">lock</span>
                  <input
                    id="admin-password"
                    v-model="password"
                    :type="showPassword ? 'text' : 'password'"
                    required
                    autocomplete="current-password"
                    placeholder="Masukkan kata sandi administrator"
                    class="form-field"
                    :disabled="isLoading"
                  />
                  <button
                    type="button"
                    class="btn-toggle-pw"
                    @click="showPassword = !showPassword"
                    :aria-label="showPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                    :title="showPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                  >
                    <span class="material-symbols-outlined">
                      {{ showPassword ? 'visibility_off' : 'visibility' }}
                    </span>
                  </button>
                </div>
              </div>

              <!-- Remember Me & Forgot Password Hints -->
              <div class="form-options-row">
                <label class="remember-checkbox-label">
                  <input
                    type="checkbox"
                    v-model="rememberMe"
                    class="custom-checkbox"
                  />
                  <span class="checkbox-text">Ingat sesi saya di perangkat ini</span>
                </label>
              </div>

              <!-- Submit Button -->
              <button
                type="submit"
                class="btn-login-submit"
                :disabled="isLoading || !email || !password"
              >
                <div v-if="isLoading" class="submit-loading-state">
                  <span class="submit-spinner" aria-hidden="true"></span>
                  <span>Memverifikasi Kredensial...</span>
                </div>
                <div v-else class="submit-normal-state">
                  <span>Masuk ke Dashboard</span>
                  <span class="material-symbols-outlined icon-arrow">arrow_forward</span>
                </div>
              </button>
            </form>

            <!-- Security Trust Footnote -->
            <div class="security-footnote">
              <span class="material-symbols-outlined icon-shield">shield</span>
              <p class="footnote-text">
                Enkripsi SSL 256-Bit • Autentikasi Berbasis Laravel Sanctum Token Aman
              </p>
            </div>

          </div>
        </section>

      </div>
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../../stores/auth'

const router = useRouter()
const auth = useAuthStore()

const email = ref('')
const password = ref('')
const showPassword = ref(false)
const rememberMe = ref(true)
const isLoading = ref(false)
const errorMessage = ref('')
const isDemoFilled = ref(false)

function fillDemoCredentials() {
  email.value = 'admin@amanahtinscenter.com'
  password.value = 'admin123'
  isDemoFilled.value = true
  errorMessage.value = ''
  setTimeout(() => {
    isDemoFilled.value = false
  }, 2500)
}

async function handleLogin() {
  if (!email.value || !password.value) {
    errorMessage.value = 'Silakan lengkapi alamat email dan kata sandi.'
    return
  }

  errorMessage.value = ''
  isLoading.value = true

  try {
    await auth.login({
      email: email.value,
      password: password.value,
    })
    router.push('/admin/dashboard')
  } catch (err) {
    if (err.response?.data?.message) {
      errorMessage.value = err.response.data.message
    } else if (err.response?.data?.errors) {
      errorMessage.value = Object.values(err.response.data.errors).flat().join(', ')
    } else {
      errorMessage.value = 'Kombinasi email atau kata sandi tidak cocok dengan data klinik.'
    }
  } finally {
    isLoading.value = false
  }
}
</script>

<style scoped>
/* ============================================================
   DESIGN TOKENS & FOUNDATIONS
   ============================================================ */
.login-wrapper {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  background-color: #f4f7fc;
  font-family: var(--font-body, 'Nunito Sans', sans-serif);
  position: relative;
  overflow-x: hidden;
}

/* Ambient glow blobs */
.ambient-glow {
  position: fixed;
  border-radius: 50%;
  filter: blur(80px);
  pointer-events: none;
  z-index: 0;
  opacity: 0.65;
}

.glow-top-left {
  width: 450px;
  height: 450px;
  top: -120px;
  left: -120px;
  background: radial-gradient(circle, rgba(193, 232, 255, 0.7) 0%, rgba(204, 239, 142, 0.25) 70%, transparent 100%);
}

.glow-bottom-right {
  width: 500px;
  height: 500px;
  bottom: -150px;
  right: -150px;
  background: radial-gradient(circle, rgba(227, 239, 255, 0.8) 0%, rgba(193, 232, 255, 0.4) 70%, transparent 100%);
}

/* ============================================================
   TOP HEADER
   ============================================================ */
.login-header {
  position: relative;
  z-index: 10;
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);
  border-bottom: 1px solid rgba(191, 200, 206, 0.35);
  box-shadow: 0 2px 12px rgba(9, 29, 46, 0.03);
}

.header-container {
  max-width: 1240px;
  margin: 0 auto;
  padding: 0.85rem 1.5rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
}

.brand-link {
  display: flex;
  align-items: center;
  gap: 0.85rem;
  text-decoration: none;
}

.brand-logo-frame {
  width: 40px;
  height: 40px;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0, 99, 132, 0.2);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.brand-svg {
  width: 100%;
  height: 100%;
  display: block;
}

.brand-text {
  display: flex;
  flex-direction: column;
}

.brand-title {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 1.125rem;
  font-weight: 800;
  color: #006384;
  line-height: 1.2;
}

.brand-subtitle {
  font-size: 0.72rem;
  color: #64748b;
  font-weight: 600;
  letter-spacing: 0.01em;
}

.btn-back-home {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  padding: 0.5rem 1rem;
  background: #ffffff;
  border: 1.5px solid rgba(191, 200, 206, 0.5);
  border-radius: 999px;
  color: #334155;
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 0.85rem;
  font-weight: 700;
  text-decoration: none;
  transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
}

.btn-back-home:hover {
  background: #f0f6ff;
  border-color: #006384;
  color: #006384;
  transform: translateX(-2px);
}

.icon-back {
  font-size: 18px;
  transition: transform 0.2s;
}

.btn-back-home:hover .icon-back {
  transform: translateX(-3px);
}

/* ============================================================
   MAIN STAGE & CARD LAYOUT
   ============================================================ */
.login-main {
  flex: 1;
  position: relative;
  z-index: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2.5rem 1.25rem;
}

.login-card {
  width: 100%;
  max-width: 1100px;
  background: #ffffff;
  border-radius: 24px;
  border: 1px solid rgba(191, 200, 206, 0.45);
  box-shadow: 0 20px 48px -10px rgba(9, 29, 46, 0.08), 0 1px 3px rgba(0, 0, 0, 0.02);
  display: grid;
  grid-template-columns: 1fr 1.15fr;
  overflow: hidden;
}

/* ============================================================
   LEFT BRANDING PANEL (DESKTOP)
   ============================================================ */
.login-left-panel {
  background: linear-gradient(150deg, #f0f7ff 0%, #e2efff 100%);
  padding: 3rem 2.5rem;
  border-right: 1px solid rgba(191, 200, 206, 0.35);
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.left-panel-content {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
}

.panel-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.45rem;
  background: rgba(0, 99, 132, 0.1);
  color: #006384;
  font-size: 0.75rem;
  font-weight: 800;
  letter-spacing: 0.03em;
  padding: 0.35rem 0.85rem;
  border-radius: 999px;
  width: fit-content;
}

.badge-icon {
  font-size: 16px;
}

.panel-headline {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 1.75rem;
  font-weight: 800;
  color: #091d2e;
  line-height: 1.28;
  margin: 0;
  letter-spacing: -0.015em;
}

.panel-subtext {
  font-size: 0.925rem;
  color: #475569;
  line-height: 1.62;
  margin: 0;
}

/* Media Showcase with Pediatric Imagery */
.panel-media-wrap {
  position: relative;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 10px 24px -4px rgba(9, 29, 46, 0.12);
  margin: 0.5rem 0;
  border: 3px solid #ffffff;
}

.panel-img {
  width: 100%;
  height: 200px;
  object-fit: cover;
  object-position: center 30%;
  display: block;
}

.panel-media-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(180deg, transparent 40%, rgba(9, 29, 46, 0.85) 100%);
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  padding: 1rem 1.15rem;
  color: #ffffff;
}

.media-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 0.8rem;
  font-weight: 700;
  color: #ffffff;
}

.text-amber {
  color: #fbbf24;
}

.media-caption {
  font-size: 0.725rem;
  color: #cbd5e1;
  margin: 0.2rem 0 0 0;
  line-height: 1.4;
}

/* Pillars Mini Grid */
.pillars-mini-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 0.65rem;
  padding-top: 0.5rem;
}

.pillar-mini-chip {
  display: flex;
  align-items: center;
  gap: 0.45rem;
  background: #ffffff;
  padding: 0.6rem 0.8rem;
  border-radius: 12px;
  font-size: 0.78rem;
  font-weight: 700;
  color: #1e293b;
  border: 1px solid rgba(191, 200, 206, 0.3);
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
}

.chip-icon {
  font-size: 18px;
}

.text-teal { color: #006384; }
.text-green { color: #16a34a; }
.text-amber { color: #d97706; }
.text-purple { color: #7c3aed; }

/* ============================================================
   RIGHT LOGIN FORM PANEL
   ============================================================ */
.login-right-panel {
  padding: 3.25rem 3rem;
  display: flex;
  align-items: center;
  justify-content: center;
}

.form-wrapper {
  width: 100%;
  max-width: 440px;
}

/* Mobile Brand Banner */
.mobile-brand-banner {
  display: none;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 1.25rem;
}

.mobile-brand-logo {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  background: #006384;
  color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
}

.mobile-brand-logo .material-symbols-outlined {
  font-size: 18px;
}

.mobile-brand-name {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 0.95rem;
  font-weight: 800;
  color: #006384;
}

/* Form Title Group */
.form-title-group {
  margin-bottom: 1.5rem;
}

.form-icon-bubble {
  width: 46px;
  height: 46px;
  border-radius: 14px;
  background: #c1e8ff;
  color: #006384;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 0.85rem;
}

.form-icon-bubble .material-symbols-outlined {
  font-size: 24px;
}

.form-main-title {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 1.65rem;
  font-weight: 800;
  color: #091d2e;
  line-height: 1.25;
  margin: 0;
  letter-spacing: -0.01em;
}

.form-subtitle {
  font-size: 0.875rem;
  color: #64748b;
  margin: 0.35rem 0 0 0;
  line-height: 1.5;
}

/* Demo Card */
.demo-card {
  background: #f0fdf4;
  border: 1.5px dashed #86efac;
  border-radius: 14px;
  padding: 0.85rem 1rem;
  margin-bottom: 1.35rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 0.75rem;
  transition: all 0.25s ease;
}

.demo-card.demo-filled {
  background: #dcfce7;
  border-color: #22c55e;
  box-shadow: 0 4px 12px rgba(34, 197, 94, 0.15);
}

.demo-card-left {
  display: flex;
  align-items: flex-start;
  gap: 0.65rem;
}

.demo-icon-circle {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background: #bbf7d0;
  color: #15803d;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  margin-top: 1px;
}

.demo-icon-circle .material-symbols-outlined {
  font-size: 18px;
}

.demo-info {
  display: flex;
  flex-direction: column;
}

.demo-label {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 0.775rem;
  font-weight: 800;
  color: #166534;
}

.demo-details {
  display: flex;
  flex-direction: column;
  font-size: 0.75rem;
  color: #14532d;
  margin-top: 0.15rem;
  gap: 0.1rem;
}

.demo-details code {
  background: rgba(255, 255, 255, 0.85);
  padding: 0.1rem 0.35rem;
  border-radius: 4px;
  font-weight: 700;
  color: #0f766e;
}

.btn-demo-fill {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  background: #16a34a;
  color: #ffffff;
  border: none;
  padding: 0.45rem 0.85rem;
  border-radius: 999px;
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 0.775rem;
  font-weight: 800;
  cursor: pointer;
  white-space: nowrap;
  box-shadow: 0 2px 6px rgba(22, 163, 74, 0.25);
  transition: all 0.2s;
  flex-shrink: 0;
}

.btn-demo-fill:hover {
  background: #15803d;
  transform: translateY(-1px);
}

.btn-demo-fill .text-sm {
  font-size: 15px;
}

/* Alert Banner */
.error-banner {
  background: #fef2f2;
  border: 1px solid #fecaca;
  color: #991b1b;
  border-radius: 12px;
  padding: 0.75rem 1rem;
  margin-bottom: 1.25rem;
  display: flex;
  align-items: center;
  gap: 0.65rem;
  font-size: 0.825rem;
  font-weight: 600;
  line-height: 1.4;
}

.error-icon {
  font-size: 20px;
  color: #dc2626;
  flex-shrink: 0;
}

.error-text {
  flex: 1;
}

.btn-close-error {
  background: none;
  border: none;
  color: #991b1b;
  cursor: pointer;
  padding: 0.2rem;
  display: flex;
  align-items: center;
  border-radius: 50%;
}

.btn-close-error .material-symbols-outlined {
  font-size: 16px;
}

/* Form Groups & Inputs */
.auth-form {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.4rem;
}

.form-label {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 0.85rem;
  font-weight: 700;
  color: #1e293b;
  display: flex;
  align-items: center;
  gap: 0.25rem;
}

.required-star {
  color: #dc2626;
}

.password-label-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.input-container {
  position: relative;
  display: flex;
  align-items: center;
}

.input-lead-icon {
  position: absolute;
  left: 1rem;
  color: #94a3b8;
  font-size: 20px;
  pointer-events: none;
  transition: color 0.2s;
}

.form-field {
  width: 100%;
  padding: 0.8rem 2.85rem 0.8rem 2.75rem;
  border-radius: 14px;
  border: 1.5px solid rgba(191, 200, 206, 0.6);
  background: #f8fafc;
  font-size: 0.925rem;
  font-family: inherit;
  color: #091d2e;
  transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
  outline: none;
}

.form-field:focus {
  border-color: #006384;
  background: #ffffff;
  box-shadow: 0 0 0 4px rgba(0, 99, 132, 0.12);
}

.input-container:focus-within .input-lead-icon {
  color: #006384;
}

.btn-clear-input {
  position: absolute;
  right: 0.75rem;
  background: none;
  border: none;
  color: #94a3b8;
  cursor: pointer;
  display: flex;
  align-items: center;
  padding: 0.25rem;
  border-radius: 50%;
}

.btn-clear-input:hover {
  color: #475569;
}

.btn-clear-input .material-symbols-outlined {
  font-size: 18px;
}

.btn-toggle-pw {
  position: absolute;
  right: 0.65rem;
  width: 36px;
  height: 36px;
  background: none;
  border: none;
  color: #94a3b8;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 8px;
  transition: all 0.15s;
}

.btn-toggle-pw:hover {
  color: #006384;
  background: rgba(0, 99, 132, 0.06);
}

.btn-toggle-pw .material-symbols-outlined {
  font-size: 20px;
}

/* Remember Me Checkbox */
.form-options-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-top: 0.1rem;
}

.remember-checkbox-label {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  cursor: pointer;
  user-select: none;
}

.custom-checkbox {
  width: 17px;
  height: 17px;
  accent-color: #006384;
  cursor: pointer;
  border-radius: 4px;
}

.checkbox-text {
  font-size: 0.825rem;
  color: #475569;
  font-weight: 600;
}

/* Submit Button */
.btn-login-submit {
  width: 100%;
  padding: 0.95rem 1.5rem;
  border-radius: 999px;
  background: linear-gradient(135deg, #006384 0%, #007b9e 100%);
  color: #ffffff;
  border: none;
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 0.975rem;
  font-weight: 700;
  cursor: pointer;
  box-shadow: 0 4px 14px rgba(0, 99, 132, 0.28);
  transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
  margin-top: 0.5rem;
}

.btn-login-submit:hover:not(:disabled) {
  background: linear-gradient(135deg, #00506b 0%, #006987 100%);
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(0, 99, 132, 0.35);
}

.btn-login-submit:active:not(:disabled) {
  transform: scale(0.98);
}

.btn-login-submit:disabled {
  opacity: 0.6;
  cursor: not-allowed;
  box-shadow: none;
  transform: none;
}

.submit-normal-state,
.submit-loading-state {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
}

.icon-arrow {
  font-size: 18px;
  transition: transform 0.2s;
}

.btn-login-submit:hover:not(:disabled) .icon-arrow {
  transform: translateX(4px);
}

.submit-spinner {
  width: 18px;
  height: 18px;
  border: 2.5px solid rgba(255, 255, 255, 0.35);
  border-top-color: #ffffff;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

/* Security Footnote */
.security-footnote {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.45rem;
  margin-top: 1.75rem;
  padding-top: 1.25rem;
  border-top: 1px solid rgba(191, 200, 206, 0.3);
  text-align: center;
}

.icon-shield {
  font-size: 16px;
  color: #16a34a;
  flex-shrink: 0;
}

.footnote-text {
  font-size: 0.75rem;
  color: #64748b;
  margin: 0;
  font-weight: 600;
}

/* Transitions */
.alert-fade-enter-active,
.alert-fade-leave-active {
  transition: all 0.25s ease;
}
.alert-fade-enter-from,
.alert-fade-leave-to {
  opacity: 0;
  transform: translateY(-8px);
}

/* ============================================================
   RESPONSIVE BREAKPOINTS (TABLET & MOBILE)
   ============================================================ */

/* Tablet View (768px - 1024px) */
@media (max-width: 1024px) {
  .login-card {
    grid-template-columns: 1fr;
    max-width: 580px;
  }

  .login-left-panel {
    display: none;
  }

  .login-right-panel {
    padding: 2.75rem 2.25rem;
  }

  .mobile-brand-banner {
    display: flex;
  }
}

/* Mobile View (max-width: 640px) */
@media (max-width: 640px) {
  .header-container {
    padding: 0.75rem 1rem;
  }

  .brand-subtitle {
    display: none;
  }

  .brand-title {
    font-size: 1rem;
  }

  .brand-logo-frame {
    width: 36px;
    height: 36px;
  }

  .btn-back-home {
    padding: 0.4rem 0.75rem;
    font-size: 0.78rem;
  }

  .back-text {
    display: none;
  }

  .btn-back-home::after {
    content: 'Beranda';
  }

  .login-main {
    padding: 1.25rem 0.85rem;
    align-items: flex-start;
  }

  .login-card {
    border-radius: 18px;
    box-shadow: 0 8px 24px rgba(9, 29, 46, 0.06);
  }

  .login-right-panel {
    padding: 1.75rem 1.25rem;
  }

  .form-main-title {
    font-size: 1.45rem;
  }

  .form-subtitle {
    font-size: 0.825rem;
  }

  .demo-card {
    flex-direction: column;
    align-items: stretch;
    gap: 0.65rem;
    padding: 0.75rem 0.85rem;
  }

  .btn-demo-fill {
    width: 100%;
    justify-content: center;
    padding: 0.5rem 1rem;
  }

  .form-field {
    font-size: 16px; /* Mencegah auto-zoom di iOS Safari saat fokus input */
    padding: 0.75rem 2.75rem 0.75rem 2.65rem;
  }

  .btn-login-submit {
    padding: 0.9rem 1.25rem;
    font-size: 0.95rem;
  }
}
</style>
