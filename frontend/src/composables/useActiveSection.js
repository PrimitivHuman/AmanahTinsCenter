import { ref } from 'vue'

export const activeSection = ref('beranda')

export function setActiveSection(section) {
  activeSection.value = section
}
