# Found Pet Report - Client Side Plan

## Goal
Add a Found Pet Report feature on the client side for logged-in users, accessible from the modal's "Start Found Report" button on `/missing-pets`. The feature references the existing `/missing-pets/form` flow but is a standalone page tweaked for "Found Pet Report" semantics (no pet selection, required pet photo, found-specific fields).

## Context (verified against codebase)

- `missing_pets_reports` table already has `report_type` column (VARCHAR 20, default `'missing'`, indexed) and nullable `pet_id`/`user_id` — no migration needed.
- `MissingPetsReport` model already has `report_type` in `$fillable`.
- Guest controller (`GuestMissingPetReportController`) already supports `report_type = 'found'` via `?type=found` query param — proven pattern to follow.
- Authenticated `MissingPetReportController@store` hardcodes `report_type = 'missing'` — separate `storeFound()` method added.
- Navbar already links "Lost & Found Pets" to `/missing-pets` (resources/views/Client/partials/navbar.blade.php:51, :142).
- Modal on `missing_pets_page.blade.php` has "Start Found Report" button — redirects to `route('found-pets.form')` when logged in.
- `/found-pets/form` and `/found-pets/report` routes already registered (routes/web.php) with auth middleware.
- `storeFound()` controller method already added to `MissingPetReportController`.

## Design Patterns to Reference

| Element | Source File | Pattern |
|---|---|---|
| Pill buttons | `resources/views/Client/adoption_form.blade.php` (step 2) | Radio input `sr-only peer` + styled `span` pill: `px-3 py-1.5 rounded-full border border-gray-300 text-gray-700 text-sm bg-white cursor-pointer peer-hover:border-emerald-200 peer-hover:bg-emerald-50 peer-hover:text-emerald-700 peer-checked:border-emerald-600 peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:ring-2 peer-checked:ring-emerald-400 peer-checked:ring-offset-1 peer-checked:shadow-sm` |
| Breed dropdown/modal | `resources/views/Client/pet_registration_form.blade.php` (Step 2) | Button-triggered modal using `public/js/breeds.js` (`catBreeds`, `dogBreeds`, `quickDogBreeds`, `quickCatBreeds` arrays). Hidden input `name="pet_breed" required`. Display button shows selected breed text. |
| Pet Photo upload | `resources/views/Client/pet_registration_form.blade.php` (Step 2, Unique Body Mark) | Click-to-upload square: `relative border-2 border-dashed border-slate-300 rounded-xl aspect-square hover:border-emerald-400 transition-colors min-h-[144px] w-36 md:w-48` with hidden file input, preview image, remove button, and centered upload button with camera icon. |
| Eye Color pills | `resources/views/Client/pet_registration_form.blade.php` (Step 2) | Pill buttons with options: Brown, Blue, Amber / Yellow, Green, Heterochromia (Two different colors), Other. Conditional text input for "Other". |
| Barangay modal | `resources/views/Client/missing_pets_form.blade.php` | Button-triggered modal with search bar, alphabetical listing, empty state. JS: `openBarangayModal()`, `closeBarangayModal()`, `renderBarangayModal(filter)`, `filterBarangayModal()`, `handleBarangaySelect(id, name)`. Hidden input for barangay_id. |

## Affected Files

1. `routes/web.php` — DONE: `GET /found-pets/form` and `POST /found-pets/report` routes registered.
2. `app/Http/Controllers/Client/MissingPetReportController.php` — DONE: `storeFound()` method added.
3. `resources/views/Client/found_pets_form.blade.php` — NEEDS DESIGN UPDATES (see below).
4. `resources/views/Client/missing_pets_page.blade.php` — DONE: "Start Found Report" button redirects to `route('found-pets.form')` when logged in.

## Found Pet Form View Changes (`Client.found_pets_form`)

### Change 1: Remove "Required"/"Optional" labels
- Section 1 header: Remove `<span class="text-xs text-emerald-300">Required</span>`
- Section 2 header: Remove `<span class="text-xs text-emerald-300">Optional</span>`
- Section 3 header: Remove `<span class="text-xs text-emerald-300">Required</span>`
- Section titles remain without requirement indicators in the header (required fields still marked with `<span class="text-red-500">*</span>` in labels).

### Change 2: Species → Pill buttons (adoption/form step 2 pattern)
- Replace current radio button layout with pill buttons for Dog/Cat
- Radio input: `sr-only peer`, span styled as pill button
- Field name stays `species`, values `Dog`/`Cat`

### Change 3: Breed / Mix → Breed dropdown (pet-registration/form Step 2 pattern)
- Rename label from "Breed / Mix" to "Breed"
- Replace text input with button-triggered dropdown/modal using `public/js/breeds.js`
- Hidden input: `name="breed" required` (replaces `breed_mix`)
- Include `{{ asset('js/breeds.js') }}` script in view
- JavaScript: populate breed options based on species selection, modal with search

### Change 4: Pet Photo upload redesign (pet-registration/form Step 2 body mark pattern)
- Replace standard file input with click-to-upload square:
  - Container: `relative border-2 border-dashed border-slate-300 rounded-xl aspect-square hover:border-emerald-400 transition-colors min-h-[144px] w-36 md:w-48`
  - Hidden file input: `name="pet_photo" accept="image/*" required`
  - Preview image: `w-full h-full object-cover rounded-lg hidden`
  - Remove button: `×` (red, hidden initially)
  - Upload overlay button: camera icon + "Click to upload"
- Keep `required` attribute on file input

### Change 5: Eye Color → Pill buttons (pet-registration/form Step 2 pattern)
- Replace text input with pill buttons for: Brown, Blue, Amber / Yellow, Green, Heterochromia (Two different colors), Other
- Radio input: `peer sr-only`, span styled as pill
- Conditional text input for "Other" (shown when "Other" selected)
- Field name stays `eye_color`

### Change 6: Barangay → Modal (missing pet form pattern)
- Replace `<select>` dropdown with button-triggered modal
- Include barangay modal HTML (from missing_pets_form.blade.php lines 399-450)
- Include barangay modal JS functions (open/close/render/filter/select)
- Hidden input: `name="barangay_id" required`

### Layout
- Same as `missing_pets_form.blade.php` — `Client.partials.navbar`, main grid (form `lg:col-span-8`, sidebar `lg:col-span-4`), `Client.partials.footer`.
- Section 1: Found Pet Description (Species pills, Breed dropdown, Pet Photo upload)
- Section 2: Distinguishing Marks & Condition (Eye Color pills, Collar/Harness, Fur Colors, Condition)
- Section 3: Time & Found Location (Date & Time Found, Barangay modal, Location Notes)
- Section 4: Reporter's Contact Info (Right sidebar, read-only profile card)

## Validation Rules (storeFound) — Updated

```
report_type => 'required|in:found'
species => 'required|in:Dog,Cat'
breed => 'required|string|max:255'       // renamed from breed_mix
pet_photo => 'required|image|max:8192'
eye_color => 'nullable|string|max:255'
collar_harness => 'nullable|string|max:255'
fur_colors => 'nullable|string|max:255'
condition => 'nullable|string|max:255'
date_found => 'required|date'
time_found => 'required'
barangay_id => 'required|integer|exists:barangays,barangay_id'
location_notes => 'nullable|string|max:2000'
```

## Confirmed Decisions (user-approved)

1. **Route naming**: `found-pets.form` / `found-pets.report.store`
2. **Post-submit redirect**: Redirect to `/missing-pets` with success flash
3. **Photo storage folder**: `found-pets` subfolder on public disk
4. **Condition field storage**: Combined into `body_marks` column (no migration)

## Validation Steps for Implementation Agent

1. Run `php artisan route:list` and confirm `/found-pets/form` and `/found-pets/report` appear with `auth` middleware.
2. Navigate to `/missing-pets`, open modal, click "Start Found Report" — should redirect to `/found-pets/form`.
3. Verify Species pill buttons render correctly (Dog/Cat toggle).
4. Verify Breed dropdown/modal opens and populates based on species selection.
5. Verify Pet Photo click-to-upload square works with preview and remove.
6. Verify Eye Color pill buttons work with "Other" conditional input.
7. Verify Barangay modal opens, searches, and selects correctly.
8. Submit valid found report — confirm row inserted in `missing_pets_reports` with `report_type = 'found'`, `pet_id = NULL`, `status = 'pending review'`.
9. Submit invalid (missing photo, missing date, missing breed) — confirm validation errors returned.

## Out of Scope

- Guest (unauthenticated) found pet reporting — deferred.
- Found pet detail/show page, map markers, or admin approval workflow.
- Changing `report_type` hardcoded `'missing'` in `AdminAsst\MissingPetController`.
- Database migration (none needed).
