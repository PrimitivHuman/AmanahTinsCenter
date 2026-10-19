<template>
  <Transition name="popup-fade">
    <div v-if="isVisible" class="popup-overlay" @click.self="closePopup" role="dialog" aria-modal="true" aria-label="Promo Diskon Layanan Terapi">
      <div class="popup-container" :class="{ 'is-animating': isAnimating }">
        <!-- Close Button -->
        <button class="popup-close" @click="closePopup" aria-label="Tutup popup">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
          </svg>
        </button>

        <!-- Image: Mobile (portrait) -->
        <img
          class="popup-image popup-image--mobile"
          src="/WhatsApp Image 2026-10-19 at 20.55.34.jpeg"
          alt="Promo Diskon Layanan Terapi & Konsultasi"
          @click="handleImageClick"
        />

        <!-- Image: Desktop/Tablet (landscape) -->
        <img
          class="popup-image popup-image--desktop"
          src="/WhatsApp Image 2026-10-19 at 20.55.344.jpeg"
          alt="Promo Diskon Layanan Terapi & Konsultasi"
          @click="handleImageClick"
        />


      </div>
    </div>
  </Transition>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const isVisible = ref(false)
const isAnimating = ref(false)

const STORAGE_KEY = 'atc_promo_popup_seen'
const POPUP_COOLDOWN_HOURS = 24

function shouldShowPopup() {
  const lastSeen = localStorage.getItem(STORAGE_KEY)
  if (!lastSeen) return true
  const elapsed = Date.now() - parseInt(lastSeen, 10)
  const cooldownMs = POPUP_COOLDOWN_HOURS * 60 * 60 * 1000
  return elapsed > cooldownMs
}

function markAsSeen() {
  localStorage.setItem(STORAGE_KEY, Date.now().toString())
}

function closePopup() {
  isAnimating.value = false
  isVisible.value = false
  markAsSeen()
}

function handleImageClick() {
  closePopup()
  router.push('/layanan')
}

onMounted(() => {
  if (shouldShowPopup()) {
    setTimeout(() => {
      isVisible.value = true
      requestAnimationFrame(() => {
        isAnimating.value = true
      })
    }, 800)
  }
})
</script>

<style scoped>
/* ===== Overlay ===== */
.popup-overlay {
  position: fixed;
  inset: 0;
  z-index: 9999;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(0, 0, 0, 0.65);
  backdrop-filter: blur(4px);
  -webkit-backdrop-filter: blur(4px);
  padding: 1rem;
}

/* ===== Container ===== */
.popup-container {
  position: relative;
  max-width: 90vw;
  max-height: 90vh;
  border-radius: 16px;
  overflow: hidden;
  box-shadow:
    0 25px 60px rgba(0, 0, 0, 0.4),
    0 0 0 1px rgba(255, 255, 255, 0.1);
  transform: scale(0.85) translateY(20px);
  opacity: 0;
  transition:
    transform 0.45s cubic-bezier(0.34, 1.56, 0.64, 1),
    opacity 0.35s ease;
}

.popup-container.is-animating {
  transform: scale(1) translateY(0);
  opacity: 1;
}

/* ===== Images ===== */
.popup-image {
  display: block;
  width: 100%;
  height: auto;
  object-fit: contain;
  cursor: pointer;
}

/* Mobile (portrait) – shown on small screens by default */
.popup-image--mobile {
  display: block;
}

/* Desktop (landscape) – hidden on small screens */
.popup-image--desktop {
  display: none;
}

/* ===== Close Button ===== */
.popup-close {
  position: absolute;
  top: 10px;
  right: 10px;
  z-index: 10;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  border: none;
  background: rgba(0, 0, 0, 0.55);
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: background 0.2s ease, transform 0.2s ease;
  backdrop-filter: blur(4px);
}

.popup-close:hover {
  background: rgba(220, 38, 38, 0.85);
  transform: scale(1.1) rotate(90deg);
}



/* ===== Tablet & Desktop (>=640px) – switch to landscape image ===== */
@media (min-width: 640px) {
  .popup-image--mobile {
    display: none;
  }

  .popup-image--desktop {
    display: block;
  }

  .popup-container {
    max-width: 780px;
  }
}

/* ===== Vue Transition ===== */
.popup-fade-enter-active,
.popup-fade-leave-active {
  transition: opacity 0.3s ease;
}

.popup-fade-enter-from,
.popup-fade-leave-to {
  opacity: 0;
}
</style>
