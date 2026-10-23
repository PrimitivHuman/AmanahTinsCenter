/**
 * Shared Canonical Categories for Amanah Tin's Center
 * Digunakan secara sinkron di Admin (ArticleFormView, ArticlesView)
 * dan Halaman Publik (ArticlesView, ArticleDetailView)
 */

export const ARTICLE_CATEGORIES = [
  {
    value: 'Terapi Wicara',
    label: 'Terapi Wicara',
    shortLabel: 'Wicara',
    icon: 'record_voice_over',
    color: '#0284c7',
    badgeClass: 'badge-blue',
    iconColor: 'icon-blue',
    description: 'Stimulasi artikulasi, speech delay, oral motor, dan komunikasi anak.',
  },
  {
    value: 'Terapi Okupasi',
    label: 'Terapi Okupasi',
    shortLabel: 'Okupasi',
    icon: 'front_hand',
    color: '#0d9488',
    badgeClass: 'badge-teal',
    iconColor: 'icon-teal',
    description: 'Kemandirian aktivitas harian (ADL), motorik halus & kasar, dan pra-menulis.',
  },
  {
    value: 'Sensori Integrasi',
    label: 'Sensori Integrasi',
    shortLabel: 'Sensori',
    icon: 'spa',
    color: '#16a34a',
    badgeClass: 'badge-green',
    iconColor: 'icon-green',
    description: 'Modulasi sensori, keseimbangan vestibular, dan regulasi ketenangan anak.',
  },
  {
    value: 'Psikologi Anak',
    label: 'Psikologi Anak',
    shortLabel: 'Psikologi',
    icon: 'psychology',
    color: '#9333ea',
    badgeClass: 'badge-purple',
    iconColor: 'icon-purple',
    description: 'Regulasi emosi, perilaku anak, atensi fokus, kesiapan sekolah, dan asesmen kognitif.',
  },
  {
    value: 'Parenting & Tumbuh Kembang',
    label: 'Parenting & Tumbuh Kembang',
    shortLabel: 'Parenting',
    icon: 'favorite',
    color: '#ea580c',
    badgeClass: 'badge-amber',
    iconColor: 'icon-amber',
    description: 'Panduan pola asuh, milestone perkembangan anak, dan stimulasi di rumah.',
  },
]

// Peta alias lama agar data awal / bookmark tidak hilang atau gagal tersaring
export const CATEGORY_ALIASES = {
  'Fisioterapi Pediatrik': 'Terapi Okupasi',
  'Fisioterapi': 'Terapi Okupasi',
  'Tumbuh Kembang': 'Parenting & Tumbuh Kembang',
  'Parenting': 'Parenting & Tumbuh Kembang',
  'Parenting & Pola Asuh': 'Parenting & Tumbuh Kembang',
  'Parenting Positif': 'Parenting & Tumbuh Kembang',
  'Sensori & Motorik': 'Sensori Integrasi',
  'Sensori Motorik': 'Sensori Integrasi',
  'Motorik': 'Terapi Okupasi',
  'Psikologi': 'Psikologi Anak',
  'Psikolog': 'Psikologi Anak',
  'Psikolog Anak': 'Psikologi Anak',
  'Psikolog Remaja': 'Psikologi Anak',
  'Psikolog Dewasa': 'Psikologi Anak',
}

/**
 * Normalisasi nilai kategori jika berasal dari alias lama
 */
export function normalizeCategory(cat) {
  if (!cat) return 'Terapi Wicara'
  return CATEGORY_ALIASES[cat] || cat
}

/**
 * Dapatkan metadata kategori (icon, color, badgeClass, label)
 */
export function getCategoryMeta(cat) {
  const norm = normalizeCategory(cat)
  return (
    ARTICLE_CATEGORIES.find((c) => c.value === norm) || {
      value: cat || 'Umum',
      label: cat || 'Umum',
      shortLabel: cat || 'Umum',
      icon: 'article',
      color: '#006384',
      badgeClass: 'badge-blue',
      iconColor: 'icon-blue',
      description: 'Artikel dan tips tumbuh kembang anak.',
    }
  )
}
