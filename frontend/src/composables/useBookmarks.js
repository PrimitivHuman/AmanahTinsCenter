import { ref, onMounted } from 'vue'

const STORAGE_KEY = 'atc_saved_articles'

// Shared reactive state
const bookmarkedArticles = ref([])

function loadBookmarks() {
  try {
    const raw = localStorage.getItem(STORAGE_KEY)
    if (raw) {
      bookmarkedArticles.value = JSON.parse(raw)
    } else {
      bookmarkedArticles.value = []
    }
  } catch (e) {
    console.error('Failed to parse bookmarked articles from localStorage', e)
    bookmarkedArticles.value = []
  }
}

function saveBookmarks() {
  try {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(bookmarkedArticles.value))
    window.dispatchEvent(new Event('atc_bookmark_change'))
  } catch (e) {
    console.error('Failed to save bookmarks to localStorage', e)
  }
}

// Initial load
if (typeof window !== 'undefined') {
  loadBookmarks()
  window.addEventListener('atc_bookmark_change', loadBookmarks)
  window.addEventListener('storage', (e) => {
    if (e.key === STORAGE_KEY) {
      loadBookmarks()
    }
  })
}

export function useBookmarks() {
  function isBookmarked(slug) {
    if (!slug) return false
    return bookmarkedArticles.value.some((item) => item.slug === slug)
  }

  function toggleBookmark(article) {
    if (!article || !article.slug) return false

    const index = bookmarkedArticles.value.findIndex((item) => item.slug === article.slug)
    let added = false

    if (index > -1) {
      // Remove
      bookmarkedArticles.value.splice(index, 1)
      added = false
    } else {
      // Add
      bookmarkedArticles.value.unshift({
        id: article.id || Date.now(),
        slug: article.slug,
        title: article.title || 'Artikel Edukasi',
        category: article.category || 'Tumbuh Kembang',
        excerpt: article.excerpt || '',
        thumbnail: article.thumbnail || '',
        read_time: article.read_time || '4 min baca',
        published_at: article.published_at || new Date().toISOString().split('T')[0]
      })
      added = true
    }

    saveBookmarks()
    return added
  }

  return {
    bookmarkedArticles,
    isBookmarked,
    toggleBookmark,
    loadBookmarks
  }
}
