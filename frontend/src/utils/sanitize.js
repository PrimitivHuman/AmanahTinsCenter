import DOMPurify from 'dompurify'

/**
 * Sanitasi HTML untuk mencegah Stored XSS pada konten yang dirender dengan v-html.
 * Mengizinkan tag tipografi dan format artikel yang sah, namun memblokir skrip, iframe,
 * event handlers (onerror, onload, onclick), dan pseudo-protokol (javascript:).
 */
export function sanitizeHtml(dirty) {
  if (!dirty || typeof dirty !== 'string') return ''

  return DOMPurify.sanitize(dirty, {
    ALLOWED_TAGS: [
      'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
      'p', 'br', 'hr',
      'strong', 'b', 'em', 'i', 'u', 's', 'strike', 'sub', 'sup', 'mark',
      'ul', 'ol', 'li',
      'blockquote', 'q', 'cite',
      'table', 'thead', 'tbody', 'tfoot', 'tr', 'th', 'td', 'caption',
      'pre', 'code', 'kbd',
      'a', 'span', 'div',
      'img', 'figure', 'figcaption',
    ],
    ALLOWED_ATTR: [
      'href', 'target', 'rel', 'title', 'alt', 'src', 'width', 'height',
      'class', 'id', 'style', 'align', 'colspan', 'rowspan',
    ],
    ALLOWED_URI_REGEXP: /^(?:(?:(?:f|ht)tps?|mailto|tel|callto|sms|cid|xmpp):|[^a-z]|[a-z+.\-]+(?:[^a-z+.\-:]|$))/i,
    ADD_ATTR: ['target'],
    FORBID_TAGS: ['script', 'iframe', 'object', 'embed', 'form', 'input', 'button'],
    FORBID_ATTR: ['onerror', 'onload', 'onclick', 'onmouseover', 'onfocus', 'onblur'],
  })
}

export default sanitizeHtml
