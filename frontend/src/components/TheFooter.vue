<template>
  <footer class="footer">
    <div class="container">
      <!-- Main footer grid -->
      <div class="footer-grid">
        <!-- Brand column -->
        <div class="footer-brand">
          <router-link to="/" class="footer-logo">
            <span class="footer-logo-icon">
              <span class="material-symbols-outlined">child_care</span>
            </span>
            <div>
              <span class="footer-brand-name">{{ settings?.clinic_name || "Amanah Tin's Center" }}</span>
              <span class="footer-brand-tag">{{ settings?.tagline || "Pusat Terapi Tumbuh Kembang Anak" }}</span>
            </div>
          </router-link>
          <p class="footer-desc">
            {{ settings?.about_summary || "Mendampingi tumbuh kembang buah hati dengan metode terapi terukur, profesional, dan penuh kasih sayang." }}
          </p>
          <!-- Social Media -->
          <div class="social-links" v-if="hasSocialLinks">
            <a
              v-if="instagramUrl"
              :href="instagramUrl"
              target="_blank"
              rel="noopener noreferrer"
              class="social-link"
              aria-label="Instagram"
              title="Instagram Resmi"
            >
              <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
              </svg>
            </a>
            <a
              v-if="facebookUrl"
              :href="facebookUrl"
              target="_blank"
              rel="noopener noreferrer"
              class="social-link"
              aria-label="Facebook"
              title="Facebook Resmi"
            >
              <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
              </svg>
            </a>
            <a
              v-if="youtubeUrl"
              :href="youtubeUrl"
              target="_blank"
              rel="noopener noreferrer"
              class="social-link"
              aria-label="YouTube"
              title="Kanal YouTube Resmi"
            >
              <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.5 12 3.5 12 3.5s-7.505 0-9.377.55a3.016 3.016 0 0 0-2.122 2.136C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.55 9.376.55 9.376.55s7.505 0 9.377-.55a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
              </svg>
            </a>
          </div>
        </div>

        <!-- Links column 1 -->
        <div class="footer-col">
          <h4 class="footer-heading">Navigasi</h4>
          <ul class="footer-links">
            <li><router-link to="/">Beranda</router-link></li>
            <li><router-link to="/tentang-kami">Tentang Kami</router-link></li>
            <li><router-link to="/layanan">Layanan Kami</router-link></li>
            <li><router-link to="/tim-kami">Tim Kami</router-link></li>
            <li><router-link to="/artikel">Artikel & Tips</router-link></li>
            <li><router-link to="/jadwal-pendaftaran">Jadwal & Pendaftaran</router-link></li>
          </ul>
        </div>

        <!-- Links column 2 -->
        <div class="footer-col">
          <h4 class="footer-heading">Layanan</h4>
          <ul class="footer-links">
            <li><router-link to="/layanan/terapi-wicara">Terapi Wicara</router-link></li>
            <li><router-link to="/layanan/terapi-okupasi">Terapi Okupasi</router-link></li>
            <li><router-link to="/layanan/sensori-integrasi">Sensori Integrasi</router-link></li>
            <li><router-link to="/layanan/psikologi-anak">Psikologi Anak</router-link></li>
          </ul>
        </div>

        <!-- Contact column -->
        <div class="footer-col">
          <h4 class="footer-heading">Kontak</h4>
          <ul class="footer-contact">
            <li>
              <span class="material-symbols-outlined text-sm">location_on</span>
              <a
                v-if="settings?.maps_url"
                :href="settings.maps_url"
                target="_blank"
                rel="noopener noreferrer"
                class="footer-address-link"
              >
                {{ settings?.address || 'Jl. Raya Jagakarsa, Jakarta Selatan' }}
              </a>
              <span v-else>{{ settings?.address || 'Jl. Raya Jagakarsa, Jakarta Selatan' }}</span>
            </li>
            <li>
              <span class="material-symbols-outlined text-sm">chat</span>
              <a :href="waLink('Halo Admin Amanah Tin\'s Center, saya ingin bertanya info layanan')" target="_blank" rel="noopener noreferrer">
                {{ formattedWaNumber }}
              </a>
            </li>
            <li v-if="settings?.phone">
              <span class="material-symbols-outlined text-sm">call</span>
              <a :href="`tel:${settings.phone.replace(/[^0-9+]/g, '')}`">{{ settings.phone }}</a>
            </li>
            <li>
              <span class="material-symbols-outlined text-sm">mail</span>
              <a :href="`mailto:${settings?.email || 'info@amanahtinscenter.com'}`">{{ settings?.email || 'info@amanahtinscenter.com' }}</a>
            </li>
            <li>
              <span class="material-symbols-outlined text-sm">schedule</span>
              <div>
                <span>{{ settings?.weekday_hours || 'Senin–Jumat: 08.00 – 17.00 WIB' }}</span>
                <span v-if="settings?.weekend_hours" class="block-hours"><br/>{{ settings.weekend_hours }}</span>
              </div>
            </li>
          </ul>
        </div>
      </div>

      <!-- Footer bottom -->
      <div class="footer-bottom">
        <p class="footer-copy">
          © {{ new Date().getFullYear() }} Amanah Tin's Center. Seluruh hak cipta dilindungi.
        </p>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { computed } from 'vue'
import { useClinicSettings } from '../composables/useClinicSettings'

const { settings, whatsappNumber, waLink } = useClinicSettings()

const formattedWaNumber = computed(() => {
  const p = whatsappNumber.value
  if (p && p.startsWith('62') && p.length >= 11) {
    return `+62 ${p.slice(2, 5)}-${p.slice(5, 9)}-${p.slice(9)}`
  }
  return p ? `+${p}` : 'WhatsApp Klinik'
})

const instagramUrl = computed(() => {
  const ig = settings.value?.instagram
  if (!ig) return null
  if (ig.startsWith('http')) return ig
  return `https://instagram.com/${ig.replace('@', '')}`
})

const facebookUrl = computed(() => {
  const fb = settings.value?.facebook
  if (!fb) return null
  if (fb.startsWith('http')) return fb
  return `https://facebook.com/${fb}`
})

const youtubeUrl = computed(() => {
  const yt = settings.value?.youtube
  if (!yt) return null
  if (yt.startsWith('http')) return yt
  return `https://youtube.com/@${yt.replace('@', '')}`
})

const hasSocialLinks = computed(() => {
  return !!(instagramUrl.value || facebookUrl.value || youtubeUrl.value)
})
</script>

<style scoped>
.footer {
  background-color: var(--inverse-surface);
  color: var(--inverse-on-surface);
  padding: var(--space-xl) 0 var(--space-lg);
  margin-top: auto;
}

.footer-grid {
  display: grid;
  grid-template-columns: 2fr 1fr 1fr 1.5fr;
  gap: var(--space-lg);
  padding-bottom: var(--space-lg);
  border-bottom: 1px solid rgba(255,255,255,0.1);
}

.footer-logo {
  display: flex;
  align-items: center;
  gap: 0.625rem;
  text-decoration: none;
  color: var(--inverse-on-surface);
  margin-bottom: 1rem;
}

.footer-logo-icon {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background-color: rgba(136, 208, 244, 0.2);
  color: var(--inverse-primary);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.footer-brand-name {
  display: block;
  font-family: var(--font-headline);
  font-size: 16px;
  font-weight: 700;
  color: white;
}

.footer-brand-tag {
  display: block;
  font-size: 11px;
  color: rgba(232, 242, 255, 0.7);
}

.footer-desc {
  font-size: 14px;
  line-height: 1.6;
  color: rgba(232, 242, 255, 0.7);
  margin-bottom: 1.25rem;
}

.social-links {
  display: flex;
  gap: 0.75rem;
}

.social-link {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background-color: rgba(255,255,255,0.1);
  display: flex;
  align-items: center;
  justify-content: center;
  color: rgba(232, 242, 255, 0.8);
  text-decoration: none;
  transition: background-color 0.2s, color 0.2s;
}

.social-link:hover {
  background-color: var(--primary);
  color: white;
}

.footer-heading {
  font-family: var(--font-headline);
  font-size: 15px;
  font-weight: 700;
  color: white;
  margin-bottom: 1rem;
  letter-spacing: 0.02em;
}

.footer-links {
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.footer-links a {
  color: rgba(232, 242, 255, 0.7);
  text-decoration: none;
  font-size: 14px;
  transition: color 0.15s;
}

.footer-links a:hover {
  color: white;
}

.footer-contact {
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 0.625rem;
}

.footer-contact li {
  display: flex;
  align-items: flex-start;
  gap: 0.5rem;
  font-size: 14px;
  color: rgba(232, 242, 255, 0.7);
}

.footer-contact a {
  color: rgba(232, 242, 255, 0.7);
  text-decoration: none;
  transition: color 0.15s;
}

.footer-contact a:hover {
  color: white;
}

.footer-contact .material-symbols-outlined {
  font-size: 16px;
  color: var(--inverse-primary);
  flex-shrink: 0;
  margin-top: 1px;
}

.footer-bottom {
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  padding-top: var(--space-md);
}

.footer-copy {
  font-size: 12px;
  color: rgba(232, 242, 255, 0.5);
}

@media (max-width: 900px) {
  .footer-grid {
    grid-template-columns: 1fr 1fr;
  }
  .footer-brand {
    grid-column: 1 / -1;
  }
}

@media (max-width: 600px) {
  .footer-grid {
    grid-template-columns: 1fr;
  }
  .footer-bottom {
    flex-direction: column;
    gap: 0.5rem;
    text-align: center;
  }
}
</style>
