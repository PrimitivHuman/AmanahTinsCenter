import { ref, computed } from 'vue'
import api from '../services/api'

// Shared state (module-level) so settings are fetched once for the whole app.
const FALLBACK_WA = '6282188899900'
const settings = ref(null)
let pending = null

function sanitizePhone(raw) {
  let digits = String(raw || '').replace(/[^0-9]/g, '')
  if (digits.startsWith('0')) digits = '62' + digits.slice(1)
  return digits
}

function load(force = false) {
  if (pending && !force) return pending
  pending = api
    .get('/settings')
    .then((res) => {
      settings.value = res.data
      return settings.value
    })
    .catch((err) => {
      console.error('Failed to load clinic settings', err)
      pending = null
      return null
    })
  return pending
}

/**
 * Single source of truth for the clinic WhatsApp number.
 * The number comes from Admin > Pengaturan Klinik (GET /settings).
 */
export function useClinicSettings() {
  load()

  const whatsappNumber = computed(
    () => sanitizePhone(settings.value?.whatsapp) || FALLBACK_WA
  )

  function waLink(text = '') {
    const base = `https://wa.me/${whatsappNumber.value}`
    return text ? `${base}?text=${encodeURIComponent(text)}` : base
  }

  /** For legacy callers that already hold an url-encoded message. */
  function waLinkEncoded(encodedText = '') {
    const base = `https://wa.me/${whatsappNumber.value}`
    return encodedText ? `${base}?text=${encodedText}` : base
  }

  return { settings, whatsappNumber, waLink, waLinkEncoded, reloadSettings: () => load(true) }
}
