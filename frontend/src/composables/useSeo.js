/**
 * Composable untuk Dinamisasi SEO, Title, dan Open Graph Meta Tags
 * Sangat penting agar tautan yang dibagikan ke WhatsApp / Media Sosial
 * menampilkan judul, cuplikan, dan gambar yang sesuai per halaman/artikel.
 */
export function useSeo() {
  const defaultMeta = {
    title: "Pusat Terapi Tumbuh Kembang Anak",
    description: "Amanah Tin's Center - Layanan Terapi Wicara, Terapi Okupasi, Sensori Integrasi, dan Psikologi Anak di Jagakarsa, Jakarta Selatan.",
    image: "https://lh3.googleusercontent.com/aida-public/AB6AXuDndS1MEqhUoM1jUcloTszQuiVyvZQQTdkWTSuBfJTiomzP1PM9XqIRCM9jqFGt1cW7d3Leb19e2RyIVFI-ZAZVTtp0cqgL1J5nVzOeM9xb3jMOsV1syIVqmGBEzTpxgNh7DR4Bmof0JjfqdICLKa4vueP7V49v6bJx6jBVOILCbqk-mUAQWiGEt6MTKP0dWcxjtDpTGkGPMvUKtluVegL-I7DXLjkf67qRXyeHcC4",
    type: 'website',
  }

  function setMetaTag(nameOrProperty, value, attribute = 'name') {
    if (!value && value !== '') return
    let el = document.querySelector(`meta[${attribute}="${nameOrProperty}"]`)
    if (!el) {
      el = document.createElement('meta')
      el.setAttribute(attribute, nameOrProperty)
      document.head.appendChild(el)
    }
    el.setAttribute('content', value)
  }

  function setCanonical(url) {
    if (!url) return
    let link = document.querySelector('link[rel="canonical"]')
    if (!link) {
      link = document.createElement('link')
      link.setAttribute('rel', 'canonical')
      document.head.appendChild(link)
    }
    link.setAttribute('href', url)
  }

  function updateSeo({
    title,
    description,
    image,
    url,
    type = 'website',
  } = {}) {
    const fullTitle = title
      ? `${title} | Amanah Tin's Center`
      : "Amanah Tin's Center - Pusat Terapi Tumbuh Kembang Anak"
    document.title = fullTitle

    const desc = description || defaultMeta.description
    const ogImg = image || defaultMeta.image
    const pageUrl = url || (typeof window !== 'undefined' ? window.location.href : '')

    // Standard Meta
    setMetaTag('description', desc, 'name')

    // Open Graph (WhatsApp, Facebook, Telegram)
    setMetaTag('og:site_name', "Amanah Tin's Center", 'property')
    setMetaTag('og:title', title || "Amanah Tin's Center", 'property')
    setMetaTag('og:description', desc, 'property')
    setMetaTag('og:type', type, 'property')
    setMetaTag('og:image', ogImg, 'property')
    if (pageUrl) {
      setMetaTag('og:url', pageUrl, 'property')
      setCanonical(pageUrl)
    }

    // Twitter Card
    setMetaTag('twitter:card', 'summary_large_image', 'name')
    setMetaTag('twitter:title', title || "Amanah Tin's Center", 'name')
    setMetaTag('twitter:description', desc, 'name')
    setMetaTag('twitter:image', ogImg, 'name')
  }

  return {
    updateSeo,
  }
}
