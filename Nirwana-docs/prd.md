# PRD - Nirwana Gent's

## 1. Product Overview

**Nirwana Gent's** adalah platform digital untuk barbershop premium dengan nuansa klasik, mewah, hangat, dan nyaman. Website menggabungkan tiga fungsi utama:

1. **Company Profile** untuk memperkenalkan brand, layanan, barber, suasana, dan informasi bisnis.
2. **Booking System** untuk memesan jadwal layanan berdasarkan service, barber, tanggal, dan slot waktu.
3. **E-Commerce** untuk menjual produk grooming melalui katalog, product detail, cart, checkout, dan order history.

### Brand direction

- Brand: Nirwana Gent's
- Positioning: premium men's grooming
- Character: classic, masculine, refined, warm, confident
- Suggested tagline: `Classic Style. Timeless Confidence.`
- Primary audience: pria yang memperhatikan grooming, mahasiswa, profesional muda, pengusaha, dan pelanggan yang mencari pengalaman barber premium.

> Catatan: nama barber, harga, alamat, angka statistik, testimonial, jam operasional, dan data bisnis yang belum diberikan harus dianggap sebagai **sample data** dan tidak boleh dipresentasikan sebagai fakta nyata.

---

## 2. Goals

### Business goals

- Memperkenalkan Nirwana Gent's secara profesional.
- Mendorong pengunjung melakukan booking.
- Menyediakan kanal penjualan produk grooming.
- Menjadikan informasi layanan, barber, dan kontak mudah ditemukan.

### Product goals

- Pengunjung memahami brand dalam beberapa detik pertama.
- User dapat melakukan booking tanpa alur yang membingungkan.
- User dapat membeli produk dengan cart dan checkout.
- Admin dapat mengelola layanan, barber, produk, booking, order, dan customer.
- Website tetap premium tanpa mengorbankan usability.

### Success criteria

- Semua halaman utama dapat diakses melalui navigasi yang konsisten.
- Booking menghasilkan appointment record dengan status yang jelas.
- Cart menghitung quantity dan total secara benar.
- Checkout menghasilkan order dan order detail.
- Admin dapat mengubah status booking dan order.
- Tidak ada slot booking ganda untuk barber yang sama pada waktu yang sama.
- Layout usable pada mobile, tablet, dan desktop.
- Copy UI tidak mengandung klaim atau angka fiktif yang disamarkan sebagai fakta.

---

## 3. Non-Goals

Untuk versi tugas/MVP:

- Tidak membuat payment gateway production-grade.
- Tidak membuat aplikasi mobile native.
- Tidak membuat sistem payroll barber.
- Tidak membuat inventory multi-cabang.
- Tidak membuat integrasi WhatsApp otomatis jika belum diperlukan.
- Tidak membutuhkan real-time chat.
- Tidak membutuhkan marketplace multi-vendor.

Metode pembayaran dapat berupa simulasi seperti QRIS, transfer bank, atau cash on pickup. Status pembayaran dapat dikelola admin secara manual.

---

## 4. Personas

### Visitor

Mencari informasi barbershop, layanan, harga, lokasi, dan suasana.

Needs:
- informasi cepat
- visual yang meyakinkan
- service list
- lokasi dan kontak
- CTA booking

### Customer

Sudah ingin menggunakan layanan atau membeli produk.

Needs:
- booking slot yang jelas
- riwayat appointment
- cart
- checkout
- order history
- account profile

### Admin

Mengelola operasi digital barbershop.

Needs:
- dashboard ringkas
- CRUD service
- CRUD barber
- CRUD product
- booking management
- order management
- customer management

---

## 5. Information Architecture

### Public

- `/`
- `/about`
- `/services`
- `/services/[slug]`
- `/barbers`
- `/barbers/[slug]`
- `/gallery`
- `/shop`
- `/shop/[slug]`
- `/contact`

### Booking

- `/booking`
- `/booking/confirmation`
- `/account/appointments`

### Commerce

- `/cart`
- `/checkout`
- `/account/orders`
- `/account/orders/[id]`

### Authentication

- `/login`
- `/register`
- `/forgot-password`

### Customer account

- `/account`
- `/account/profile`
- `/account/appointments`
- `/account/orders`

### Admin

- `/admin`
- `/admin/services`
- `/admin/barbers`
- `/admin/products`
- `/admin/bookings`
- `/admin/orders`
- `/admin/customers`

---

## 6. Page Requirements

### Home

Purpose: brand introduction and conversion.

Sections:
- floating/navigation header
- hero
- short brand story
- featured services
- why Nirwana Gent's
- featured barbers
- grooming store
- gallery
- booking CTA
- footer

Primary CTA: `Book an Appointment`
Secondary CTA: `Explore Services`

### About

Sections:
- brand story
- philosophy
- values
- vision and mission
- atmosphere/interior
- optional team introduction

### Services

Features:
- service categories
- service cards
- price
- duration
- description
- booking CTA
- optional filter

### Service Detail

Features:
- service name
- description
- duration
- price
- inclusions
- eligible barbers
- booking CTA

### Barbers

Features:
- barber cards
- role
- specialties
- short bio
- availability indicator only when backed by real data
- booking CTA

### Barber Detail

Features:
- profile
- specialties
- experience only if supplied
- available services
- booking CTA

### Gallery

Features:
- editorial image grid
- category/filter if needed
- optimized images
- meaningful alt text

### Shop

Features:
- search
- categories
- product cards
- price
- stock state
- add to cart

### Product Detail

Features:
- product media
- name
- price
- stock
- description
- usage instructions
- quantity
- add to cart

### Cart

Features:
- cart items
- quantity control
- remove
- subtotal
- shipping if applicable
- total
- checkout CTA

### Checkout

Features:
- customer information
- address
- payment method
- order summary
- validation
- place order

### Booking

Flow:
1. choose service
2. choose barber or any available barber
3. choose date
4. load available slots
5. choose time
6. customer information
7. review
8. confirm

Rules:
- unavailable slots are disabled
- past date/time cannot be selected
- booking collision must be prevented server-side
- booking status must be visible

### My Appointments

Features:
- upcoming
- completed
- cancelled
- detail
- cancel where policy allows

### My Orders

Features:
- order list
- order detail
- status
- totals
- purchased items

### Account

Features:
- profile
- appointment history
- order history
- logout

### Admin Dashboard

Widgets:
- today's bookings
- pending bookings
- orders
- revenue summary only when derived from stored order data
- low stock products
- recent activity

Admin CRUD:
- services
- barbers
- products
- customers

Admin workflows:
- confirm/cancel/complete booking
- update order status
- manage stock

---

## 7. Functional Requirements

### Authentication

- Register with name, email, phone, password.
- Login/logout.
- Password stored as a secure hash.
- Role-based access.
- Admin routes require admin authorization.
- Customer data is only accessible to the owning customer or authorized admin.

### Booking

- Service is required.
- Barber selection may be optional if `Any Available Barber` is supported.
- Date and time are required.
- Availability must be calculated from actual booking records.
- Server must reject duplicate booking collisions.
- Booking receives a unique human-readable reference.
- Booking has status: `pending`, `confirmed`, `completed`, `cancelled`.
- Cancellation rules must be explicit.

### Cart

- Add product.
- Increase/decrease quantity.
- Remove product.
- Reject quantity above available stock.
- Recalculate totals server-side at checkout.
- Never trust client-provided price.

### Order

- Create order from current cart.
- Persist immutable order item price at purchase time.
- Reduce stock atomically after successful order creation according to payment/order policy.
- Status: `pending`, `confirmed`, `processing`, `ready`, `completed`, `cancelled`.
- Customer can see own orders.
- Admin can manage all orders.

### Product Management

- Create/read/update/delete product.
- Product has category, price, stock, image, description.
- Product can be active/inactive.
- Product price is stored numerically, not as formatted text.

---

## 8. Data Model

Core entities:

- `users`
- `services`
- `barbers`
- `bookings`
- `products`
- `cart_items`
- `orders`
- `order_items`

Recommended supporting entities:

- `barber_services`
- `business_hours`
- `barber_time_off`
- `product_categories`
- `media`
- `contact_messages`

Relationships:

- user 1:N bookings
- user 1:N orders
- service 1:N bookings
- barber 1:N bookings
- order 1:N order_items
- product 1:N order_items
- user 1:N cart_items
- product 1:N cart_items
- service N:M barber
- product N:1 product_category

---

## 9. UX Requirements

### Booking UX

Use a clear stepper:
`Service -> Barber -> Date -> Time -> Details -> Review`

Keep the current selection visible while progressing.

### Commerce UX

Use:
`Browse -> Product Detail -> Cart -> Checkout -> Success`

Do not hide cart state. Cart count should be visible in the main navigation.

### Error UX

Errors should explain:
- what went wrong
- what the user can do next

Example:
`Slot ini baru saja diambil. Pilih waktu lain.`

Avoid:
`Something went wrong.`

---

## 10. Visual Direction

Design read:

> Reading this as: premium consumer barbershop brand for design-conscious men, with an editorial luxury language, leaning toward warm materials, high-contrast serif typography, asymmetric composition, and restrained physical motion.

Suggested design dials:

- `DESIGN_VARIANCE: 7`
- `MOTION_INTENSITY: 5`
- `VISUAL_DENSITY: 3`

Palette:
- Espresso: `#241A14`
- Near Black: `#11100E`
- Warm Cream: `#F3EBDD`
- Brass Gold: `#B18A4A`
- Muted Taupe: `#8C8174`

Typography:
- Display: a high-contrast editorial serif such as `Cormorant Garamond` or another properly licensed premium serif.
- UI/body: a refined grotesk such as `Manrope`, `Plus Jakarta Sans`, or an equivalent self-hosted/licensed font.
- Do not use typography merely because it is trendy. Select based on readability and brand fit.

Visual principles:
- generous whitespace
- editorial asymmetry
- warm photography
- dark wood/leather/brass material cues
- restrained grain/noise only where it improves atmosphere
- tactile nested containers for premium cards
- no generic SaaS glassmorphism
- no default three-card feature grid when a more editorial composition communicates better

---

## 11. Content Rules

- Do not invent customer testimonials, ratings, founding dates, customer counts, awards, locations, barber experience, or revenue.
- Mark demo content clearly in development data.
- Prefer concrete copy over abstract luxury language.
- Avoid filler such as `elevate`, `unlock`, `seamless`, `revolutionary`, `next-level`, and similar generic marketing vocabulary.
- Keep one consistent copy register per page.
- Avoid fake precision.
- Every visible string must pass a copy self-audit.
- Do not use em dash characters in visible copy.

---

## 12. Accessibility

- semantic HTML
- keyboard navigation
- visible focus states
- sufficient color contrast
- form labels
- useful error messages
- alt text for meaningful images
- decorative images use empty alt
- reduced motion support
- touch targets appropriate for mobile

---

## 13. Performance

- optimize and lazy-load non-critical images
- use responsive image sizes
- animate only transform and opacity
- avoid scroll handlers that cause continuous reflow
- use IntersectionObserver or Motion's viewport APIs for reveal animations
- keep backdrop blur limited to fixed/sticky overlays
- avoid excessive animation on mobile
- avoid layout shifts

---

## 14. MVP Scope

### Must have

- Home
- About
- Services
- Barbers
- Shop
- Product detail
- Cart
- Checkout
- Login/register
- Booking
- My appointments
- My orders
- Admin dashboard
- CRUD services
- CRUD barbers
- CRUD products
- Booking management
- Order management

### Nice to have

- Gallery
- Search/filter
- favorites
- coupon
- QRIS simulation
- WhatsApp deep link
- email confirmation
- calendar export
- reviews
- stock alerts

### Future

- online payment gateway
- multi-branch
- membership
- loyalty points
- automated reminders
- real-time availability
- analytics dashboard

---

## 15. Acceptance Checklist

- [ ] Home communicates brand and primary CTAs.
- [ ] Visitor can reach service and shop content.
- [ ] Customer can register and log in.
- [ ] Customer can book an available slot.
- [ ] Duplicate booking is rejected.
- [ ] Customer can view/cancel eligible appointment.
- [ ] Customer can add product to cart.
- [ ] Cart quantity and totals are correct.
- [ ] Checkout creates an order.
- [ ] Customer can view order history.
- [ ] Admin can manage service/barber/product records.
- [ ] Admin can manage booking/order statuses.
- [ ] Responsive layout works on mobile and desktop.
- [ ] Copy contains no fabricated facts.
- [ ] No visible em dash is present.
