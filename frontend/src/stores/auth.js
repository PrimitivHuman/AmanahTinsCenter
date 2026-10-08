import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import api from '../services/api'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null)
  const token = ref(null)

  const isLoggedIn = computed(() => !!token.value)

  function initAuth() {
    const savedToken = localStorage.getItem('atc_admin_token')
    const savedUser = localStorage.getItem('atc_admin_user')
    if (savedToken) {
      token.value = savedToken
      user.value = savedUser ? JSON.parse(savedUser) : null
    }
  }

  async function login(credentials) {
    const response = await api.post('/auth/login', credentials)
    token.value = response.data.token
    user.value = response.data.user
    localStorage.setItem('atc_admin_token', token.value)
    localStorage.setItem('atc_admin_user', JSON.stringify(user.value))
    return response.data
  }

  async function logout() {
    try {
      await api.post('/auth/logout')
    } catch {}
    token.value = null
    user.value = null
    localStorage.removeItem('atc_admin_token')
    localStorage.removeItem('atc_admin_user')
  }

  return { user, token, isLoggedIn, initAuth, login, logout }
})
