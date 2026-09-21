# RULES - Nirwana Gent's

## 0. Priority

Urutan prioritas:

1. correctness
2. accessibility
3. security
4. usability
5. brand consistency
6. visual polish
7. animation

Jika visual bertentangan dengan usability atau accessibility, usability menang.

---

## 1. Anti-Slop Design

Dilarang menjadikan default AI sebagai desain:

- purple AI gradients
- centered hero + dark mesh
- generic glassmorphism
- equal 3-column feature cards everywhere
- excessive pills
- random floating blobs
- infinite micro-animation
- template SaaS styling

Setiap visual harus punya alasan berdasarkan brand atau task.

---

## 2. Typography

Default premium project tidak menggunakan:
- Inter
- Roboto
- Arial
- Open Sans
- Helvetica

Gunakan kombinasi serif editorial + refined sans yang konsisten.

Font harus:
- self-hosted atau loaded through framework font tooling
- memiliki lisensi yang sesuai
- tidak diambil dari `<link>` Google Fonts di production

---

## 3. Colors

Gunakan token brand.

```text
--color-espresso
--color-near-black
--color-warm-cream
--color-brass
--color-taupe
```

Jangan menambahkan accent color baru tanpa alasan brand.

---

## 4. Borders & Shadows

Hindari:
- generic gray 1px border
- harsh black shadows
- shadow-md sebagai default

Pilih:
- subtle hairline
- layered surfaces
- soft ambient depth
- inset highlight jika relevan

---

## 5. Cards

Tidak semua content harus menjadi card.

Card digunakan jika:
- content perlu grouping
- clickable
- membutuhkan surface hierarchy

Untuk premium card, nested shell/core boleh digunakan.

Jangan mengulang bentuk card yang sama untuk seluruh halaman.

---

## 6. Layout

Hindari:
- simetris tanpa alasan
- grid monoton
- semua section centered

Prioritaskan:
- editorial split
- asymmetry
- varied scale
- whitespace
- strong media composition

Tetap gunakan conventional layouts pada booking, cart, checkout, dan admin bila itu meningkatkan usability.

---

## 7. Motion

Dilarang:
- `linear`
- `ease-in-out`
- animation yang mengubah layout terus-menerus
- scroll event loop untuk reveal
- excessive parallax
- motion yang menghalangi interaction

Prioritaskan:
- transform
- opacity
- custom cubic-bezier
- viewport-triggered reveal

Gunakan reduced-motion behavior.

---

## 8. Navbar

Public navbar boleh floating dan detached dari viewport edge.

Navbar harus:
- mudah ditemukan
- tetap usable
- tidak menutupi content
- memiliki mobile navigation
- tidak bergantung pada animation

---

## 9. Buttons

CTA utama harus:
- spesifik
- memiliki contrast
- memiliki visible hover/focus
- memiliki pressed state
- touch-friendly

Hindari CTA generik jika konteks memungkinkan.

Prefer:
- `Book an Appointment`
- `View Services`
- `Add to Cart`
- `Proceed to Checkout`

Hindari:
- `Learn More` jika tujuan sebenarnya jelas
- `Get Started` untuk booking barbershop
- `Click Here`

---

## 10. Copywriting

### Forbidden patterns

Hindari empty vocabulary:
- unlock
- elevate
- empower
- journey
- seamless
- cutting-edge
- next-level
- game-changing
- revolutionary
- robust
- delve
- showcase

Bukan berarti kata-kata tersebut tidak pernah boleh muncul. Jangan gunakan sebagai filler atau pengganti informasi konkret.

### Jangan:
- mengumumkan isi sebelum menyampaikan isi
- membuka copy dengan `Let's dive in`
- menggunakan `Here's what you need to know`
- menggunakan `Honestly?`
- menggunakan `Real talk`
- menggunakan chatbot closer seperti `I hope this helps!`
- menggunakan passive voice tanpa actor bila actor penting
- mengganti kata berulang hanya demi variasi
- memakai all-caps untuk berteriak di body copy

### Do:
- langsung ke poin
- gunakan bahasa manusia
- pertahankan voice brand
- ulangi istilah yang paling jelas bila memang tepat

---

## 11. No Fabricated Facts

Tidak boleh mengarang:
- testimonial
- rating
- angka customer
- revenue
- awards
- years of experience
- founding year
- alamat
- phone
- opening hours
- price
- stock
- availability
- service duration

Jika data belum diberikan:
- gunakan `TBD`
- gunakan sample data yang jelas ditandai
- atau hilangkan informasi

---

## 12. No Fake Precision

Angka seperti:
- `98%`
- `10,000+ customers`
- `4.9/5`
- `7 years`
- `15 minutes`

hanya boleh jika:
- berasal dari data nyata
- diberikan user
- berasal dari source yang dapat diverifikasi
- atau ditandai eksplisit sebagai sample/mock data

---

## 13. Punctuation

**Jangan gunakan em dash (`—`) atau en dash (`–`) pada visible copy.**

Gunakan:
- titik
- koma
- titik dua
- parentheses
- hyphen biasa bila memang diperlukan

---

## 14. Booking Rules

- service wajib
- date wajib
- time wajib
- barber wajib jika user memilih barber tertentu
- slot unavailable harus disabled
- server melakukan final availability check
- booking collision harus ditolak
- booking yang sudah completed tidak bisa dibatalkan
- booking cancelled tidak boleh kembali aktif tanpa proses yang jelas
- timezone harus konsisten
- tanggal lampau tidak boleh dibooking

---

## 15. Cart Rules

- quantity minimal 1
- quantity tidak boleh melebihi stock
- product inactive tidak dapat ditambahkan
- price dari client tidak dipercaya
- total dihitung ulang server-side
- stock dicek saat checkout
- cart tidak boleh mengubah order yang sudah dibuat

---

## 16. Order Rules

Order item menyimpan snapshot:
- product name
- unit price
- quantity
- line total

Tujuannya agar histori order tetap benar walaupun product berubah.

Order status:

```text
pending
confirmed
processing
ready
completed
cancelled
```

Transisi status harus divalidasi.

---

## 17. Authentication Rules

- password di-hash dengan library/protocol yang aman
- jangan simpan plaintext password
- session harus secure
- admin route harus dilindungi
- customer hanya boleh melihat resource miliknya
- jangan percaya `role` dari client
- jangan expose secrets ke browser

---

## 18. Validation Rules

Semua mutation divalidasi server-side.

Minimal:
- email
- phone
- password
- quantity
- date
- time
- service ID
- barber ID
- product ID
- ownership
- role

Client validation hanya untuk UX, bukan security boundary.

---

## 19. Error Messages

Error harus:
- spesifik
- singkat
- actionable

Good:
> Slot 13:00 sudah diambil. Pilih waktu lain.

Bad:
> Something went wrong.

Jangan expose:
- SQL error
- stack trace
- secret
- internal IDs jika tidak diperlukan

---

## 20. Accessibility Rules

Wajib:
- semantic HTML
- keyboard support
- focus state
- labels
- accessible error
- contrast
- alt text
- reduced motion

Jangan menggunakan:
- color-only status
- hover-only information
- icon-only control tanpa accessible label

---

## 21. Responsive Rules

Mobile adalah layout yang dirancang, bukan desktop yang diperkecil.

Aturan:
- single column jika perlu
- touch targets cukup besar
- no overlapping controls
- no horizontal overflow yang tidak disengaja
- typography tetap readable
- booking slots dapat discan dengan cepat

---

## 22. Images

- gunakan gambar yang relevan dengan brand
- jangan gunakan random stock image hanya untuk mengisi ruang
- optimalkan ukuran
- lazy-load non-critical images
- gunakan alt text yang menjelaskan isi gambar jika meaningful
- decorative image gunakan empty alt

---

## 23. Performance

- animate transform/opacity
- gunakan lazy loading
- gunakan responsive images
- hindari backdrop blur besar pada scrolling content
- hindari expensive continuous effects
- hindari `window.scroll` listener untuk reveal
- gunakan IntersectionObserver/Motion viewport

---

## 24. Admin

Admin UI tidak perlu mengikuti semua experimental marketing patterns.

Prioritas admin:
1. information density yang masuk akal
2. scanning
3. filtering
4. predictable controls
5. confirmation untuk destructive actions

Admin boleh menggunakan table jika memang paling efektif.

---

## 25. Definition of Done

Feature dianggap selesai jika:

- [ ] happy path berjalan
- [ ] loading state ada
- [ ] empty state ada
- [ ] error state ada
- [ ] validation ada
- [ ] authorization ada
- [ ] responsive
- [ ] keyboard usable
- [ ] copy sudah diaudit
- [ ] tidak ada fabricated fact
- [ ] tidak ada em/en dash pada visible copy
- [ ] tidak ada unnecessary animation
- [ ] tidak ada hardcoded secret
- [ ] tidak ada client-side trust terhadap price/stock/role

---

## 26. Final Pre-Flight

Sebelum merge/deploy:

### Product
- [ ] Booking dapat dibuat
- [ ] Booking collision ditolak
- [ ] Cart bekerja
- [ ] Checkout bekerja
- [ ] Order tersimpan
- [ ] Admin dapat mengelola status

### Design
- [ ] Brand terasa classic luxury
- [ ] Tidak terlihat seperti template
- [ ] Hierarchy jelas
- [ ] Whitespace cukup
- [ ] Mobile tidak rusak

### Copy
- [ ] Tidak ada AI filler
- [ ] Tidak ada fake metric
- [ ] Tidak ada fake testimonial
- [ ] Tidak ada chatbot closer
- [ ] Tidak ada em dash/en dash
- [ ] CTA jelas

### Engineering
- [ ] TypeScript clean
- [ ] Server validation
- [ ] Auth/authorization
- [ ] Secure secrets
- [ ] Database migration reproducible
- [ ] Error handling
- [ ] Performance check

---

## 27. Source Principles

Dokumen ini mengadaptasi prinsip dari tiga skill publik:

1. `taste-skill/soft-skill`: premium visual direction, motion, spacing, tactile components, performance guardrails.
2. `taste-skill/taste-skill`: design-read first, design dials, anti-default discipline, contextual design systems, responsive and component guidance.
3. `anti-slop-copywriting`: concrete copy, evidence discipline, anti-fabrication, copy self-audit, avoidance of AI-like vocabulary and patterns.

The project-specific rules above take precedence over generic examples when the two differ.
