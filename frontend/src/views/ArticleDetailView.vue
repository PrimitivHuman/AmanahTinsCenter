<template>
  <PublicLayout>
    <!-- ==================== STICKY READING PROGRESS BAR ==================== -->
    <div
      v-if="!isLoading && !isNotFound && activeArticle"
      class="reading-progress-track"
      role="progressbar"
      :aria-valuenow="Math.round(readingProgress)"
      aria-valuemin="0"
      aria-valuemax="100"
    >
      <div class="reading-progress-fill" :style="{ width: readingProgress + '%' }"></div>
    </div>

    <div class="article-detail-page">
      <!-- ==================== SKELETON LOADING STATE (ANTI-FLICKER) ==================== -->
      <div v-if="isLoading" class="article-skeleton-page" aria-busy="true" aria-label="Memuat artikel...">
        <!-- Skeleton Breadcrumb Strip -->
        <div class="breadcrumb-strip">
          <div class="container breadcrumb-container">
            <div class="skeleton-breadcrumb-row">
              <div class="skel-bar skel-bc-1"></div>
              <span class="skel-bc-sep">/</span>
              <div class="skel-bar skel-bc-2"></div>
              <span class="skel-bc-sep">/</span>
              <div class="skel-bar skel-bc-3"></div>
            </div>
          </div>
        </div>

        <!-- Skeleton Hero Header -->
        <section class="article-hero-section">
          <div class="container">
            <div class="hero-badges">
              <div class="skel-bar skel-pill-1"></div>
              <div class="skel-bar skel-pill-2"></div>
              <div class="skel-bar skel-pill-3"></div>
            </div>

            <div class="skel-title-wrap">
              <div class="skel-bar skel-title-line1"></div>
              <div class="skel-bar skel-title-line2"></div>
            </div>

            <div class="meta-bar-card skel-meta-card">
              <div class="skel-meta-left">
                <div class="skel-avatar"></div>
                <div class="skel-meta-text">
                  <div class="skel-bar skel-line-short"></div>
                  <div class="skel-bar skel-line-tiny"></div>
                </div>
              </div>
              <div class="skel-meta-right">
                <div class="skel-circle"></div>
                <div class="skel-circle"></div>
              </div>
            </div>

            <div class="skel-hero-img-wrap">
              <div class="skel-bar skel-hero-img"></div>
            </div>
          </div>
        </section>

        <!-- Skeleton Body Grid -->
        <main class="article-body-section">
          <div class="container">
            <div class="article-grid">
              <div class="article-content-col">
                <div class="editorial-card skel-card">
                  <div class="skel-bar skel-line-lead"></div>
                  <div class="skel-bar skel-line-lead-2"></div>
                </div>

                <div class="editorial-card skel-card">
                  <div class="skel-bar skel-h2-line"></div>
                  <div class="skel-bar skel-p-line"></div>
                  <div class="skel-bar skel-p-line"></div>
                  <div class="skel-bar skel-p-line skel-w-85"></div>
                  <div class="skel-bar skel-p-line skel-w-65"></div>

                  <div style="height: 1.5rem;"></div>

                  <div class="skel-bar skel-h2-line skel-w-50"></div>
                  <div class="skel-bar skel-p-line"></div>
                  <div class="skel-bar skel-p-line"></div>
                  <div class="skel-bar skel-p-line skel-w-80"></div>
                </div>
              </div>

              <aside class="sidebar-col">
                <div class="editorial-card skel-card" style="height: 180px;">
                  <div class="skel-bar skel-h2-line skel-w-65"></div>
                  <div class="skel-bar skel-p-line"></div>
                  <div class="skel-bar skel-p-line skel-w-75"></div>
                </div>

                <div class="editorial-card skel-card">
                  <div class="skel-bar skel-h2-line skel-w-65" style="margin-bottom: 1.25rem;"></div>
                  <div v-for="n in 3" :key="n" class="skel-related-row">
                    <div class="skel-rel-thumb"></div>
                    <div class="skel-rel-info">
                      <div class="skel-bar skel-line-short"></div>
                      <div class="skel-bar skel-line-tiny"></div>
                    </div>
                  </div>
                </div>
              </aside>
            </div>
          </div>
        </main>
      </div>

      <!-- ==================== 404 NOT FOUND STATE ==================== -->
      <section v-else-if="isNotFound || !activeArticle" class="article-not-found-section">
        <div class="container not-found-container">
          <div class="not-found-card">
            <div class="not-found-icon-wrap">
              <span class="material-symbols-outlined">menu_book</span>
            </div>
            <span class="not-found-badge">404 • Artikel Tidak Tersedia</span>
            <h1 class="not-found-title">Artikel Tidak Ditemukan</h1>
            <p class="not-found-desc">
              Artikel yang Anda cari mungkin telah dipindahkan, dinonaktifkan, atau masih berstatus draf internal redaksi kami.
            </p>
            <div class="not-found-actions">
              <router-link to="/artikel" class="btn-not-found-primary">
                <span class="material-symbols-outlined">arrow_back</span>
                <span>Kembali ke Katalog Artikel</span>
              </router-link>
              <router-link to="/" class="btn-not-found-secondary">
                <span class="material-symbols-outlined">home</span>
                <span>Beranda Klinik</span>
              </router-link>
            </div>
          </div>
        </div>
      </section>

      <template v-else>
        <!-- ==================== BREADCRUMBS & TOP NAV-BACK STRIP ==================== -->
        <div class="breadcrumb-strip">
          <div class="container breadcrumb-container">
            <nav aria-label="Breadcrumb" class="breadcrumb-nav">
              <router-link to="/" class="bc-link">
                <span class="material-symbols-outlined bc-icon">home</span>
                <span>Beranda</span>
              </router-link>
              <span class="bc-sep">/</span>
              <router-link to="/artikel" class="bc-link">Artikel &amp; Tips</router-link>
              <span class="bc-sep">/</span>
              <span class="bc-active">{{ activeArticle.title }}</span>
            </nav>
            <router-link to="/artikel" class="back-link">
              <span class="material-symbols-outlined back-icon">arrow_back</span>
              <span>Kembali ke Semua Artikel</span>
            </router-link>
          </div>
        </div>
      <!-- ==================== ARTICLE HERO / META HEADER ==================== -->
      <section class="article-hero-section">
        <div class="container">
          <!-- Badges Category -->
          <div class="hero-badges">
            <span class="badge-pill badge-primary">
              <span class="material-symbols-outlined badge-icon">record_voice_over</span>
              <span>{{ activeArticle.category || 'Terapi Wicara' }}</span>
            </span>
            <span class="badge-pill badge-secondary">
              <span class="material-symbols-outlined badge-icon">escalator_warning</span>
              <span>Tumbuh Kembang Anak</span>
            </span>
            <span class="badge-pill badge-neutral">
              <span class="material-symbols-outlined badge-icon">schedule</span>
              <span>{{ activeArticle.read_time || '5 Menit Baca' }}</span>
            </span>
          </div>

          <!-- Main Headline -->
          <h1 class="article-main-title">
            {{ activeArticle.title }}
          </h1>

          <!-- Author and Medical Review Metadata Bar -->
          <div class="meta-bar-card">
            <div class="meta-bar-left">
              <!-- Author Info -->
              <div class="author-block">
                <div class="author-avatar-badge">
                  <span class="material-symbols-outlined">person</span>
                </div>
                <div>
                  <h4 class="author-title-name">{{ activeArticle.author || "Tim Ahli Amanah Tin's Center" }}</h4>
                  <p class="author-title-role">{{ activeArticle.category }} • Tenaga Medis ATC</p>
                </div>
              </div>

              <div class="meta-divider"></div>

              <!-- Medical Reviewer -->
              <div class="reviewer-badge">
                <span class="material-symbols-outlined verified-icon">verified</span>
                <span>Ditinjau medis: <strong>dr. Raden Sarah Amalia, Sp.A</strong></span>
              </div>

              <div class="meta-divider"></div>

              <!-- Date -->
              <div class="date-block">
                <span class="material-symbols-outlined date-icon">calendar_today</span>
                <span>{{ formatDate(activeArticle.created_at || activeArticle.published_at) }}</span>
              </div>
            </div>

            <!-- Social Share & Bookmark Strip -->
            <div class="meta-bar-right">
              <span class="share-label">Bagikan:</span>
              <button @click="shareWhatsApp" class="share-btn share-btn-wa" title="Bagikan ke WhatsApp">
                <span class="material-symbols-outlined">chat</span>
              </button>
              <button @click="shareGeneral" class="share-btn share-btn-social" title="Bagikan ke Media Sosial / Perangkat">
                <span class="material-symbols-outlined">share</span>
              </button>
              <button @click="copyLink" class="share-btn share-btn-link" title="Salin Tautan Artikel">
                <span class="material-symbols-outlined">link</span>
              </button>
              <button
                @click="handleToggleSave"
                class="share-btn share-btn-bookmark"
                :class="{ 'is-active': isCurrentSaved }"
                :title="isCurrentSaved ? 'Hapus dari daftar bacaan' : 'Simpan Artikel'"
              >
                <span class="material-symbols-outlined" :class="{ 'fill': isCurrentSaved }">bookmark</span>
              </button>
            </div>
          </div>

          <!-- Featured Image Card -->
          <div class="featured-image-frame">
            <img
              :src="activeArticle.image || activeArticle.thumbnail || 'https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?auto=format&fit=crop&q=80&w=1200'"
              :alt="activeArticle.title"
              class="featured-img"
              decoding="async"
              fetchpriority="high"
            />
            <div class="image-caption-pill">
              <span class="material-symbols-outlined caption-cam-icon">photo_camera</span>
              <span>Sesi stimulasi &amp; konsultasi di Klinik Amanah Tin's Center</span>
            </div>
          </div>
        </div>
      </section>

      <!-- ==================== MAIN EDITORIAL BODY + STICKY SIDEBAR ==================== -->
      <main class="article-body-section">
        <div class="container">
          <div class="article-grid">
            <!-- Left: Main Article Content (8 Cols) -->
            <article class="article-content-col">
              <!-- Lead Paragraph Box -->
              <div class="editorial-card lead-card" v-if="activeArticle.excerpt">
                <p class="lead-text">
                  {{ activeArticle.excerpt }}
                </p>
              </div>

              <!-- Dynamic Body Content from Database (Disanitasi DOMPurify anti-XSS) -->
              <div v-if="activeArticle.content" class="editorial-card article-dynamic-body" v-html="sanitizedBody"></div>

              <!-- Static 5 Sections Fallback if dummy article -->
              <template v-else>

              <!-- Mobile Quick Table of Contents Dropdown (Mobile & Tablet) -->
              <div class="mobile-toc-accordion">
                <button
                  @click="isMobileTocOpen = !isMobileTocOpen"
                  class="btn-mobile-toc"
                  type="button"
                  aria-label="Buka Daftar Isi Cepat"
                >
                  <div class="mobile-toc-label">
                    <span class="material-symbols-outlined mobile-toc-icon">format_list_bulleted</span>
                    <span>Daftar Isi Cepat ({{ tableOfContents.length }} Bagian)</span>
                  </div>
                  <span class="material-symbols-outlined mobile-toc-chevron" :class="{ 'is-rotated': isMobileTocOpen }">expand_more</span>
                </button>
                <div v-show="isMobileTocOpen" class="mobile-toc-dropdown">
                  <a
                    v-for="item in tableOfContents"
                    :key="item.id"
                    :href="'#' + item.id"
                    @click.prevent="scrollToSection(item.id); isMobileTocOpen = false"
                    class="mobile-toc-link"
                    :class="{ 'is-active': activeTocId === item.id }"
                  >
                    <span class="toc-bullet">{{ item.num }}</span>
                    <span class="toc-link-text">{{ item.title }}</span>
                  </a>
                </div>
              </div>

              <!-- Section 1: Milestone Usia -->
              <section id="sec-milestone" class="editorial-card section-milestone">
                <div class="section-title-row">
                  <div class="step-num-circle circle-blue">1</div>
                  <h2 class="editorial-h2">Milestone Perkembangan Bicara Sesuai Rentang Usia</h2>
                </div>
                <p class="section-lead-desc">
                  Keterampilan komunikasi anak berkembang secara bertahap, dimulai dari vokalisasi sederhana hingga kemampuan merangkai kalimat bermakna:
                </p>
                <div class="stages-stack">
                  <div class="stage-item">
                    <span class="material-symbols-outlined stage-check">check_circle</span>
                    <div>
                      <h4 class="stage-title">Usia 12 Bulan (1 Tahun)</h4>
                      <p class="stage-desc">
                        Mulai mengoceh (babbling) dengan intonasi beragam, menoleh saat dipanggil namanya, memahami kata sederhana seperti "tidak" atau "kemari", serta mengucapkan minimal 1–2 kata bermakna (misal: "Mama", "Papa", "Air").
                      </p>
                    </div>
                  </div>
                  <div class="stage-item">
                    <span class="material-symbols-outlined stage-check">check_circle</span>
                    <div>
                      <h4 class="stage-title">Usia 18 Bulan (1.5 Tahun)</h4>
                      <p class="stage-desc">
                        Memiliki perbendaharaan setidaknya 10 hingga 20 kata bermakna, menunjuk bagian tubuh atau gambar saat ditanya, serta meniru kata-kata sederhana dari orang dewasa di sekitarnya.
                      </p>
                    </div>
                  </div>
                  <div class="stage-item">
                    <span class="material-symbols-outlined stage-check">check_circle</span>
                    <div>
                      <h4 class="stage-title">Usia 24 Bulan (2 Tahun)</h4>
                      <p class="stage-desc">
                        Menguasai minimal 50 kata tunggal, mulai menggabungkan 2 kata (misal: "Mau minum", "Mama gendong"), serta memahami instruksi 2 langkah yang tidak rumit.
                      </p>
                    </div>
                  </div>
                  <div class="stage-item">
                    <span class="material-symbols-outlined stage-check">check_circle</span>
                    <div>
                      <h4 class="stage-title">Usia 3 Tahun (36 Bulan)</h4>
                      <p class="stage-desc">
                        Mampu berbicara menggunakan 3 sampai 4 kata dalam satu kalimat, bicaranya 75% dipahami oleh orang luar keluarga, dan gemar bertanya "Apa ini?" atau "Kenapa?".
                      </p>
                    </div>
                  </div>
                </div>
              </section>

              <!-- Section 2: Red Flags -->
              <section id="sec-redflags" class="editorial-card section-redflags">
                <div class="section-title-row">
                  <div class="step-num-circle circle-red">2</div>
                  <h2 class="editorial-h2">Gejala Red Flags yang Perlu Diwaspadai Segera</h2>
                </div>
                <p class="section-lead-desc">
                  Apabila orang tua mendapati satu atau lebih tanda berikut pada Si Kecil, jangan menunda konsultasi dengan dokter anak atau terapis wicara:
                </p>
                <div class="redflags-grid">
                  <div class="redflag-card">
                    <div class="warning-circle">
                      <span class="material-symbols-outlined">warning</span>
                    </div>
                    <div>
                      <h4 class="redflag-title">Kontak Mata Minim</h4>
                      <p class="redflag-desc">Anak jarang menatap mata lawan bicara ketika diajak berinteraksi atau tidak merespons panggilan namanya pada usia 12 bulan.</p>
                    </div>
                  </div>
                  <div class="redflag-card">
                    <div class="warning-circle">
                      <span class="material-symbols-outlined">warning</span>
                    </div>
                    <div>
                      <h4 class="redflag-title">Tidak Ada Gestur Menunjuk</h4>
                      <p class="redflag-desc">Pada usia 12–14 bulan, anak belum mampu melambaikan tangan, menunjuk objek yang diinginkan, atau menggelengkan kepala.</p>
                    </div>
                  </div>
                  <div class="redflag-card">
                    <div class="warning-circle">
                      <span class="material-symbols-outlined">warning</span>
                    </div>
                    <div>
                      <h4 class="redflag-title">Kosakata Sangat Terbatas</h4>
                      <p class="redflag-desc">Belum mengucapkan kata konsisten di usia 18 bulan atau kurang dari 20 kata di usia 2 tahun.</p>
                    </div>
                  </div>
                  <div class="redflag-card">
                    <div class="warning-circle">
                      <span class="material-symbols-outlined">warning</span>
                    </div>
                    <div>
                      <h4 class="redflag-title">Artikulasi Sangat Tidak Jelas</h4>
                      <p class="redflag-desc">Di usia 3 tahun, ucapan anak sulit dimengerti bahkan oleh pengasuh utama atau sering hanya berupa gumaman tak jelas.</p>
                    </div>
                  </div>
                </div>
              </section>

              <!-- Section 3: Mitos vs Fakta -->
              <section id="sec-myths" class="editorial-card section-myths">
                <div class="section-title-row">
                  <div class="step-num-circle circle-green">3</div>
                  <h2 class="editorial-h2">Mitos vs Fakta Seputar Keterlambatan Bicara</h2>
                </div>
                <p class="section-lead-desc">
                  Banyak kekeliruan umum di masyarakat yang membuat orang tua menunda pemeriksaan penting:
                </p>
                <div class="myths-stack">
                  <div class="myth-fact-box">
                    <div class="myth-side">
                      <span class="myth-tag myth-tag-error">Mitos Keliru &#10060;</span>
                      <p class="myth-text">"Nanti juga bisa ngomong sendiri kok, anak laki-laki memang wajar telat sampai umur 4 tahun."</p>
                    </div>
                    <div class="fact-side">
                      <span class="myth-tag myth-tag-success">Fakta Klinis &#10004;&#65039;</span>
                      <p class="fact-text">Karakteristik gender tidak boleh menjadi pembenaran keterlambatan milestone. Usia 0–3 tahun adalah <em>golden period</em> plastisitas otak, penanganan lebih dini memberikan prognosis jauh lebih baik.</p>
                    </div>
                  </div>
                  <div class="myth-fact-box">
                    <div class="myth-side">
                      <span class="myth-tag myth-tag-error">Mitos Keliru &#10060;</span>
                      <p class="myth-text">"Nonton video edukatif di gadget berjam-jam bisa bikin anak cepat pandai bahasa Inggris dan bicara."</p>
                    </div>
                    <div class="fact-side">
                      <span class="myth-tag myth-tag-success">Fakta Klinis &#10004;&#65039;</span>
                      <p class="fact-text">Komunikasi membutuhkan interaksi dua arah (reciprocal interaction). Paparan layar pasif berlebih justru merupakan salah satu penyebab utama speech delay pada balita modern.</p>
                    </div>
                  </div>
                </div>
              </section>

              <!-- Quotation Box -->
              <div class="editorial-quote-box">
                <span class="material-symbols-outlined quote-icon">format_quote</span>
                <div>
                  <blockquote class="quote-text">
                    "Setiap anak berkembang dengan ritmenya masing-masing, namun intervensi dini adalah hadiah terbaik untuk masa depan komunikasi ananda."
                  </blockquote>
                  <p class="quote-author">&mdash; Filosofi Pendampingan Amanah Tin's Center</p>
                </div>
              </div>

              <!-- Section 4: Proses Asesmen -->
              <section id="sec-process" class="editorial-card section-process">
                <div class="section-title-row">
                  <div class="step-num-circle circle-blue">4</div>
                  <h2 class="editorial-h2">Bagaimana Proses Asesmen di Amanah Tin's Center?</h2>
                </div>
                <p class="section-lead-desc">
                  Di klinik kami di Jagakarsa, asesmen terapi wicara dirancang agar anak merasa seperti bermain, bukan sedang diuji:
                </p>
                <div class="process-steps-row">
                  <div class="process-step-box">
                    <div class="p-icon-wrap">
                      <span class="material-symbols-outlined">history_edu</span>
                    </div>
                    <h4 class="p-title">1. Wawancara Orang Tua</h4>
                    <p class="p-desc">Menggali riwayat kelahiran, nutrisi, oral-motor, dan kebiasaan sehari-hari.</p>
                  </div>
                  <div class="process-step-box">
                    <div class="p-icon-wrap">
                      <span class="material-symbols-outlined">toys</span>
                    </div>
                    <h4 class="p-title">2. Observasi Play-Based</h4>
                    <p class="p-desc">Evaluasi kemampuan reseptif, ekspresif, artikulasi, dan respon sensorik saat bermain.</p>
                  </div>
                  <div class="process-step-box">
                    <div class="p-icon-wrap">
                      <span class="material-symbols-outlined">clinical_notes</span>
                    </div>
                    <h4 class="p-title">3. Rencana Terapi Holistik</h4>
                    <p class="p-desc">Penyusunan target individual program (IEP) bersama keluarga yang fleksibel dan terukur.</p>
                  </div>
                </div>
              </section>

              <!-- Section 5: Tips Stimulasi Sederhana di Rumah -->
              <section id="sec-tips" class="editorial-card section-tips">
                <div class="section-title-row">
                  <div class="step-num-circle circle-green">5</div>
                  <h2 class="editorial-h2">Tips Stimulasi Sederhana di Rumah untuk Ayah &amp; Bunda</h2>
                </div>
                <ul class="tips-list">
                  <li class="tip-item">
                    <span class="material-symbols-outlined tip-check">check_circle</span>
                    <span><strong>Lakukan Self-Talk dan Parallel-Talk:</strong> Ceritakan apa yang sedang Ayah/Bunda lakukan ("Bunda sedang memotong wortel oranye") dan apa yang sedang anak kerjakan.</span>
                  </li>
                  <li class="tip-item">
                    <span class="material-symbols-outlined tip-check">check_circle</span>
                    <span><strong>Beri Waktu untuk Merespons (Wait Time):</strong> Saat bertanya, tunggu 5–10 detik sebelum mengulang pertanyaan agar otak anak memiliki waktu memproses dan merangkai respon.</span>
                  </li>
                  <li class="tip-item">
                    <span class="material-symbols-outlined tip-check">check_circle</span>
                    <span><strong>Batasi Layar Gadget:</strong> Utamakan interaksi kontak mata dan aktivitas sensori nyata seperti bernyanyi bersama atau membaca buku bergambar.</span>
                  </li>
                </ul>
              </section>
              </template>

              <!-- Author Bio Card -->
              <div class="author-bio-card">
                <div class="bio-avatar-fallback">
                  <span class="material-symbols-outlined">person</span>
                </div>
                <div class="bio-content">
                  <span class="bio-role-badge">Penulis Artikel</span>
                  <h3 class="bio-name">{{ activeArticle.author || "Tim Ahli Amanah Tin's Center" }}</h3>
                  <p class="bio-specialty">{{ activeArticle.category || 'Tumbuh Kembang' }} • Tim Ahli ATC</p>
                  <p class="bio-text">
                    Materi edukasi klinis yang disusun berdasarkan panduan stimulasi tumbuh kembang anak terpercaya dari Amanah Tin's Center Jagakarsa.
                  </p>
                </div>
              </div>

              <!-- Tags & Save Strip -->
              <div class="tags-action-bar">
                <div class="tags-wrap">
                  <span class="tags-label">Kategori:</span>
                  <span class="tag-pill">#{{ activeArticle.category || 'TumbuhKembang' }}</span>
                  <span class="tag-pill">#EdukasiAnak</span>
                  <span class="tag-pill">#AmanahTinsCenter</span>
                </div>
                <div class="bottom-action-buttons">
                  <button @click="shareWhatsApp" class="btn-bottom-share" title="Bagikan ke WhatsApp">
                    <span class="material-symbols-outlined">chat</span>
                    <span>Bagikan WA</span>
                  </button>
                  <button @click="copyLink" class="btn-bottom-share" title="Salin Tautan">
                    <span class="material-symbols-outlined">link</span>
                    <span>Salin Link</span>
                  </button>
                  <button
                    @click="handleToggleSave"
                    class="btn-save-article"
                    :class="{ 'is-saved': isCurrentSaved }"
                    :title="isCurrentSaved ? 'Hapus dari daftar bacaan' : 'Simpan ke daftar bacaan'"
                  >
                    <span class="material-symbols-outlined" :class="{ 'fill': isCurrentSaved }">bookmark</span>
                    <span>{{ isCurrentSaved ? 'Tersimpan di Bookmark' : 'Simpan Artikel' }}</span>
                  </button>
                </div>
              </div>
            </article>

            <!-- Right: Sticky Sidebar (4 Cols) -->
            <aside class="article-sidebar-col">
              <div class="sidebar-sticky-wrap">
                <!-- Widget: Sticky Table of Contents (Daftar Isi Cepat) -->
                <nav v-if="!activeArticle?.content" class="sidebar-widget widget-toc" aria-label="Daftar Isi Artikel">
                  <div class="toc-header">
                    <div class="toc-header-left">
                      <span class="material-symbols-outlined toc-head-icon">format_list_bulleted</span>
                      <h3 class="toc-title">Daftar Isi Cepat</h3>
                    </div>
                    <span class="toc-badge-count">{{ tableOfContents.length }} Bagian</span>
                  </div>
                  <ul class="toc-list">
                    <li
                      v-for="item in tableOfContents"
                      :key="item.id"
                      class="toc-item"
                    >
                      <a
                        :href="'#' + item.id"
                        @click.prevent="scrollToSection(item.id)"
                        class="toc-link"
                        :class="{ 'is-active': activeTocId === item.id }"
                      >
                        <span class="toc-bullet">{{ item.num }}</span>
                        <span class="toc-text">{{ item.title }}</span>
                        <span v-if="activeTocId === item.id" class="material-symbols-outlined toc-arrow">chevron_right</span>
                      </a>
                    </li>
                  </ul>
                </nav>
                <!-- Widget 1: CTA Asesmen Jagakarsa -->
                <div class="sidebar-widget widget-cta">
                  <div class="widget-icon-box">
                    <span class="material-symbols-outlined">medical_services</span>
                  </div>
                  <h3 class="widget-title">Khawatir dengan Bicara Si Kecil?</h3>
                  <p class="widget-desc">
                    Jadwalkan sesi konsultasi dan asesmen komprehensif bersama tim terapis profesional di klinik Amanah Tin's Center Jagakarsa.
                  </p>
                  <div class="widget-actions">
                    <router-link to="/jadwal-pendaftaran" class="btn-widget-primary">
                      <span>Daftar Asesmen Awal</span>
                      <span class="material-symbols-outlined">arrow_forward</span>
                    </router-link>
                    <a :href="waLink()" target="_blank" rel="noopener noreferrer" class="btn-widget-secondary">
                      <span class="material-symbols-outlined">chat</span>
                      <span>Tanya Terlebih Dahulu via WA</span>
                    </a>
                  </div>
                  <div class="widget-location-row">
                    <span class="material-symbols-outlined loc-icon">location_on</span>
                    <span>Jl. Raya Jagakarsa No. 12, Jakarta Selatan</span>
                  </div>
                </div>


                <!-- Widget 3: Artikel Terkait Lainnya -->
                <div class="sidebar-widget widget-related">
                  <h3 class="related-widget-title">
                    <span class="material-symbols-outlined">auto_stories</span>
                    <span>Artikel Terkait Lainnya</span>
                  </h3>
                  <div class="related-list">
                    <router-link
                      v-for="item in displayRelated"
                      :key="item.slug"
                      :to="`/artikel/${item.slug}`"
                      class="related-link-card"
                    >
                      <img :src="item.thumbnail" :alt="item.title" class="related-thumb" loading="lazy" decoding="async" />
                      <div>
                        <h5 class="related-card-title">{{ item.title }}</h5>
                        <span class="related-card-date">{{ item.date }}</span>
                      </div>
                    </router-link>
                  </div>
                </div>
              </div>
            </aside>
          </div>
        </div>
      </main>

      <!-- ==================== BOTTOM RECOMMENDED ARTICLES GRID ==================== -->
      <section class="section-bottom-articles">
        <div class="container">
          <div class="bottom-header">
            <div>
              <span class="section-eyebrow">Rekomendasi Bacaan</span>
              <h2 class="bottom-title">Artikel Edukatif Pilihan untuk Bunda</h2>
            </div>
            <router-link to="/artikel" class="btn-view-all-articles">
              <span>Lihat Semua Artikel</span>
              <span class="material-symbols-outlined">arrow_forward</span>
            </router-link>
          </div>

          <div class="bottom-articles-grid">
            <article
              v-for="rec in displayBottomArticles"
              :key="rec.slug"
              class="rec-card"
            >
              <div class="rec-thumb-wrap">
                <img :src="rec.thumbnail" :alt="rec.title" class="rec-thumb" loading="lazy" decoding="async" />
              </div>
              <div class="rec-body">
                <div>
                  <div class="rec-meta">
                    <span class="rec-cat-pill" :class="rec.catClass">{{ rec.category }}</span>
                    <span class="rec-date">{{ rec.date }}</span>
                  </div>
                  <h3 class="rec-title">{{ rec.title }}</h3>
                  <p class="rec-desc">{{ rec.desc }}</p>
                </div>
                <router-link :to="`/artikel/${rec.slug}`" class="rec-read-more">
                  <span>Baca Selengkapnya</span>
                  <span class="material-symbols-outlined">chevron_right</span>
                </router-link>
              </div>
            </article>
          </div>
        </div>
      </section>

      <!-- ==================== CLINIC REGISTRATION BANNER ==================== -->
      <section class="section-reg-banner" id="daftar-form">
        <div class="container">
          <div class="reg-banner-card">
            <div class="reg-left">
              <span class="reg-pill">
                <span class="material-symbols-outlined">local_hospital</span>
                <span>Layanan Terpadu Jagakarsa</span>
              </span>
              <h2 class="reg-title">
                Mulai Perjalanan Tumbuh Kembang Si Kecil Bersama Kami
              </h2>
              <p class="reg-desc">
                Dapatkan evaluasi yang ramah, hangat, dan akurat dari tim terapis multidisiplin Amanah Tin's Center. Jadwalkan asesmen awal atau konsultasikan pertanyaan Anda hari ini.
              </p>
              <div class="reg-trust-items">
                <div class="trust-check">
                  <span class="material-symbols-outlined">check_circle</span>
                  <span>Terapis Tersertifikasi</span>
                </div>
                <div class="trust-check">
                  <span class="material-symbols-outlined">check_circle</span>
                  <span>Jadwal Fleksibel</span>
                </div>
                <div class="trust-check">
                  <span class="material-symbols-outlined">check_circle</span>
                  <span>Ruang Ramah Anak</span>
                </div>
              </div>
            </div>

            <div class="reg-right">
              <a :href="waLink()" target="_blank" rel="noopener noreferrer" class="btn-banner-wa">
                <span class="material-symbols-outlined">chat</span>
                <span>Hubungi WhatsApp Klinik</span>
              </a>
              <router-link to="/jadwal-pendaftaran" class="btn-banner-register">
                <span class="material-symbols-outlined">event</span>
                <span>Isi Formulir Pendaftaran</span>
              </router-link>
            </div>
          </div>
        </div>
      </section>
      </template>

      <!-- ==================== TOAST NOTIFICATION ==================== -->
      <Teleport to="body">
        <Transition name="toast-fade">
          <div v-if="toast.visible" class="article-toast" :class="`toast-${toast.type}`" role="status" aria-live="polite">
            <span class="material-symbols-outlined toast-icon">{{ toast.icon }}</span>
            <div class="toast-body">
              <h5 class="toast-title">{{ toast.title }}</h5>
              <p class="toast-desc">{{ toast.message }}</p>
            </div>
            <button @click="toast.visible = false" class="toast-close" aria-label="Tutup notifikasi">
              <span class="material-symbols-outlined">close</span>
            </button>
          </div>
        </Transition>
      </Teleport>
    </div>
  </PublicLayout>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import PublicLayout from '../layouts/PublicLayout.vue'
import { useBookmarks } from '../composables/useBookmarks'
import { useClinicSettings } from '../composables/useClinicSettings'
import { useSeo } from '../composables/useSeo'
import api from '../services/api'
import { sanitizeHtml } from '../utils/sanitize'

const route = useRoute()
const { waLink } = useClinicSettings()
const seo = useSeo()

// ===== JSON-LD Article Schema =====
// Menyuntikkan structured data ke <head> agar Google menampilkan rich snippets
const BASE_URL = 'https://tinsgrowcenter.com'
const JSON_LD_ID = 'article-jsonld-schema'

function injectArticleJsonLd(article) {
  removeArticleJsonLd()
  if (!article) return

  const schema = {
    '@context': 'https://schema.org',
    '@type': 'Article',
    'headline': article.title,
    'description': article.excerpt || article.title,
    'image': article.image || article.thumbnail || `${BASE_URL}/iconATC.jpeg`,
    'url': `${BASE_URL}/artikel/${article.slug}`,
    'datePublished': article.published_at || article.created_at,
    'dateModified': article.updated_at || article.published_at || article.created_at,
    'author': {
      '@type': 'Person',
      'name': article.author || "Tim Ahli Amanah Tin's Center"
    },
    'publisher': {
      '@type': 'Organization',
      'name': "Amanah Tin's Center",
      'url': BASE_URL,
      'logo': {
        '@type': 'ImageObject',
        'url': `${BASE_URL}/iconATC.jpeg`
      }
    },
    'mainEntityOfPage': {
      '@type': 'WebPage',
      '@id': `${BASE_URL}/artikel/${article.slug}`
    },
    'articleSection': article.category || 'Tumbuh Kembang',
    'inLanguage': 'id-ID'
  }

  const script = document.createElement('script')
  script.type = 'application/ld+json'
  script.id = JSON_LD_ID
  script.textContent = JSON.stringify(schema)
  document.head.appendChild(script)
}

function removeArticleJsonLd() {
  const existing = document.getElementById(JSON_LD_ID)
  if (existing) existing.remove()
}

// Fallback demo article if database doesn't have article
const currentArticle = {
  id: 1,
  slug: 'tanda-anak-butuh-terapi-wicara',
  title: 'Tanda-Tanda Anak Membutuhkan Terapi Wicara & Kapan Waktu yang Tepat untuk Asesmen',
  category: 'Terapi Wicara',
  excerpt: 'Kenali red flags keterlambatan bicara sejak dini, mulai dari minimnya babbling hingga kesulitan mengekspresikan kosakata sehari-hari.',
  published_at: '2025-05-12',
  read_time: '5 Menit Baca',
  thumbnail: 'https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?auto=format&fit=crop&q=80&w=1200'
}

const apiArticle = ref(null)
const apiRelated = ref([])
const isLoading = ref(true)

const activeArticle = computed(() => {
  if (apiArticle.value) return apiArticle.value
  if (!isLoading.value && route.params.slug === 'tanda-anak-butuh-terapi-wicara') return currentArticle
  return null
})

// Sanitasi konten dinamis dengan DOMPurify untuk mencegah stored XSS
const sanitizedBody = computed(() => {
  return sanitizeHtml(activeArticle.value?.content || '')
})

function formatDate(dateStr) {
  if (!dateStr) return 'Terbaru'
  try {
    const d = new Date(dateStr)
    if (isNaN(d.getTime())) return dateStr
    return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })
  } catch {
    return dateStr
  }
}

const isNotFound = ref(false)

async function fetchArticleData() {
  const slug = route.params.slug
  if (!slug) return
  isLoading.value = true
  isNotFound.value = false
  apiArticle.value = null
  try {
    const res = await api.get(`/articles/${slug}`)
    if (res.data && res.data.article) {
      apiArticle.value = res.data.article
      if (res.data.related && res.data.related.length > 0) {
        apiRelated.value = res.data.related
      } else {
        apiRelated.value = []
      }
      seo.updateSeo({
        title: res.data.article.title,
        description: res.data.article.excerpt || res.data.article.title,
        image: res.data.article.image || res.data.article.thumbnail,
        url: `${BASE_URL}/artikel/${res.data.article.slug}`,
        type: 'article',
      })
      injectArticleJsonLd(res.data.article)
    } else {
      if (slug === 'tanda-anak-butuh-terapi-wicara') {
        apiArticle.value = currentArticle
        seo.updateSeo({
          title: currentArticle.title,
          description: currentArticle.excerpt,
          image: currentArticle.thumbnail,
          url: `${BASE_URL}/artikel/${currentArticle.slug}`,
          type: 'article',
        })
        injectArticleJsonLd(currentArticle)
      } else {
        isNotFound.value = true
        seo.updateSeo({
          title: 'Artikel Tidak Ditemukan',
          description: 'Artikel yang Anda cari tidak tersedia atau belum diterbitkan.',
        })
      }
    }
  } catch (err) {
    if (slug === 'tanda-anak-butuh-terapi-wicara') {
      apiArticle.value = currentArticle
      seo.updateSeo({
        title: currentArticle.title,
        description: currentArticle.excerpt,
        image: currentArticle.thumbnail,
        url: `${BASE_URL}/artikel/${currentArticle.slug}`,
        type: 'article',
      })
      injectArticleJsonLd(currentArticle)
    } else {
      isNotFound.value = true
      seo.updateSeo({
        title: 'Artikel Tidak Ditemukan',
        description: 'Artikel yang Anda cari tidak tersedia atau belum diterbitkan.',
      })
    }
  } finally {
    isLoading.value = false
  }
}

// Persistent Bookmark Composable
const { isBookmarked, toggleBookmark } = useBookmarks()
const isCurrentSaved = computed(() => activeArticle.value?.slug ? isBookmarked(activeArticle.value.slug) : false)

// Toast state & handler
const toast = ref({
  visible: false,
  title: '',
  message: '',
  icon: 'check_circle',
  type: 'success'
})
let toastTimer = null

function showToast({ title, message, icon = 'check_circle', type = 'success' }) {
  if (toastTimer) clearTimeout(toastTimer)
  toast.value = { visible: true, title, message, icon, type }
  toastTimer = setTimeout(() => {
    toast.value.visible = false
  }, 3400)
}

function handleToggleSave() {
  if (!activeArticle.value) return
  const added = toggleBookmark(activeArticle.value)
  if (added) {
    showToast({
      title: 'Artikel Disimpan!',
      message: 'Artikel berhasil disimpan ke daftar bacaan Anda.',
      icon: 'bookmark_added',
      type: 'success'
    })
  } else {
    showToast({
      title: 'Bookmark Dihapus',
      message: 'Artikel telah dihapus dari daftar bacaan Anda.',
      icon: 'bookmark_remove',
      type: 'info'
    })
  }
}

// Table of Contents (Daftar Isi Cepat)
const tableOfContents = [
  { id: 'sec-milestone', num: '01', title: 'Milestone Bicara Sesuai Usia' },
  { id: 'sec-redflags',  num: '02', title: 'Gejala Red Flags Diwaspadai' },
  { id: 'sec-myths',     num: '03', title: 'Mitos vs Fakta Speech Delay' },
  { id: 'sec-process',   num: '04', title: 'Proses Asesmen di Klinik ATC' },
  { id: 'sec-tips',      num: '05', title: 'Tips Stimulasi Sederhana di Rumah' },
]
const activeTocId = ref('sec-milestone')
const isMobileTocOpen = ref(false)

function scrollToSection(id) {
  const el = document.getElementById(id)
  if (!el) return
  const yOffset = -95
  const y = el.getBoundingClientRect().top + window.pageYOffset + yOffset
  window.scrollTo({ top: y, behavior: 'smooth' })
  activeTocId.value = id
}

// Sticky Reading Progress Bar (Calculated smoothly from editorial container)
const readingProgress = ref(0)

function handleScroll() {
  const articleEl = document.querySelector('.article-content-col')
  if (!articleEl) return

  const rect = articleEl.getBoundingClientRect()
  const articleTop = rect.top + window.scrollY
  const articleHeight = rect.height
  const windowHeight = window.innerHeight
  const scrollY = window.scrollY

  const totalScrollable = articleHeight - windowHeight + 150
  if (totalScrollable <= 0) {
    readingProgress.value = 100
  } else {
    const currentScrolled = scrollY - (articleTop - 100)
    const progress = Math.min(100, Math.max(0, (currentScrolled / totalScrollable) * 100))
    readingProgress.value = progress
  }

  // Scroll spy for Table of Contents
  if (!activeArticle.value?.content) {
    const scrollPosition = scrollY + 140
    for (let i = tableOfContents.length - 1; i >= 0; i--) {
      const section = document.getElementById(tableOfContents[i].id)
      if (section && section.offsetTop <= scrollPosition) {
        activeTocId.value = tableOfContents[i].id
        break
      }
    }
  }
}

// Social Share & Web Share API
function shareWhatsApp() {
  if (!activeArticle.value) return
  const url = window.location.href
  const text = encodeURIComponent(`Rekomendasi bacaan penting untuk Ayah & Bunda dari Klinik Amanah Tin's Center:\n\n"${activeArticle.value.title}"\n\nBaca artikel selengkapnya di: ${url}`)
  window.open(`https://wa.me/?text=${text}`, '_blank')
}

async function shareGeneral() {
  if (!activeArticle.value) return
  const url = window.location.href
  const title = `${activeArticle.value.title} - Amanah Tin's Center`
  const text = activeArticle.value.excerpt || 'Panduan tumbuh kembang dan terapi anak terpercaya di Jagakarsa.'

  if (navigator.share) {
    try {
      await navigator.share({ title, text, url })
      showToast({
        title: 'Berhasil Dibagikan',
        message: 'Terima kasih telah membagikan informasi edukatif ini.',
        icon: 'share',
        type: 'success'
      })
      return
    } catch (err) {
      if (err.name === 'AbortError') return
    }
  }

  // Fallback if Web Share is unavailable
  copyLink()
}

async function copyLink() {
  try {
    await navigator.clipboard.writeText(window.location.href)
    showToast({
      title: 'Tautan Berhasil Disalin!',
      message: 'Tautan artikel telah disalin ke papan klip. Siap dibagikan ke WhatsApp / media sosial.',
      icon: 'link',
      type: 'success'
    })
  } catch (e) {
    showToast({
      title: 'Gagal Menyalin Otomatis',
      message: 'Silakan salin URL dari bilah alamat browser Anda.',
      icon: 'error',
      type: 'info'
    })
  }
}

// Fallback sidebar related articles
const defaultRelated = [
  {
    slug: 'tips-stimulasi-motorik-halus',
    title: 'Tips Stimulasi Motorik Halus Anak di Rumah dengan Alat Sederhana',
    date: '5 Mei 2025',
    thumbnail: 'https://images.unsplash.com/photo-1596464716127-f2a82984de30?auto=format&fit=crop&q=80&w=800'
  },
  {
    slug: 'pentingnya-konsistensi-terapi',
    title: 'Pentingnya Konsistensi dalam Terapi Tumbuh Kembang Anak',
    date: '28 April 2025',
    thumbnail: 'https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?auto=format&fit=crop&q=80&w=800'
  },
  {
    slug: 'komunikasi-positif-bebas-tantrum',
    title: 'Cara Membangun Komunikasi Positif Bebas Tantrum dengan Balita',
    date: '20 April 2025',
    thumbnail: 'https://images.unsplash.com/photo-1543269865-cbf427effbad?auto=format&fit=crop&q=80&w=800'
  }
]

const displayRelated = computed(() => {
  if (apiRelated.value && apiRelated.value.length > 0) {
    return apiRelated.value.map(item => ({
      slug: item.slug,
      title: item.title,
      date: formatDate(item.published_at || item.created_at),
      thumbnail: item.image || item.thumbnail || 'https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?auto=format&fit=crop&q=80&w=800'
    }))
  }
  return defaultRelated
})

// Bottom 3 recommended articles
const bottomArticles = [
  {
    slug: 'tips-stimulasi-motorik-halus',
    category: 'Sensori Integrasi',
    catClass: 'rec-cat-green',
    date: '5 Mei 2025',
    title: 'Tips Stimulasi Motorik Halus & Sensori di Rumah',
    desc: 'Panduan praktis melatih koordinasi jemari dan fokus anak prasekolah dengan material aman yang ada di dapur.',
    thumbnail: 'https://images.unsplash.com/photo-1596464716127-f2a82984de30?auto=format&fit=crop&q=80&w=800'
  },
  {
    slug: 'pentingnya-konsistensi-terapi',
    category: 'Psikologi Anak',
    catClass: 'rec-cat-blue',
    date: '28 April 2025',
    title: 'Pentingnya Konsistensi dalam Terapi Tumbuh Kembang',
    desc: 'Mengapa jadwal sesi rutin dan peran aktif orang tua di rumah menjadi kunci keberhasilan terapi anak.',
    thumbnail: 'https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?auto=format&fit=crop&q=80&w=800'
  },
  {
    slug: 'komunikasi-positif-bebas-tantrum',
    category: 'Parenting',
    catClass: 'rec-cat-neutral',
    date: '20 April 2025',
    title: 'Cara Membangun Komunikasi Positif dengan Balita',
    desc: 'Strategi meredakan frustrasi anak saat sulit mengekspresikan keinginannya dan menumbuhkan rasa percaya diri.',
    thumbnail: 'https://images.unsplash.com/photo-1543269865-cbf427effbad?auto=format&fit=crop&q=80&w=800'
  }
]

// Rekomendasi dinamis: Prioritaskan artikel dari database (API) jika ada
const displayBottomArticles = computed(() => {
  if (apiRelated.value && apiRelated.value.length > 0) {
    return apiRelated.value.map(item => {
      let catClass = 'rec-cat-neutral'
      if (item.category === 'Sensori Integrasi') catClass = 'rec-cat-green'
      else if (item.category === 'Terapi Wicara' || item.category === 'Psikologi Anak') catClass = 'rec-cat-blue'

      return {
        slug: item.slug,
        category: item.category || 'Tumbuh Kembang',
        catClass,
        date: formatDate(item.published_at || item.created_at),
        title: item.title,
        desc: item.excerpt || 'Baca panduan terpadu tumbuh kembang anak selengkapnya bersama tim terapis Amanah Tin\'s Center.',
        thumbnail: item.image || item.thumbnail || 'https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?auto=format&fit=crop&q=80&w=800'
      }
    })
  }
  return bottomArticles
})

onMounted(() => {
  fetchArticleData()
  window.addEventListener('scroll', handleScroll, { passive: true })
  handleScroll()
})

watch(() => route.params.slug, (newSlug) => {
  if (!newSlug) return
  window.scrollTo({ top: 0, behavior: 'instant' })
  fetchArticleData()
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
  if (toastTimer) clearTimeout(toastTimer)
  removeArticleJsonLd()
})
</script>

<style scoped>
/* ==================== GLOBAL HELPERS ==================== */
.article-detail-page {
  background-color: var(--background);
  color: var(--on-surface);
  overflow-x: hidden;
}

.container {
  width: 100%;
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 1.5rem;
}

/* ==================== BREADCRUMBS ==================== */
.breadcrumb-strip {
  background-color: rgba(237, 244, 255, 0.6);
  border-bottom: 1px solid rgba(191, 200, 206, 0.25);
  padding: 0.75rem 0;
}

.breadcrumb-container {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: space-between;
  gap: 0.75rem;
  font-size: 13.5px;
}

.breadcrumb-nav {
  display: flex;
  align-items: center;
  gap: 0.35rem;
  color: var(--on-surface-variant);
  flex-wrap: wrap;
}

.bc-link {
  color: var(--on-surface-variant);
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
  transition: color 0.15s;
}

.bc-link:hover {
  color: var(--primary);
}

.bc-icon {
  font-size: 16px;
}

.bc-sep {
  color: var(--outline-variant);
  font-size: 13px;
}

.bc-active {
  color: var(--primary);
  font-weight: 600;
  max-width: 440px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.back-link {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  color: var(--primary);
  font-weight: 700;
  text-decoration: none;
  transition: color 0.15s;
}

.back-link:hover {
  color: var(--primary-container);
}

.back-icon {
  font-size: 17px;
  transition: transform 0.2s;
}

.back-link:hover .back-icon {
  transform: translateX(-3px);
}

/* ==================== ARTICLE HERO ==================== */
.article-hero-section {
  padding: 2.25rem 0 2.5rem;
  background: linear-gradient(180deg, rgba(237, 244, 255, 0.4) 0%, var(--background) 100%);
}

.hero-badges {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 0.625rem;
  margin-bottom: 1rem;
}

.badge-pill {
  display: inline-flex;
  align-items: center;
  gap: 0.375rem;
  padding: 0.375rem 0.875rem;
  border-radius: 9999px;
  font-size: 12px;
  font-weight: 700;
}

.badge-icon {
  font-size: 14px;
}

.badge-primary {
  background: var(--primary-fixed);
  color: var(--on-primary-fixed);
}

.badge-secondary {
  background: var(--secondary-fixed);
  color: var(--on-secondary-fixed);
}

.badge-neutral {
  background: var(--surface-container);
  color: var(--on-surface-variant);
}

.article-main-title {
  font-family: var(--font-headline);
  font-size: clamp(26px, 3.2vw, 38px);
  font-weight: 700;
  line-height: 1.28;
  color: var(--on-surface);
  max-width: 980px;
  letter-spacing: -0.015em;
  margin-bottom: 1.5rem;
}

/* Meta Bar Card */
.meta-bar-card {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: space-between;
  gap: 1.25rem;
  padding: 1rem 1.5rem;
  background: var(--surface-container-lowest);
  border-radius: 1rem;
  border: 1px solid rgba(191, 200, 206, 0.35);
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
}

.meta-bar-left {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 1.25rem;
}

.author-block {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.author-avatar-img {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid var(--primary-fixed);
}

.author-title-name {
  font-family: var(--font-headline);
  font-size: 14px;
  font-weight: 700;
  color: var(--on-surface);
  line-height: 1.2;
}

.author-title-role {
  font-size: 11.5px;
  color: var(--on-surface-variant);
}

.meta-divider {
  width: 1px;
  height: 28px;
  background: rgba(191, 200, 206, 0.4);
}

.reviewer-badge {
  display: flex;
  align-items: center;
  gap: 0.375rem;
  font-size: 13px;
  color: var(--secondary);
  background: rgba(204, 239, 142, 0.3);
  padding: 0.35rem 0.75rem;
  border-radius: 9999px;
}

.verified-icon {
  font-size: 16px;
  font-variation-settings: 'FILL' 1;
}

.date-block {
  display: flex;
  align-items: center;
  gap: 0.375rem;
  font-size: 12.5px;
  color: var(--on-surface-variant);
}

.date-icon {
  font-size: 15px;
}

.meta-bar-right {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.share-label {
  font-size: 12px;
  font-weight: 700;
  color: var(--on-surface-variant);
  margin-right: 0.25rem;
}

.share-btn {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  border: none;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s;
}

.share-btn .material-symbols-outlined {
  font-size: 18px;
}

.share-btn-wa {
  background: rgba(204, 239, 142, 0.5);
  color: var(--secondary);
}

.share-btn-wa:hover {
  background: var(--secondary-fixed);
  transform: translateY(-2px);
}

.share-btn-social {
  background: rgba(193, 232, 255, 0.5);
  color: var(--primary);
}

.share-btn-social:hover {
  background: var(--primary-fixed);
  transform: translateY(-2px);
}

.share-btn-link {
  background: var(--surface-container);
  color: var(--on-surface);
}

.share-btn-link:hover {
  background: var(--surface-container-high);
  transform: translateY(-2px);
}

/* Featured Image Frame */
.featured-image-frame {
  margin-top: 2rem;
  position: relative;
  border-radius: 1.5rem;
  overflow: hidden;
  background: var(--surface-container);
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
  border: 1px solid rgba(0, 99, 132, 0.1);
  max-height: 460px;
}

.featured-img {
  width: 100%;
  height: 460px;
  object-fit: cover;
  display: block;
}

.image-caption-pill {
  position: absolute;
  bottom: 1rem;
  left: 1rem;
  background: rgba(255, 255, 255, 0.92);
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
  padding: 0.5rem 1rem;
  border-radius: 9999px;
  font-size: 12px;
  color: var(--on-surface);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.caption-cam-icon {
  font-size: 16px;
  color: var(--primary);
}

/* ==================== ARTICLE CONTENT GRID ==================== */
.article-body-section {
  padding: 3rem 0 4rem;
  background: var(--background);
}

.article-grid {
  display: grid;
  grid-template-columns: minmax(0, 8fr) minmax(0, 4fr);
  gap: 2.5rem;
  align-items: flex-start;
}

.article-content-col {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

.editorial-card {
  background: var(--surface-container-lowest);
  border-radius: 1.25rem;
  padding: 2rem;
  border: 1px solid rgba(191, 200, 206, 0.35);
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
}

.lead-card {
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.04);
}

.lead-text {
  font-size: 18px;
  line-height: 1.75;
  color: var(--on-surface);
  font-weight: 500;
}

.text-link {
  color: var(--primary);
  font-weight: 700;
  text-decoration: underline;
  transition: color 0.15s;
}

.text-link:hover {
  color: var(--primary-container);
}

.lead-sub {
  font-size: 15.5px;
  line-height: 1.65;
  color: var(--on-surface-variant);
  margin-top: 1rem;
}

/* ==================== DYNAMIC BODY CONTENT TYPOGRAPHY ==================== */
.article-dynamic-body {
  font-family: var(--font-body);
  font-size: 16.5px;
  line-height: 1.85;
  color: var(--on-surface);
}

.article-dynamic-body :deep(h2),
.article-dynamic-body h2 {
  font-family: var(--font-headline);
  font-size: 1.55rem;
  font-weight: 800;
  color: var(--on-surface);
  margin-top: 2rem;
  margin-bottom: 0.85rem;
  line-height: 1.35;
  border-left: 4px solid var(--primary);
  padding-left: 0.85rem;
}

.article-dynamic-body :deep(h3),
.article-dynamic-body h3 {
  font-family: var(--font-headline);
  font-size: 1.25rem;
  font-weight: 700;
  color: var(--primary);
  margin-top: 1.5rem;
  margin-bottom: 0.65rem;
  line-height: 1.4;
}

.article-dynamic-body :deep(p),
.article-dynamic-body p {
  margin-bottom: 1.25rem;
  color: #334155;
  font-size: 16.5px;
  line-height: 1.85;
}

.article-dynamic-body :deep(ul),
.article-dynamic-body ul {
  list-style-type: disc;
  margin-left: 1.5rem;
  margin-bottom: 1.5rem;
  color: #334155;
}

.article-dynamic-body :deep(ol),
.article-dynamic-body ol {
  list-style-type: decimal;
  margin-left: 1.5rem;
  margin-bottom: 1.5rem;
  color: #334155;
}

.article-dynamic-body :deep(li),
.article-dynamic-body li {
  margin-bottom: 0.5rem;
  line-height: 1.7;
}

.article-dynamic-body :deep(strong),
.article-dynamic-body strong {
  font-weight: 700;
  color: var(--on-surface);
}

.article-dynamic-body :deep(a),
.article-dynamic-body a {
  color: var(--primary);
  text-decoration: underline;
  font-weight: 600;
  transition: color 0.15s;
}

.article-dynamic-body :deep(a:hover),
.article-dynamic-body a:hover {
  color: var(--primary-container);
}

.article-dynamic-body :deep(blockquote),
.article-dynamic-body blockquote {
  margin: 1.75rem 0;
  padding: 1.25rem 1.5rem;
  background: rgba(0, 99, 132, 0.04);
  border-left: 4px solid var(--primary);
  border-radius: 0 1rem 1rem 0;
  font-style: italic;
  color: #1e293b;
  font-size: 16px;
  line-height: 1.75;
}

.article-dynamic-body :deep(.callout-card),
.article-dynamic-body .callout-card {
  margin: 2rem 0;
  padding: 1.5rem;
  background: linear-gradient(135deg, rgba(0, 99, 132, 0.06) 0%, rgba(75, 103, 22, 0.06) 100%);
  border-left: 4px solid var(--secondary);
  border-radius: 1rem;
}

.article-dynamic-body :deep(img),
.article-dynamic-body img {
  max-width: 100%;
  height: auto;
  border-radius: 1rem;
  margin: 1.5rem 0;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
}

.article-dynamic-body :deep(hr),
.article-dynamic-body hr {
  border: 0;
  height: 1px;
  background: rgba(191, 200, 206, 0.5);
  margin: 2rem 0;
}

/* Headings inside content */
.section-title-row {
  display: flex;
  align-items: center;
  gap: 0.875rem;
  margin-bottom: 1rem;
}

.step-num-circle {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: var(--font-headline);
  font-size: 17px;
  font-weight: 700;
  flex-shrink: 0;
}

.circle-blue {
  background: var(--primary-fixed);
  color: var(--primary);
}

.circle-red {
  background: var(--error-container);
  color: var(--error);
}

.circle-green {
  background: var(--secondary-fixed);
  color: var(--secondary);
}

.editorial-h2 {
  font-family: var(--font-headline);
  font-size: 22px;
  font-weight: 700;
  color: var(--on-surface);
  line-height: 1.3;
}

.section-lead-desc {
  font-size: 15px;
  line-height: 1.6;
  color: var(--on-surface-variant);
  margin-bottom: 1.5rem;
}

/* Milestone Stages Stack */
.stages-stack {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.stage-item {
  padding: 1rem 1.25rem;
  border-radius: 0.875rem;
  background: rgba(237, 244, 255, 0.7);
  border-left: 4px solid var(--primary);
  display: flex;
  align-items: flex-start;
  gap: 0.875rem;
}

.stage-check {
  font-size: 20px;
  color: var(--primary);
  flex-shrink: 0;
  margin-top: 2px;
}

.stage-title {
  font-family: var(--font-headline);
  font-size: 15px;
  font-weight: 700;
  color: var(--on-surface);
  margin-bottom: 0.25rem;
}

.stage-desc {
  font-size: 13.5px;
  line-height: 1.6;
  color: var(--on-surface-variant);
}

/* Red Flags 2x2 Grid */
.redflags-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
}

.redflag-card {
  padding: 1.25rem;
  border-radius: 0.875rem;
  background: var(--surface-container-low);
  border: 1px solid rgba(191, 200, 206, 0.35);
  display: flex;
  align-items: flex-start;
  gap: 0.875rem;
}

.warning-circle {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background: rgba(186, 26, 26, 0.1);
  color: var(--error);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.warning-circle .material-symbols-outlined {
  font-size: 18px;
  font-weight: 700;
}

.redflag-title {
  font-family: var(--font-headline);
  font-size: 14px;
  font-weight: 700;
  color: var(--on-surface);
  margin-bottom: 0.25rem;
}

.redflag-desc {
  font-size: 13px;
  line-height: 1.55;
  color: var(--on-surface-variant);
}

/* Myths vs Facts */
.myths-stack {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.myth-fact-box {
  display: grid;
  grid-template-columns: 1fr 1fr;
  border-radius: 0.875rem;
  overflow: hidden;
  border: 1px solid rgba(191, 200, 206, 0.4);
}

.myth-side {
  background: rgba(255, 218, 214, 0.35);
  padding: 1.25rem;
  border-right: 1px solid rgba(191, 200, 206, 0.3);
}

.fact-side {
  background: rgba(204, 239, 142, 0.25);
  padding: 1.25rem;
}

.myth-tag {
  display: inline-block;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  margin-bottom: 0.5rem;
}

.myth-tag-error {
  color: var(--error);
}

.myth-tag-success {
  color: var(--secondary);
}

.myth-text {
  font-size: 13.5px;
  font-weight: 700;
  color: var(--on-surface);
  line-height: 1.5;
}

.fact-text {
  font-size: 13.5px;
  color: var(--on-surface-variant);
  line-height: 1.55;
}

/* Quotation Box */
.editorial-quote-box {
  padding: 2rem;
  border-radius: 1.25rem;
  background: rgba(217, 234, 255, 0.45);
  border: 2px dashed rgba(0, 99, 132, 0.3);
  display: flex;
  align-items: flex-start;
  gap: 1.25rem;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
}

.quote-icon {
  font-size: 38px;
  color: var(--primary);
  flex-shrink: 0;
}

.quote-text {
  font-family: var(--font-headline);
  font-size: 18px;
  font-weight: 600;
  font-style: italic;
  color: var(--on-surface);
  line-height: 1.6;
}

.quote-author {
  margin-top: 0.75rem;
  font-size: 13px;
  font-weight: 700;
  color: var(--primary);
}

/* Process Section */
.process-steps-row {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1rem;
}

.process-step-box {
  padding: 1.25rem;
  border-radius: 0.875rem;
  background: var(--surface-container-low);
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.p-icon-wrap {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  background: rgba(0, 99, 132, 0.1);
  color: var(--primary);
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 0.75rem;
}

.p-icon-wrap .material-symbols-outlined {
  font-size: 24px;
}

.p-title {
  font-family: var(--font-headline);
  font-size: 14px;
  font-weight: 700;
  color: var(--on-surface);
  margin-bottom: 0.25rem;
}

.p-desc {
  font-size: 12px;
  color: var(--on-surface-variant);
  line-height: 1.5;
}

/* Tips List */
.tips-list {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.tip-item {
  display: flex;
  align-items: flex-start;
  gap: 0.75rem;
  font-size: 14.5px;
  line-height: 1.6;
  color: var(--on-surface-variant);
}

.tip-check {
  font-size: 20px;
  color: var(--secondary);
  flex-shrink: 0;
  margin-top: 2px;
}

/* Author Bio Card */
.author-bio-card {
  padding: 2rem;
  border-radius: 1.25rem;
  background: var(--surface-container-low);
  border: 1px solid rgba(191, 200, 206, 0.35);
  display: flex;
  align-items: flex-start;
  gap: 1.5rem;
}

.bio-avatar-img {
  width: 90px;
  height: 90px;
  border-radius: 50%;
  object-fit: cover;
  border: 4px solid var(--surface-container-lowest);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  flex-shrink: 0;
}

.bio-content {
  flex: 1;
}

.bio-role-badge {
  display: inline-block;
  font-size: 11px;
  font-weight: 700;
  background: var(--primary-fixed);
  color: var(--on-primary-fixed);
  padding: 0.2rem 0.65rem;
  border-radius: 9999px;
  margin-bottom: 0.35rem;
}

.bio-name {
  font-family: var(--font-headline);
  font-size: 18px;
  font-weight: 700;
  color: var(--on-surface);
}

.bio-specialty {
  font-size: 12.5px;
  font-weight: 700;
  color: var(--primary);
  margin-bottom: 0.5rem;
}

.bio-text {
  font-size: 13.5px;
  line-height: 1.6;
  color: var(--on-surface-variant);
}

/* Tags & Save Strip */
.tags-action-bar {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
  padding-top: 1rem;
  border-top: 1px solid rgba(191, 200, 206, 0.3);
}

.tags-wrap {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 0.5rem;
}

.tags-label {
  font-size: 12px;
  font-weight: 700;
  color: var(--on-surface-variant);
}

.tag-pill {
  font-size: 12px;
  color: var(--on-surface-variant);
  background: var(--surface-container);
  padding: 0.25rem 0.75rem;
  border-radius: 9999px;
}

.btn-save-article {
  display: inline-flex;
  align-items: center;
  gap: 0.375rem;
  background: var(--surface-container);
  color: var(--on-surface);
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 9999px;
  font-size: 12px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-save-article:hover {
  background: var(--surface-container-high);
}

.btn-save-article .material-symbols-outlined {
  font-size: 16px;
}

/* ==================== STICKY SIDEBAR ==================== */
.sidebar-sticky-wrap {
  position: sticky;
  top: 100px;
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.sidebar-widget {
  border-radius: 1.25rem;
  padding: 1.5rem;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
}

/* Widget 1: CTA Asesmen */
.widget-cta {
  background: var(--surface-container-low);
  border: 1px solid rgba(0, 99, 132, 0.2);
}

.widget-icon-box {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  background: var(--primary);
  color: var(--on-primary);
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 1rem;
  box-shadow: 0 4px 12px rgba(0, 99, 132, 0.25);
}

.widget-icon-box .material-symbols-outlined {
  font-size: 24px;
}

.widget-title {
  font-family: var(--font-headline);
  font-size: 18px;
  font-weight: 700;
  color: var(--on-surface);
  margin-bottom: 0.5rem;
  line-height: 1.3;
}

.widget-desc {
  font-size: 13.5px;
  line-height: 1.6;
  color: var(--on-surface-variant);
  margin-bottom: 1.25rem;
}

.widget-actions {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.btn-widget-primary {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  background: var(--primary);
  color: var(--on-primary);
  padding: 0.75rem 1.25rem;
  border-radius: 9999px;
  font-size: 13.5px;
  font-weight: 700;
  text-decoration: none;
  box-shadow: 0 4px 12px rgba(0, 99, 132, 0.2);
  transition: all 0.2s;
}

.btn-widget-primary:hover {
  background: var(--primary-container);
  transform: translateY(-2px);
}

.btn-widget-secondary {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  background: var(--secondary);
  color: var(--on-secondary);
  padding: 0.75rem 1.25rem;
  border-radius: 9999px;
  font-size: 13.5px;
  font-weight: 700;
  text-decoration: none;
  box-shadow: 0 4px 12px rgba(75, 103, 22, 0.2);
  transition: all 0.2s;
}

.btn-widget-secondary:hover {
  background: var(--secondary-container);
  color: var(--on-secondary-container);
  transform: translateY(-2px);
}

.widget-location-row {
  margin-top: 1rem;
  padding-top: 1rem;
  border-top: 1px solid rgba(191, 200, 206, 0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.375rem;
  font-size: 11.5px;
  color: var(--on-surface-variant);
}

.loc-icon {
  font-size: 16px;
  color: var(--secondary);
}


/* Widget 3: Related Articles */
.widget-related {
  background: var(--surface-container-lowest);
  border: 1px solid rgba(191, 200, 206, 0.35);
}

.related-widget-title {
  font-family: var(--font-headline);
  font-size: 16px;
  font-weight: 700;
  color: var(--on-surface);
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 1rem;
}

.related-widget-title .material-symbols-outlined {
  font-size: 20px;
  color: var(--primary);
}

.related-list {
  display: flex;
  flex-direction: column;
  gap: 0.875rem;
}

.related-link-card {
  display: flex;
  align-items: flex-start;
  gap: 0.75rem;
  padding-bottom: 0.875rem;
  border-bottom: 1px solid rgba(191, 200, 206, 0.25);
  text-decoration: none;
  transition: opacity 0.2s;
}

.related-link-card:last-child {
  border-bottom: none;
  padding-bottom: 0;
}

.related-thumb {
  width: 64px;
  height: 64px;
  border-radius: 0.75rem;
  object-fit: cover;
  flex-shrink: 0;
}

.related-card-title {
  font-family: var(--font-headline);
  font-size: 13.5px;
  font-weight: 700;
  color: var(--on-surface);
  line-height: 1.35;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  transition: color 0.15s;
}

.related-link-card:hover .related-card-title {
  color: var(--primary);
}

.related-card-date {
  font-size: 11.5px;
  color: var(--on-surface-variant);
  display: block;
  margin-top: 0.25rem;
}

/* ==================== BOTTOM RECOMMENDED ARTICLES ==================== */
.section-bottom-articles {
  padding: 4rem 0;
  background: rgba(237, 244, 255, 0.5);
  border-top: 1px solid rgba(191, 200, 206, 0.3);
}

.bottom-header {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  margin-bottom: 2rem;
  gap: 1.5rem;
}

.section-eyebrow {
  font-size: 12.5px;
  font-weight: 700;
  color: var(--primary);
  text-transform: uppercase;
  letter-spacing: 0.08em;
  display: block;
}

.bottom-title {
  font-family: var(--font-headline);
  font-size: clamp(22px, 2.5vw, 28px);
  font-weight: 700;
  color: var(--on-surface);
  margin-top: 0.25rem;
}

.btn-view-all-articles {
  display: inline-flex;
  align-items: center;
  gap: 0.375rem;
  color: var(--primary);
  font-size: 14px;
  font-weight: 700;
  text-decoration: none;
  transition: color 0.15s;
  white-space: nowrap;
}

.btn-view-all-articles:hover {
  color: var(--primary-container);
}

.bottom-articles-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.5rem;
}

.rec-card {
  background: var(--surface-container-lowest);
  border-radius: 1.25rem;
  overflow: hidden;
  border: 1px solid rgba(191, 200, 206, 0.3);
  box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
  display: flex;
  flex-direction: column;
  transition: transform 0.25s, box-shadow 0.25s;
}

.rec-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 24px rgba(43, 61, 79, 0.08);
}

.rec-thumb-wrap {
  aspect-ratio: 16 / 10;
  overflow: hidden;
  background: var(--surface-container);
}

.rec-thumb {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s;
}

.rec-card:hover .rec-thumb {
  transform: scale(1.05);
}

.rec-body {
  padding: 1.5rem;
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.rec-meta {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 0.625rem;
}

.rec-cat-pill {
  font-size: 11px;
  font-weight: 700;
  padding: 0.2rem 0.65rem;
  border-radius: 9999px;
}

.rec-cat-green {
  background: var(--secondary-fixed);
  color: var(--on-secondary-fixed);
}

.rec-cat-blue {
  background: var(--primary-fixed);
  color: var(--on-primary-fixed);
}

.rec-cat-neutral {
  background: var(--surface-container);
  color: var(--on-surface-variant);
}

.rec-date {
  font-size: 11.5px;
  color: var(--on-surface-variant);
}

.rec-title {
  font-family: var(--font-headline);
  font-size: 16px;
  font-weight: 700;
  color: var(--on-surface);
  line-height: 1.35;
  margin-bottom: 0.5rem;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.rec-desc {
  font-size: 13px;
  line-height: 1.55;
  color: var(--on-surface-variant);
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.rec-read-more {
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
  color: var(--primary);
  font-size: 13px;
  font-weight: 700;
  text-decoration: none;
  margin-top: 1rem;
  transition: gap 0.2s;
}

.rec-read-more:hover {
  gap: 0.5rem;
}

/* ==================== REGISTRATION BANNER ==================== */
.section-reg-banner {
  padding: 4rem 0;
  background: linear-gradient(135deg, var(--primary) 0%, var(--primary-container) 100%);
  color: var(--on-primary);
}

.reg-banner-card {
  background: var(--surface-container-lowest);
  color: var(--on-surface);
  border-radius: 1.5rem;
  padding: 2.5rem 3rem;
  box-shadow: 0 16px 36px rgba(0, 0, 0, 0.12);
  border: 1px solid rgba(0, 99, 132, 0.2);
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 2.5rem;
}

.reg-left {
  max-width: 640px;
}

.reg-pill {
  display: inline-flex;
  align-items: center;
  gap: 0.375rem;
  background: var(--secondary-fixed);
  color: var(--on-secondary-fixed);
  padding: 0.35rem 0.875rem;
  border-radius: 9999px;
  font-size: 12px;
  font-weight: 700;
  margin-bottom: 0.875rem;
}

.reg-pill .material-symbols-outlined {
  font-size: 16px;
}

.reg-title {
  font-family: var(--font-headline);
  font-size: clamp(24px, 2.8vw, 32px);
  font-weight: 700;
  color: var(--primary);
  line-height: 1.25;
}

.reg-desc {
  font-size: 14.5px;
  line-height: 1.6;
  color: var(--on-surface-variant);
  margin-top: 0.75rem;
}

.reg-trust-items {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 1.25rem;
  margin-top: 1.25rem;
  font-size: 13.5px;
  font-weight: 600;
  color: var(--on-surface);
}

.trust-check {
  display: flex;
  align-items: center;
  gap: 0.375rem;
}

.trust-check .material-symbols-outlined {
  font-size: 18px;
  color: var(--secondary);
  font-variation-settings: 'FILL' 1;
}

.reg-right {
  display: flex;
  flex-direction: column;
  gap: 0.875rem;
  flex-shrink: 0;
  min-width: 260px;
}

.btn-banner-wa {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.625rem;
  background: var(--secondary);
  color: var(--on-secondary);
  padding: 0.875rem 1.75rem;
  border-radius: 9999px;
  font-size: 14.5px;
  font-weight: 700;
  text-decoration: none;
  box-shadow: 0 4px 14px rgba(75, 103, 22, 0.25);
  transition: all 0.2s;
  text-align: center;
}

.btn-banner-wa:hover {
  background: var(--secondary-container);
  color: var(--on-secondary-container);
  transform: translateY(-2px);
}

.btn-banner-register {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.625rem;
  background: var(--primary);
  color: var(--on-primary);
  padding: 0.875rem 1.75rem;
  border-radius: 9999px;
  font-size: 14.5px;
  font-weight: 700;
  text-decoration: none;
  box-shadow: 0 4px 14px rgba(0, 99, 132, 0.25);
  transition: all 0.2s;
  text-align: center;
}

.btn-banner-register:hover {
  background: var(--primary-container);
  transform: translateY(-2px);
}

/* ==================== RESPONSIVE BREAKPOINTS ==================== */
@media (max-width: 1024px) {
  .article-grid {
    grid-template-columns: 1fr;
    gap: 2rem;
  }
  .sidebar-sticky-wrap {
    position: static;
  }
  .reg-banner-card {
    flex-direction: column;
    align-items: flex-start;
    padding: 2rem;
  }
  .reg-right {
    width: 100%;
    flex-direction: row;
  }
  .bottom-articles-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 768px) {
  .meta-bar-card {
    flex-direction: column;
    align-items: flex-start;
  }
  .meta-divider {
    display: none;
  }
  .redflags-grid {
    grid-template-columns: 1fr;
  }
  .myth-fact-box {
    grid-template-columns: 1fr;
  }
  .myth-side {
    border-right: none;
    border-bottom: 1px solid rgba(191, 200, 206, 0.3);
  }
  .process-steps-row {
    grid-template-columns: 1fr;
  }
  .bottom-articles-grid {
    grid-template-columns: 1fr;
  }
  .reg-right {
    flex-direction: column;
  }
  .author-bio-card {
    flex-direction: column;
    align-items: center;
    text-align: center;
  }
  .featured-img {
    height: 300px;
  }
}

/* ==================== STICKY READING PROGRESS BAR ==================== */
.reading-progress-track {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 4px;
  background: rgba(0, 99, 132, 0.08);
  z-index: 9999;
  pointer-events: none;
}

.reading-progress-fill {
  height: 100%;
  background: linear-gradient(90deg, #006384 0%, #00a2c7 60%, #16a34a 100%);
  transition: width 0.08s linear;
  border-radius: 0 2px 2px 0;
  box-shadow: 0 0 10px rgba(0, 162, 199, 0.7);
}

/* Share & Bookmark Buttons in Meta Bar */
.share-btn-bookmark {
  background: var(--surface-container);
  color: var(--on-surface-variant);
}

.share-btn-bookmark:hover {
  background: #fef3c7;
  color: #b45309;
  transform: translateY(-2px);
}

.share-btn-bookmark.is-active {
  background: #fef3c7;
  color: #b45309;
  box-shadow: 0 2px 8px rgba(180, 83, 9, 0.2);
}

.share-btn-bookmark.is-active .material-symbols-outlined {
  font-variation-settings: 'FILL' 1;
}

/* ==================== MOBILE TOC ACCORDION ==================== */
.mobile-toc-accordion {
  display: none;
  background: #ffffff;
  border: 1.5px solid rgba(0, 99, 132, 0.18);
  border-radius: 1rem;
  padding: 0.65rem 1rem;
  margin-bottom: 1.5rem;
  box-shadow: 0 4px 14px rgba(9, 29, 46, 0.04);
}

@media (max-width: 1024px) {
  .mobile-toc-accordion {
    display: block;
  }
}

.btn-mobile-toc {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: none;
  border: none;
  padding: 0.25rem 0;
  cursor: pointer;
  font-family: var(--font-headline);
  font-size: 14px;
  font-weight: 700;
  color: #091d2e;
}

.mobile-toc-label {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.mobile-toc-chevron {
  font-size: 22px;
  color: #006384;
  transition: transform 0.25s ease;
}

.mobile-toc-chevron.is-rotated {
  transform: rotate(180deg);
}

.mobile-toc-dropdown {
  display: flex;
  flex-direction: column;
  gap: 0.4rem;
  padding-top: 0.75rem;
  margin-top: 0.5rem;
  border-top: 1px solid rgba(191, 200, 206, 0.3);
}

.mobile-toc-link {
  display: flex;
  align-items: center;
  gap: 0.6rem;
  padding: 0.5rem 0.65rem;
  border-radius: 8px;
  text-decoration: none;
  color: #475569;
  font-size: 13px;
  font-weight: 600;
  transition: all 0.2s;
}

.mobile-toc-link.is-active {
  background: #e0f2fe;
  color: #006384;
  font-weight: 700;
}

/* ==================== STICKY TABLE OF CONTENTS (SIDEBAR) ==================== */
.widget-toc {
  background: #ffffff;
  border: 1.5px solid rgba(0, 99, 132, 0.15);
  box-shadow: 0 6px 20px -2px rgba(9, 29, 46, 0.05);
  transition: border-color 0.2s;
}

.widget-toc:hover {
  border-color: rgba(0, 99, 132, 0.3);
}

.toc-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-bottom: 0.75rem;
  margin-bottom: 0.75rem;
  border-bottom: 1px solid rgba(191, 200, 206, 0.35);
}

.toc-header-left {
  display: flex;
  align-items: center;
  gap: 0.45rem;
}

.toc-head-icon {
  font-size: 20px;
  color: #006384;
}

.toc-title {
  font-family: var(--font-headline);
  font-size: 15px;
  font-weight: 800;
  color: #091d2e;
  margin: 0;
}

.toc-badge-count {
  font-size: 11px;
  font-weight: 700;
  color: #006384;
  background: #e0f2fe;
  padding: 0.15rem 0.5rem;
  border-radius: 999px;
}

.toc-list {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 0.35rem;
}

.toc-link {
  display: flex;
  align-items: center;
  gap: 0.65rem;
  padding: 0.55rem 0.75rem;
  border-radius: 8px;
  text-decoration: none;
  color: #475569;
  font-size: 13px;
  font-weight: 600;
  line-height: 1.35;
  transition: all 0.2s ease;
  position: relative;
}

.toc-bullet {
  font-size: 11px;
  font-weight: 800;
  color: #64748b;
  background: #f1f5f9;
  width: 22px;
  height: 22px;
  border-radius: 6px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  transition: all 0.2s;
}

.toc-text {
  flex: 1;
}

.toc-arrow {
  font-size: 18px;
  color: #006384;
  margin-left: auto;
}

.toc-link:hover {
  background: #f0f7fb;
  color: #006384;
}

.toc-link:hover .toc-bullet {
  background: #e0f2fe;
  color: #006384;
}

.toc-link.is-active {
  background: #e0f2fe;
  color: #006384;
  font-weight: 700;
  box-shadow: 0 1px 4px rgba(0, 99, 132, 0.08);
}

.toc-link.is-active .toc-bullet {
  background: #006384;
  color: #ffffff;
}

/* ==================== BOTTOM ACTION BUTTONS ==================== */
.bottom-action-buttons {
  display: flex;
  align-items: center;
  gap: 0.65rem;
  flex-wrap: wrap;
}

.btn-bottom-share {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  background: #f8fafc;
  color: #006384;
  border: 1px solid #cbd5e1;
  padding: 0.5rem 0.85rem;
  border-radius: 999px;
  font-family: var(--font-headline);
  font-size: 12.5px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-bottom-share:hover {
  background: #e0f2fe;
  border-color: #006384;
  color: #006384;
  transform: translateY(-2px);
}

.btn-bottom-share .material-symbols-outlined {
  font-size: 16px;
}

.btn-save-article.is-saved {
  background: #fef3c7;
  color: #b45309;
  border: 1px solid rgba(180, 83, 9, 0.25);
  box-shadow: 0 2px 8px rgba(180, 83, 9, 0.15);
}

.btn-save-article.is-saved:hover {
  background: #fde68a;
  color: #92400e;
}

.btn-save-article.is-saved .material-symbols-outlined {
  color: #b45309;
  font-variation-settings: 'FILL' 1;
}

/* ==================== TOAST NOTIFICATION ==================== */
.article-toast {
  position: fixed;
  bottom: 2rem;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  align-items: center;
  gap: 0.85rem;
  background: rgba(9, 29, 46, 0.95);
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
  color: #ffffff;
  padding: 0.85rem 1.35rem;
  border-radius: 999px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
  z-index: 99999;
  font-family: var(--font-headline);
  border: 1px solid rgba(255, 255, 255, 0.15);
  max-width: 90vw;
}

.toast-icon {
  font-size: 22px;
  color: #38bdf8;
  flex-shrink: 0;
}

.toast-success .toast-icon {
  color: #4ade80;
}

.toast-info .toast-icon {
  color: #facc15;
}

.toast-body {
  display: flex;
  flex-direction: column;
}

.toast-title {
  font-size: 13.5px;
  font-weight: 800;
  margin: 0;
  line-height: 1.25;
  color: #ffffff;
}

.toast-desc {
  font-size: 12px;
  margin: 0;
  color: #cbd5e1;
  font-family: var(--font-body);
  line-height: 1.35;
}

.toast-close {
  background: none;
  border: none;
  color: #94a3b8;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-left: 0.5rem;
  border-radius: 50%;
  padding: 0.2rem;
}

.toast-close:hover {
  color: #ffffff;
}

.toast-fade-enter-active,
.toast-fade-leave-active {
  transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}

.toast-fade-enter-from,
.toast-fade-leave-to {
  opacity: 0;
  transform: translate(-50%, 20px);
}

/* ==================== 404 NOT FOUND STATE STYLES ==================== */
.article-not-found-section {
  padding: 5rem 1rem;
  min-height: 60vh;
  display: flex;
  align-items: center;
  justify-content: center;
}

.not-found-container {
  max-width: 680px;
  margin: 0 auto;
}

.not-found-card {
  background: var(--surface);
  border: 1px solid rgba(191, 200, 206, 0.4);
  border-radius: 20px;
  padding: 3.5rem 2rem;
  text-align: center;
  box-shadow: 0 10px 30px rgba(9, 29, 46, 0.05);
}

.not-found-icon-wrap {
  width: 72px;
  height: 72px;
  margin: 0 auto 1.5rem;
  background: rgba(0, 99, 132, 0.1);
  color: var(--primary);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.not-found-icon-wrap .material-symbols-outlined {
  font-size: 38px;
}

.not-found-badge {
  display: inline-block;
  padding: 0.35rem 0.9rem;
  background: #f1f5f9;
  color: #475569;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 700;
  letter-spacing: 0.04em;
  text-transform: uppercase;
  margin-bottom: 1rem;
}

.not-found-title {
  font-family: var(--font-headline);
  font-size: 2rem;
  font-weight: 800;
  color: var(--on-surface);
  margin-bottom: 0.75rem;
}

.not-found-desc {
  font-size: 1.05rem;
  line-height: 1.6;
  color: var(--on-surface-variant);
  margin-bottom: 2rem;
  max-width: 480px;
  margin-left: auto;
  margin-right: auto;
}

.not-found-actions {
  display: flex;
  gap: 1rem;
  justify-content: center;
  flex-wrap: wrap;
}

.btn-not-found-primary {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  background: var(--primary);
  color: #ffffff;
  padding: 0.85rem 1.6rem;
  border-radius: 12px;
  font-weight: 700;
  font-size: 0.9375rem;
  text-decoration: none;
  transition: all 0.2s;
  box-shadow: 0 4px 14px rgba(0, 99, 132, 0.25);
}

.btn-not-found-primary:hover {
  background: #004d67;
  transform: translateY(-2px);
  color: #ffffff;
}

.btn-not-found-secondary {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  background: transparent;
  color: var(--on-surface);
  border: 1px solid rgba(191, 200, 206, 0.8);
  padding: 0.85rem 1.5rem;
  border-radius: 12px;
  font-weight: 600;
  font-size: 0.9375rem;
  text-decoration: none;
  transition: all 0.2s;
}

.btn-not-found-secondary:hover {
  background: rgba(0, 0, 0, 0.04);
}

/* ============================================================
   ARTICLE DETAIL SKELETON SHIMMER (ANTI-FLICKER)
   ============================================================ */
.article-skeleton-page {
  animation: fadeIn 0.15s ease-out;
}

.skel-bar {
  background: linear-gradient(90deg, #eef3f7 25%, #e2e8f0 50%, #eef3f7 75%);
  background-size: 200% 100%;
  animation: articleSkeletonShimmer 1.5s infinite;
  border-radius: 6px;
}

@keyframes articleSkeletonShimmer {
  0% { background-position: 200% 0; }
  100% { background-position: -200% 0; }
}

.skeleton-breadcrumb-row {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  height: 24px;
}
.skel-bc-1 { width: 60px; height: 14px; }
.skel-bc-2 { width: 90px; height: 14px; }
.skel-bc-3 { width: 180px; height: 14px; }
.skel-bc-sep { color: #cbd5e1; font-size: 13px; }

.skel-pill-1 { width: 120px; height: 32px; border-radius: 9999px; }
.skel-pill-2 { width: 150px; height: 32px; border-radius: 9999px; }
.skel-pill-3 { width: 100px; height: 32px; border-radius: 9999px; }

.skel-title-wrap {
  margin: 1.25rem 0 1.5rem;
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}
.skel-title-line1 { width: 85%; height: 40px; border-radius: 8px; }
.skel-title-line2 { width: 60%; height: 40px; border-radius: 8px; }

.skel-meta-card {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
}
.skel-meta-left {
  display: flex;
  align-items: center;
  gap: 0.85rem;
}
.skel-avatar {
  width: 44px;
  height: 44px;
  border-radius: 50%;
  background: linear-gradient(90deg, #eef3f7 25%, #e2e8f0 50%, #eef3f7 75%);
  background-size: 200% 100%;
  animation: articleSkeletonShimmer 1.5s infinite;
}
.skel-meta-text {
  display: flex;
  flex-direction: column;
  gap: 0.35rem;
}
.skel-line-short { width: 130px; height: 15px; }
.skel-line-tiny { width: 90px; height: 12px; }

.skel-meta-right {
  display: flex;
  gap: 0.5rem;
}
.skel-circle {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: linear-gradient(90deg, #eef3f7 25%, #e2e8f0 50%, #eef3f7 75%);
  background-size: 200% 100%;
  animation: articleSkeletonShimmer 1.5s infinite;
}

.skel-hero-img-wrap {
  width: 100%;
  border-radius: var(--radius-lg, 1.25rem);
  overflow: hidden;
  margin-bottom: 2.5rem;
}
.skel-hero-img {
  width: 100%;
  height: 440px;
  border-radius: var(--radius-lg, 1.25rem);
}

.skel-card {
  background: #ffffff;
  border: 1px solid rgba(191, 200, 206, 0.3);
  border-radius: var(--radius-md, 1rem);
  padding: 2rem;
  margin-bottom: 1.5rem;
}
.skel-line-lead { width: 100%; height: 20px; margin-bottom: 0.75rem; }
.skel-line-lead-2 { width: 80%; height: 20px; }

.skel-h2-line { height: 26px; width: 45%; margin-bottom: 1rem; border-radius: 6px; }
.skel-p-line { height: 16px; width: 100%; margin-bottom: 0.75rem; }
.skel-w-85 { width: 85%; }
.skel-w-80 { width: 80%; }
.skel-w-75 { width: 75%; }
.skel-w-65 { width: 65%; }
.skel-w-50 { width: 50%; }

.skel-related-row {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  margin-bottom: 1rem;
}
.skel-rel-thumb {
  width: 64px;
  height: 64px;
  border-radius: 8px;
  background: linear-gradient(90deg, #eef3f7 25%, #e2e8f0 50%, #eef3f7 75%);
  background-size: 200% 100%;
  animation: articleSkeletonShimmer 1.5s infinite;
  flex-shrink: 0;
}
.skel-rel-info {
  display: flex;
  flex-direction: column;
  gap: 0.4rem;
  flex: 1;
}

@media (max-width: 768px) {
  .skel-hero-img { height: 240px; }
  .skel-title-line1, .skel-title-line2 { height: 28px; }
  .skel-meta-card { flex-direction: column; align-items: flex-start; gap: 1rem; }
}
</style>

