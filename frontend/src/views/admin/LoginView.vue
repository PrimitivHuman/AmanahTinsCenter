<template>
  <div class="login-wrapper">
    <!-- Top Header -->
    <header class="login-header">
      <router-link to="/" class="logo-link">
        <div class="logo-icon">
          <span class="material-symbols-outlined">child_care</span>
        </div>
        <div>
          <span class="logo-text">Amanah Tin's Center</span>
          <span class="logo-sub">Portal Administrasi Terpadu</span>
        </div>
      </router-link>
      <router-link to="/" class="back-link">
        <span class="material-symbols-outlined">arrow_back</span>
        <span>Kembali ke Beranda</span>
      </router-link>
    </header>

    <!-- Split Stage -->
    <main class="login-main">
      <div class="login-split-card">
        <!-- Left Branding Panel -->
        <div class="login-left-panel">
          <div>
            <div class="panel-brand-header">
              <div class="brand-badge-icon">
                <span class="material-symbols-outlined">verified_user</span>
              </div>
              <span class="brand-badge-label">Portal Pengelola & Tenaga Medis</span>
            </div>
            <h1 class="panel-title">
              Masuk ke Sistem Administrasi & Manajemen Klinik
            </h1>
            <p class="panel-desc">
              Pusat koordinasi rekam konsultasi, penjadwalan sesi terapi tumbuh kembang wicara dan okupasi, serta tata kelola konten artikel edukasi.
            </p>
          </div>

          <div class="panel-img-box">
            <img
              src="https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?auto=format&fit=crop&q=80&w=800"
              alt="Terapi Tumbuh Kembang"
              class="panel-img"
            />
            <div class="panel-img-overlay">
              <div class="overlay-badge">
                <span class="material-symbols-outlined">favorite</span>
                <span>Dedikasi Penuh Kasih & Keilmuan</span>
              </div>
              <p class="overlay-text">Terintegrasi dengan 4 pilar terapi tersertifikasi klinis.</p>
            </div>
          </div>

          <!-- 4 Pillars Mini Grid -->
          <div class="pillars-grid">
            <div class="pillar-chip">
              <span class="material-symbols-outlined text-teal">record_voice_over</span>
              <span>Terapi Wicara</span>
            </div>
            <div class="pillar-chip">
              <span class="material-symbols-outlined text-green">accessibility_new</span>
              <span>Okupasi & Sensori</span>
            </div>
          </div>
        </div>

        <!-- Right Form Panel -->
        <div class="login-right-panel">
          <div class="form-container">
            <div class="form-header">
              <div class="form-icon-circle">
                <span class="material-symbols-outlined">admin_panel_settings</span>
              </div>
              <h2 class="form-title">Masuk ke Akun Admin</h2>
              <p class="form-subtitle">
                Silakan masukkan kredensial resmi terdaftar Anda untuk mengelola konten dan jadwal.
              </p>
            </div>

            <!-- Demo Credential Note -->
            <div class="demo-box" @click="fillDemoCredentials">
              <span class="material-symbols-outlined">info</span>
              <div>
                <strong>Akun Pengujian Demo:</strong>
                <p>Email: <code>admin@amanahtinscenter.com</code> | Sandi: <code>admin123</code> (Klik untuk isi otomatis)</p>
              </div>
            </div>

            <div v-if="errorMessage" class="error-banner">
              <span class="material-symbols-outlined">error</span>
              <span>{{ errorMessage }}</span>
            </div>

            <form @submit.prevent="handleLogin" class="auth-form">
              <div class="form-group">
                <label for="email">Email Admin</label>
                <div class="input-icon-box">
                  <span class="material-symbols-outlined input-icon">mail</span>
                  <input
                    id="email"
                    v-model="email"
                    type="email"
                    required
                    placeholder="misal: admin@amanahtinscenter.com"
                    class="form-input"
                  />
                </div>
              </div>

              <div class="form-group">
                <div class="label-flex">
                  <label for="password">Kata Sandi</label>
                </div>
                <div class="input-icon-box">
                  <span class="material-symbols-outlined input-icon">lock</span>
                  <input
                    id="password"
                    v-model="password"
                    :type="showPassword ? 'text' : 'password'"
                    required
                    placeholder="Masukkan kata sandi"
                    class="form-input"
                  />
                  <button
                    type="button"
                    class="pw-toggle-btn"
                    @click="showPassword = !showPassword"
                  >
                    <span class="material-symbols-outlined">
                      {{ showPassword ? 'visibility_off' : 'visibility' }}
                    </span>
                  </button>
                </div>
              </div>

              <button
                type="submit"
                class="login-submit-btn"
                :disabled="isLoading"
              >
                <span v-if="isLoading" class="spinner-small"></span>
                <span v-else class="flex-center-gap">
                  <span>Masuk ke Dashboard</span>
                  <span class="material-symbols-outlined">arrow_forward</span>
                </span>
              </button>
            </form>

            <div class="form-footer">
              <span class="material-symbols-outlined security-icon">shield</span>
              <span>Portal diamankan dengan enkripsi SSL & Laravel Sanctum Token.</span>
            </div>
          </div>
        </div>
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
const isLoading = ref(false)
const errorMessage = ref('')

function fillDemoCredentials() {
  email.value = 'admin@amanahtinscenter.com'
  password.value = 'admin123'
}

async function handleLogin() {
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
      errorMessage.value = 'Kombinasi email atau kata sandi tidak valid.'
    }
  } finally {
    isLoading.value = false
  }
}
</script>

<style scoped>
.login-wrapper {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  background-color: var(--background, #f7f9ff);
  font-family: var(--font-body, 'Nunito Sans', sans-serif);
}

.login-header {
  padding: 1.25rem 2.5rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-bottom: 1px solid rgba(191, 200, 206, 0.3);
  background: #ffffff;
}

.logo-link {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  text-decoration: none;
}

.logo-icon {
  width: 40px;
  height: 40px;
  border-radius: 12px;
  background: var(--primary, #006384);
  color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
}

.logo-text {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-weight: 700;
  font-size: 1.125rem;
  color: var(--primary, #006384);
  display: block;
  line-height: 1.2;
}

.logo-sub {
  font-size: 0.75rem;
  color: var(--on-surface-variant, #40484d);
}

.back-link {
  display: flex;
  align-items: center;
  gap: 0.375rem;
  color: var(--on-surface-variant, #40484d);
  font-size: 0.875rem;
  font-weight: 600;
  text-decoration: none;
  transition: color 0.2s;
}

.back-link:hover {
  color: var(--primary, #006384);
}

.login-main {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2.5rem 1.5rem;
}

.login-split-card {
  width: 100%;
  max-width: 1100px;
  display: grid;
  grid-template-columns: 1fr 1.2fr;
  background: #ffffff;
  border-radius: 24px;
  border: 1px solid rgba(191, 200, 206, 0.4);
  box-shadow: 0 16px 36px rgba(43, 61, 79, 0.08);
  overflow: hidden;
}

.login-left-panel {
  background: linear-gradient(145deg, #edf4ff 0%, #e3efff 100%);
  padding: 2.5rem;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  border-right: 1px solid rgba(191, 200, 206, 0.3);
}

.panel-brand-header {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.35rem 0.75rem;
  border-radius: 9999px;
  background: rgba(0, 99, 132, 0.1);
  color: var(--primary, #006384);
  font-size: 0.75rem;
  font-weight: 700;
  margin-bottom: 1.25rem;
}

.panel-title {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 1.75rem;
  font-weight: 700;
  color: var(--on-surface, #091d2e);
  line-height: 1.3;
  margin-bottom: 0.75rem;
}

.panel-desc {
  font-size: 0.9375rem;
  color: var(--on-surface-variant, #40484d);
  line-height: 1.6;
}

.panel-img-box {
  margin: 1.75rem 0;
  position: relative;
  border-radius: 16px;
  overflow: hidden;
  height: 200px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}

.panel-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.panel-img-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to top, rgba(9, 29, 46, 0.8) 0%, transparent 60%);
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  padding: 1rem;
  color: #ffffff;
}

.overlay-badge {
  display: flex;
  align-items: center;
  gap: 0.375rem;
  font-weight: 700;
  font-size: 0.8125rem;
}

.overlay-text {
  font-size: 0.75rem;
  opacity: 0.9;
  margin-top: 0.25rem;
}

.pillars-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 0.75rem;
}

.pillar-chip {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  background: #ffffff;
  padding: 0.625rem 0.875rem;
  border-radius: 12px;
  font-size: 0.8125rem;
  font-weight: 700;
  color: var(--on-surface, #091d2e);
  border: 1px solid rgba(191, 200, 206, 0.3);
}

.text-teal { color: var(--primary, #006384); }
.text-green { color: var(--secondary, #4b6716); }

.login-right-panel {
  padding: 3rem 2.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
}

.form-container {
  max-width: 420px;
  width: 100%;
}

.form-header {
  margin-bottom: 1.5rem;
}

.form-icon-circle {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  background: var(--primary-fixed, #c1e8ff);
  color: var(--primary, #006384);
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 0.75rem;
}

.form-title {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--on-surface, #091d2e);
}

.form-subtitle {
  font-size: 0.875rem;
  color: var(--on-surface-variant, #40484d);
  margin-top: 0.35rem;
}

.demo-box {
  background: rgba(204, 239, 142, 0.35);
  border: 1px dashed rgba(75, 103, 22, 0.4);
  border-radius: 12px;
  padding: 0.75rem 1rem;
  font-size: 0.8125rem;
  color: #2e4400;
  margin-bottom: 1.5rem;
  cursor: pointer;
  display: flex;
  align-items: flex-start;
  gap: 0.5rem;
  transition: background 0.2s;
}

.demo-box:hover {
  background: rgba(204, 239, 142, 0.55);
}

.demo-box code {
  background: rgba(255, 255, 255, 0.8);
  padding: 0.15rem 0.35rem;
  border-radius: 4px;
  font-weight: bold;
}

.error-banner {
  background: #ffdad6;
  color: #93000a;
  padding: 0.75rem 1rem;
  border-radius: 12px;
  font-size: 0.8125rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 1.25rem;
}

.auth-form {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.375rem;
}

.form-group label {
  font-size: 0.875rem;
  font-weight: 700;
  color: var(--on-surface, #091d2e);
}

.label-flex {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.input-icon-box {
  position: relative;
  display: flex;
  align-items: center;
}

.input-icon {
  position: absolute;
  left: 1rem;
  color: var(--outline, #70787e);
  pointer-events: none;
  font-size: 1.25rem;
}

.form-input {
  width: 100%;
  padding: 0.75rem 1rem 0.75rem 2.875rem;
  border-radius: 12px;
  border: 1px solid rgba(191, 200, 206, 0.6);
  background: var(--surface-bright, #f7f9ff);
  font-size: 0.9375rem;
  font-family: inherit;
  color: var(--on-surface, #091d2e);
  transition: all 0.2s;
}

.form-input:focus {
  outline: none;
  border-color: var(--primary, #006384);
  box-shadow: 0 0 0 4px rgba(0, 99, 132, 0.12);
  background: #ffffff;
}

.pw-toggle-btn {
  position: absolute;
  right: 0.875rem;
  background: none;
  border: none;
  cursor: pointer;
  color: var(--outline, #70787e);
  display: flex;
  align-items: center;
  padding: 0.25rem;
}

.login-submit-btn {
  width: 100%;
  padding: 0.875rem;
  border-radius: 9999px;
  background: var(--primary, #006384);
  color: #ffffff;
  border: none;
  font-family: inherit;
  font-size: 0.9375rem;
  font-weight: 700;
  cursor: pointer;
  box-shadow: 0 4px 12px rgba(0, 99, 132, 0.25);
  transition: all 0.2s;
  margin-top: 0.5rem;
}

.login-submit-btn:hover:not(:disabled) {
  background: var(--primary-container, #2e7c9e);
  transform: translateY(-1px);
}

.login-submit-btn:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

.flex-center-gap {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
}

.spinner-small {
  display: inline-block;
  width: 20px;
  height: 20px;
  border: 2px solid rgba(255, 255, 255, 0.3);
  border-radius: 50%;
  border-top-color: #ffffff;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.form-footer {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-top: 1.75rem;
  font-size: 0.75rem;
  color: var(--on-surface-variant, #40484d);
  line-height: 1.4;
}

.security-icon {
  font-size: 1.125rem;
  color: var(--secondary, #4b6716);
  flex-shrink: 0;
}

@media (max-width: 900px) {
  .login-split-card {
    grid-template-columns: 1fr;
  }
  .login-left-panel {
    display: none;
  }
}
</style>
