# SKILL - Nirwana Gent's Design & Frontend Skill

## Purpose

Skill ini adalah aturan kerja untuk menghasilkan website Nirwana Gent's yang terasa seperti brand barbershop premium, bukan template generik.

Skill ini mengadaptasi prinsip dari:
- `taste-skill/soft-skill`
- `taste-skill/taste-skill`
- `anti-slop/antislop-copywriting`

Referensi:
- https://github.com/Leonxlnx/taste-skill/blob/main/skills/soft-skill/SKILL.md
- https://github.com/Leonxlnx/taste-skill/blob/main/skills/taste-skill/SKILL.md
- https://github.com/miqdadbadjuber/anti-slop/blob/main/skills/antislop-copywriting/SKILL.md

Aturan di bawah adalah adaptasi untuk proyek ini, bukan salinan dari repository.

---

## 1. Design Read

Sebelum membuat UI, nyatakan secara internal:

> Reading this as: premium consumer barbershop brand for men, with an editorial luxury language, warm physical materials, strong typography, restrained motion, and a clear booking-first conversion path.

Jangan langsung jatuh ke aesthetic default AI.

---

## 2. Three Dials

Default proyek:

```text
DESIGN_VARIANCE: 7
MOTION_INTENSITY: 5
VISUAL_DENSITY: 3
```

Makna:
- Variance 7: komposisi editorial dan sedikit asimetris.
- Motion 5: terasa hidup tetapi tidak seperti demo animasi.
- Density 3: lapang dan premium.

Untuk checkout, booking, dan admin, turunkan variance/motion bila eksperimen visual mengganggu task completion.

---

## 3. Visual Language

Gunakan:

- warm cream
- espresso
- near-black
- muted brass
- natural wood/leather cues
- editorial serif display
- refined grotesk UI
- generous whitespace
- photography-led composition

Hindari:
- AI-purple gradient
- dark mesh background generik
- glassmorphism di semua elemen
- template SaaS
- tiga kartu fitur yang selalu sama
- neon accent
- excessive rounded cards
- decorative animation tanpa fungsi

---

## 4. Typography

Gunakan font yang punya karakter dan lisensi yang sesuai.

Display:
- Cormorant Garamond, atau serif editorial setara.

UI/body:
- Manrope, Plus Jakarta Sans, atau sans setara yang self-hosted/licensed.

Jangan menggunakan:
- Inter
- Roboto
- Arial
- Open Sans
- Helvetica

sebagai default desain premium proyek ini.

Jangan load Google Fonts dengan `<link>` di production. Gunakan `next/font` atau self-hosted `@font-face`.

---

## 5. Layout

Pola yang diprioritaskan:

### Editorial Split

Headline besar + visual di sisi lain.

### Asymmetric Bento

Gunakan hanya jika grouping konten memang cocok.

### Z-axis / layered composition

Gunakan untuk hero atau gallery bila tidak mengganggu aksesibilitas.

### Full-width editorial media

Cocok untuk gallery dan brand story.

Mobile:
- semua asymmetric layout kembali menjadi single-column
- hilangkan overlap yang mengganggu touch target
- gunakan padding horizontal yang konsisten
- jangan pakai `h-screen` untuk section yang harus mengikuti viewport

---

## 6. Premium Container Pattern

Untuk card penting, gunakan nested shell:

```text
Outer shell
  subtle surface
  hairline border/ring
  generous padding
  large radius

  Inner core
    actual content
    slightly different surface
    subtle inner highlight
```

Jangan membuat setiap element menjadi card. Gunakan container hanya jika membantu hierarchy.

---

## 7. CTA Pattern

Primary CTA harus jelas dan mudah disentuh.

Untuk button dengan icon:
- icon berada dalam wrapper kecil
- hover memberi perpindahan/scale kecil
- active memberi physical press feedback

Contoh intent:
`Book an Appointment ↗`

Jangan membuat semua tombol bergerak secara agresif.

---

## 8. Motion

Motion harus terasa seperti massa fisik, bukan CSS demo.

Gunakan custom cubic-bezier.

Contoh:
```css
cubic-bezier(0.32, 0.72, 0, 1)
```

Reveal:
- opacity
- translateY
- optional blur

Gunakan:
- Motion viewport APIs
- IntersectionObserver

Jangan gunakan continuous `window.scroll` listener untuk reveal.

Jangan animate:
- top
- left
- width
- height

secara terus-menerus.

---

## 9. Navigation

Public navigation dapat menggunakan floating header yang sedikit terpisah dari viewport edge.

Desktop:
- logo
- primary nav
- Shop
- Cart
- Book Now

Mobile:
- compact header
- hamburger
- full-screen/large overlay
- staggered link reveal

Navigation harus tetap usable tanpa motion.

---

## 10. Booking UX Skill

Booking adalah conversion flow utama.

Gunakan:

```text
Service
  ↓
Barber
  ↓
Date
  ↓
Time
  ↓
Customer Details
  ↓
Review
  ↓
Confirmed
```

Rules:
- current step selalu terlihat
- selected state harus jelas
- unavailable slot harus disabled
- jangan menyembunyikan harga
- jangan meminta data yang tidak dibutuhkan
- error harus spesifik
- mobile first

Booking tidak boleh terasa seperti marketing page. Saat transaksi dimulai, clarity mengalahkan dekorasi.

---

## 11. E-Commerce UX Skill

Flow:

```text
Shop
  ↓
Product Detail
  ↓
Add to Cart
  ↓
Cart
  ↓
Checkout
  ↓
Success
```

Cart count harus mudah ditemukan.

Product card harus memiliki:
- image
- product name
- price
- stock state bila relevan
- add to cart

Jangan menggunakan fake rating atau fake sales count.

---

## 12. Copywriting Skill

### Copy must be concrete

Utamakan:
- apa yang ditawarkan
- untuk siapa
- apa yang termasuk
- durasi
- harga jika sudah final
- tindakan berikutnya

Hindari vocabulary AI yang kosong:
- unlock
- elevate
- empower
- delve
- showcase
- journey
- robust
- game-changer
- next-level
- seamless
- cutting-edge
- revolutionary

Jangan mengganti kata hanya agar terlihat variatif. Repetisi kata yang jelas lebih baik daripada synonym cycling.

---

## 13. Copy Voice

Voice Nirwana Gent's:
- tenang
- percaya diri
- maskulin
- hangat
- tidak berteriak
- tidak terlalu korporat
- tidak puitis secara berlebihan

Contoh yang baik:

> A precise cut, finished to suit your style.

Contoh yang buruk:

> Elevate your gentleman journey into an extraordinary next-level grooming experience.

Copy harus menjelaskan sesuatu, bukan sekadar terdengar premium.

---

## 14. Evidence Rules

Jangan mengarang:
- jumlah pelanggan
- rating
- jumlah cabang
- tahun berdiri
- pengalaman barber
- penghargaan
- testimonial
- statistik
- harga
- alamat
- jam buka

Jika belum ada data:
- gunakan placeholder yang jelas
- gunakan sample/mock label pada development
- atau tulis copy tanpa angka

Jangan membuat angka terlihat nyata hanya karena desain membutuhkan angka.

---

## 15. Copy Self-Audit

Sebelum halaman dianggap selesai, baca semua visible strings:
- headline
- eyebrow
- subheading
- button
- caption
- alt text
- error
- empty state
- footer

Tanyakan:
1. Apakah kalimatnya natural?
2. Apakah referennya jelas?
3. Apakah ada klaim tanpa sumber?
4. Apakah terdengar seperti AI?
5. Apakah kata-katanya benar-benar membantu user?

Jika ragu, pilih kalimat yang lebih sederhana.

---

## 16. Accessibility Skill

Wajib:
- semantic HTML
- keyboard navigation
- visible focus
- accessible labels
- form error association
- sufficient contrast
- reduced motion
- alt text
- touch-friendly targets

Animasi tidak boleh menjadi satu-satunya cara menyampaikan state.

---

## 17. Responsive Skill

Desktop dapat menggunakan:
- split hero
- asymmetry
- large typography
- layered media

Mobile harus:
- single column
- clear hierarchy
- no collision
- no tiny controls
- no forced horizontal overflow

Test minimal:
- 375px
- 768px
- 1024px
- 1440px

---

## 18. Component Discipline

Buat component karena:
- reusable
- domain-specific
- stateful
- atau memperjelas struktur

Jangan membuat:
`FancyCard`, `PremiumBox`, `MagicSection` hanya demi abstraksi.

Nama component harus menjelaskan intent:
- `ServiceCard`
- `BookingStepper`
- `ProductCard`
- `CartSummary`

---

## 19. Pre-Flight

Sebelum shipping:

### Design
- [ ] Design read jelas
- [ ] Tidak terlihat seperti template
- [ ] Hierarchy jelas
- [ ] Whitespace cukup
- [ ] Typography konsisten

### Motion
- [ ] Tidak ada linear/ease-in-out default
- [ ] Transform/opacity diprioritaskan
- [ ] Reduced motion tersedia
- [ ] Tidak ada scroll reflow berat

### Copy
- [ ] Tidak ada empty AI vocabulary
- [ ] Tidak ada fabricated facts
- [ ] Tidak ada fake metrics
- [ ] Tidak ada chatbot closer
- [ ] Tidak ada em dash
- [ ] CTA spesifik

### UX
- [ ] Booking jelas
- [ ] Cart jelas
- [ ] Checkout jelas
- [ ] Error actionable
- [ ] Mobile usable

### Engineering
- [ ] TypeScript type-safe
- [ ] Server validation
- [ ] Authorization
- [ ] Loading state
- [ ] Empty state
- [ ] Error state
- [ ] No secrets in client bundle
