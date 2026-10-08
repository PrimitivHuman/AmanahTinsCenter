---
name: Warm Child Development Sanctuary
colors:
  surface: '#f7f9ff'
  surface-dim: '#c9dcf3'
  surface-bright: '#f7f9ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#edf4ff'
  surface-container: '#e3efff'
  surface-container-high: '#d9eaff'
  surface-container-highest: '#d1e4fb'
  on-surface: '#091d2e'
  on-surface-variant: '#40484d'
  inverse-surface: '#203243'
  inverse-on-surface: '#e8f2ff'
  outline: '#70787e'
  outline-variant: '#bfc8ce'
  surface-tint: '#056687'
  primary: '#006384'
  on-primary: '#ffffff'
  primary-container: '#2e7c9e'
  on-primary-container: '#fbfcff'
  inverse-primary: '#88d0f4'
  secondary: '#4b6716'
  on-secondary: '#ffffff'
  secondary-container: '#ccef8e'
  on-secondary-container: '#516d1c'
  tertiary: '#884e03'
  on-tertiary: '#ffffff'
  tertiary-container: '#a5661f'
  on-tertiary-container: '#fffbff'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#c1e8ff'
  primary-fixed-dim: '#88d0f4'
  on-primary-fixed: '#001e2b'
  on-primary-fixed-variant: '#004d67'
  secondary-fixed: '#ccef8e'
  secondary-fixed-dim: '#b1d275'
  on-secondary-fixed: '#131f00'
  on-secondary-fixed-variant: '#354e00'
  tertiary-fixed: '#ffdcbf'
  tertiary-fixed-dim: '#ffb873'
  on-tertiary-fixed: '#2d1600'
  on-tertiary-fixed-variant: '#6a3b00'
  background: '#f7f9ff'
  on-background: '#091d2e'
  surface-variant: '#d1e4fb'
typography:
  display-hero:
    fontFamily: Outfit
    fontSize: 48px
    fontWeight: '700'
    lineHeight: 58px
    letterSpacing: -0.02em
  display-hero-mobile:
    fontFamily: Outfit
    fontSize: 32px
    fontWeight: '700'
    lineHeight: 40px
    letterSpacing: -0.01em
  headline-lg:
    fontFamily: Outfit
    fontSize: 36px
    fontWeight: '600'
    lineHeight: 46px
    letterSpacing: -0.015em
  headline-lg-mobile:
    fontFamily: Outfit
    fontSize: 26px
    fontWeight: '600'
    lineHeight: 34px
    letterSpacing: 0em
  headline-md:
    fontFamily: Outfit
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
  headline-sm:
    fontFamily: Outfit
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
  title-md:
    fontFamily: Outfit
    fontSize: 18px
    fontWeight: '600'
    lineHeight: 26px
  body-lg:
    fontFamily: Nunito Sans
    fontSize: 18px
    fontWeight: '400'
    lineHeight: 28px
  body-md:
    fontFamily: Nunito Sans
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  body-sm:
    fontFamily: Nunito Sans
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  label-lg:
    fontFamily: Nunito Sans
    fontSize: 15px
    fontWeight: '700'
    lineHeight: 22px
    letterSpacing: 0.01em
  label-md:
    fontFamily: Nunito Sans
    fontSize: 13px
    fontWeight: '600'
    lineHeight: 18px
    letterSpacing: 0.02em
  caption:
    fontFamily: Nunito Sans
    fontSize: 12px
    fontWeight: '500'
    lineHeight: 16px
rounded:
  sm: 0.5rem
  DEFAULT: 1rem
  md: 1.5rem
  lg: 2rem
  xl: 3rem
  full: 9999px
spacing:
  gutter: 1.5rem
  gutter-mobile: 1rem
  margin: 2rem
  margin-mobile: 1.25rem
  margin-desktop-max: 5rem
  space-xs: 0.375rem
  space-sm: 0.75rem
  space-md: 1.25rem
  space-lg: 2rem
  space-xl: 3.5rem
---

## Brand & Style

This design system is tailored for a pediatric therapy and child development clinic. The emotional posture balances clinical professionalism with maternal warmth, security, and childlike optimism. It addresses parents who may feel anxious about developmental milestones, offering immediate reassurance, clear pathways to consultation, and a welcoming, stigma-free atmosphere.

The design movement combines **Contemporary Soft UI** and **Warm Editorial Minimalism**:
- **Organic Softness:** Pill-shaped interactions, generously rounded cards, and gentle pastel zoning prevent clinical sterility.
- **Supportive Clarity:** Clean typographic hierarchies and legible content cards break down therapy programs (Speech Therapy, Occupational Therapy, Sensory Integration, Child Psychology) into digestible, approachable concepts.
- **Tactile Comfort:** Micro-textures, friendly line iconography, and soft organic shapes frame authentic photography of child-therapist interactions.

## Colors

The palette transforms soft pastels into functional clinical UI elements by establishing clear roles for tinted surfaces and high-contrast foreground interactive elements:

- **Primary (`#3A86A8`, derived from Sky Blue `#A7D8F0`):** Provides accessible contrast for text links, key headers, and core brand CTA buttons. Light pastel sky `#A7D8F0` acts as a calm background wash and card highlight.
- **Secondary (`#6C8A36`, derived from Sage Green `#A7C957`):** Represents growth, patience, and therapy milestones. Deepened for primary positive action items and badges, with `#A7C957` used as surface fills for sensory therapy tags.
- **Tertiary Accent (`#F2A65A`, derived from Pastel Yellow `#FFDFA7` & Peach `#FFD6C9`):** Warms up informational callouts, consultation badges, and energetic milestones without overpowering parents.
- **Surface Neutrals & Canvas:** `#FFFFFF` pure white cards layered against `#F8FAF8` and `#F4F8FA` tinted canvas backdrops. Deep slate `#2B3D4F` anchors typography to ensure WCAG AAA body legibility.

## Typography

Typography balances rounded, welcoming geometry with effortless legibility:

- **Headlines & Display:** Set in Outfit, providing a modern geometric aesthetic with rounded nuances that reflect childhood friendliness without devolving into novelty typography.
- **Body & Functional Text:** Set in Nunito Sans, featuring rounded terminal anatomy, open apertures, and exceptional readability on mobile devices for parents reading therapy documentation, guides, or intake forms.
- **Hierarchy Notes:** Headlines use alternating dual-tone emphasis (e.g., Primary Deep Blue + Sage Green accents within a single sentence) to maintain warmth and draw attention to uplifting developmental concepts.

## Layout & Spacing

The layout uses an open, breathing 12-column fluid grid system centered within a max canvas width of 1280px.

- **Breakpoints:**
  - **Mobile (< 768px):** 4 columns, `margin-mobile` (1.25rem), stacked feature tiers, single-column therapy cards, horizontal chip carousels.
  - **Tablet (768px - 1024px):** 8 columns, `margin` (2rem), 2-column service matrices.
  - **Desktop (> 1024px):** 12 columns, `gutter` (1.5rem), up to 4-column feature grids, alternating split sections for clinic profiles and parental resources.
- **Rhythm:** Generous vertical section padding (`space-xl`) prevents emotional clutter, while cards leverage internal padding of `space-md` or `space-lg` to create peaceful visual breathing rooms.

## Elevation & Depth

Visual hierarchy rejects harsh, dark drop shadows in favor of soft, natural ambient daylighting and tinted surface cards:

- **Level 0 (Base Canvas):** Off-white `#FAFCFA` and soft pastel background tints (`#F0F8FC`, `#F4F8EE`, `#FFF9F0`).
- **Level 1 (Standard Card & Info Surfaces):** Pure white background `#FFFFFF` with a subtle outline (`border: 1px solid rgba(58, 134, 168, 0.08)`) and diffuse ambient glow: `0px 8px 24px -4px rgba(58, 134, 168, 0.06)`.
- **Level 2 (Hovered Cards & Interactive Blocks):** Lifted elevation with softened dual shadows: `0px 14px 32px -6px rgba(43, 61, 79, 0.08), 0px 4px 12px -2px rgba(167, 201, 87, 0.12)`.
- **Level 3 (Modals, WhatsApp Floating CTA, Overlays):** `0px 24px 48px -12px rgba(43, 61, 79, 0.16)`.
- **Organic Depth:** Photography containers utilize soft curved masking with pastel badge overlays rather than floating heavy dimensional shadows.

## Shapes

The shape philosophy is built on gentle radii and pill-shaped touch targets:

- **Buttons & Chips:** Pill-shaped (`rounded-full` / `9999px`) to invite touch and eliminate harsh industrial edges.
- **Content Cards & Media Windows:** Rounded at `1.5rem` to `2rem` (`rounded-2xl` to `rounded-3xl`), evoking a gentle, embracing atmosphere.
- **Badges & Icon Pods:** Squircle or circle backgrounds (`rounded-full`) tinted with low-opacity pastel fills (`#A7D8F0` at 25%, `#A7C957` at 20%, `#FFDFA7` at 30%, `#FFD6C9` at 35%) to house friendly line icons.

## Components

### Buttons
- **Primary Action (e.g., "Jadwalkan Konsultasi", "Daftar Sekarang"):** Pill-shaped, rich teal-blue (`#3A86A8`) background with crisp white typography. Hover state transitions to soft elevation gain and subtle expansion. Right-aligned micro-arrow icon indicates forward momentum.
- **Secondary / WhatsApp CTA:** Sage green (`#6C8A36`) or pastel outline pill with generous horizontal padding (`1.75rem`), conveying open, pressure-free communication.
- **Tertiary / Ghost:** No background fill; primary blue text with subtle underline hover effect and arrow slide animation.

### Service & Program Cards
- **Structure:** Clean white surface (`#FFFFFF`) with 28px rounded corners.
- **Header:** Features a circular icon pod tinted in matching pastel categories (Speech Therapy in sky tint, Occupational Therapy in peach tint, Sensory Integration in sage tint, Psychology in soft violet/rose tint).
- **Body:** Outfit Title-MD header, Nunito Sans descriptive body, terminated with an explicit "Selengkapnya →" link.

### Chips & Category Filters
- Height of 36px, full pill radius. Default state has a soft tinted background matching the section theme (`#F0F7FB`). Selected state switches to a solid brand tint with high-contrast text and a soft drop shadow.

### Input Fields & Intake Forms
- Background tinted in faint off-white (`#F8FAF8`), framed by a 1.5px subtle border (`#DCE5DC`). Focus state shifts to Primary Teal-Blue ring (`rgba(58, 134, 168, 0.25)`) with rounded corners at `1rem`. Generous vertical padding allows easy fingertip interaction for busy parents on mobile devices.

### Value Proposition / Trust Features
- Segmented pill containers and four-pillar trust grids (Quality Therapy, Flexible Schedule, Personal Approach, Safe Environment). Icons centered inside light pastel squircle capsules with concise labels below.

### Article & Parental Tips Cards
- Top media mask rounded at 20px, metadata tags set in caption typography, followed by a punchy headline and 2-line summary. Clean, uncluttered layout ensures parent-friendly scanning during quick breaks.