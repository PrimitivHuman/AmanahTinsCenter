import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '../stores/auth'

// Public pages
import HomeView from '../views/HomeView.vue'
import AboutView from '../views/AboutView.vue'
import ServicesView from '../views/ServicesView.vue'
import ServiceDetailView from '../views/ServiceDetailView.vue'
import TeamView from '../views/TeamView.vue'
import ArticlesView from '../views/ArticlesView.vue'
import ArticleDetailView from '../views/ArticleDetailView.vue'
import ScheduleView from '../views/ScheduleView.vue'

// Admin pages
import AdminLoginView from '../views/admin/LoginView.vue'
import AdminDashboardView from '../views/admin/DashboardView.vue'
import AdminArticlesView from '../views/admin/ArticlesView.vue'
import AdminArticleFormView from '../views/admin/ArticleFormView.vue'
import AdminTeamView from '../views/admin/TeamView.vue'
import AdminSettingsView from '../views/admin/SettingsView.vue'
// import AdminScheduleView from '../views/admin/ScheduleView.vue' // dinonaktifkan: pendaftaran via WhatsApp

const routes = [
  // Public routes
  { path: '/', name: 'home', component: HomeView },
  { path: '/tentang-kami', name: 'about', component: AboutView },
  { path: '/layanan', name: 'services', component: ServicesView },
  { path: '/layanan/:slug', name: 'service-detail', component: ServiceDetailView },
  { path: '/tim-kami', name: 'team', component: TeamView },
  { path: '/artikel', name: 'articles', component: ArticlesView },
  { path: '/artikel/:slug', name: 'article-detail', component: ArticleDetailView },
  { path: '/jadwal-pendaftaran', name: 'schedule', component: ScheduleView },

  // Admin routes
  { path: '/admin/login', name: 'admin-login', component: AdminLoginView, meta: { guest: true } },
  {
    path: '/admin',
    meta: { requiresAuth: true },
    children: [
      { path: '', redirect: '/admin/dashboard' },
      { path: 'dashboard', name: 'admin-dashboard', component: AdminDashboardView },
      { path: 'artikel', name: 'admin-articles', component: AdminArticlesView },
      { path: 'artikel/baru', name: 'admin-article-create', component: AdminArticleFormView },
      { path: 'artikel/:id/edit', name: 'admin-article-edit', component: AdminArticleFormView },
      { path: 'tim-kami', name: 'admin-team', component: AdminTeamView },
      // Fitur Janji & Pendaftaran dinonaktifkan (alur pendaftaran diarahkan ke WhatsApp)
      { path: 'jadwal', redirect: '/admin/dashboard' },
      { path: 'pengaturan', name: 'admin-settings', component: AdminSettingsView },
    ]
  },

  // 404
  { path: '/:pathMatch(.*)*', redirect: '/' }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) return savedPosition
    if (to.hash) return { el: to.hash, behavior: 'smooth' }
    return { top: 0, behavior: 'smooth' }
  }
})

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

export default router
