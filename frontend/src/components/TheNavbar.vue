<template>
  <header class="navbar-wrapper" :class="{ 'scrolled': isScrolled }">
    <nav class="main-navbar" aria-label="Navigasi Utama">
      <div class="container navbar-inner">
        <!-- Brand Logo -->
        <router-link to="/" class="navbar-brand" @click="handleBrandClick">
          <div class="brand-logo-frame">
            <!-- Medical Shield & Child Joyful Custom SVG Mark -->
            <svg class="brand-svg" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect width="40" height="40" rx="12" fill="url(#brandGrad)" />
              <path d="M20 9C20 9 12 14.5 12 21.5C12 26.5 15.8 29.5 20 31.5C24.2 29.5 28 26.5 28 21.5C28 14.5 20 9 20 9Z" fill="white" fill-opacity="0.2" />
              <!-- Child & Star Figure -->
              <circle cx="20" cy="17" r="3.2" fill="white" />
              <path d="M14.5 25.5C15.2 22.8 17.4 21.2 20 21.2C22.6 21.2 24.8 22.8 25.5 25.5" stroke="white" stroke-width="2" stroke-linecap="round" />
              <!-- Heart symbol -->
              <path d="M20 27L18.8 25.9C15.5 23 14 21.6 14 19.8C14 18.2 15.2 17 16.8 17C17.7 17 18.6 17.4 19.1 18.1L20 19.1L20.9 18.1C21.4 17.4 22.3 17 23.2 17C24.8 17 26 18.2 26 19.8C26 21.6 24.5 23 21.2 25.9L20 27Z" fill="#FFC857" />
              <defs>
                <linearGradient id="brandGrad" x1="0" y1="0" x2="40" y2="40" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#006384" />
                  <stop offset="1" stop-color="#00839e" />
                </linearGradient>
              </defs>
            </svg>
          </div>
          <div class="brand-text">
            <span class="brand-name">Amanah Tin's Center</span>
            <span class="brand-tagline">Pusat Terapi &amp; Tumbuh Kembang Anak</span>
          </div>
        </router-link>

        <!-- Desktop Navigation Links (Termasuk Kontak) -->
        <div class="desktop-nav">
          <ul class="nav-list">
            <li v-for="link in navLinks" :key="link.path" class="nav-item">
              <a
                v-if="link.isAnchor"
                :href="link.path"
                class="nav-link"
                :class="{ 'active': isRouteActive(link.path, true) }"
                @click="handleNavClick(link, $event)"
              >
                <span>{{ link.label }}</span>
              </a>
              <router-link
                v-else
                :to="link.path"
                class="nav-link"
                :class="{ 'active': isRouteActive(link.path, false) }"
                @click="handleNavClick(link, $event)"
              >
                <span>{{ link.label }}</span>
                <span v-if="link.badge" class="nav-pill-badge">{{ link.badge }}</span>
              </router-link>
            </li>
          </ul>
        </div>

        <!-- Mobile Hamburger Toggle (Tombol Tanya WA dan Jadwalkan Konsultasi dihapus) -->
        <div class="navbar-actions">
          <button
            class="mobile-toggle"
            @click="toggleMobileMenu"
            :aria-expanded="mobileOpen"
            aria-label="Buka navigasi menu"
          >
            <span class="material-symbols-outlined hamburger-icon">
              {{ mobileOpen ? 'close' : 'menu' }}
            </span>
          </button>
        </div>
      </div>
    </nav>

    <!-- ===== MOBILE NAVIGATION DRAWER ===== -->
    <transition name="drawer-fade">
      <div v-if="mobileOpen" class="mobile-drawer-overlay" @click="closeMobileMenu">
        <aside class="mobile-drawer" @click.stop>
          <!-- Drawer Header -->
          <div class="drawer-header">
            <div class="drawer-brand">
              <span class="drawer-brand-name">Amanah Tin's Center</span>
              <span class="drawer-brand-sub">Jagakarsa, Jakarta Selatan</span>
            </div>
            <button class="drawer-close-btn" @click="closeMobileMenu" aria-label="Tutup menu">
              <span class="material-symbols-outlined">close</span>
            </button>
          </div>

          <!-- Drawer Navigation Links -->
          <nav class="drawer-nav">
            <ul class="drawer-list">
              <li v-for="link in navLinks" :key="link.path">
                <a
                  v-if="link.isAnchor"
                  :href="link.path"
                  class="drawer-link"
                  :class="{ 'active': isRouteActive(link.path, true) }"
                  @click="handleNavClick(link, $event); closeMobileMenu()"
                >
                  <div class="drawer-link-left">
                    <span class="material-symbols-outlined drawer-icon">{{ link.icon }}</span>
                    <span>{{ link.label }}</span>
                  </div>
                  <span class="material-symbols-outlined drawer-arrow">chevron_right</span>
                </a>
                <router-link
                  v-else
                  :to="link.path"
                  class="drawer-link"
                  :class="{ 'active': isRouteActive(link.path, false) }"
                  @click="handleNavClick(link, $event); closeMobileMenu()"
                >
                  <div class="drawer-link-left">
                    <span class="material-symbols-outlined drawer-icon">{{ link.icon }}</span>
                    <span>{{ link.label }}</span>
                  </div>
                  <span v-if="link.badge" class="drawer-badge">{{ link.badge }}</span>
                  <span class="material-symbols-outlined drawer-arrow">chevron_right</span>
                </router-link>
              </li>
            </ul>
          </nav>

          <!-- Drawer Contact Info Strip -->
          <div class="drawer-contact-card">
            <div class="drawer-info-row">
              <span class="material-symbols-outlined text-teal">schedule</span>
              <div>
                <span class="info-label">Jam Operasional</span>
                <span class="info-val">Senin – Sabtu: 08.00 – 17.00 WIB</span>
              </div>
            </div>
            <div class="drawer-info-row">
              <span class="material-symbols-outlined text-teal">call</span>
              <div>
                <span class="info-label">Telepon Klinik</span>
                <span class="info-val">(021) 1234 5678</span>
              </div>
            </div>
          </div>
        </aside>
      </div>
    </transition>
  </header>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { activeSection } from '../composables/useActiveSection'

const route = useRoute()
const router = useRouter()

const isScrolled = ref(false)
const mobileOpen = ref(false)

// Navigasi Publik Lengkap - Kontak telah dikembalikan
const navLinks = [
  { label: 'Beranda', path: '/', icon: 'home' },
  { label: 'Tentang Kami', path: '/tentang-kami', icon: 'diversity_1' },
  { label: 'Layanan Terapi', path: '/layanan', icon: 'medical_services' },
  { label: 'Tim Medis', path: '/tim-kami', icon: 'clinical_notes' },
  { label: 'Artikel & Tips', path: '/artikel', icon: 'article' },
  { label: 'Jadwal & Reservasi', path: '/jadwal-pendaftaran', icon: 'event_available' },
  { label: 'Kontak', path: '/#kontak', icon: 'support_agent', isAnchor: true },
]

function isRouteActive(path, isAnchor = false) {
  if (isAnchor) {
    return route.path === '/' && (route.hash === '#kontak' || activeSection.value === 'kontak')
  }
  if (path === '/') {
    return route.path === '/' && !route.hash && activeSection.value !== 'kontak'
  }
  return route.path.startsWith(path)
}

function handleBrandClick() {
  if (route.path === '/') {
    window.scrollTo({ top: 0, behavior: 'smooth' })
  }
}

function handleNavClick(link, e) {
  if (link.isAnchor) {
    e.preventDefault()
    if (route.path === '/') {
      const el = document.getElementById('kontak')
      if (el) {
        const navHeight = 80
        const targetTop = el.getBoundingClientRect().top + window.scrollY - navHeight
        window.scrollTo({ top: targetTop, behavior: 'smooth' })
        history.pushState(null, '', '#kontak')
      }
    } else {
      router.push({ path: '/', hash: '#kontak' })
    }
  } else if (link.path === '/' && route.path === '/') {
    e.preventDefault()
    window.scrollTo({ top: 0, behavior: 'smooth' })
    history.pushState(null, '', '/')
  }
}

function toggleMobileMenu() {
  mobileOpen.value = !mobileOpen.value
  document.body.style.overflow = mobileOpen.value ? 'hidden' : ''
}

function closeMobileMenu() {
  mobileOpen.value = false
  document.body.style.overflow = ''
}

function handleScroll() {
  isScrolled.value = window.scrollY > 20
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll, { passive: true })
  handleScroll()
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
  document.body.style.overflow = ''
})
</script>

<style scoped>
/* ============================================================
   CLEAN & SPACIOUS SINGLE-TIER NAVBAR
   ============================================================ */
.navbar-wrapper {
  position: sticky;
  top: 0;
  z-index: 1000;
  width: 100%;
  transition: all 0.25s ease;
}

.main-navbar {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);
  border-bottom: 1px solid rgba(191, 200, 206, 0.35);
  box-shadow: 0 4px 20px -2px rgba(9, 29, 46, 0.05);
  transition: all 0.2s ease;
}

.scrolled .main-navbar {
  background: rgba(255, 255, 255, 0.98);
  box-shadow: 0 6px 24px -4px rgba(9, 29, 46, 0.09);
  border-bottom-color: rgba(191, 200, 206, 0.45);
}

.navbar-inner {
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 80px;
  gap: 1.5rem;
  transition: height 0.2s ease;
}

.scrolled .navbar-inner {
  height: 72px;
}

/* Brand */
.navbar-brand {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  text-decoration: none;
  flex-shrink: 0;
}

.brand-logo-frame {
  width: 44px;
  height: 44px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.navbar-brand:hover .brand-logo-frame {
  transform: scale(1.06);
}

.brand-svg {
  width: 100%;
  height: 100%;
  filter: drop-shadow(0 2px 6px rgba(0, 99, 132, 0.25));
}

.brand-text {
  display: flex;
  flex-direction: column;
}

.brand-name {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 18px;
  font-weight: 800;
  color: #006384;
  letter-spacing: -0.3px;
  line-height: 1.2;
}

.brand-tagline {
  font-family: var(--font-body, 'Nunito Sans', sans-serif);
  font-size: 11px;
  font-weight: 600;
  color: #556066;
  line-height: 1.2;
}

/* Desktop Nav Links */
.desktop-nav {
  display: flex;
  align-items: center;
}

.nav-list {
  display: flex;
  align-items: center;
  list-style: none;
  margin: 0;
  padding: 0;
  gap: 0.25rem;
}

.nav-link {
  position: relative;
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  padding: 0.5rem 0.85rem;
  font-family: var(--font-body, 'Nunito Sans', sans-serif);
  font-size: 14.5px;
  font-weight: 600;
  color: #40484d;
  text-decoration: none;
  border-radius: 8px;
  transition: all 0.15s ease;
  cursor: pointer;
}

.nav-link:hover {
  color: #006384;
  background-color: #edf4ff;
}

.nav-link.active {
  color: #006384;
  font-weight: 700;
  background-color: #e3efff;
}

.nav-link.active::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 20%;
  right: 20%;
  height: 2.5px;
  background: #006384;
  border-radius: 9999px;
}

.nav-pill-badge {
  font-size: 10px;
  font-weight: 700;
  background: #ccef8e;
  color: #284200;
  padding: 0.1rem 0.4rem;
  border-radius: 9999px;
  line-height: 1.2;
}

/* Right Navbar Actions */
.navbar-actions {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  flex-shrink: 0;
}

/* Mobile Toggle Hamburger */
.mobile-toggle {
  display: none;
  align-items: center;
  justify-content: center;
  background: #edf4ff;
  border: 1px solid rgba(191, 200, 206, 0.4);
  color: #006384;
  width: 42px;
  height: 42px;
  border-radius: 10px;
  cursor: pointer;
  transition: all 0.2s ease;
}

.mobile-toggle:hover {
  background: #e3efff;
}

.hamburger-icon {
  font-size: 24px;
}

/* ===== MOBILE DRAWER NAVIGATION ===== */
.mobile-drawer-overlay {
  position: fixed;
  inset: 0;
  background: rgba(9, 29, 46, 0.45);
  backdrop-filter: blur(4px);
  z-index: 1100;
  display: flex;
  justify-content: flex-end;
}

.mobile-drawer {
  width: 85%;
  max-width: 360px;
  height: 100%;
  background: #ffffff;
  box-shadow: -8px 0 32px rgba(9, 29, 46, 0.16);
  display: flex;
  flex-direction: column;
  overflow-y: auto;
  animation: slideIn 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes slideIn {
  from { transform: translateX(100%); }
  to { transform: translateX(0); }
}

.drawer-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1.25rem 1.25rem;
  border-bottom: 1px solid #edf4ff;
  background: #f7f9ff;
}

.drawer-brand {
  display: flex;
  flex-direction: column;
}

.drawer-brand-name {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 16px;
  font-weight: 800;
  color: #006384;
}

.drawer-brand-sub {
  font-size: 11px;
  color: #70787e;
}

.drawer-close-btn {
  background: #ffffff;
  border: 1px solid #d1e4fb;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  color: #40484d;
}

.drawer-nav {
  flex: 1;
  padding: 1rem 0.75rem;
}

.drawer-list {
  list-style: none;
  margin: 0;
  padding: 0;
  display: flex;
  flex-direction: column;
  gap: 0.35rem;
}

.drawer-link {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0.75rem 1rem;
  text-decoration: none;
  color: #203243;
  font-weight: 600;
  font-size: 15px;
  border-radius: 10px;
  transition: all 0.15s ease;
  cursor: pointer;
}

.drawer-link-left {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.drawer-icon {
  font-size: 20px;
  color: #006384;
}

.drawer-link:hover {
  background: #f0f6ff;
  color: #006384;
}

.drawer-link.active {
  background: #e3efff;
  color: #006384;
  font-weight: 700;
}

.drawer-badge {
  font-size: 10px;
  font-weight: 700;
  background: #ccef8e;
  color: #284200;
  padding: 0.15rem 0.5rem;
  border-radius: 9999px;
}

.drawer-arrow {
  font-size: 18px;
  color: #bfc8ce;
}

.drawer-contact-card {
  margin: 1rem;
  padding: 0.85rem 1rem;
  background: #f7f9ff;
  border: 1px solid #e3efff;
  border-radius: 12px;
  display: flex;
  flex-direction: column;
  gap: 0.65rem;
}

.drawer-info-row {
  display: flex;
  align-items: flex-start;
  gap: 0.65rem;
}

.text-teal {
  color: #006384;
  font-size: 18px;
  margin-top: 1px;
}

.info-label {
  display: block;
  font-size: 11px;
  color: #70787e;
  font-weight: 600;
}

.info-val {
  display: block;
  font-size: 12.5px;
  color: #091d2e;
  font-weight: 700;
}

/* Drawer transitions */
.drawer-fade-enter-active,
.drawer-fade-leave-active {
  transition: opacity 0.25s ease;
}

.drawer-fade-enter-from,
.drawer-fade-leave-to {
  opacity: 0;
}

/* ===== RESPONSIVE BREAKPOINTS ===== */
@media (max-width: 1080px) {
  .nav-link {
    font-size: 13.5px;
    padding: 0.4rem 0.6rem;
  }
  .brand-name {
    font-size: 16px;
  }
}

@media (max-width: 960px) {
  .desktop-nav {
    display: none;
  }
  .mobile-toggle {
    display: flex;
  }
  .navbar-inner {
    height: 70px;
  }
}

@media (max-width: 640px) {
  .brand-tagline {
    display: none;
  }
  .brand-logo-frame {
    width: 38px;
    height: 38px;
  }
  .navbar-inner {
    height: 64px;
  }
}
</style>
