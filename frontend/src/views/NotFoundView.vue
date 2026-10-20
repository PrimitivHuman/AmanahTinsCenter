<template>
  <PublicLayout>
    <section class="not-found-wrapper">
      <div class="container not-found-container">
        <div class="not-found-card fade-in-up">
          <div class="badge-pill">
            <span class="material-symbols-outlined">help_outline</span>
            <span>Error 404 - Halaman Tidak Ditemukan</span>
          </div>

          <h1 class="not-found-title">Oops! Halaman yang Anda Cari Tidak Ada</h1>
          <p class="not-found-desc">
            Alamat web yang Anda tuju mungkin sudah dipindahkan, dihapus, atau tautan yang Anda klik keliru. Jangan khawatir, Anda dapat kembali ke halaman utama atau menjelajahi layanan terapi kami di bawah ini.
          </p>

          <div class="not-found-actions">
            <router-link to="/" class="btn-primary">
              <span class="material-symbols-outlined">home</span>
              <span>Kembali ke Beranda</span>
            </router-link>
            <router-link to="/layanan" class="btn-secondary">
              <span class="material-symbols-outlined">medical_services</span>
              <span>Lihat Layanan Terapi</span>
            </router-link>
            <router-link to="/artikel" class="btn-secondary">
              <span class="material-symbols-outlined">article</span>
              <span>Baca Artikel Edukasi</span>
            </router-link>
          </div>

          <div class="not-found-help">
            <p>Butuh bantuan segera atau ingin konsultasi?</p>
            <a :href="waLink()" target="_blank" rel="noopener noreferrer" class="link-wa">
              <span class="material-symbols-outlined">chat</span>
              <span>Hubungi Admin WhatsApp Kami</span>
            </a>
          </div>
        </div>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup>
import { onMounted } from 'vue'
import PublicLayout from '../layouts/PublicLayout.vue'
import { useClinicSettings } from '../composables/useClinicSettings'
import { useSeo } from '../composables/useSeo'

const { waLink } = useClinicSettings()
const seo = useSeo()

onMounted(() => {
  seo.updateSeo({
    title: 'Halaman Tidak Ditemukan (404)',
    description: 'Halaman yang Anda tuju tidak ditemukan pada situs Amanah Tins Center.',
    robots: 'noindex, follow',
  })
})
</script>

<style scoped>
.not-found-wrapper {
  min-height: 75vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 5rem 1.5rem;
  background: linear-gradient(180deg, #f8fafc 0%, #edf4ff 100%);
}

.not-found-container {
  max-width: 720px;
  width: 100%;
  margin: 0 auto;
}

.not-found-card {
  background: #ffffff;
  border: 1px solid rgba(191, 200, 206, 0.4);
  border-radius: 24px;
  padding: 3.5rem 2.5rem;
  text-align: center;
  box-shadow: 0 20px 40px rgba(0, 50, 80, 0.06);
}

.badge-pill {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.5rem 1.25rem;
  background: rgba(239, 68, 68, 0.1);
  color: #dc2626;
  border-radius: 9999px;
  font-size: 0.875rem;
  font-weight: 700;
  margin-bottom: 1.5rem;
}

.badge-pill .material-symbols-outlined {
  font-size: 1.15rem;
}

.not-found-title {
  font-family: var(--font-heading, 'Outfit', sans-serif);
  font-size: 2rem;
  font-weight: 800;
  color: #0f172a;
  margin-bottom: 1rem;
  line-height: 1.25;
}

.not-found-desc {
  font-size: 1rem;
  color: #475569;
  line-height: 1.6;
  margin-bottom: 2.25rem;
  max-width: 580px;
  margin-left: auto;
  margin-right: auto;
}

.not-found-actions {
  display: flex;
  flex-wrap: wrap;
  gap: 0.85rem;
  justify-content: center;
  margin-bottom: 2.5rem;
}

.btn-primary {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.85rem 1.5rem;
  background: var(--primary, #0284c7);
  color: #ffffff;
  border-radius: 12px;
  font-weight: 700;
  text-decoration: none;
  transition: all 0.2s ease;
  box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);
}

.btn-primary:hover {
  background: #0369a1;
  transform: translateY(-2px);
}

.btn-secondary {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.85rem 1.5rem;
  background: #f1f5f9;
  color: #334155;
  border-radius: 12px;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.2s ease;
}

.btn-secondary:hover {
  background: #e2e8f0;
  color: #0f172a;
}

.not-found-help {
  padding-top: 1.5rem;
  border-top: 1px solid #e2e8f0;
  font-size: 0.9rem;
  color: #64748b;
}

.link-wa {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  margin-top: 0.5rem;
  color: #16a34a;
  font-weight: 700;
  text-decoration: none;
}

.link-wa:hover {
  text-decoration: underline;
}

@media (max-width: 640px) {
  .not-found-card {
    padding: 2.5rem 1.5rem;
  }
  .not-found-title {
    font-size: 1.5rem;
  }
  .not-found-actions {
    flex-direction: column;
  }
  .btn-primary, .btn-secondary {
    width: 100%;
    justify-content: center;
  }
}
</style>
