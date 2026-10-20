import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '../stores/auth'
import { useSeo } from '../composables/useSeo'

const routes = [
  // Public routes (Lazy loaded with dynamic import)
  {
    path: '/',
    name: 'home',
    component: () => import('../views/HomeView.vue'),
    meta: {
      title: 'Pusat Terapi Tumbuh Kembang Anak',
      description: "Amanah Tin's Center - Klinik tumbuh kembang anak di Jagakarsa, Jakarta Selatan. Layanan Terapi Wicara, Terapi Okupasi, Sensori Integrasi, dan Psikologi Anak.",
    },
  },
  {
    path: '/tentang-kami',
    name: 'about',
    component: () => import('../views/AboutView.vue'),
    meta: {
      title: 'Tentang Kami - Profil & Komitmen Mutu',
      description: "Kenali profil klinik, fasilitas berstandar medis ramah anak, dan filosofi pengasuhan penuh empati di Amanah Tin's Center Jagakarsa.",
    },
  },
  {
    path: '/layanan',
    name: 'services',
    component: () => import('../views/ServicesView.vue'),
    meta: {
      title: 'Layanan Terapi Terpadu Anak',
      description: 'Program intervensi klinis: Terapi Wicara, Terapi Okupasi, Sensori Integrasi, Fisioterapi Pediatrik, dan Konsultasi Psikologi Anak.',
    },
  },
  {
    path: '/layanan/:slug',
    name: 'service-detail',
    component: () => import('../views/ServiceDetailView.vue'),
    meta: {
      title: 'Detail Layanan Terapi',
      description: 'Informasi komprehensif indikasi anak, tahapan asesmen, dan pendekatan terapi spesialis di ATC.',
    },
  },
  {
    path: '/tim-kami',
    name: 'team',
    alias: ['/tim', '/tim-medis'],
    component: () => import('../views/TeamView.vue'),
    meta: {
      title: 'Tim Medis & Terapis Spesialis',
      description: 'Direktori dokter spesialis anak dan terapis klinis berlisensi STR Kemkes RI di Amanah Tin\'s Center.',
    },
  },
  {
    path: '/artikel',
    name: 'articles',
    component: () => import('../views/ArticlesView.vue'),
    meta: {
      title: 'Artikel & Panduan Tumbuh Kembang',
      description: 'Edukasi parenting, stimulasi speech delay, sensori integrasi, dan tips kemandirian anak dari tim terapis profesional.',
    },
  },
  {
    path: '/artikel/:slug',
    name: 'article-detail',
    component: () => import('../views/ArticleDetailView.vue'),
    meta: {
      title: 'Artikel Edukasi',
      description: 'Panduan lengkap tumbuh kembang anak dan stimulasi terarah.',
    },
  },
  {
    path: '/jadwal-pendaftaran',
    name: 'schedule',
    component: () => import('../views/ScheduleView.vue'),
    meta: {
      title: 'Jadwal & Pendaftaran Terapi',
      description: 'Panduan reservasi jadwal konsultasi dan asesmen awal tumbuh kembang anak di klinik ATC via WhatsApp resmi.',
    },
  },

  // Admin routes (Lazy loaded)
  {
    path: '/admin/login',
    name: 'admin-login',
    component: () => import('../views/admin/LoginView.vue'),
    meta: {
      guest: true,
      title: 'Portal Masuk Admin',
    },
  },
  {
    path: '/admin',
    meta: { requiresAuth: true },
    children: [
      { path: '', redirect: '/admin/dashboard' },
      {
        path: 'dashboard',
        name: 'admin-dashboard',
        component: () => import('../views/admin/DashboardView.vue'),
        meta: { title: 'Dashboard Ringkasan Admin' },
      },
      {
        path: 'artikel',
        name: 'admin-articles',
        component: () => import('../views/admin/ArticlesView.vue'),
        meta: { title: 'Kelola Artikel & Tips' },
      },
      {
        path: 'artikel/baru',
        name: 'admin-article-create',
        component: () => import('../views/admin/ArticleFormView.vue'),
        meta: { title: 'Tulis Artikel Baru' },
      },
      {
        path: 'artikel/:id/edit',
        name: 'admin-article-edit',
        component: () => import('../views/admin/ArticleFormView.vue'),
        meta: { title: 'Edit Artikel' },
      },
      {
        path: 'tim-kami',
        name: 'admin-team',
        component: () => import('../views/admin/TeamView.vue'),
        meta: { title: 'Kelola Tim Terapis' },
      },
      // Fitur Janji & Pendaftaran dialihkan ke WhatsApp resmi
      { path: 'jadwal', redirect: '/admin/dashboard' },
      {
        path: 'pengaturan',
        name: 'admin-settings',
        component: () => import('../views/admin/SettingsView.vue'),
        meta: { title: 'Pengaturan Informasi Klinik' },
      },
    ],
  },

  // 404 Not Found Page (Mencegah Soft 404 di Google Search Console)
  {
    path: '/:pathMatch(.*)*',
    name: 'not-found',
    component: () => import('../views/NotFoundView.vue'),
    meta: {
      title: 'Halaman Tidak Ditemukan (404)',
      description: 'Halaman yang Anda tuju tidak ditemukan pada situs Klinik Amanah Tins Center.',
      robots: 'noindex, follow',
    },
  },
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) return savedPosition
    if (to.hash) return { el: to.hash, behavior: 'smooth' }
    return { top: 0, behavior: 'smooth' }
  },
})

// Navigation Guard untuk Autentikasi Admin
router.beforeEach(async (to, from, next) => {
  const auth = useAuthStore()

  if (to.meta.requiresAuth && !auth.isLoggedIn) {
    next('/admin/login')
  } else if (to.meta.guest && auth.isLoggedIn) {
    next('/admin/dashboard')
  } else {
    next()
  }
})

// Dynamic SEO & Title Update Setelah Navigasi
const seo = useSeo()
router.afterEach((to) => {
  // Hanya atur jika bukan halaman detail artikel / detail layanan (karena keduanya mengatur meta dinamis spesifik sendiri)
  if (to.name !== 'article-detail' && to.name !== 'service-detail') {
    const isAdmin = to.path.startsWith('/admin')
    const robots = to.meta.robots || (isAdmin ? 'noindex, nofollow' : 'index, follow')
    const origin = typeof window !== 'undefined' ? window.location.origin : 'https://tinsgrowcenter.com'

    seo.updateSeo({
      title: to.meta.title || '',
      description: to.meta.description || '',
      url: `${origin}${to.path}`,
      robots,
    })
  }
})

export default router
