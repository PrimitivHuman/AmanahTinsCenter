<template>
  <PublicLayout>

    <!-- ===== HERO SECTION ===== -->
    <section class="hero-section">
      <!-- decorative blobs -->
      <div class="blob blob-right"></div>
      <div class="blob blob-left"></div>

      <div class="container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb" aria-label="Breadcrumb">
          <router-link to="/" class="bc-link">
            <span class="material-symbols-outlined" style="font-size:14px">home</span>
            Beranda
          </router-link>
          <span class="material-symbols-outlined bc-sep" style="font-size:14px">chevron_right</span>
          <span class="bc-active">Tim Kami</span>
        </nav>

        <div class="hero-content">
          <div class="hero-badge">
            <span class="material-symbols-outlined" style="font-size:16px">verified_user</span>
            <span>Tenaga Medis &amp; Praktisi Ber-STR Kemenkes</span>
          </div>
          <h1 class="hero-title">Direktori Tim Medis &amp; Terapis Tumbuh Kembang</h1>
          <p class="hero-desc">
            Didukung oleh praktisi berlisensi resmi kementerian kesehatan dengan dedikasi penuh kasih, kesabaran tinggi, dan pendekatan berbasis bukti ilmiah (evidence-based practice) di Jagakarsa, Jakarta Selatan.
          </p>
        </div>
      </div>
    </section>

    <!-- ===== TEAM DIRECTORY SECTION ===== -->
    <section class="team-section">
      <div class="container">
        <!-- Section Header -->
        <div class="team-header">
          <span class="team-eyebrow">Direktori Praktisi</span>
          <h2 class="team-title">Pilih Praktisi Sesuai Kebutuhan Anak</h2>
          <p class="team-sub">
            Gunakan filter kategori atau pencarian untuk menemukan terapis yang tepat, melihat sertifikasi klinis, dan memeriksa hari jadwal praktik.
          </p>
        </div>

        <!-- Filter Controls: Toolbar (Count + Search) & 1-Row Category Tabs -->
        <div class="filter-controls-wrap">
          <!-- Toolbar Row: Count Note on Left (above "Semua Praktisi"), Search on Right -->
          <div class="filter-toolbar-row">
            <div class="team-count-note">
              Menampilkan <strong>{{ filteredTeamMembers.length }}</strong> dari {{ teamMembers.length }} Tenaga Ahli Bersertifikasi
            </div>

            <!-- Quick Search Bar -->
            <div class="search-input-box">
              <span class="material-symbols-outlined search-icon">search</span>
              <input
                v-model="searchQuery"
                type="text"
                class="search-input"
                placeholder="Cari nama terapis atau keahlian (misal: Annisa, Autisme, Oral Motor)..."
              />
              <button
                v-if="searchQuery"
                @click="searchQuery = ''"
                class="btn-clear-search"
                title="Hapus pencarian"
              >
                <span class="material-symbols-outlined">close</span>
              </button>
            </div>
          </div>

          <!-- Category Pills Tabs (1 Baris Saja) -->
          <div class="category-tabs-nav" role="tablist">
            <button
              v-for="cat in categories"
              :key="cat.id"
              @click="selectedCategory = cat.id"
              class="cat-tab-btn"
              :class="{ 'is-active': selectedCategory === cat.id }"
              role="tab"
              :aria-selected="selectedCategory === cat.id"
            >
              <span class="material-symbols-outlined cat-tab-icon">{{ cat.icon }}</span>
              <span>{{ cat.label }}</span>
              <span class="cat-tab-badge">{{ getCategoryCount(cat.id) }}</span>
            </button>
          </div>
        </div>

        <!-- Cards Grid (12 members, 4 per row) -->
        <div v-if="filteredTeamMembers.length > 0" class="team-grid">
          <div
            v-for="member in filteredTeamMembers"
            :key="member.id || member.name"
            class="member-card"
            @click="openTherapistModal(member)"
          >
            <!-- Photo with overlay badges -->
            <div class="member-photo-wrap">
              <img :src="member.photo" :alt="member.name" class="member-photo" loading="lazy" />
              <div class="photo-overlay-gradient"></div>
              
              <span class="badge-specialty" :class="`badge-${member.color}`">
                <span class="material-symbols-outlined" style="font-size:14px">{{ member.icon }}</span>
                {{ member.specialty }}
              </span>
              
              <span class="badge-str">
                <span class="pulse-dot-green"></span>
                {{ member.str }}
              </span>
            </div>

            <!-- Member info -->
            <div class="member-info-body">
              <h3 class="member-name">{{ member.name }}</h3>
              <p class="member-edu">{{ member.edu }}</p>

              <!-- Schedule Chip -->
              <div class="member-schedule-chip">
                <span class="material-symbols-outlined sched-icon">event_available</span>
                <span class="sched-text">{{ member.schedule }}</span>
              </div>

              <!-- Focus Tags -->
              <div class="member-focus">
                <span class="focus-label">Fokus Intervensi:</span>
                <div class="focus-tags">
                  <span
                    v-for="tag in member.tags"
                    :key="tag"
                    class="focus-tag"
                    :class="`tag-${member.color}`"
                  >{{ tag }}</span>
                </div>
              </div>
            </div>

            <!-- Card Interactive Action Buttons -->
            <div class="member-actions-row" @click.stop>
              <button
                @click="openTherapistModal(member)"
                class="btn-card-detail"
                type="button"
              >
                <span>Lihat Profil</span>
                <span class="material-symbols-outlined action-icon">visibility</span>
              </button>

              <a
                :href="getTherapistWaUrl(member)"
                target="_blank"
                rel="noopener noreferrer"
                class="btn-card-wa"
                title="Jadwalkan Sesi via WhatsApp"
              >
                <span class="material-symbols-outlined fill wa-icon">chat</span>
                <span>Jadwalkan</span>
              </a>
            </div>
          </div>
        </div>

        <!-- Empty State When Filter Yields No Results -->
        <div v-else class="empty-state-box">
          <div class="empty-icon-wrap">
            <span class="material-symbols-outlined">person_search</span>
          </div>
          <h3 class="empty-title">Tidak Ditemukan Praktisi</h3>
          <p class="empty-desc">
            Tidak ada terapis yang cocok dengan kata kunci "<strong>{{ searchQuery }}</strong>" pada kategori ini.
          </p>
          <button @click="resetFilters" class="btn-reset-filter">
            <span class="material-symbols-outlined">restart_alt</span>
            <span>Reset Filter &amp; Tampilkan Semua</span>
          </button>
        </div>

        <!-- Info Footnote -->
        <div class="footnote">
          <div class="footnote-left">
            <span class="material-symbols-outlined" style="font-size:28px; color: var(--primary)">info</span>
            <p>Membutuhkan jadwal terapis spesifik atau ingin menyesuaikan hari terapi setelah jam sekolah? Tim administrasi klinik siap membantu mencocokkan jadwal terapis yang paling nyaman untuk si Kecil.</p>
          </div>
          <a
            :href="waLink('Halo Admin Amanah Tin\'s Center, saya ingin konsultasi mengenai jadwal dan pilihan terapis untuk anak saya')"
            target="_blank"
            rel="noopener noreferrer"
            class="footnote-link"
          >
            Hubungi Admin Terapi via WA &rarr;
          </a>
        </div>
      </div>
    </section>

    <!-- ===== MODAL DETAIL PROFIL TERAPIS ===== -->
    <Teleport to="body">
      <div v-if="isModalOpen && selectedTherapist" class="modal-backdrop" @click="closeTherapistModal">
        <div class="modal-card" @click.stop role="dialog" aria-modal="true" :aria-labelledby="'modal-title-' + selectedTherapist.id">
          <!-- Modal Close Button -->
          <button @click="closeTherapistModal" class="btn-modal-close" aria-label="Tutup modal">
            <span class="material-symbols-outlined">close</span>
          </button>

          <!-- Modal Header -->
          <div class="modal-header">
            <div class="modal-avatar-frame">
              <img :src="selectedTherapist.photo" :alt="selectedTherapist.name" class="modal-avatar-img" />
              <div class="modal-avatar-badge" :class="`badge-${selectedTherapist.color}`">
                <span class="material-symbols-outlined">{{ selectedTherapist.icon }}</span>
              </div>
            </div>

            <div class="modal-header-info">
              <div class="modal-badge-row">
                <span class="modal-spec-badge" :class="`badge-${selectedTherapist.color}`">
                  {{ selectedTherapist.specialty }}
                </span>
                <span class="modal-str-pill">
                  <span class="pulse-dot-green"></span>
                  {{ selectedTherapist.str }}
                </span>
              </div>

              <h2 :id="'modal-title-' + selectedTherapist.id" class="modal-name">{{ selectedTherapist.name }}</h2>
              <p class="modal-edu-text">{{ selectedTherapist.edu }}</p>
              
              <div class="modal-meta-row">
                <span class="modal-meta-item">
                  <span class="material-symbols-outlined meta-icon">verified</span>
                  <span>{{ selectedTherapist.strNumber }}</span>
                </span>
                <span class="modal-meta-item">
                  <span class="material-symbols-outlined meta-icon">history</span>
                  <span>{{ selectedTherapist.experience }}</span>
                </span>
              </div>
            </div>
          </div>

          <!-- Modal Body -->
          <div class="modal-body-content">
            <!-- Schedule Highlight Box -->
            <div class="modal-schedule-box">
              <div class="sched-icon-circle">
                <span class="material-symbols-outlined">calendar_month</span>
              </div>
              <div class="sched-box-text">
                <span class="sched-box-title">Jadwal Praktik di Jagakarsa:</span>
                <span class="sched-box-val">{{ selectedTherapist.schedule }}</span>
              </div>
            </div>

            <!-- About / Bio -->
            <div class="modal-section-block">
              <h4 class="modal-block-title">
                <span class="material-symbols-outlined block-icon">psychology</span>
                Profil &amp; Pendekatan Terapi
              </h4>
              <p class="modal-bio-text">{{ selectedTherapist.bio }}</p>
            </div>

            <!-- Philosophy Quote Box -->
            <div class="modal-quote-box">
              <span class="material-symbols-outlined quote-mark">format_quote</span>
              <p class="modal-quote-text">{{ selectedTherapist.philosophy }}</p>
            </div>

            <!-- Competencies / Certifications -->
            <div class="modal-section-block">
              <h4 class="modal-block-title">
                <span class="material-symbols-outlined block-icon">clinical_notes</span>
                Sertifikasi &amp; Keahlian Klinis Spesifik
              </h4>
              <div class="modal-cert-grid">
                <div v-for="cert in selectedTherapist.certifications" :key="cert" class="modal-cert-item">
                  <span class="material-symbols-outlined cert-check">check_circle</span>
                  <span class="cert-text">{{ cert }}</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal Footer Actions -->
          <div class="modal-footer-actions">
            <a
              :href="getTherapistWaUrl(selectedTherapist)"
              target="_blank"
              rel="noopener noreferrer"
              class="btn-modal-wa"
            >
              <span class="material-symbols-outlined fill">chat</span>
              <span>Jadwalkan Bersama {{ selectedTherapist.name.split(',')[0] }} via WA</span>
            </a>

            <router-link
              :to="'/jadwal-pendaftaran?terapis=' + encodeURIComponent(selectedTherapist.name)"
              @click="closeTherapistModal"
              class="btn-modal-form"
            >
              <span class="material-symbols-outlined">event_note</span>
              <span>Formulir Reservasi</span>
            </router-link>

            <button @click="closeTherapistModal" class="btn-modal-secondary">
              Tutup
            </button>
          </div>
        </div>
      </div>
    </Teleport>

    <!-- ===== STANDAR MUTU SECTION ===== -->
    <section class="standards-section">
      <div class="container">
        <div class="standards-header">
          <span class="standards-eyebrow">Komitmen Profesional Kami</span>
          <h2 class="standards-title">Standar Mutu Pelayanan Terapis ATC</h2>
          <p class="standards-sub">Kami menjaga integritas terapi demi rasa aman orang tua dan kenyamanan maksimal setiap buah hati.</p>
        </div>
        <div class="standards-grid">
          <div v-for="std in standards" :key="std.title" class="std-card">
            <div class="std-icon" :class="`std-icon--${std.color}`">
              <span class="material-symbols-outlined" style="font-size:24px">{{ std.icon }}</span>
            </div>
            <h3 class="std-title">{{ std.title }}</h3>
            <p class="std-desc">{{ std.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ===== CTA SECTION ===== -->
    <section class="cta-section" id="daftar">
      <div class="container">
        <div class="cta-card">
          <!-- decorative blobs -->
          <div class="cta-blob cta-blob-br"></div>
          <div class="cta-blob cta-blob-top"></div>

          <div class="cta-inner">
            <div class="cta-content">
              <div class="cta-badge">
                <span class="material-symbols-outlined" style="font-size:16px">support_agent</span>
                <span>Konsultasi &amp; Asesmen Awal Anak</span>
              </div>
              <h2 class="cta-title">Ingin Berkonsultasi Langsung dengan Tim Terapis Kami?</h2>
              <p class="cta-desc">
                Dapatkan pendampingan dan asesmen tumbuh kembang yang paling sesuai dengan kebutuhan buah hati Anda di klinik Amanah Tin's Center Jagakarsa.
              </p>
            </div>
            <div class="cta-actions">
              <a :href="waLink('Halo Admin Amanah Tin\'s Center, saya ingin konsultasi jadwal dengan tim terapis')" target="_blank" rel="noopener noreferrer" class="btn-wa">
                <span class="material-symbols-outlined" style="font-size:20px">chat</span>
                <span>Konsultasi via WhatsApp</span>
              </a>
              <router-link to="/jadwal-pendaftaran" class="btn-schedule">
                <span class="material-symbols-outlined" style="font-size:20px">event</span>
                <span>Jadwalkan Asesmen Awal</span>
              </router-link>
            </div>
          </div>

          <div class="cta-footer-info">
            <div class="cta-info-item">
              <span class="material-symbols-outlined" style="font-size:16px">place</span>
              <span>{{ settings?.address || 'Jl. Raya Jagakarsa No. 12, Jagakarsa, Jakarta Selatan' }}</span>
            </div>
            <div class="cta-info-item">
              <span class="material-symbols-outlined" style="font-size:16px">schedule</span>
              <span>{{ settings?.weekday_hours || 'Senin - Sabtu: 08.00 - 17.00 WIB' }}</span>
            </div>
          </div>
        </div>
      </div>
    </section>

  </PublicLayout>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useClinicSettings } from '../composables/useClinicSettings'
import api from '../services/api'

const { settings, waLink } = useClinicSettings()
import PublicLayout from '../layouts/PublicLayout.vue'

// Photos from blueprint (google AI-generated images)
const photos = {
  tw1: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDEqiyk6121gv8ChNiZuew6FvZqYM6PDAblTcYiCp2zrKejXMcq6F6UwgjGu7Iaa3e4rXhIrp_ywvJu9Kz9EhZiKd2459Um-Gc6zqJkmD5lhWLepwgqsb7evjTW02DHYySTvbEICSv5mKabSc6kIEwah6t2brhAK9Ha_QJuZU78_R80wE4TxyfldjEjEqtUW1cwa3Hj7QA3-OuMXKmQRyIu4-9fb9bGbMCfwDx090c',
  ot1: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCqzaTQVtPUaU-jjH7JUkPgscxWU1F6ORXYUDhxi6OwEhZoL2SBGnzy7hEbs44MRtKcZBbwsTnFzF2l3eMKjbUQa0Z9W4BlJC8f0wAWn_6L8BvLrPsxdq6emLK0b9Q6JavjVgzOahGIeLB17EaAciv7FNpjFAQaTcfJj3_WWeQNp1weADSSiald3o28J8AEyY4nyowmBtpig9BqakgYufsRxF22-KKVgSr1dkshnOA',
  si1: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBBtaiTyNRvVyTC0twGu_A_OOgQaPPquYuuzHBM9n1Ox2rtWbSz7r0KQFKvbiPmm2hWx1hQE7R-oFMCgBlZjscdh2-McSZ83oQESA-0NjvPh0UX2UWifpBhfmLjk_H-ZojRnCI7RX-XGhyP2tyTKJDyud5c34H2kj50-7UjoFyauJh1a_2swq37hsQVrcU3gDK0P-5t1Fdc1oqXQ_7tUKjQ0Gz6zW5PT2-nHWAR6JI',
  psi1: 'https://lh3.googleusercontent.com/aida-public/AB6AXuARq7DzRwA-rJhJLIXBolnUBS70HG4EgQhQ6siQc5wOCBPmojR_dvk2D22zt1H83m9tdj8kembmDE-mZ3sWEljXK44nSgZaTnrAqm7C4QW5u4NZcr6AQoBKHsRfV9MuqhXxEuwQjpA75jDPOvR_R4jriqhbU3OZDs7qd2wemWAz8AYy-UczwQfqO5mn9qT_vBHKBRZDijRsi9u7y982VOU1jEuHl9v60nnn8nTiPH8',
  tw2: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAg-SbuarFyTHFwy6n7-DdfmqAdLbXwp19-lc8XwUIbhZsiQI1cZOPZ0BQPr9OK_uL3j0TvLTjdM5nyR-iwSToe8rpDEMwJk27on-HGcWv-EjtIb42028qA_TTiPyhWKjJImEvQ-vBHiZUn480b3Q6EDQoZY1Y8K027i_OrlChJLl8jGnupN5u-cqoorF-P6twjvWEOuY_XrMOR3-UHV9sanWiKQ7S2Vz5A91gP804',
  ot2: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAl_DqJxWl_2en0JAK_7xZM1elQhN7KR1iNkTEhL4nb9YROBU07EDQtZ6Dpsyep4V8if73x-fGx1l5uUv9VISW7Wb7GqFQvXtFYYIiIDLNMgKSkvNYnS0pZ6jzIAkhhLq6SRdf7BGfLziP-1UYw2WdcvQi3af84xIoW0vBCIyxLTyfWzdkNOFqSgeJaFq7qiLcwmWrWD7bjtWLmMRRDdLqGbjzcS4gImINJHkVoEAk',
}

const selectedCategory = ref('all')
const searchQuery = ref('')
const selectedTherapist = ref(null)
const isModalOpen = ref(false)

const categories = [
  { id: 'all', label: 'Semua Praktisi', icon: 'groups' },
  { id: 'tw', label: 'Terapi Wicara (TW)', icon: 'record_voice_over' },
  { id: 'ot', label: 'Terapi Okupasi (OT)', icon: 'back_hand' },
  { id: 'si', label: 'Sensori Integrasi (SI)', icon: 'spa' },
  { id: 'psi', label: 'Psikolog Anak', icon: 'psychology' },
]

const defaultTeamMembers = [
  {
    id: 'tw-annisa',
    category: 'tw',
    name: 'Annisa Larasati, A.Md.TW',
    edu: 'Lulusan Akademi Terapi Wicara (ATW) Jakarta',
    specialty: 'Terapi Wicara (TW)',
    icon: 'record_voice_over',
    color: 'blue',
    str: 'STR Aktif Kemenkes',
    strNumber: 'STR.12.04.5.2.20-09821',
    experience: '6+ Tahun Pengalaman Klinis',
    schedule: 'Senin, Rabu, Jumat (08.30 – 16.00 WIB)',
    tags: ['Speech Delay', 'Artikulasi & Gagap', 'Oral Motor'],
    bio: 'Berpengalaman mendampingi lebih dari 300 anak dengan keterlambatan bicara (speech delay), stimulasi artikulasi bicara pelo, dan kesulitan koordinasi oral motor melalui pendekatan bermain yang menyenangkan.',
    philosophy: '"Komunikasi adalah hak setiap anak. Dengan kesabaran dan stimulasi yang tepat, setiap kata akan menemukan jalannya."',
    certifications: [
      'Oral Placement Therapy (OPT) Level 1 & 2',
      'Certified PECS Basic Practitioner',
      'Denver II Developmental Screening Test'
    ],
    photo: photos.tw1
  },
  {
    id: 'ot-dimas',
    category: 'ot',
    name: 'Dimas Bagaswara, S.Tr.Kes (OT)',
    edu: 'Sarjana Terapan Terapi Okupasi Poltekkes Surakarta',
    specialty: 'Terapi Okupasi (OT)',
    icon: 'back_hand',
    color: 'amber',
    str: 'STR Aktif Kemenkes',
    strNumber: 'STR.14.07.4.1.21-11409',
    experience: '5+ Tahun Pengalaman Klinis',
    schedule: 'Selasa, Kamis, Sabtu (08.30 – 16.30 WIB)',
    tags: ['Motorik Halus', 'Kemandirian Diri (ADL)', 'Kekuatan Genggaman'],
    bio: 'Spesialis dalam meningkatkan kemandirian fungsional harian anak (makan sendiri, berpakaian, merawat diri), kekuatan otot tangan untuk pra-menulis, serta koordinasi mata-tangan.',
    philosophy: '"Kemandirian kecil hari ini membentuk rasa percaya diri seumur hidup anak."',
    certifications: [
      'Pediatric Occupational Therapy Certified',
      'Handwriting Without Tears Program',
      'Sensory-Based Occupational Adaptation'
    ],
    photo: photos.ot1
  },
  {
    id: 'si-nurul',
    category: 'si',
    name: 'Nurul Fauziah, A.Md.OT, C.SI',
    edu: 'Certified Sensory Integration Practitioner',
    specialty: 'Sensori Integrasi (SI)',
    icon: 'spa',
    color: 'green',
    str: 'STR Aktif Kemenkes',
    strNumber: 'STR.18.02.5.2.19-07612',
    experience: '7+ Tahun Pengalaman Klinis',
    schedule: 'Senin, Selasa, Kamis (09.00 – 16.00 WIB)',
    tags: ['Sensori Vestibular', 'Regulasi Diri', 'Hipersensitif Taktil'],
    bio: 'Ahli dalam perancangan sensory diet dan regulasi modulasi sistem saraf pusat anak. Membantu anak yang mudah kewalahan sensorik (tantrum mall/suara) atau hiperaktif mencari stimulasi fisik.',
    philosophy: '"Saat kebutuhan sensorik anak dipahami, tubuh dan pikirannya akan tenang untuk belajar."',
    certifications: [
      'USC/WPS Sensory Integration Certificate',
      'Vestibular & Proprioceptive Clinical Mastery',
      'Wilbarger Brushing Protocol Certified'
    ],
    photo: photos.si1
  },
  {
    id: 'psi-clara',
    category: 'psi',
    name: 'Clara Meisya, M.Psi., Psikolog',
    edu: 'Magister Profesi Psikologi Klinis Anak UI',
    specialty: 'Psikolog Anak',
    icon: 'psychology',
    color: 'blue',
    str: 'SIPP Aktif HIMPSI',
    strNumber: 'SIPP: 1421-20/UI-HIMPSI',
    experience: '8+ Tahun Pengalaman Klinis',
    schedule: 'Rabu & Sabtu (09.00 – 15.00 WIB)',
    tags: ['Asesmen IQ & Bakat', 'Tantrum & Perilaku', 'Parenting Coaching'],
    bio: 'Menangani asesmen kognitif, evaluasi kesiapan sekolah formal, penanganan tantrum emosional, serta pendampingan pola asuh suportif bagi orang tua di rumah.',
    philosophy: '"Di balik setiap perilaku sulit seorang anak, ada emosi mendalam yang sedang berusaha mencari jalan keluar."',
    certifications: [
      'WISC & Stanford-Binet IQ Assessment',
      'Child-Centered Play Therapy Certified',
      'Positive Parenting Program (Triple P)'
    ],
    photo: photos.psi1
  },
  {
    id: 'tw-fajar',
    category: 'tw',
    name: 'Fajar Pratama, S.Tr.Kes (TW)',
    edu: 'Sarjana Terapan Terapi Wicara Poltekkes Surakarta',
    specialty: 'Terapi Wicara (TW)',
    icon: 'record_voice_over',
    color: 'blue',
    str: 'STR Aktif Kemenkes',
    strNumber: 'STR.12.04.4.1.22-13204',
    experience: '4+ Tahun Pengalaman Klinis',
    schedule: 'Selasa, Kamis, Jumat (09.00 – 16.30 WIB)',
    tags: ['Komunikasi Pragmatik', 'Bahasa Reseptif', 'Terapi Menelan'],
    bio: 'Fokus pada peningkatan pemahaman instruksi verbal anak, pengayaan kosa kata aktif, dan melatih interaksi sosial timbal balik (pragmatik) menjelang usia sekolah.',
    philosophy: '"Bicara bukan sekadar kata, melainkan jembatan hati antara anak dan keluarganya."',
    certifications: [
      'Hanen Program: It Takes Two to Talk',
      'Pediatric Dysphagia Management',
      'AAC Interactive Communication'
    ],
    photo: photos.tw2
  },
  {
    id: 'ot-rizka',
    category: 'ot',
    name: 'Rizka Tri Hapsari, A.Md.OT',
    edu: 'Spesialisasi Okupasi Pediatrik & Perilaku',
    specialty: 'Terapi Okupasi (OT)',
    icon: 'back_hand',
    color: 'amber',
    str: 'STR Aktif Kemenkes',
    strNumber: 'STR.14.07.5.2.20-10332',
    experience: '5+ Tahun Pengalaman Klinis',
    schedule: 'Senin, Rabu, Sabtu (08.30 – 15.30 WIB)',
    tags: ['Konsentrasi Duduk', 'Koordinasi Visual', 'Motorik Kasar'],
    bio: 'Mendampingi anak melatih ketahanan duduk tenang (task focus), koordinasi visual spasial menyalin pola, dan penguatan otot postural tubuh saat belajar di kelas.',
    philosophy: '"Tubuh yang terkoordinasi dengan baik adalah fondasi utama bagi otak yang fokus."',
    certifications: [
      'Visual-Motor Integration Mastery',
      'Postural Control for Learning Readiness',
      'Pediatric Adaptive Seating Specialist'
    ],
    photo: photos.ot2
  },
  {
    id: 'si-bayu',
    category: 'si',
    name: 'Bayu Kurniawan, S.Tr.Kes (SI)',
    edu: 'Praktisi Sensori Integrasi & Motorik Anak',
    specialty: 'Sensori Integrasi (SI)',
    icon: 'spa',
    color: 'green',
    str: 'STR Aktif Kemenkes',
    strNumber: 'STR.18.02.4.1.19-08221',
    experience: '6+ Tahun Pengalaman Klinis',
    schedule: 'Senin, Rabu, Jumat (09.00 – 17.00 WIB)',
    tags: ['Proprioseptif', 'Keseimbangan Tubuh', 'Praksis Gerak'],
    bio: 'Ahli stimulasi proprioseptif dan vestibular melalui aktivitas sensory gym. Membantu anak yang canggung dalam bergerak (dispraksia) atau memiliki ketakutan ketinggian/gravitasi.',
    philosophy: '"Bermain aktif dengan aman memberi keberanian bagi anak untuk menjelajahi dunianya."',
    certifications: [
      'Sensory Integration Praxis Assessment',
      'Vestibular Rehabilitation for Children',
      'Heavy Work Therapeutic Design'
    ],
    photo: photos.ot1
  },
  {
    id: 'tw-dewi',
    category: 'tw',
    name: 'Dewi Sartika, A.Md.TW',
    edu: 'Spesialisasi Artikulasi & Fonologi Anak',
    specialty: 'Terapi Wicara (TW)',
    icon: 'record_voice_over',
    color: 'blue',
    str: 'STR Aktif Kemenkes',
    strNumber: 'STR.12.04.5.2.20-09744',
    experience: '5+ Tahun Pengalaman Klinis',
    schedule: 'Selasa, Kamis, Sabtu (08.30 – 16.00 WIB)',
    tags: ['Kelancaran Wicara', 'Pengucapan Fonem', 'Bahasa Ekspresif'],
    bio: 'Menangani anak dengan gangguan fonologi, cadel parah pada huruf konsonan (r, s, k, t), serta kelancaran berbicara (gagap anak usia dini) dengan visual biofeedback.',
    philosophy: '"Setiap pelafalan yang jelas memberi kekuatan bagi anak untuk didengar."',
    certifications: [
      'Phonological Disorder Intervention',
      'Early Childhood Stuttering Protocol',
      'PROMPT Bridging Level 1'
    ],
    photo: photos.tw1
  },
  {
    id: 'psi-danang',
    category: 'psi',
    name: 'Danang Prasetyo, M.Psi., Psikolog',
    edu: 'Psikolog Perkembangan & Kesiapan Sekolah',
    specialty: 'Psikolog Anak',
    icon: 'psychology',
    color: 'blue',
    str: 'SIPP Aktif HIMPSI',
    strNumber: 'SIPP: 1618-21/IPK-HIMPSI',
    experience: '7+ Tahun Pengalaman Klinis',
    schedule: 'Senin & Kamis (10.00 – 16.30 WIB)',
    tags: ['Sosial Emosional', 'Kesiapan SD', 'Regulasi Emosi'],
    bio: 'Fokus pada pengembangan keterampilan sosio-emosional anak, adaptasi masuk sekolah dasar reguler/inklusi, serta resolusi konflik kecemasan perpisahan (separation anxiety).',
    philosophy: '"Hati anak yang tenang akan membuka pintu bagi kecerdasan yang tak terbatas."',
    certifications: [
      'School Readiness Assessment Certified',
      'Emotion Regulation Therapy for Children',
      'Cognitive Behavioral Therapy for Kids'
    ],
    photo: photos.psi1
  },
  {
    id: 'ot-intan',
    category: 'ot',
    name: 'Intan Permatasari, A.Md.OT',
    edu: 'Terapi Okupasi Sensori & Koordinasi',
    specialty: 'Terapi Okupasi (OT)',
    icon: 'back_hand',
    color: 'amber',
    str: 'STR Aktif Kemenkes',
    strNumber: 'STR.14.07.5.2.22-12108',
    experience: '4+ Tahun Pengalaman Klinis',
    schedule: 'Rabu, Jumat, Sabtu (09.00 – 16.00 WIB)',
    tags: ['Pramenulis & Menulis', 'Bilateral Integration', 'Motor Planning'],
    bio: 'Mendampingi anak yang kesulitan memegang gunting, koordinasi dua belah tangan (bilateral), dan ketepatan pra-menulis agar tidak cepat lelah saat belajar di TK & SD.',
    philosophy: '"Keterampilan motorik yang terasah rapi adalah kunci kreativitas tanpa batas."',
    certifications: [
      'Bilateral Motor Integration Program',
      'Pre-Writing & Scissor Skills Mastery',
      'Adaptive Play Intervention'
    ],
    photo: photos.ot2
  },
  {
    id: 'tw-hendra',
    category: 'tw',
    name: 'Hendra Wijaya, S.Tr.Kes (TW)',
    edu: 'Praktisi AAC & Komunikasi Autisme',
    specialty: 'Terapi Wicara (TW)',
    icon: 'record_voice_over',
    color: 'blue',
    str: 'STR Aktif Kemenkes',
    strNumber: 'STR.12.04.4.1.19-07502',
    experience: '6+ Tahun Pengalaman Klinis',
    schedule: 'Senin, Kamis, Sabtu (08.30 – 15.30 WIB)',
    tags: ['AAC & PECS', 'Interaksi Resiprokal', 'Autisme (ASD)'],
    bio: 'Keahlian dalam memfasilitasi komunikasi anak non-verbal, spektrum autisme (ASD), dan ADHD menggunakan sistem komunikasi alternatif dan augmentatif (AAC/PECS).',
    philosophy: '"Setiap anak memiliki cara unik untuk berbicara; tugas kitalah untuk memahami bahasanya."',
    certifications: [
      'Certified PECS Advanced Practitioner',
      'Autism Spectrum Communication Support',
      'Social Stories & Pragmatic Language'
    ],
    photo: photos.tw2
  },
  {
    id: 'si-ratih',
    category: 'si',
    name: 'Ratih Kusuma, A.Md.OT, C.SI',
    edu: 'Praktisi Modulasi & Regulasi Sensori',
    specialty: 'Sensori Integrasi (SI)',
    icon: 'spa',
    color: 'green',
    str: 'STR Aktif Kemenkes',
    strNumber: 'STR.18.02.5.2.21-11883',
    experience: '5+ Tahun Pengalaman Klinis',
    schedule: 'Selasa, Rabu, Jumat (09.00 – 16.30 WIB)',
    tags: ['Toleransi Sensorik', 'Atensi & Fokus', 'Adaptasi Sensori'],
    bio: 'Menangani anak dengan hipersensitivitas sentuhan tekstur (picky eating sensori, jijik pasir/cat) dan stimulasi integrasi sensori agar anak nyaman beraktivitas sehari-hari.',
    philosophy: '"Rasa nyaman di dalam tubuhnya sendiri adalah awal dari senyum bahagia si Kecil."',
    certifications: [
      'Sensory-Based Picky Eater Approach',
      'Tactile Desensitization Mastery',
      'Sensory Diet for Classroom Success'
    ],
    photo: photos.si1
  },
]

const standards = [
  {
    icon: 'verified',
    color: 'blue',
    title: 'Kualifikasi Terverifikasi',
    desc: 'Seluruh terapis adalah lulusan perguruan tinggi terakreditasi dan memiliki Surat Tanda Registrasi (STR) aktif dari Kemkes RI.',
  },
  {
    icon: 'favorite',
    color: 'green',
    title: 'Pendekatan Penuh Kasih',
    desc: 'Metode terapi tanpa paksaan, ramah anak, dan bebas stigma. Terapi dirancang dalam kemasan bermain yang bermakna bagi anak.',
  },
  {
    icon: 'diversity_3',
    color: 'teal',
    title: 'Evaluasi Terpadu Multidisiplin',
    desc: 'Terapis wicara, okupasi, dan psikolog berkolaborasi menyelaraskan target kemajuan anak sehingga intervensi berjalan efektif.',
  },
  {
    icon: 'forum',
    color: 'amber',
    title: 'Diskusi Terbuka Orang Tua',
    desc: 'Setiap akhir sesi terapi disertai laporan evaluasi dan panduan stimulasi sederhana yang mudah dipraktikkan di rumah.',
  },
]

// Reactive team members list with local fallback
const teamMembers = ref(defaultTeamMembers)

const formatMemberFromApi = (m) => {
  let category = 'tw'
  let icon = 'record_voice_over'
  let color = 'blue'
  const text = ((m.role || '') + ' ' + (m.specialization || '')).toLowerCase()
  if (text.includes('wicara') || text.includes('tw') || text.includes('speech')) {
    category = 'tw'
    icon = 'record_voice_over'
    color = 'blue'
  } else if (text.includes('okupasi') || text.includes('ot')) {
    category = 'ot'
    icon = 'back_hand'
    color = 'amber'
  } else if (text.includes('sensori') || text.includes('si')) {
    category = 'si'
    icon = 'spa'
    color = 'teal'
  } else if (text.includes('psikolog') || text.includes('psi')) {
    category = 'psi'
    icon = 'psychology'
    color = 'purple'
  } else if (text.includes('fisio')) {
    category = 'psi'
    icon = 'accessibility_new'
    color = 'amber'
  }

  // Parse tags
  let tags = []
  if (Array.isArray(m.tags)) {
    tags = m.tags
  } else if (typeof m.tags === 'string' && m.tags.trim()) {
    try { tags = JSON.parse(m.tags) } catch { tags = m.tags.split(',').map(s => s.trim()) }
  } else if (m.specialization) {
    tags = m.specialization.split(',').map(s => s.trim())
  }

  // Parse certifications
  let certifications = []
  if (Array.isArray(m.certifications)) {
    certifications = m.certifications
  } else if (typeof m.certifications === 'string' && m.certifications.trim()) {
    try { certifications = JSON.parse(m.certifications) } catch { certifications = m.certifications.split(',').map(s => s.trim()) }
  }

  return {
    id: m.id,
    category,
    name: m.name,
    edu: m.edu || m.specialization || 'Praktisi Terapi Anak ATC',
    specialty: m.role || 'Terapis Anak',
    icon,
    color,
    str: m.str_number ? 'STR Aktif Kemenkes' : 'Praktisi Terverifikasi',
    strNumber: m.str_number || 'STR. Terdaftar Kemenkes RI',
    experience: m.experience_years ? (m.experience_years.includes('Pengalaman') ? m.experience_years : `${m.experience_years} Pengalaman Klinis`) : 'Berpengalaman Klinis',
    schedule: m.schedule || 'Senin - Sabtu (Sesuai Reservasi)',
    tags: tags.length ? tags : ['Tumbuh Kembang', 'Pediatrik'],
    bio: m.bio || 'Praktisi terapis anak di Amanah Tin\'s Center yang berdedikasi mendampingi potensi optimal anak melalui stimulasi terarah dan terpadu.',
    philosophy: m.philosophy || '"Mendampingi setiap langkah buah hati untuk berkembang dengan penuh percaya diri."',
    certifications: certifications.length ? certifications : ['Sertifikasi Kompetensi Klinis'],
    photo: m.image || photos[category + '1'] || photos.tw1,
  }
}

// Computed: Filtered team members based on selectedCategory and searchQuery
const filteredTeamMembers = computed(() => {
  return teamMembers.value.filter((m) => {
    // 1. Category filter
    const matchCat = selectedCategory.value === 'all' || m.category === selectedCategory.value

    // 2. Search query filter
    const q = searchQuery.value.trim().toLowerCase()
    if (!q) return matchCat

    const matchName = (m.name || '').toLowerCase().includes(q)
    const matchSpecialty = (m.specialty || '').toLowerCase().includes(q)
    const matchEdu = (m.edu || '').toLowerCase().includes(q)
    const matchTags = Array.isArray(m.tags) && m.tags.some((t) => t.toLowerCase().includes(q))
    const matchBio = (m.bio || '').toLowerCase().includes(q)

    return matchCat && (matchName || matchSpecialty || matchEdu || matchTags || matchBio)
  })
})

const getCategoryCount = (catId) => {
  if (catId === 'all') return teamMembers.value.length
  return teamMembers.value.filter((m) => m.category === catId).length
}

const resetFilters = () => {
  selectedCategory.value = 'all'
  searchQuery.value = ''
}

const openTherapistModal = (member) => {
  selectedTherapist.value = member
  isModalOpen.value = true
  document.body.style.overflow = 'hidden'
}

const closeTherapistModal = () => {
  isModalOpen.value = false
  selectedTherapist.value = null
  document.body.style.overflow = ''
}

const handleKeyDown = (e) => {
  if (e.key === 'Escape' && isModalOpen.value) {
    closeTherapistModal()
  }
}

onMounted(async () => {
  window.addEventListener('keydown', handleKeyDown)
  try {
    const res = await api.get('/team')
    if (res.data && Array.isArray(res.data) && res.data.length > 0) {
      teamMembers.value = res.data.map(formatMemberFromApi)
    }
  } catch (err) {
    console.warn('Gagal memuat data tim dari API, menggunakan fallback lokal:', err)
  }
})

onUnmounted(() => {
  window.removeEventListener('keydown', handleKeyDown)
  document.body.style.overflow = ''
})

const getTherapistWaUrl = (member) => {
  const text = `Halo Admin Amanah Tin's Center, saya ingin reservasi jadwal asesmen/terapi bersama ${member.name} (${member.specialty}). Jadwal praktik: ${member.schedule}. Mohon info ketersediaan slotnya.`
  return waLink(text)
}
</script>

<style scoped>
/* ============================================================
   HERO
   ============================================================ */
.hero-section {
  position: relative;
  padding: 2.5rem 0 3rem;
  background: linear-gradient(to bottom, #f0f7fb, var(--background));
  overflow: hidden;
}
.blob {
  position: absolute;
  border-radius: 50%;
  pointer-events: none;
  z-index: 0;
  filter: blur(60px);
}
.blob-right {
  width: 280px; height: 280px;
  background: rgba(204, 239, 142, 0.4);
  top: -48px; right: 40px;
}
.blob-left {
  width: 320px; height: 320px;
  background: rgba(193, 232, 255, 0.4);
  top: 80px; left: 25%;
}
.hero-section .container { position: relative; z-index: 1; }

.breadcrumb {
  display: flex; align-items: center; gap: 0.5rem;
  font-size: 12px; color: var(--on-surface-variant);
  margin-bottom: 1.5rem;
}
.bc-link {
  display: flex; align-items: center; gap: 0.25rem;
  color: var(--on-surface-variant); text-decoration: none;
  transition: color 0.2s;
}
.bc-link:hover { color: var(--primary); }
.bc-sep { color: var(--on-surface-variant); }
.bc-active { color: var(--primary); font-weight: 600; }

.hero-content { max-width: 720px; display: flex; flex-direction: column; gap: 1rem; }

.hero-badge {
  display: inline-flex; align-items: center; gap: 0.5rem;
  background: #e0f2fe;
  color: #0369a1;
  padding: 0.375rem 1rem;
  border-radius: 9999px;
  font-size: 13px; font-weight: 700;
  width: fit-content;
  border: 1px solid rgba(3, 105, 161, 0.2);
}
.hero-title {
  font-family: var(--font-headline);
  font-size: 40px; font-weight: 800;
  letter-spacing: -0.02em; line-height: 1.22;
  color: #091d2e; margin: 0;
}
.hero-desc {
  font-size: 16.5px; line-height: 1.68;
  color: #4b5860; margin: 0;
  max-width: 680px;
}

/* ============================================================
   TEAM SECTION
   ============================================================ */
.team-section { padding: var(--space-xl) 0; background: var(--background); }

.team-header {
  margin-bottom: 1.75rem;
}
.team-eyebrow {
  display: inline-block;
  background: #e0f2fe;
  color: #006384;
  font-size: 12px; font-weight: 800;
  padding: 0.25rem 0.875rem;
  border-radius: 9999px;
  text-transform: uppercase;
  margin-bottom: 0.5rem;
}
.team-title {
  font-family: var(--font-headline);
  font-size: 32px; font-weight: 800;
  color: #091d2e; margin: 0 0 0.5rem;
  letter-spacing: -0.015em;
}
.team-sub { font-size: 15.5px; color: #556066; max-width: 640px; line-height: 1.6; margin: 0; }

/* ============================================================
   FILTER CONTROLS (TOOLBAR & 1-ROW CATEGORY TABS)
   ============================================================ */
.filter-controls-wrap {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
  margin-bottom: 2.25rem;
  position: relative;
  z-index: 5;
}

.filter-toolbar-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1.25rem;
  flex-wrap: wrap;
}

.team-count-note {
  font-size: 13.5px;
  color: #475569;
  background: #f8fafc;
  padding: 0.45rem 1rem;
  border-radius: 999px;
  border: 1px solid #e2e8f0;
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  font-weight: 500;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
}

.team-count-note strong {
  color: #006384;
  font-weight: 800;
}

.category-tabs-nav {
  display: flex;
  flex-wrap: nowrap;
  gap: 0.65rem;
  /* Headroom vertikal agar efek translateY & box-shadow saat hover tidak terpotong */
  padding: 0.5rem 0.35rem 0.65rem 0.35rem;
  margin: -0.25rem -0.35rem 0 -0.35rem;
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
  scrollbar-width: none;
  -ms-overflow-style: none;
}

.category-tabs-nav::-webkit-scrollbar {
  display: none;
}

@media (min-width: 1024px) {
  .category-tabs-nav {
    overflow: visible; /* Pada desktop tidak ada clipping boundary sama sekali */
    padding-left: 0;
    padding-right: 0;
    margin-left: 0;
    margin-right: 0;
  }
}

.cat-tab-btn {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  flex-shrink: 0;
  white-space: nowrap;
  background: #ffffff;
  color: #334155;
  border: 1.5px solid rgba(191, 200, 206, 0.45);
  padding: 0.6rem 1.15rem;
  border-radius: 999px;
  font-family: var(--font-headline);
  font-size: 13px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
  position: relative;
  z-index: 1;
}

.cat-tab-btn:hover {
  border-color: #006384;
  color: #006384;
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(0, 99, 132, 0.12);
  z-index: 2;
}

.cat-tab-btn.is-active {
  background: #006384;
  color: #ffffff;
  border-color: #006384;
  box-shadow: 0 4px 14px rgba(0, 99, 132, 0.25);
  z-index: 1;
}

.cat-tab-icon {
  font-size: 18px;
}

.cat-tab-badge {
  background: rgba(0, 0, 0, 0.08);
  color: inherit;
  font-size: 11px;
  font-weight: 800;
  padding: 0.15rem 0.45rem;
  border-radius: 999px;
}

.cat-tab-btn.is-active .cat-tab-badge {
  background: rgba(255, 255, 255, 0.25);
  color: #ffffff;
}

.search-input-box {
  position: relative;
  min-width: 300px;
  max-width: 440px;
  width: 100%;
}

@media (max-width: 640px) {
  .filter-toolbar-row {
    flex-direction: column;
    align-items: stretch;
    gap: 0.75rem;
  }
  .search-input-box {
    min-width: 100%;
    max-width: 100%;
  }
}

.search-icon {
  position: absolute;
  left: 1rem;
  top: 50%;
  transform: translateY(-50%);
  color: #94a3b8;
  font-size: 20px;
  pointer-events: none;
}

.search-input {
  width: 100%;
  padding: 0.65rem 2.25rem 0.65rem 2.75rem;
  border-radius: 999px;
  border: 1.5px solid rgba(191, 200, 206, 0.45);
  background: #ffffff;
  font-size: 13.5px;
  color: #091d2e;
  outline: none;
  transition: all 0.2s;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
}

.search-input:focus {
  border-color: #006384;
  box-shadow: 0 0 0 3px rgba(0, 99, 132, 0.15);
}

.btn-clear-search {
  position: absolute;
  right: 0.75rem;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  color: #94a3b8;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0.25rem;
  border-radius: 50%;
}

.btn-clear-search:hover {
  color: #091d2e;
}

/* ============================================================
   TEAM GRID & MEMBER CARDS
   ============================================================ */
.team-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1.75rem;
}

.member-card {
  background: #ffffff;
  border: 1.5px solid rgba(191, 200, 206, 0.35);
  border-radius: 1.25rem;
  overflow: hidden;
  padding: 1.25rem;
  display: flex;
  flex-direction: column;
  box-shadow: 0 6px 20px -4px rgba(9, 29, 46, 0.06);
  transition: all 0.25s ease;
  cursor: pointer;
  position: relative;
}

.member-card:hover {
  transform: translateY(-5px);
  border-color: #006384;
  box-shadow: 0 16px 36px -6px rgba(0, 99, 132, 0.15);
}

.member-photo-wrap {
  position: relative;
  margin-bottom: 1rem;
  border-radius: 1rem;
  overflow: hidden;
}

.member-photo {
  width: 100%;
  height: 210px;
  object-fit: cover;
  display: block;
  transition: transform 0.4s ease;
}

.member-card:hover .member-photo {
  transform: scale(1.04);
}

.photo-overlay-gradient {
  position: absolute;
  inset: 0;
  background: linear-gradient(180deg, rgba(0,0,0,0) 60%, rgba(9, 29, 46, 0.4) 100%);
  pointer-events: none;
}

.badge-specialty {
  position: absolute;
  top: 0.75rem; left: 0.75rem;
  display: flex; align-items: center; gap: 0.3rem;
  background: rgba(255,255,255,0.95);
  backdrop-filter: blur(6px);
  border-radius: 9999px;
  padding: 0.3rem 0.75rem;
  font-size: 11.5px; font-weight: 800;
  box-shadow: 0 2px 8px rgba(0,0,0,0.12);
  border: 1px solid rgba(255,255,255,0.8);
}
.badge-blue   { color: #006384; }
.badge-amber  { color: #d97706; }
.badge-green  { color: #16a34a; }

.badge-str {
  position: absolute;
  bottom: 0.75rem; right: 0.75rem;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(6px);
  color: #065f46;
  border-radius: 9999px;
  padding: 0.25rem 0.65rem;
  font-size: 11px; font-weight: 700;
  box-shadow: 0 2px 6px rgba(0,0,0,0.15);
  display: flex;
  align-items: center;
  gap: 0.35rem;
}

.pulse-dot-green {
  width: 6px;
  height: 6px;
  background: #10b981;
  border-radius: 50%;
  box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.3);
}

.member-info-body {
  flex: 1;
  display: flex;
  flex-direction: column;
}

.member-name {
  font-family: var(--font-headline);
  font-size: 16.5px; font-weight: 800;
  color: #091d2e; margin: 0 0 0.25rem;
  line-height: 1.3;
}

.member-edu {
  font-size: 12px; color: #556066;
  margin: 0 0 0.75rem; line-height: 1.45;
}

/* Schedule Chip */
.member-schedule-chip {
  display: flex;
  align-items: center;
  gap: 0.4rem;
  background: #f1f5f9;
  border-radius: 8px;
  padding: 0.4rem 0.65rem;
  margin-bottom: 0.85rem;
}

.sched-icon {
  font-size: 16px;
  color: #006384;
}

.sched-text {
  font-size: 11.5px;
  font-weight: 700;
  color: #334155;
  line-height: 1.3;
}

.member-focus {
  margin-top: auto;
  margin-bottom: 1.15rem;
}

.focus-label {
  display: block;
  font-size: 11.5px; font-weight: 700;
  color: #64748b;
  text-transform: uppercase;
  margin-bottom: 0.4rem;
}
.focus-tags { display: flex; flex-wrap: wrap; gap: 0.35rem; }
.focus-tag {
  font-size: 11.5px;
  padding: 0.2rem 0.6rem;
  border-radius: 9999px;
  font-weight: 600;
}
.tag-blue  { background: #e0f2fe; color: #006384; }
.tag-amber { background: #fef3c7; color: #b45309; }
.tag-green { background: #dcfce7; color: #15803d; }

/* Member Card Action Row */
.member-actions-row {
  display: grid;
  grid-template-columns: 1fr auto;
  gap: 0.5rem;
  padding-top: 1rem;
  border-top: 1px solid rgba(191, 200, 206, 0.25);
}

.btn-card-detail {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.35rem;
  background: #f8fafc;
  color: #006384;
  border: 1px solid #cbd5e1;
  border-radius: 999px;
  padding: 0.55rem 0.75rem;
  font-family: var(--font-headline);
  font-size: 12px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.2s;
  text-decoration: none;
}

.btn-card-detail:hover {
  background: #e0f2fe;
  border-color: #006384;
}

.action-icon {
  font-size: 16px;
}

.btn-card-wa {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.3rem;
  background: #25d366;
  color: #ffffff;
  border-radius: 999px;
  padding: 0.55rem 0.85rem;
  font-family: var(--font-headline);
  font-size: 12px;
  font-weight: 700;
  text-decoration: none;
  transition: all 0.2s;
  box-shadow: 0 2px 6px rgba(37, 211, 102, 0.25);
  white-space: nowrap;
}

.btn-card-wa:hover {
  background: #1ebc59;
  transform: translateY(-1px);
}

.wa-icon {
  font-size: 16px;
}

/* ============================================================
   EMPTY STATE
   ============================================================ */
.empty-state-box {
  background: #ffffff;
  border: 1.5px dashed #cbd5e1;
  border-radius: 1.5rem;
  padding: 3.5rem 2rem;
  text-align: center;
  margin: 1rem 0 2.5rem;
}

.empty-icon-wrap {
  width: 64px;
  height: 64px;
  border-radius: 50%;
  background: #f1f5f9;
  color: #64748b;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 1.25rem;
}

.empty-icon-wrap .material-symbols-outlined {
  font-size: 32px;
}

.empty-title {
  font-family: var(--font-headline);
  font-size: 20px;
  font-weight: 800;
  color: #091d2e;
  margin: 0 0 0.5rem;
}

.empty-desc {
  font-size: 14.5px;
  color: #556066;
  max-width: 440px;
  margin: 0 auto 1.5rem;
}

.btn-reset-filter {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  background: #006384;
  color: #ffffff;
  font-family: var(--font-headline);
  font-size: 13.5px;
  font-weight: 700;
  padding: 0.75rem 1.5rem;
  border-radius: 999px;
  border: none;
  cursor: pointer;
  transition: all 0.2s;
  box-shadow: 0 4px 12px rgba(0, 99, 132, 0.2);
}

.btn-reset-filter:hover {
  background: #004d66;
}

/* Footnote */
.footnote {
  margin-top: 2.5rem;
  background: #f8fafc;
  border: 1px solid rgba(191,200,206,0.3);
  border-radius: 1rem;
  padding: 1.25rem 1.75rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1.5rem;
  flex-wrap: wrap;
}
.footnote-left {
  display: flex; align-items: center; gap: 0.85rem; flex: 1;
}
.footnote-left p { font-size: 14px; color: #334155; line-height: 1.6; margin: 0; }
.footnote-link {
  font-size: 13.5px; font-weight: 800;
  color: #006384; text-decoration: none;
  white-space: nowrap;
  font-family: var(--font-headline);
}
.footnote-link:hover { text-decoration: underline; }

/* ============================================================
   MODAL PROFIL LENGKAP TERAPIS (INTERACTIVE POP-UP)
   ============================================================ */
.modal-backdrop {
  position: fixed;
  inset: 0;
  background: rgba(9, 29, 46, 0.65);
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
  z-index: 2200;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1.5rem;
  animation: fadeInBackdrop 0.25s ease;
}

@keyframes fadeInBackdrop {
  from { opacity: 0; }
  to { opacity: 1; }
}

.modal-card {
  background: #ffffff;
  border-radius: 1.5rem;
  max-width: 680px;
  width: 100%;
  max-height: 90vh;
  overflow-y: auto;
  scrollbar-width: none; /* Firefox */
  -ms-overflow-style: none; /* IE & Edge */
  box-shadow: 0 24px 60px -12px rgba(9, 29, 46, 0.35);
  position: relative;
  animation: scaleUpModal 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}

.modal-card::-webkit-scrollbar {
  display: none; /* Chrome, Safari, Opera */
}

@keyframes scaleUpModal {
  from { opacity: 0; transform: scale(0.95) translateY(12px); }
  to { opacity: 1; transform: scale(1) translateY(0); }
}

.btn-modal-close {
  position: absolute;
  top: 1.25rem;
  right: 1.25rem;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: #f1f5f9;
  border: none;
  color: #475569;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s;
  z-index: 10;
}

.btn-modal-close:hover {
  background: #e2e8f0;
  color: #091d2e;
}

.modal-header {
  padding: 2.25rem 2.25rem 1.5rem;
  display: flex;
  align-items: flex-start;
  gap: 1.5rem;
  border-bottom: 1px solid #edf2f7;
}

.modal-avatar-frame {
  position: relative;
  flex-shrink: 0;
}

.modal-avatar-img {
  width: 110px;
  height: 110px;
  border-radius: 1.25rem;
  object-fit: cover;
  border: 3px solid #ffffff;
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
}

.modal-avatar-badge {
  position: absolute;
  bottom: -6px;
  right: -6px;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background: #ffffff;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
  display: flex;
  align-items: center;
  justify-content: center;
}

.modal-avatar-badge .material-symbols-outlined {
  font-size: 18px;
}

.modal-header-info {
  flex: 1;
}

.modal-badge-row {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 0.5rem;
  margin-bottom: 0.5rem;
}

.modal-spec-badge {
  font-size: 12px;
  font-weight: 800;
  text-transform: uppercase;
  background: #e0f2fe;
  color: #006384;
  padding: 0.25rem 0.75rem;
  border-radius: 999px;
}

.modal-str-pill {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  font-size: 11.5px;
  font-weight: 700;
  color: #065f46;
  background: #ecfdf5;
  padding: 0.25rem 0.65rem;
  border-radius: 999px;
}

.modal-name {
  font-family: var(--font-headline);
  font-size: 22px;
  font-weight: 800;
  color: #091d2e;
  margin: 0 0 0.25rem;
  line-height: 1.25;
}

.modal-edu-text {
  font-size: 13px;
  color: #556066;
  margin: 0 0 0.75rem;
  line-height: 1.4;
}

.modal-meta-row {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
}

.modal-meta-item {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  font-size: 12px;
  font-weight: 600;
  color: #64748b;
}

.meta-icon {
  font-size: 16px;
  color: #006384;
}

.modal-body-content {
  padding: 1.5rem 2.25rem;
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.modal-schedule-box {
  background: #f0f9ff;
  border: 1.5px solid #bae6fd;
  border-radius: 1rem;
  padding: 1rem 1.25rem;
  display: flex;
  align-items: center;
  gap: 0.85rem;
}

.sched-icon-circle {
  width: 42px;
  height: 42px;
  border-radius: 50%;
  background: #006384;
  color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.sched-box-text {
  display: flex;
  flex-direction: column;
}

.sched-box-title {
  font-size: 11.5px;
  font-weight: 800;
  color: #0369a1;
  text-transform: uppercase;
}

.sched-box-val {
  font-family: var(--font-headline);
  font-size: 14.5px;
  font-weight: 800;
  color: #091d2e;
}

.modal-section-block {
  display: flex;
  flex-direction: column;
  gap: 0.65rem;
}

.modal-block-title {
  display: flex;
  align-items: center;
  gap: 0.4rem;
  font-family: var(--font-headline);
  font-size: 14px;
  font-weight: 800;
  color: #091d2e;
  text-transform: uppercase;
  letter-spacing: 0.03em;
  margin: 0;
}

.block-icon {
  font-size: 18px;
  color: #006384;
}

.modal-bio-text {
  font-size: 14px;
  color: #334155;
  line-height: 1.65;
  margin: 0;
}

.modal-quote-box {
  background: #f8fafc;
  border-left: 3.5px solid #006384;
  padding: 0.85rem 1.25rem;
  border-radius: 0 12px 12px 0;
  position: relative;
}

.quote-mark {
  font-size: 22px;
  color: #94a3b8;
  opacity: 0.6;
  margin-bottom: 0.25rem;
  display: block;
}

.modal-quote-text {
  font-size: 13.5px;
  font-style: italic;
  color: #1e293b;
  line-height: 1.55;
  margin: 0;
}

.modal-cert-grid {
  display: flex;
  flex-direction: column;
  gap: 0.45rem;
}

.modal-cert-item {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  padding: 0.6rem 0.85rem;
  border-radius: 8px;
}

.cert-check {
  font-size: 18px;
  color: #16a34a;
  flex-shrink: 0;
}

.cert-text {
  font-size: 13px;
  font-weight: 600;
  color: #1e293b;
}

.modal-footer-actions {
  padding: 1.25rem 2.25rem 2rem;
  background: #f8fafc;
  border-top: 1px solid #edf2f7;
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 0.75rem;
}

.btn-modal-wa {
  flex: 1;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  background: #25d366;
  color: #ffffff;
  font-family: var(--font-headline);
  font-size: 13.5px;
  font-weight: 700;
  padding: 0.85rem 1.5rem;
  border-radius: 999px;
  text-decoration: none;
  box-shadow: 0 4px 12px rgba(37, 211, 102, 0.25);
  transition: all 0.2s;
  white-space: nowrap;
}

.btn-modal-wa:hover {
  background: #1ebc59;
  transform: translateY(-2px);
}

.btn-modal-form {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  background: #006384;
  color: #ffffff;
  font-family: var(--font-headline);
  font-size: 13.5px;
  font-weight: 700;
  padding: 0.85rem 1.25rem;
  border-radius: 999px;
  text-decoration: none;
  transition: all 0.2s;
  white-space: nowrap;
}

.btn-modal-form:hover {
  background: #004d66;
}

.btn-modal-secondary {
  background: transparent;
  border: 1px solid #cbd5e1;
  color: #475569;
  font-family: var(--font-headline);
  font-size: 13.5px;
  font-weight: 700;
  padding: 0.85rem 1.25rem;
  border-radius: 999px;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-modal-secondary:hover {
  background: #f1f5f9;
  color: #091d2e;
}

/* ============================================================
   STANDARDS SECTION
   ============================================================ */
.standards-section {
  padding: var(--space-xl) 0;
  background: #f0f7fb;
  border-top: 1px solid rgba(191,200,206,0.2);
  border-bottom: 1px solid rgba(191,200,206,0.2);
}
.standards-header { text-align: center; max-width: 640px; margin: 0 auto 3rem; }
.standards-eyebrow {
  display: inline-block;
  background: #e0f2fe;
  color: #006384;
  font-size: 12px; font-weight: 800;
  padding: 0.25rem 0.875rem;
  border-radius: 9999px;
  text-transform: uppercase;
  margin-bottom: 0.75rem;
}
.standards-title {
  font-family: var(--font-headline);
  font-size: 34px; font-weight: 800;
  color: #091d2e;
  margin: 0 0 0.5rem;
}
.standards-sub { font-size: 15.5px; color: #556066; margin: 0; }

.standards-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1.5rem;
}
.std-card {
  background: #fff;
  border: 1px solid rgba(191,200,206,0.3);
  border-radius: 1.25rem;
  padding: 1.5rem;
  box-shadow: 0 4px 16px rgba(9, 29, 46, 0.05);
}
.std-icon {
  width: 48px; height: 48px;
  border-radius: 12px;
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 1.25rem;
}
.std-icon--blue  { background: #e0f2fe; color: #006384; }
.std-icon--green { background: #dcfce7; color: #16a34a; }
.std-icon--teal  { background: #ccfbf1; color: #0d9488; }
.std-icon--amber { background: #fef3c7; color: #d97706; }
.std-title {
  font-family: var(--font-headline);
  font-size: 17px; font-weight: 800;
  color: #091d2e; margin: 0 0 0.5rem;
}
.std-desc { font-size: 13.5px; line-height: 1.6; color: #556066; margin: 0; }

/* ============================================================
   CTA SECTION
   ============================================================ */
.cta-section { padding: var(--space-xl) 0; background: var(--background); }
.cta-card {
  background: linear-gradient(135deg, #006384 0%, #00839e 100%);
  color: #fff;
  border-radius: 1.5rem;
  padding: 3.5rem;
  position: relative;
  overflow: hidden;
  box-shadow: 0 16px 36px -4px rgba(0, 99, 132, 0.25);
}
.cta-blob {
  position: absolute;
  border-radius: 50%;
  pointer-events: none;
}
.cta-blob-br {
  width: 320px; height: 320px;
  right: -80px; bottom: -80px;
  background: rgba(204, 239, 142, 0.2);
  filter: blur(48px);
}
.cta-blob-top {
  width: 240px; height: 240px;
  top: 0; right: 33%;
  background: rgba(255,255,255,0.1);
  filter: blur(40px);
}
.cta-inner {
  position: relative; z-index: 1;
  display: grid;
  grid-template-columns: 1fr auto;
  gap: 2rem;
  align-items: center;
  margin-bottom: 2rem;
}
.cta-badge {
  display: inline-flex; align-items: center; gap: 0.5rem;
  background: rgba(255,255,255,0.18);
  border-radius: 9999px;
  padding: 0.3rem 0.85rem;
  font-size: 12px; font-weight: 700;
  margin-bottom: 1rem;
  width: fit-content;
}
.cta-title {
  font-family: var(--font-headline);
  font-size: 32px; font-weight: 800;
  color: #fff; margin: 0 0 1rem;
  line-height: 1.25;
}
.cta-desc {
  font-size: 16.5px; line-height: 1.65;
  color: rgba(255, 255, 255, 0.9);
  margin: 0; max-width: 640px;
}
.cta-actions {
  display: flex; flex-direction: column; gap: 0.75rem;
  flex-shrink: 0; min-width: 220px;
}
.btn-wa, .btn-schedule {
  display: flex; align-items: center; justify-content: center; gap: 0.5rem;
  padding: 0.85rem 1.6rem;
  border-radius: 9999px;
  font-family: var(--font-headline);
  font-size: 14.5px; font-weight: 700;
  text-decoration: none;
  transition: all 0.2s;
  white-space: nowrap;
}
.btn-wa {
  background: #25d366;
  color: #fff;
  box-shadow: 0 4px 12px rgba(37, 211, 102, 0.35);
}
.btn-wa:hover {
  background: #1ebc59;
  transform: translateY(-2px);
}
.btn-schedule {
  background: rgba(255,255,255,0.18);
  color: #fff;
  border: 1.5px solid rgba(255,255,255,0.4);
}
.btn-schedule:hover {
  background: rgba(255,255,255,0.28);
  transform: translateY(-2px);
}

.cta-footer-info {
  position: relative; z-index: 1;
  display: flex; flex-wrap: wrap; gap: 1.5rem;
  padding-top: 1.5rem;
  border-top: 1px solid rgba(255,255,255,0.2);
}
.cta-info-item {
  display: flex; align-items: center; gap: 0.5rem;
  font-size: 12.5px; color: rgba(255, 255, 255, 0.85);
}

/* ============================================================
   RESPONSIVE
   ============================================================ */
@media (max-width: 1200px) {
  .team-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 1024px) {
  .hero-title { font-size: 34px; }
  .team-grid { grid-template-columns: repeat(2, 1fr); }
  .standards-grid { grid-template-columns: repeat(2, 1fr); }
  .cta-inner { grid-template-columns: 1fr; }
  .cta-actions { flex-direction: row; flex-wrap: wrap; }
}
@media (max-width: 640px) {
  .hero-title { font-size: 26px; }
  .team-grid { grid-template-columns: 1fr; }
  .standards-grid { grid-template-columns: 1fr; }
  .cta-card { padding: 2rem 1.5rem; }
  .cta-title { font-size: 24px; }
  .search-input-box { min-width: 100%; }
  .modal-header { flex-direction: column; align-items: center; text-align: center; }
  .modal-badge-row { justify-content: center; }
  .modal-meta-row { justify-content: center; }
  .modal-footer-actions { flex-direction: column; }
  .btn-modal-wa, .btn-modal-form, .btn-modal-secondary { width: 100%; text-align: center; }
}
</style>
