# Architecture - Nirwana Gent's

## 1. Architecture Decision

Nirwana Gent's menggunakan arsitektur full-stack web modern dengan pemisahan yang jelas antara:

- presentation/UI
- application logic
- data access
- database
- media/assets

Target utama adalah website yang terasa premium di sisi publik, tetapi tetap mudah dipelihara dan dikembangkan untuk booking serta e-commerce.

## 2. Recommended Stack

### Frontend / Full-stack framework

**Next.js + React + TypeScript**

Alasan:
- routing terstruktur
- server/client component separation
- server-side rendering untuk halaman company profile
- cocok untuk interaksi booking/cart
- TypeScript membantu menjaga kontrak data

### Styling

**Tailwind CSS**

Gunakan utility-first styling dengan token desain milik Nirwana Gent's. Jangan menyalin style dari design system lain secara mentah.

### Motion

**Motion for React**

Gunakan untuk:
- page/section reveal
- modal
- menu
- micro interaction
- hover/press feedback

### State

- local state untuk UI lokal
- React context atau Zustand hanya untuk state lintas komponen yang benar-benar diperlukan
- server/database menjadi source of truth untuk booking, stock, order, dan harga

### Database

**PostgreSQL**

ORM:
**Prisma** atau ORM TypeScript setara.

### Authentication

Gunakan library authentication yang matang, bukan sistem password custom dari nol.

### Storage

Object storage untuk image/media jika deployment membutuhkannya.

---

## 3. High-Level System

```text
Browser
  |
  v
Next.js App
  |
  +-- Public pages
  |     +-- Home
  |     +-- About
  |     +-- Services
  |     +-- Barbers
  |     +-- Gallery
  |     +-- Shop
  |
  +-- Customer features
  |     +-- Auth
  |     +-- Booking
  |     +-- Cart
  |     +-- Checkout
  |     +-- Account
  |
  +-- Admin features
  |     +-- Dashboard
  |     +-- CRUD
  |     +-- Booking management
  |     +-- Order management
  |
  v
Application Services
  |
  +-- Booking service
  +-- Cart service
  +-- Order service
  +-- Product service
  +-- Auth service
  |
  v
Prisma / Data Access
  |
  v
PostgreSQL
```

---

## 4. Suggested Project Structure

```text
src/
├── app/
│   ├── (public)/
│   │   ├── page.tsx
│   │   ├── about/
│   │   ├── services/
│   │   ├── barbers/
│   │   ├── gallery/
│   │   ├── shop/
│   │   └── contact/
│   │
│   ├── (commerce)/
│   │   ├── cart/
│   │   ├── checkout/
│   │   └── order/
│   │
│   ├── (booking)/
│   │   ├── booking/
│   │   └── account/appointments/
│   │
│   ├── (auth)/
│   │   ├── login/
│   │   ├── register/
│   │   └── forgot-password/
│   │
│   ├── account/
│   │   ├── page.tsx
│   │   ├── profile/
│   │   ├── appointments/
│   │   └── orders/
│   │
│   ├── admin/
│   │   ├── page.tsx
│   │   ├── services/
│   │   ├── barbers/
│   │   ├── products/
│   │   ├── bookings/
│   │   ├── orders/
│   │   └── customers/
│   │
│   └── api/
│
├── components/
│   ├── ui/
│   ├── layout/
│   ├── marketing/
│   ├── booking/
│   ├── commerce/
│   └── admin/
│
├── lib/
│   ├── auth/
│   ├── db/
│   ├── booking/
│   ├── commerce/
│   ├── validation/
│   └── utils/
│
├── server/
│   ├── services/
│   ├── repositories/
│   └── actions/
│
├── types/
├── config/
└── styles/
```

---

## 5. Domain Boundaries

### Marketing domain

Read-heavy, public:
- pages
- services
- barbers
- gallery
- contact

### Booking domain

Transactional:
- availability
- appointment creation
- appointment cancellation
- booking status

### Commerce domain

Transactional:
- products
- cart
- checkout
- orders
- stock

### Identity domain

- authentication
- roles
- profile

### Admin domain

- management UI
- authorization
- operational updates

Keep these boundaries explicit so booking logic does not become coupled to product/cart logic.

---

## 6. Database Model

### users

```text
id
name
email
phone
password_hash
role
created_at
updated_at
```

Roles:
- `customer`
- `admin`

### services

```text
id
name
slug
description
price
duration_minutes
image_url
is_active
created_at
updated_at
```

### barbers

```text
id
name
slug
role
bio
image_url
is_active
created_at
updated_at
```

### barber_services

```text
barber_id
service_id
```

### bookings

```text
id
reference
user_id
service_id
barber_id
appointment_date
start_time
end_time
status
notes
created_at
updated_at
```

### products

```text
id
category_id
name
slug
description
price
stock
image_url
is_active
created_at
updated_at
```

### cart_items

```text
id
user_id
product_id
quantity
created_at
updated_at
```

### orders

```text
id
reference
user_id
subtotal
shipping_fee
total
payment_method
payment_status
status
shipping_address
created_at
updated_at
```

### order_items

```text
id
order_id
product_id
product_name_snapshot
unit_price
quantity
line_total
```

Use snapshots for purchased product name and price so historical orders remain accurate after product edits.

---

## 7. Booking Availability

Availability must be calculated from:

```text
Business hours
+ Barber availability
+ Barber time off
+ Existing bookings
+ Service duration
```

A slot is bookable only if:

1. service is active
2. barber is active
3. barber supports the service
4. appointment falls inside business hours
5. barber is not on leave/time off
6. no existing booking overlaps
7. requested time is not in the past

### Collision rule

Server-side validation must treat two intervals as conflicting when:

```text
new_start < existing_end
AND
new_end > existing_start
```

Do not rely on disabled UI buttons as the only protection.

Use a database transaction and an appropriate uniqueness/locking strategy to reduce race conditions.

---

## 8. Order / Stock Flow

```text
Cart
  |
  v
Checkout
  |
  v
Validate product + stock + price
  |
  v
Create order + order items
  |
  v
Update stock atomically
  |
  v
Clear cart
  |
  v
Order success
```

Never accept the final price from the browser as authoritative.

---

## 9. Authentication & Authorization

Public:
- read active services
- read active barbers
- read active products
- read company profile

Customer:
- create/view own bookings
- cancel own eligible bookings
- manage own cart
- create/view own orders
- manage own profile

Admin:
- manage all operational records
- access dashboard
- update statuses

Authorization must be enforced server-side.

---

## 10. UI Architecture

### Design system tokens

```text
colors/
  espresso
  near-black
  warm-cream
  brass
  taupe

spacing/
  section
  container
  component

radius/
  shell
  core
  pill

motion/
  reveal
  hover
  press
  modal
```

Use semantic tokens instead of scattering raw color values throughout components.

### Layout direction

Public marketing pages use an **Editorial Luxury** direction:
- asymmetric split layouts
- large serif display type
- warm cream and espresso palette
- strong photography
- generous whitespace
- restrained tactile interactions

Booking and checkout should prioritize clarity over experimentation. The premium aesthetic continues through typography, spacing, materials, and hierarchy, but transactional controls remain conventional and obvious.

---

## 11. Motion Architecture

Use Motion for React or CSS transitions.

Rules:
- animate transform and opacity
- use custom easing rather than generic `linear` or `ease-in-out`
- use IntersectionObserver or Motion viewport APIs for reveal
- avoid scroll event loops
- use reduced-motion fallback
- do not animate layout dimensions continuously
- do not over-animate forms and checkout

Suggested reveal:
```text
initial:
opacity 0
translateY 48px
blur 8px

animate:
opacity 1
translateY 0
blur 0
```

Use motion as hierarchy, not decoration.

---

## 12. Component Strategy

### Reusable marketing components

- `SiteHeader`
- `SiteFooter`
- `Hero`
- `SectionIntro`
- `ServiceCard`
- `BarberCard`
- `ProductCard`
- `GalleryGrid`
- `BookingCTA`

### Reusable transaction components

- `BookingStepper`
- `ServiceSelector`
- `BarberSelector`
- `DatePicker`
- `TimeSlotGrid`
- `BookingSummary`
- `CartItem`
- `CartSummary`
- `CheckoutForm`
- `OrderStatus`

### Admin

- `AdminSidebar`
- `DataTable`
- `StatusBadge`
- `FormDialog`
- `ConfirmDialog`
- `StatsCard`

Do not force marketing components into admin pages.

---

## 13. API / Server Action Boundaries

Suggested operations:

```text
GET  /services
GET  /services/:slug
GET  /barbers
GET  /products
GET  /products/:slug

POST /booking/availability
POST /bookings
GET  /account/bookings
PATCH /account/bookings/:id/cancel

GET  /cart
POST /cart/items
PATCH /cart/items/:id
DELETE /cart/items/:id

POST /checkout
GET  /account/orders
GET  /account/orders/:id

ADMIN
POST/PATCH/DELETE /admin/services
POST/PATCH/DELETE /admin/barbers
POST/PATCH/DELETE /admin/products
PATCH /admin/bookings/:id
PATCH /admin/orders/:id
```

Where practical, use server actions for internal mutations and route handlers for APIs that need an explicit HTTP boundary.

---

## 14. Validation

Use a schema validator such as Zod.

Validate:
- email
- phone
- password
- quantity
- IDs
- dates
- time
- service
- barber
- checkout fields

Validation must run both:
- client-side for immediate feedback
- server-side for security and correctness

---

## 15. Security

Minimum requirements:
- hash passwords with a proven password hashing algorithm
- secure session handling
- server-side authorization
- CSRF protection where applicable
- input validation
- output escaping
- rate limit login and sensitive endpoints
- do not expose secrets to client bundle
- do not trust client price, stock, role, or ownership
- sanitize uploaded media metadata
- audit admin mutations if feasible

---

## 16. SEO

Public pages should have:
- unique title
- meta description
- canonical URL
- Open Graph metadata
- descriptive image alt text
- semantic headings
- structured data where appropriate

Possible structured data:
- LocalBusiness/Barbershop
- Product
- BreadcrumbList

Only publish structured data fields backed by real business information.

---

## 17. Responsive Strategy

Breakpoints should be driven by content rather than device labels.

Mobile:
- single column
- no overlapping interactive elements
- touch-friendly controls
- compact but readable navigation

Desktop:
- editorial split layouts
- asymmetric grids
- larger typography
- more whitespace

Avoid using `h-screen` for full-height sections. Prefer viewport-safe sizing such as `min-height: 100dvh` when truly necessary.

---

## 18. Observability / Errors

User-facing:
- concise
- actionable
- no internal stack traces

Developer-facing:
- structured logs
- error IDs for server failures
- clear domain error types

Example:
`Slot 13:00 sudah tidak tersedia. Silakan pilih slot lain.`

Not:
`500 Internal Server Error`.

---

## 19. Deployment Shape

```text
Vercel / equivalent
   |
   +-- Next.js application
   |
   +-- PostgreSQL
   |
   +-- Object storage
```

Environment variables:
```text
DATABASE_URL
AUTH_SECRET
STORAGE_URL
STORAGE_KEY
STORAGE_SECRET
```

Never commit secrets.

---

## 20. Architecture Principles

1. Database is source of truth for transactional state.
2. Server validates every mutation.
3. Marketing UI and transactional UI have different density rules.
4. Reusable components should encode intent, not just visual appearance.
5. Avoid premature abstraction.
6. Prefer simple domain services over a giant generic service layer.
7. Keep visual polish separate from business correctness.
8. Accessibility and responsive behavior are first-class requirements.
