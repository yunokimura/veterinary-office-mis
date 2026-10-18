# Found Pet Report - Client Side Plan

## Goal
Add a Found Pet Report feature on the client side for logged-in users, accessible from the modal's "Start Found Report" button on `/missing-pets`. The feature references the existing `/missing-pets/form` flow but is a standalone page tweaked for "Found Pet Report" semantics (no pet selection, required pet photo, found-specific fields).

## Context (verified against codebase)

- `missing_pets_reports` table already has `report_type` column (VARCHAR 20, default `'missing'`, indexed) and nullable `pet_id`/`user_id` — no migration needed.
- `MissingPetsReport` model already has `report_type` in `$fillable`.
- Guest controller (`GuestMissingPetReportController`) already supports `report_type = 'found'` via `?type=found` query param — proven pattern to follow.
- Authenticated `MissingPetReportController@store` hardcodes `report_type = 'missing'` — must be changed to accept `report_type` from request.
- Navbar already links "Lost & Found Pets" to `/missing-pets` (resources/views/Client/partials/navbar.blade.php:51, :142).
- Modal on `missing_pets_page.blade.php` has "Start Found Report" button (around line 936) — currently opens the same missing form; must redirect to new found-pets page.
- `/missing-pets/form` route (routes/web.php:1257) is `auth`-protected and passes `$user`, `$petOwner`, `$barangays` to `Client.missing_pets_form`.

## Design Decisions

| Decision | Recommendation | Rationale |
|---|---|---|
| Route pattern | `GET /found-pets/form` + `POST /found-pets/report` | User explicitly asked for a "new page" referencing `/missing-pets/form`, not a query-param variant. |
| Controller method | New `storeFound()` on `MissingPetReportController` | Keeps missing and found validation separate; avoids bloating the existing `store()` with conditional branches. |
| View | New `resources/views/Client/found_pets_form.blade.php` | Different section structure than missing form (no pet selection, required photo, found-specific fields). |
| photo storage disk | `public` disk, folder `found-pets` | Separates found-pet photos from missing-pet photos; consistent with existing `Storage::disk('public')->store(...)`. |
| report_type value | `'found'` | Matches guest controller and dashboard filter already in place. |
| status on create | `'pending review'` | Consistent with missing reports. |
| pet_id on found report | `null` | Found pets are not owned by the reporter; column is already nullable. |
| Pet record creation | No — report only | Do NOT create/update a `pets` row for found pets. Only create a `MissingPetsReport` row. |
| Post-submit redirect | `route('missing-pets')` with success flash | Returns user to the Lost & Found listing after submission. |

## Affected Files (read-only analysis — implementation agent edits these)

1. `routes/web.php` — add `GET /found-pets/form` and `POST /found-pets/report` routes (auth middleware).
2. `app/Http/Controllers/Client/MissingPetReportController.php` — add `storeFound(Request $request)` method with found-specific validation.
3. `resources/views/Client/found_pets_form.blade.php` — NEW view (4 sections per spec).
4. `resources/views/Client/missing_pets_page.blade.php` — change "Start Found Report" button to redirect to `route('found-pets.form')`.

## Found Pet Form View Structure (`Client.found_pets_form`)

**Layout:** Same as `missing_pets_form.blade.php` — `Client.partials.navbar`, main grid (form `lg:col-span-8`, sidebar `lg:col-span-4`), `Client.partials.footer`.

**Section 1 — "Found Pet Description" (replaces "Select Your Pet"):**
- Species: Dog / Cat (radio buttons or dropdown)
- Breed / Mix: text input (e.g., "Askal / Mixed Breed")
- Pet Photo Upload: **Required** file input (image, max 8192 KB)

**Section 2 — "Distinguishing Marks & Condition":**
- Eye Color: text input
- Collar/Harness description: text input
- Fur colors: text input
- Condition: text input (e.g., "Injured", "Friendly", "Wearing blue collar")

**Section 3 — "Time & Found Location":**
- Date & Time Found: datetime input (renamed from "Last Seen")
- Barangay: dropdown (from `$barangays`)
- Specific location notes: textarea

**Section 4 — "Reporter's Contact Info" (Right Sidebar):**
- Read-only profile card: name, email, phone, address (from `$petOwner` / `auth()->user()`)
- CVO staff can contact the person who spotted/rescued the pet

**Hidden fields submitted:** `report_type = 'found'`, `reported_by_name`, `reporter_contact`, `reporter_email` (populated from authenticated user/petOwner, read-only).

## Validation Rules (storeFound)

```
report_type => 'required|in:found'
species => 'required|in:Dog,Cat'
breed_mix => 'required|string|max:255'
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

**Combined datetime:** `Carbon::createFromFormat('Y-m-d H:i', $date_found.' '.$time_found)` stored in `last_seen_at` column (consistent with guest controller pattern).

**Report data:**
```
user_id => auth()->id()
pet_id => null
report_type => 'found'
reported_by_name => petOwner name or user name
reporter_contact => petOwner phone or user contact
reporter_email => user email
body_marks => condition + distinguishing marks combined
collar_harness => from input
last_seen_at => combined date_found + time_found
barangay_id => from input
location_description => location_notes
emergency_contact => reporter_contact
status => 'pending review'
photo_path => stored pet_photo path
```

## Confirmed Decisions (user-approved)

1. **Route naming**: `found-pets.form` / `found-pets.report.store`
2. **Post-submit redirect**: Redirect to `/missing-pets` with success flash
3. **Photo storage folder**: `found-pets` subfolder on public disk
4. **Condition field storage**: Combined into `body_marks` column (no migration)

## Validation Steps for Implementation Agent

1. Run `php artisan route:list` and confirm `/found-pets/form` and `/found-pets/report` appear with `auth` middleware.
2. Navigate to `/missing-pets`, open modal, click "Start Found Report" — should redirect to `/found-pets/form`.
3. Submit valid found report — confirm row inserted in `missing_pets_reports` with `report_type = 'found'`, `pet_id = NULL`, `status = 'pending review'`.
4. Submit invalid (missing photo, missing date) — confirm validation errors returned.
5. Confirm navbar "Lost & Found Pets" link still works and points to `/missing-pets`.

## Out of Scope

- Guest (unauthenticated) found pet reporting — deferred per user ("we'll get to the guest account-side later").
- Found pet detail/show page, map markers, or admin approval workflow for found reports.
- Changing `report_type` hardcoded `'missing'` in `AdminAsst\MissingPetController` — admin-side only.
- Database migration (none needed).
