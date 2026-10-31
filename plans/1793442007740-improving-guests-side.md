# Implementation Plan: Improving Guests Side

## Goal
Improve the guest (not logged in) side of the Laravel-MIS public website. Change landing page to `/home`, rework hero/service/stats/announcements/lost-pets sections with guest-aware modals and UI polish.

## Current State (verified from codebase)

**Routes** (`routes/web.php`):
- `Route::get('/', ...)` named `landing` — redirects authenticated users to role dashboards; returns `Client.welcome` view for guests
- `Route::get('/home', ...)` named `public.home` — identical logic/view as `landing`
- `Route::get('/about-us', ...)` returns `Client.about_us` (view exists at `resources/views/Client/about_us.blade.php`)
- Public service routes: `/pet-registration`, `/kapon`, `/vaccination`, `/missing-pets`, `/adoption`

**View**: `resources/views/Client/welcome.blade.php` (1797 lines) — single Blade file containing all sections inline with embedded CSS/JS.

**Components**:
- `resources/views/components/announcement-modal.blade.php` — generic announcement detail modal (fetches `/announcements/{id}`)
- `resources/views/components/campaign-card.blade.php` — announcement card linking to `route('announcements.show', $announcement)`

**Navbar** (`resources/views/Client/partials/navbar.blade.php`): already links to `/about-us` and has guest Login/Register buttons.

**Model**: `MissingPetsReport` has `report_type` column (values: `missing`, `found`, etc.), table `missing_pets_reports`, primary key `report_id`.

## Reference Images (provided by user)
- `modalref1.png` — "Account Required" modal: Log In to Book / Create Free Account / Continue browsing services as Guest
- `modalref2.png` — "Explore Veterinary Services" guest modal with service list (Pet Registration, Spay & Neuter, Anti-Rabies Vaccination FREE, Lost & Found Pets, Pet Adoption)
- `announcementref1.png` — Announcement listing: Featured card + grid/slider, pill badge (CAMPAIGN / EVENT)
- `announcementmodalref1.png` — Featured announcement modal (FEATURED CAMPAIGN badge, guinea pigs image)
- `announcementmodalref2.png` — Regular announcement modal (CAMPAIGN badge, cat image)

---

## Tasks (split by section)

### Task 1: Landing Page Default Route
**File**: `routes/web.php`
- Change `Route::get('/', ...)` so unauthenticated guests are redirected to `route('public.home')` (`/home`) instead of rendering `Client.welcome` directly.
- Keep authenticated role-based redirect behavior unchanged.
- The `/home` route already returns `Client.welcome`; no view change needed here.

### Task 2: Hero Section (`#home`)
**File**: `resources/views/Client/welcome.blade.php`

**2a. "Book Veterinary Services" button → guest modal**
- Replace `href="{{ url('/pet-registration') }}"` with a JS trigger `openNotLoggedInModal()`.
- Modal 1 ("Account Required", per `modalref1.png`):
  - Title: "Account Required"
  - Body: "To book mobile clinic appointments, track your pet's vaccination records, and manage schedules in Dasmariñas City, please log in or create an account."
  - Benefits list (3 checkmarks): Instant booking for Spay/Neuter & Vaccinations; Digital Pet Passport & Vaccination Certificate; SMS reminders when the mobile clinic is in your barangay.
  - Primary button: "Log In to Book" → redirects to login route
  - Secondary button: "Create Free Account" → redirects to register route
  - Tertiary link: "Continue browsing services as Guest" → opens Modal 2
- Modal 2 ("Explore Veterinary Services", per `modalref2.png`):
  - Title: "Explore Veterinary Services"
  - Subtitle: "Select a service below to view details or begin booking."
  - Guest view badge
  - Service list: Pet Registration, Spay & Neuter (Kapon) [Low-cost], Anti-Rabies Vaccination [FREE badge], Lost & Found Pets, Pet Adoption
  - Each with "View Service" button
  - Footer: "Ready to make an appointment? Log In to Book Now →"
- Both modals: close on Escape and backdrop click; prevent body scroll when open.

**2b. "Explore Services" button → About Us**
- Change `href="#services"` to `href="{{ url('/about-us') }}"`.

### Task 3: Our Veterinary Services Section (`#services`)
**File**: `resources/views/Client/welcome.blade.php`

**3a. Card 1 "Register Pet"**
- Rename title: "Register Pet" → "Pet Registration"
- Rename button: "Register Now" → "Learn More"
- Button redirect: already `url('/pet-registration')` — keep

**3b. Card 2 "Spay/Neuter (Kapon)"**
- Rename button: "Book Spay/Neuter" → "Learn More"
- Button redirect: already `url('/kapon')` — keep

**3c. Card 3 "Lost Pets"**
- Rename title: "Lost Pets" → "Lost & Found Pets"
- Replace subtitle: "Report a lost pet or browse our database to help reunite lost pets with their owners." → "Report a lost pet or a found pet to help reunite lost pets with their owners."
- Button: keep "Report Lost Pet" → `url('/missing-pets')`

### Task 4: Stats Section
**File**: `resources/views/Client/welcome.blade.php`

**4a. Background**
- Change `bg-primary` (solid dark green) to a translucent green matching hero section overlay style (e.g., `bg-primary/80` with `backdrop-blur-md` or a gradient overlay), so it is not plain dark green.

**4b. Number animation**
- Add intersection-observer–based counter animation for the 5 stat numbers (pets registered, vaccinated, spayed/neutered, reunited, rehomed).
- Animate only on first time the section comes into view (use `data-animated` flag or one-time IntersectionObserver entry).

### Task 5: Announcements Section (`#updates`)
**File**: `resources/views/Client/welcome.blade.php`

**5a. Remove "View All News" link**
- Delete the `<a href="#">View all news</a>` link and its wrapper.

**5b. Featured + Carousel layout**
- Render 1 featured announcement as a larger card (per `announcementref1.png` featured style).
- Render remaining announcements in a 3-item grid; if more than 4 items total, use a smooth horizontal slider instead of grid.
- Remove left/right navigation arrows.
- Make scrollbar presentable (thin, styled thumb/track).
- Each announcement card uses pill/badge: "CAMPAIGN" or "EVENT" based on `$announcement->category` (green for campaign, blue for event).

**5c. "Read More" → modals**
- Replace `route('announcements.show', $announcement)` link with modal trigger.
- Featured announcement → modal per `announcementmodalref1.png` (FEATURED CAMPAIGN badge style).
- Regular announcements → modal per `announcementmodalref2.png` (CAMPAIGN badge style).
- Pill/badge color changes by category (campaign vs event).
- Modals can reuse `components/announcement-modal` with dynamic content, or be new inline modals on the welcome view.

### Task 6: Lost Pets / Adoption Gallery Section (`#lost-pets`)
**File**: `resources/views/Client/welcome.blade.php`

**6a. Found pet gallery modal**
- Query `MissingPetsReport::where('report_type', 'found')->get()` in the route/controller for `/home`.
- Pass found reports to the view.
- Add a "Found Pets" tab/button alongside "Lost Pets" and "Pets for Adoption".
- Clicking opens a gallery modal of found pets.
- If no found reports, show empty state (no error).

**6b. Universal empty state**
- Replace the two `@empty` blocks ("No lost pets found." / "No pets currently available for adoption.") with one universal empty-state component/partial used for all 3 galleries (missing, adoption, found).
- Empty state: icon, heading, message, centered.

**6c. "Adopt a Pet" button → guest account modal**
- On the "Pets for Adoption" tab, the "Adopt a Pet" CTA should open a modal prompting the guest to create an account (per `modalref1.png` "Account Required" pattern), since this is the guest view.
- Modal: prompt to log in or create an account to adopt.

---

## Data Flow / Route Changes Summary

| Item | From | To |
|------|------|----|
| `/` (landing) guest | render `Client.welcome` | redirect to `route('public.home')` |
| Hero "Book Veterinary Services" | `url('/pet-registration')` | guest modal (Account Required → Explore Services) |
| Hero "Explore Services" | `#services` | `url('/about-us')` |
| Services Card 1 title | "Register Pet" | "Pet Registration" |
| Services Card 1 button | "Register Now" | "Learn More" |
| Services Card 2 button | "Book Spay/Neuter" | "Learn More" |
| Services Card 3 title | "Lost Pets" | "Lost & Found Pets" |
| Services Card 3 subtitle | "...browse our database..." | "...a found pet to help reunite..." |
| Announcements "View All News" | link present | removed |
| Announcements layout | 3-card grid | featured + grid/slider (no arrows, styled scrollbar) |
| Announcements "Read More" | `route('announcements.show')` | modal (featured vs regular variants) |
| Lost Pets section | 2 tabs (missing, adoption) | 3 tabs (missing, adoption, found) + found modal |
| Empty states | 2 separate `@empty` blocks | 1 universal empty state |
| Adoption "Adopt a Pet" | `url('/adoption')` | guest account modal |

---

## Validation Checklist

- [ ] `http://127.0.0.1:8000/` redirects guests to `http://127.0.0.1:8000/home`
- [ ] Authenticated users still get role-based dashboard redirect on `/`
- [ ] Hero "Book Veterinary Services" opens Account Required modal for guests
- [ ] "Continue browsing services as Guest" opens Explore Veterinary Services modal
- [ ] Hero "Explore Services" navigates to `/about-us`
- [ ] Service cards renamed and buttons redirect correctly
- [ ] Stats section has translucent green background
- [ ] Stats numbers animate on first scroll into view only
- [ ] "View All News" removed from announcements
- [ ] Announcements show featured + grid/slider, no arrows, styled scrollbar
- [ ] Announcement "Read More" opens correct modal variant (featured vs regular)
- [ ] Badge/pill reflects campaign vs event category
- [ ] Found pets gallery modal works (empty state if no `report_type = found` data)
- [ ] Universal empty state used for all 3 galleries
- [ ] "Adopt a Pet" on guest view opens account creation modal

---

## Open Questions (to resolve before implementation)

1. Should the announcement modals reuse `components/announcement-modal.blade.php` (which fetches `/announcements/{id}` via AJAX) or be self-contained Blade modals rendered on the welcome view? Reusing the component avoids duplication but requires a controller route that returns modal HTML.
2. For the announcements "more than 4 items → horizontal slider": should the slider be pure CSS scroll-snap or a JS carousel library? Recommendation: CSS scroll-snap (no new dependencies).
3. For the found pets modal: should it reuse the existing `petDetailModal` JS or be a new modal? Recommendation: new modal scoped to found pets gallery.
