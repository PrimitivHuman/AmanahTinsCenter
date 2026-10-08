<template>
  <header class="navbar">
    <div class="container navbar-inner">
      <!-- Brand Logo -->
      <router-link to="/" class="navbar-brand">
        <span class="brand-icon">
          <span class="material-symbols-outlined">child_care</span>
        </span>
        <div class="brand-text">
          <span class="brand-name">Amanah Tin's Center</span>
          <span class="brand-tagline">Pusat Terapi Tumbuh Kembang</span>
        </div>
      </router-link>

      <!-- Desktop Navigation -->
      <nav class="nav-links" :class="{ open: mobileOpen }">
        <a
          v-for="link in navLinks"
          :key="link.id"
          :href="route.path === '/' ? `#${link.id}` : link.path"
          :data-section="link.id"
          class="nav-link"
          :class="{ active: isLinkActive(link) }"
          @click="handleNavClick($event, link)"
        >
          {{ link.label }}
        </a>
      </nav>

      <!-- CTA Button -->
      <div class="navbar-actions">
        <router-link to="/jadwal-pendaftaran" class="btn-primary btn-sm">
          Daftar Sekarang
          <span class="material-symbols-outlined" style="font-size:18px">arrow_forward</span>
        </router-link>
        <!-- Mobile toggle -->
        <button class="mobile-toggle" @click="mobileOpen = !mobileOpen" :aria-expanded="mobileOpen" aria-label="Toggle menu">
          <span class="material-symbols-outlined">{{ mobileOpen ? 'close' : 'menu' }}</span>
        </button>
      </div>
    </div>

    <!-- Mobile menu overlay -->
    <div v-if="mobileOpen" class="mobile-overlay" @click="mobileOpen = false"></div>
  </header>
</template>

<script setup>
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { activeSection } from '../composables/useActiveSection'

const route = useRoute()
const router = useRouter()
const mobileOpen = ref(false)

const navLinks = [
  { id: 'beranda', path: '/', label: 'Beranda' },
  { id: 'tentang-kami', path: '/tentang-kami', label: 'Tentang Kami' },
  { id: 'layanan', path: '/layanan', label: 'Layanan' },
  { id: 'tim-kami', path: '/tim-kami', label: 'Tim Kami' },
  { id: 'artikel', path: '/artikel', label: 'Artikel & Tips' },
  { id: 'jadwal', path: '/jadwal-pendaftaran', label: 'Jadwal & Pendaftaran' },
  { id: 'kontak', path: '/#kontak', label: 'Kontak' },
]

function isLinkActive(link) {
  if (route.path === '/') {
    return activeSection.value === link.id
  }
  return route.path === link.path
}

function handleNavClick(e, link) {
  mobileOpen.value = false
  if (route.path === '/') {
    e.preventDefault()
    if (link.id === 'beranda') {
      window.scrollTo({ top: 0, behavior: 'smooth' })
      history.pushState(null, '', '/')
      activeSection.value = 'beranda'
      return
    }
    const target = document.getElementById(link.id)
    if (target) {
      const navHeight = 80
      const targetTop = target.getBoundingClientRect().top + window.scrollY - navHeight
      window.scrollTo({ top: targetTop, behavior: 'smooth' })
      history.pushState(null, '', `#${link.id}`)
      activeSection.value = link.id
    }
  } else {
    if (link.id === 'kontak') {
      e.preventDefault()
      router.push({ path: '/', hash: '#kontak' })
    } else {
      e.preventDefault()
      router.push(link.path)
    }
  }
}
</script>

<style scoped>
.navbar {
  background-color: rgba(255, 255, 255, 0.92);
  backdrop-filter: blur(12px);
  position: sticky;
  top: 0;
  z-index: 50;
  border-bottom: 1px solid rgba(191, 200, 206, 0.3);
  box-shadow: 0 2px 8px rgba(9, 29, 46, 0.04);
}

.navbar-inner {
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 80px;
  gap: 1rem;
}

.navbar-brand {
  display: flex;
  align-items: center;
  gap: 0.625rem;
  text-decoration: none;
  flex-shrink: 0;
}

.brand-icon {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background-color: var(--primary-fixed);
  color: var(--primary);
  display: flex;
  align-items: center;
  justify-content: center;
  transition: transform 0.2s;
}

.navbar-brand:hover .brand-icon {
  transform: scale(1.05);
}

.brand-text {
  display: flex;
  flex-direction: column;
}

.brand-name {
  font-family: var(--font-headline);
  font-size: 17px;
  font-weight: 700;
  color: var(--primary);
  line-height: 1.2;
}

.brand-tagline {
  font-size: 11px;
  color: var(--on-surface-variant);
  font-weight: 400;
}

.nav-links {
  display: flex;
  align-items: center;
  gap: 0.25rem;
  flex-wrap: nowrap;
}

.nav-link {
  font-size: 14px;
  font-weight: 600;
  font-family: var(--font-body);
  color: var(--on-surface-variant);
  text-decoration: none;
  padding: 0.375rem 0.625rem;
  border-radius: var(--radius-sm);
  transition: color 0.15s, background-color 0.15s, border-color 0.15s;
  white-space: nowrap;
  border-bottom: 2px solid transparent;
  cursor: pointer;
}

.nav-link:hover {
  color: var(--primary);
  background-color: var(--surface-container-low);
}

.nav-link.active,
.nav-link.router-link-active,
.nav-link.router-link-exact-active {
  color: var(--primary) !important;
  font-weight: 700;
  border-bottom: 2px solid var(--primary);
}

.navbar-actions {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  flex-shrink: 0;
}

.btn-sm {
  padding: 0.5rem 1.25rem;
  font-size: 14px;
}

.mobile-toggle {
  display: none;
  background: none;
  border: none;
  cursor: pointer;
  color: var(--on-surface);
  padding: 0.375rem;
  border-radius: var(--radius-sm);
}

.mobile-overlay {
  display: none;
}

@media (max-width: 900px) {
  .nav-links {
    position: fixed;
    top: 80px;
    left: 0;
    right: 0;
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(12px);
    flex-direction: column;
    padding: 1.5rem var(--margin-mobile);
    gap: 0.25rem;
    border-bottom: 1px solid rgba(191, 200, 206, 0.3);
    transform: translateY(-110%);
    transition: transform 0.3s ease;
    z-index: 49;
  }

  .nav-links.open {
    transform: translateY(0);
  }

  .nav-link {
    width: 100%;
    padding: 0.75rem 1rem;
    font-size: 15px;
  }

  .mobile-toggle {
    display: flex;
  }

  .mobile-overlay {
    display: block;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.3);
    z-index: 48;
    top: 80px;
  }
}
</style>
