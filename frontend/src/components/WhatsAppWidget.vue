<template>
  <div v-if="!isAdminRoute" class="whatsapp-widget-root">
    <!-- Click Outside Backdrop for Mobile -->
    <div
      v-if="isOpen"
      class="wa-backdrop"
      @click="closeWidget"
      aria-hidden="true"
    ></div>

    <!-- ===== FLOATING TANYA WA POP-UP CARD ===== -->
    <transition name="wa-popup-anim">
      <div
        v-if="isOpen"
        class="wa-popup-card"
        role="dialog"
        aria-modal="true"
        aria-labelledby="wa-card-title"
      >
        <!-- Card Header -->
        <div class="wa-card-header">
          <div class="wa-card-profile">
            <div class="wa-avatar-wrapper">
              <div class="wa-avatar">
                <!-- Mini ATC Shield Icon -->
                <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="wa-avatar-svg">
                  <rect width="40" height="40" rx="12" fill="white" />
                  <path d="M20 9C20 9 12 14.5 12 21.5C12 26.5 15.8 29.5 20 31.5C24.2 29.5 28 26.5 28 21.5C28 14.5 20 9 20 9Z" fill="#006384" fill-opacity="0.25" />
                  <circle cx="20" cy="17" r="3.2" fill="#006384" />
                  <path d="M14.5 25.5C15.2 22.8 17.4 21.2 20 21.2C22.6 21.2 24.8 22.8 25.5 25.5" stroke="#006384" stroke-width="2" stroke-linecap="round" />
                  <path d="M20 27L18.8 25.9C15.5 23 14 21.6 14 19.8C14 18.2 15.2 17 16.8 17C17.7 17 18.6 17.4 19.1 18.1L20 19.1L20.9 18.1C21.4 17.4 22.3 17 23.2 17C24.8 17 26 18.2 26 19.8C26 21.6 24.5 23 21.2 25.9L20 27Z" fill="#FFC857" />
                </svg>
              </div>
              <span class="wa-status-dot" title="Online"></span>
            </div>
            <div class="wa-profile-info">
              <h3 id="wa-card-title" class="wa-profile-name">
                Tanya {{ settings?.clinic_name || "Amanah Tin's Center" }}
              </h3>
              <div class="wa-profile-status">
                <span class="status-indicator"></span>
                <span>Online • Respon Cepat</span>
              </div>
            </div>
          </div>

          <button
            class="wa-close-btn"
            @click="closeWidget"
            aria-label="Tutup Tanya WA"
          >
            <span class="material-symbols-outlined">close</span>
          </button>
        </div>

        <!-- Card Body / Chat Area -->
        <div class="wa-card-body">
          <div class="wa-chat-timestamp">
            <span>Hari ini • {{ settings?.weekday_hours || 'Jam Layanan 08.00 – 17.00 WIB' }}</span>
          </div>

          <!-- Incoming Message Bubble -->
          <div class="wa-bubble incoming">
            <div class="wa-bubble-sender">Koordinator Layanan ATC</div>
            <p class="wa-bubble-text">
              Halo Ayah &amp; Bunda! 👋
              <br />
              Selamat datang di <strong>{{ settings?.clinic_name || "Amanah Tin's Center" }}</strong>. Ada yang bisa kami bantu seputar konsultasi tumbuh kembang atau jadwal terapi ananda?
            </p>
            <span class="wa-bubble-time">{{ currentTimeStr }}</span>
          </div>

          <!-- Quick Topic Buttons ("Tanya Cepat") -->
          <div class="wa-quick-section">
            <span class="wa-quick-label">Pilih topik pertanyaan cepat:</span>
            <div class="wa-quick-grid">
              <button
                v-for="(topic, idx) in quickTopics"
                :key="idx"
                class="wa-quick-btn"
                @click="sendQuickTopic(topic.prompt)"
              >
                <span class="material-symbols-outlined wa-quick-icon">{{ topic.icon }}</span>
                <span>{{ topic.title }}</span>
              </button>
            </div>
          </div>

          <!-- Custom Message Input Box -->
          <div class="wa-custom-input-box">
            <label for="wa-custom-text" class="wa-input-label">Atau ketik pertanyaan Anda:</label>
            <textarea
              id="wa-custom-text"
              v-model="customMessage"
              rows="2"
              class="wa-textarea"
              placeholder="Tulis pesan/pertanyaan untuk admin klinik..."
              @keydown.enter.prevent="sendCustomMessage"
            ></textarea>
            <button
              class="wa-send-btn"
              :disabled="!customMessage.trim()"
              @click="sendCustomMessage"
            >
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
              </svg>
              <span>Kirim ke WhatsApp</span>
            </button>
          </div>
        </div>

        <!-- Card Footer -->
        <div class="wa-card-footer">
          <span class="material-symbols-outlined wa-footer-icon">verified_user</span>
          <span>Nomor Resmi ATC: <strong>{{ displayPhoneNumber }}</strong></span>
        </div>
      </div>
    </transition>

    <!-- ===== FLOATING TRIGGER BUTTON (HANYA LOGO WHATSAPP) ===== -->
    <div class="wa-trigger-container">
      <!-- Circular WhatsApp FAB Button -->
      <button
        class="wa-fab-btn"
        :class="{ 'is-active': isOpen }"
        @click="toggleWidget"
        :aria-expanded="isOpen"
        aria-label="Tanya WA via WhatsApp"
        :title="isOpen ? 'Tutup Tanya WA' : 'Tanya WA via WhatsApp'"
      >
        <span class="wa-fab-pulse" v-if="!isOpen"></span>
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="32"
          height="32"
          viewBox="0 0 24 24"
          fill="currentColor"
          class="fab-icon-wa"
        >
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
        </svg>
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useRoute } from 'vue-router'
import { useClinicSettings } from '../composables/useClinicSettings'

const route = useRoute()
const { settings, whatsappNumber, waLink } = useClinicSettings()
const isOpen = ref(false)
const customMessage = ref('')

const isAdminRoute = computed(() => route.path.startsWith('/admin'))

// Quick topics for consultations
const quickTopics = [
  {
    icon: 'child_care',
    title: 'Konsultasi Tumbuh Kembang',
    prompt: 'Halo Admin Amanah Tin\'s Center, saya ingin berkonsultasi mengenai tahapan perkembangan dan skrining untuk ananda. Mohon informasi prosedur dan jadwalnya.'
  },
  {
    icon: 'record_voice_over',
    title: 'Tanya Terapi Wicara (TW)',
    prompt: 'Halo Admin ATC, saya ingin bertanya seputar layanan Terapi Wicara untuk anak yang mengalami keterlambatan bicara (speech delay).'
  },
  {
    icon: 'psychology',
    title: 'Tanya Sensori Integrasi (SI)',
    prompt: 'Halo Admin ATC, saya ingin menanyakan layanan Terapi Sensori Integrasi & Okupasi untuk ananda.'
  },
  {
    icon: 'event_available',
    title: 'Jadwal & Reservasi Pasien Baru',
    prompt: 'Halo Admin ATC, saya ingin mendaftar pasien baru dan menanyakan ketersediaan jadwal terapis yang tersedia.'
  },
  {
    icon: 'payments',
    title: 'Info Biaya & Paket Terapi',
    prompt: 'Halo Admin ATC, mohon informasi rincian biaya asesmen awal dan paket sesi terapi di Amanah Tin\'s Center.'
  }
]

// Current time formatted
const currentTimeStr = computed(() => {
  const now = new Date()
  return now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
})

// Formatted display phone number for UI
const displayPhoneNumber = computed(() => {
  const p = whatsappNumber.value
  if (p && p.startsWith('62') && p.length >= 11) {
    return `+62 ${p.slice(2, 5)}-${p.slice(5, 9)}-${p.slice(9)}`
  }
  return p ? `+${p}` : '+62 821-8889-9900'
})

function toggleWidget() {
  isOpen.value = !isOpen.value
}

function closeWidget() {
  isOpen.value = false
}

function openWhatsAppUrl(messageText) {
  const url = waLink(messageText)
  window.open(url, '_blank', 'noopener,noreferrer')
  isOpen.value = false
}

function sendQuickTopic(promptText) {
  openWhatsAppUrl(promptText)
}

function sendCustomMessage() {
  const text = customMessage.value.trim()
  if (!text) return
  const fullMessage = `Halo Admin Amanah Tin's Center, saya ingin bertanya: ${text}`
  openWhatsAppUrl(fullMessage)
  customMessage.value = ''
}

function handleKeyDown(e) {
  if (e.key === 'Escape' && isOpen.value) {
    closeWidget()
  }
}

onMounted(() => {
  window.addEventListener('keydown', handleKeyDown)
})

onUnmounted(() => {
  window.removeEventListener('keydown', handleKeyDown)
})
</script>

<style scoped>
/* ============================================================
   TANYA WA - FLOATING WIDGET & POPUP STYLING
   ============================================================ */
.whatsapp-widget-root {
  position: relative;
  z-index: 1050;
}

/* Mobile backdrop */
.wa-backdrop {
  position: fixed;
  inset: 0;
  background: rgba(9, 29, 46, 0.4);
  backdrop-filter: blur(2px);
  z-index: 1040;
}

@media (min-width: 640px) {
  .wa-backdrop {
    display: none;
  }
}

/* ===== POP-UP CARD ===== */
.wa-popup-card {
  position: fixed;
  bottom: 5.5rem;
  right: 1.5rem;
  width: 375px;
  max-width: calc(100vw - 2rem);
  background: #ffffff;
  border-radius: 20px;
  box-shadow: 0 16px 40px -8px rgba(9, 29, 46, 0.22), 0 0 0 1px rgba(191, 200, 206, 0.3);
  overflow: hidden;
  z-index: 1050;
  display: flex;
  flex-direction: column;
}

/* Card Header */
.wa-card-header {
  background: linear-gradient(135deg, #006384 0%, #00839e 100%);
  color: #ffffff;
  padding: 1.15rem 1.25rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.wa-card-profile {
  display: flex;
  align-items: center;
  gap: 0.85rem;
}

.wa-avatar-wrapper {
  position: relative;
  width: 44px;
  height: 44px;
}

.wa-avatar {
  width: 100%;
  height: 100%;
  border-radius: 12px;
  background: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
  overflow: hidden;
}

.wa-avatar-svg {
  width: 100%;
  height: 100%;
}

.wa-status-dot {
  position: absolute;
  bottom: -2px;
  right: -2px;
  width: 13px;
  height: 13px;
  background: #25d366;
  border: 2.5px solid #006384;
  border-radius: 50%;
}

.wa-profile-info {
  display: flex;
  flex-direction: column;
}

.wa-profile-name {
  font-family: var(--font-headline, 'Outfit', sans-serif);
  font-size: 15.5px;
  font-weight: 700;
  color: #ffffff;
  margin: 0;
  line-height: 1.25;
}

.wa-profile-status {
  display: flex;
  align-items: center;
  gap: 0.35rem;
  font-size: 11.5px;
  color: rgba(255, 255, 255, 0.88);
  font-weight: 500;
  margin-top: 2px;
}

.status-indicator {
  width: 7px;
  height: 7px;
  background: #4ade80;
  border-radius: 50%;
  display: inline-block;
  animation: pulse-dot 1.8s infinite ease-in-out;
}

@keyframes pulse-dot {
  0%, 100% { opacity: 1; transform: scale(1); }
  50% { opacity: 0.5; transform: scale(0.85); }
}

.wa-close-btn {
  background: rgba(255, 255, 255, 0.18);
  border: none;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #ffffff;
  cursor: pointer;
  transition: all 0.15s ease;
}

.wa-close-btn:hover {
  background: rgba(255, 255, 255, 0.3);
  transform: rotate(90deg);
}

.wa-close-btn .material-symbols-outlined {
  font-size: 18px;
}

/* Card Body */
.wa-card-body {
  background: #f8fafc;
  padding: 1.15rem;
  max-height: 430px;
  overflow-y: auto;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.wa-chat-timestamp {
  text-align: center;
  font-size: 11px;
  color: #70787e;
  font-weight: 600;
  padding: 0.2rem 0.6rem;
  background: rgba(227, 239, 255, 0.6);
  border-radius: 999px;
  align-self: center;
}

/* Bubble Message */
.wa-bubble {
  position: relative;
  max-width: 92%;
  padding: 0.85rem 1rem;
  border-radius: 14px;
  font-size: 13.5px;
  line-height: 1.45;
  color: #203243;
}

.wa-bubble.incoming {
  background: #ffffff;
  align-self: flex-start;
  border-bottom-left-radius: 4px;
  box-shadow: 0 2px 8px rgba(9, 29, 46, 0.06);
  border: 1px solid rgba(227, 239, 255, 0.8);
}

.wa-bubble-sender {
  font-size: 11px;
  font-weight: 700;
  color: #006384;
  margin-bottom: 0.25rem;
}

.wa-bubble-text {
  margin: 0;
}

.wa-bubble-time {
  display: block;
  text-align: right;
  font-size: 10px;
  color: #8b959e;
  margin-top: 0.35rem;
}

/* Quick Topic Section */
.wa-quick-section {
  display: flex;
  flex-direction: column;
  gap: 0.45rem;
}

.wa-quick-label {
  font-size: 11.5px;
  font-weight: 700;
  color: #556066;
  text-transform: uppercase;
  letter-spacing: 0.3px;
}

.wa-quick-grid {
  display: flex;
  flex-direction: column;
  gap: 0.4rem;
}

.wa-quick-btn {
  display: flex;
  align-items: center;
  gap: 0.6rem;
  padding: 0.6rem 0.85rem;
  background: #ffffff;
  border: 1px solid #d5e5f7;
  border-radius: 10px;
  font-size: 13px;
  font-weight: 600;
  color: #006384;
  text-align: left;
  cursor: pointer;
  transition: all 0.18s ease;
}

.wa-quick-btn:hover {
  background: #edf6ff;
  border-color: #00839e;
  transform: translateX(3px);
  box-shadow: 0 2px 8px rgba(0, 99, 132, 0.12);
}

.wa-quick-icon {
  font-size: 18px;
  color: #00839e;
  flex-shrink: 0;
}

/* Custom Message Input */
.wa-custom-input-box {
  display: flex;
  flex-direction: column;
  gap: 0.4rem;
  padding-top: 0.5rem;
  border-top: 1px dashed #d5e5f7;
}

.wa-input-label {
  font-size: 11.5px;
  font-weight: 700;
  color: #556066;
}

.wa-textarea {
  width: 100%;
  border: 1px solid #cbd5e1;
  border-radius: 10px;
  padding: 0.6rem 0.75rem;
  font-size: 13px;
  font-family: inherit;
  resize: none;
  outline: none;
  transition: border-color 0.15s ease;
  box-sizing: border-box;
}

.wa-textarea:focus {
  border-color: #006384;
  box-shadow: 0 0 0 3px rgba(0, 99, 132, 0.12);
}

.wa-send-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  width: 100%;
  padding: 0.65rem 1rem;
  background: #25d366;
  color: #ffffff;
  border: none;
  border-radius: 10px;
  font-size: 13.5px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.18s ease;
  box-shadow: 0 4px 12px rgba(37, 211, 102, 0.28);
}

.wa-send-btn:hover:not(:disabled) {
  background: #1ebc59;
  transform: translateY(-1px);
  box-shadow: 0 6px 16px rgba(37, 211, 102, 0.38);
}

.wa-send-btn:disabled {
  opacity: 0.55;
  cursor: not-allowed;
  box-shadow: none;
}

/* Card Footer */
.wa-card-footer {
  background: #edf4fa;
  border-top: 1px solid #e2e8f0;
  padding: 0.65rem 1rem;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.45rem;
  font-size: 11px;
  color: #556066;
}

.wa-footer-icon {
  font-size: 16px;
  color: #006384;
}

/* ===== TRIGGER CONTAINER (FAB + TEASER) ===== */
.wa-trigger-container {
  position: fixed;
  bottom: 1.75rem;
  right: 1.75rem;
  display: flex;
  align-items: center;
  gap: 0.65rem;
  z-index: 1050;
}

/* ===== TRIGGER CONTAINER (FAB HANYA LOGO WHATSAPP) ===== */
.wa-trigger-container {
  position: fixed;
  bottom: 1.75rem;
  right: 1.75rem;
  z-index: 1050;
}

/* Circular FAB */
.wa-fab-btn {
  position: relative;
  width: 58px;
  height: 58px;
  border-radius: 50%;
  background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
  border: none;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #ffffff;
  cursor: pointer;
  box-shadow: 0 8px 24px rgba(37, 211, 102, 0.42);
  transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.wa-fab-btn:hover {
  transform: scale(1.08) translateY(-2px);
  box-shadow: 0 12px 30px rgba(37, 211, 102, 0.52);
}

.wa-fab-btn.is-active {
  transform: scale(0.96);
  box-shadow: 0 6px 18px rgba(37, 211, 102, 0.45);
}

.wa-fab-pulse {
  position: absolute;
  inset: -6px;
  border-radius: 50%;
  border: 2px solid #25d366;
  opacity: 0.8;
  animation: ripple 2.2s infinite ease-out;
  pointer-events: none;
}

@keyframes ripple {
  0% { transform: scale(0.95); opacity: 0.8; }
  70% { transform: scale(1.35); opacity: 0; }
  100% { transform: scale(1.4); opacity: 0; }
}

.fab-icon-wa {
  filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.15));
}

/* ===== ANIMATIONS ===== */
.wa-popup-anim-enter-active {
  transition: all 0.28s cubic-bezier(0.16, 1, 0.3, 1);
}
.wa-popup-anim-leave-active {
  transition: all 0.2s cubic-bezier(0.7, 0, 0.84, 0);
}
.wa-popup-anim-enter-from {
  opacity: 0;
  transform: translateY(18px) scale(0.94);
}
.wa-popup-anim-leave-to {
  opacity: 0;
  transform: translateY(14px) scale(0.96);
}

/* ===== RESPONSIVE ===== */
@media (max-width: 640px) {
  .wa-trigger-container {
    bottom: 1.25rem;
    right: 1.25rem;
  }
  .wa-popup-card {
    right: 1rem;
    left: 1rem;
    width: auto;
    bottom: 5.5rem;
    max-height: 80vh;
  }
  .wa-fab-btn {
    width: 52px;
    height: 52px;
  }
}
</style>
