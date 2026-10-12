<template>
  <div class="public-layout">
    <TheNavbar />
    <main class="main-content">
      <slot />
    </main>
    <TheFooter />
  </div>
</template>

<script setup>
import TheNavbar from '../components/TheNavbar.vue'
import TheFooter from '../components/TheFooter.vue'
</script>

<style scoped>
.public-layout {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}
.main-content {
  flex: 1;
}

@media (max-width: 640px) {
  .main-content {
    padding-bottom: 2.5rem;
  }
}
</style>
