<template>
  <div class="admin-shell">
    <!-- Mobile Backdrop -->
    <div v-if="isMobileOpen" class="sidebar-backdrop" @click="isMobileOpen = false"></div>

    <!-- Sidebar -->
    <aside class="admin-sidebar" :class="{ 'sidebar-collapsed': isCollapsed, 'mobile-open': isMobileOpen }">
      <div class="sidebar-top">
        <!-- Clinic Brand Header -->
        <div class="brand-box">
          <div class="brand-avatar">
            <span class="material-symbols-outlined">child_care</span>
          </div>
          <div class="brand-text" v-if="!isCollapsed">
            <h2 class="brand-title">Amanah Tin's Center</h2>
            <span class="brand-sub">Portal Admin & Terapis</span>
          </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="sidebar-nav">
          <router-link to="/admin/dashboard" class="nav-item" active-class="nav-item-active" @click="closeMobile">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="nav-label" v-if="!isCollapsed">Dashboard Ringkasan</span>
          </router-link>

          <!-- Menu "Janji & Pendaftaran" dinonaktifkan: pendaftaran kini langsung via WhatsApp -->

          <router-link to="/admin/artikel" class="nav-item" active-class="nav-item-active" @click="closeMobile">
            <span class="material-symbols-outlined">menu_book</span>
            <span class="nav-label" v-if="!isCollapsed">Kelola Artikel & Tips</span>
          </router-link>

          <router-link to="/admin/tim-kami" class="nav-item" active-class="nav-item-active" @click="closeMobile">
            <span class="material-symbols-outlined">group</span>
            <span class="nav-label" v-if="!isCollapsed">Kelola Tim Terapis</span>
          </router-link>

          <router-link to="/admin/pengaturan" class="nav-item" active-class="nav-item-active" @click="closeMobile">
            <span class="material-symbols-outlined">settings</span>
            <span class="nav-label" v-if="!isCollapsed">Pengaturan Klinik</span>
          </router-link>
        </nav>

        <div class="nav-divider" v-if="!isCollapsed"></div>

        <!-- External Website Link -->
        <a href="/" target="_blank" class="external-link" v-if="!isCollapsed">
          <span class="material-symbols-outlined">open_in_new</span>
          <span>Tinjau Website Utama</span>
        </a>
      </div>

      <!-- User Profile Box -->
      <div class="sidebar-user">
        <div class="user-avatar">
          {{ userInitials }}
        </div>
        <div class="user-meta" v-if="!isCollapsed">
          <div class="user-name">{{ auth.user?.name || 'Admin ATC' }}</div>
          <div class="user-role">{{ auth.user?.email || 'admin@amanahtins.id' }}</div>
        </div>
        <button class="logout-btn" @click="handleLogout" title="Keluar Akun" v-if="!isCollapsed">
          <span class="material-symbols-outlined">logout</span>
        </button>
      </div>
    </aside>

    <!-- Main Content Area -->
    <div class="admin-main">
      <!-- Topbar Header -->
      <header class="admin-topbar">
        <div class="topbar-left">
          <button class="toggle-sidebar-btn" @click="toggleSidebar" title="Menu Navigasi" aria-label="Toggle Navigation">
            <span class="material-symbols-outlined">menu</span>
          </button>
          <div class="breadcrumb-trail">
            <span class="crumb-root">Admin Portal</span>
            <span class="material-symbols-outlined crumb-sep">chevron_right</span>
            <span class="crumb-current">{{ title }}</span>
          </div>
        </div>

        <!-- Topbar Right (kosong atau profil/aksi lain) -->
        <div class="topbar-right"></div>
      </header>

      <!-- Page Body -->
      <main class="admin-content">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'

defineProps({
  title: {
    type: String,
    default: 'Dashboard'
  }
})

const router = useRouter()
const auth = useAuthStore()
const isCollapsed = ref(false)
const isMobileOpen = ref(false)

function toggleSidebar() {
  if (typeof window !== 'undefined' && window.innerWidth <= 768) {
    isMobileOpen.value = !isMobileOpen.value
  } else {
    isCollapsed.value = !isCollapsed.value
  }
}

function closeMobile() {
  isMobileOpen.value = false
}

const userInitials = computed(() => {
  const name = auth.user?.name || 'Admin'
  return name.split(' ').map(n => n[0]).slice(0, 2).join('').toUpperCase()
})

async function handleLogout() {
  if (confirm('Apakah Anda yakin ingin keluar dari portal admin?')) {
    await auth.logout()
    router.push('/admin/login')
  }
}
</script>

<style scoped>
.admin-shell {
  display: flex;
  min-height: 100vh;
  background-color: var(--background, #f7f9ff);
  color: var(--on-surface, #091d2e);
  font-family: var(--font-body, 'Nunito Sans', sans-serif);
}

.admin-sidebar {
  width: 280px;
  background: var(--surface-container-lowest, #ffffff);
  border-right: 1px solid rgba(191, 200, 206, 0.35);
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  flex-shrink: 0;
  height: 100vh;
  position: sticky;
  top: 0;
  z-index: 40;
  transition: width 0.25s ease;
}

.admin-sidebar.sidebar-collapsed {
  width: 78px;
}

.sidebar-top {
  padding: 1.5rem 1.25rem;
  display: flex;
  flex-direction: column;
}

.brand-box {
  display: flex;
  align-items: center;
  gap: 0.875rem;
  margin-bottom: 1.5rem;
}

.brand-avatar {
  width: 44px;
  height: 44px;
  border-radius: 12px;
  background: var(--primary-fixed, #c1e8ff);
  color: var(--primary, #006384);
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
}

.brand-title {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 1.125rem;
  font-weight: 700;
  color: var(--primary, #006384);
  line-height: 1.2;
}

.brand-sub {
  font-size: 0.75rem;
  color: var(--on-surface-variant, #40484d);
}

.sidebar-nav {
  display: flex;
  flex-direction: column;
  gap: 0.4rem;
}

.nav-item {
  display: flex;
  align-items: center;
  gap: 0.875rem;
  padding: 0.75rem 1rem;
  border-radius: 9999px;
  color: var(--on-surface-variant, #40484d);
  font-weight: 600;
  font-size: 0.9375rem;
  text-decoration: none;
  transition: all 0.2s ease;
}

.nav-item:hover {
  background: var(--surface-container-low, #edf4ff);
  color: var(--primary, #006384);
}

.nav-item-active {
  background: var(--primary-fixed, #c1e8ff) !important;
  color: var(--primary, #006384) !important;
  font-weight: 700;
  box-shadow: 0 2px 6px rgba(0, 99, 132, 0.08);
}

.nav-divider {
  border-top: 1px solid rgba(191, 200, 206, 0.35);
  margin: 1.25rem 0;
}

.external-link {
  display: flex;
  align-items: center;
  gap: 0.625rem;
  padding: 0.625rem 1rem;
  border-radius: 12px;
  background: var(--surface-container-low, #edf4ff);
  border: 1px solid rgba(191, 200, 206, 0.4);
  color: var(--primary, #006384);
  font-size: 0.8125rem;
  font-weight: 600;
  text-decoration: none;
  transition: background 0.2s;
}

.external-link:hover {
  background: var(--surface-container, #e3efff);
}

.sidebar-user {
  padding: 1rem 1.25rem;
  margin: 0.75rem;
  border-radius: 16px;
  background: var(--surface-container-low, #edf4ff);
  border: 1px solid rgba(191, 200, 206, 0.3);
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.user-avatar {
  width: 38px;
  height: 38px;
  border-radius: 50%;
  background: rgba(0, 99, 132, 0.15);
  color: var(--primary, #006384);
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 0.875rem;
  flex-shrink: 0;
}

.user-meta {
  overflow: hidden;
  flex: 1;
}

.user-name {
  font-size: 0.875rem;
  font-weight: 700;
  color: var(--on-surface, #091d2e);
  white-space: nowrap;
  text-overflow: ellipsis;
  overflow: hidden;
}

.user-role {
  font-size: 0.75rem;
  color: var(--on-surface-variant, #40484d);
  white-space: nowrap;
  text-overflow: ellipsis;
  overflow: hidden;
}

.logout-btn {
  background: none;
  border: none;
  cursor: pointer;
  color: var(--outline, #70787e);
  padding: 0.35rem;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: color 0.2s, background 0.2s;
}

.logout-btn:hover {
  color: var(--error, #ba1a1a);
  background: rgba(186, 26, 26, 0.08);
}

.admin-main {
  flex: 1;
  display: flex;
  flex-direction: column;
  min-width: 0;
  overflow-y: auto;
}

.admin-topbar {
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(8px);
  position: sticky;
  top: 0;
  z-index: 30;
  padding: 0.875rem 2rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-bottom: 1px solid rgba(191, 200, 206, 0.3);
  box-shadow: 0 4px 12px rgba(43, 61, 79, 0.03);
}

.topbar-left {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.toggle-sidebar-btn {
  background: none;
  border: 1px solid rgba(191, 200, 206, 0.4);
  border-radius: 8px;
  padding: 0.35rem;
  cursor: pointer;
  color: var(--on-surface, #091d2e);
  display: flex;
  align-items: center;
  justify-content: center;
}

.breadcrumb-trail {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.875rem;
  color: var(--on-surface-variant, #40484d);
}

.crumb-sep {
  font-size: 1rem;
  color: var(--outline, #70787e);
}

.crumb-current {
  color: var(--primary, #006384);
  font-weight: 700;
}

.admin-content {
  padding: 2rem;
  max-width: 1380px;
  width: 100%;
  margin: 0 auto;
}

.sidebar-backdrop {
  position: fixed;
  inset: 0;
  background: rgba(9, 29, 46, 0.45);
  backdrop-filter: blur(4px);
  z-index: 45;
  animation: fadeInBackdrop 0.2s ease;
}

@keyframes fadeInBackdrop {
  from { opacity: 0; }
  to { opacity: 1; }
}

@media (max-width: 1024px) {
  .admin-content {
    padding: 1.5rem 1.25rem;
  }
  .admin-topbar {
    padding: 0.75rem 1.25rem;
  }
}

@media (max-width: 768px) {
  .admin-sidebar {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    width: 280px !important;
    transform: translateX(-100%);
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    z-index: 50;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
  }
  .admin-sidebar.mobile-open {
    transform: translateX(0);
  }
  .admin-topbar {
    padding: 0.75rem 1rem;
  }
  .crumb-root,
  .crumb-sep {
    display: none;
  }
  .admin-content {
    padding: 1rem;
  }
}
</style>
