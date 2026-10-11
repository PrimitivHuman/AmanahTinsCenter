<template>
  <router-view v-slot="{ Component, route }">
    <transition name="page" mode="out-in">
      <component :is="Component" :key="route.path" />
    </transition>
  </router-view>
  
  <!-- Interactive Tanya WA WhatsApp Widget (Halaman Publik) -->
  <WhatsAppWidget />
</template>

<script setup>
import { onMounted } from 'vue'
import { useAuthStore } from './stores/auth'
import WhatsAppWidget from './components/WhatsAppWidget.vue'

const auth = useAuthStore()

onMounted(() => {
  auth.initAuth()
})
</script>

