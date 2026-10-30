# Plan: Redesign "My Registered Pets" section pet cards

**File:** `resources/views/Client/owner_dashboard.blade.php`
**Scope:** Only the "My Pets" section (lines ~167-378) → renamed "My Registered Pets" with redesigned pet cards. Everything else untouched. Content/data unchanged except removal of Download Vaccine Passport buttons; only design/layout changes otherwise.

## Goal
- Rename section heading "My Pets" → "My Registered Pets".
- Remake each pet card's design to match the provided reference HTML pet-card design (slate card, stats grid, rabies badge, lucide icons, chevron footer).
- Preserve all existing PHP data logic: pet image path, vaccination status ($vaxColor/$vaxHeading/$vaxSub), age computation ($ageDisplay), neutered status, weight, View Profile button, search input.
- Remove the "Download Vaccine Passport" icon button from each pet card footer.

## Decisions

1. **Color system** — Add a `dasma` emerald palette to this view's existing `tailwind.config.extend.colors` (slate/rose/emerald are default Tailwind, no config needed). Scoped to this view only.
   - dasma-50/100/500/600/700/800/900 (from reference HTML).

2. **Icons** — Lucide is an accepted pattern in this codebase (used in `dashboard/vaccination-appointments.blade.php`, `reports/spay_neuter_index.blade.php`). Add `<script src="https://unpkg.com/lucide@latest"></script>` + `lucide.createIcons()` call to this view, and replace the pet-card inline SVGs with `data-lucide` icons (`paw-print` in section header, `alert-circle`/`check-circle-2` in rabies badge, `chevron-right` in footer, `search` in search input).

3. **Footer buttons** — Keep only "View Profile" (solid, per new design). Remove "Download Vaccine Passport" button per user request. Do NOT fabricate an "Updated date" (no data source).

4. **Search** — Add `data-name` and `data-species` attributes to each card and wire the existing `#petSearch` input to a `filterPets()` function (the input currently exists but is non-functional). This is part of adopting the reference design's searchable cards.

## On the open question: dasma classes need tailwind.config

This view uses the Tailwind CDN (`<script src="https://cdn.tailwindcss.com"></script>`), which JIT-compiles utility classes client-side. Each blade view in this codebase defines its own inline `<script> tailwind.config = { ... } </script>` block. The current `owner_dashboard.blade.php` defines only `primary` and `secondary` colors.

Utility classes like `bg-dasma-500`, `text-dasma-600`, `border-dasma-200` are generated only if `dasma` is defined in `tailwind.config.theme.extend.colors`. If `dasma` is NOT added to this view's config, those classes resolve to nothing at runtime — the pet cards would render without the emerald/green coloring (rabies badges, status text, accents all fall back to unstyled/default gray). So step 1 (adding `dasma` to this view's `tailwind.config.extend.colors`) is required for the reference design's color classes to actually render.

## Changes (in order)

1. Add `dasma` colors to the view's `tailwind.config.extend.colors` block.
2. Add lucide `<script>` tag (head) and `lucide.createIcons()` call (before `</body>`).
3. Section header: change heading "My Pets" → "My Registered Pets"; swap inline SVG icon for lucide `paw-print`; restyle header wrapper to reference design (`border-b border-slate-200 pb-2`, etc.). Keep subtext and search/Add New Pet content unchanged.
4. Pet card container: `pet-card bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all overflow-hidden flex flex-col justify-between` + `data-name`/`data-species` attributes.
5. Card top: image (or `bg-dasma-800` letter avatar) + pet name + species badge + breed • PET-ID line.
6. Stats grid: `grid grid-cols-2 gap-2 my-4 p-2.5 bg-slate-50 rounded-xl text-xs` with "Gender & Age" and "Weight / Status" rows, reusing existing `$ageDisplay` and neutered/weight data.
7. Rabies badge: reuse existing `$vaxColor`/`$vaxIconColor`/`$vaxTextColor`/`$vaxHeading`/`$vaxSub` variables; lucide `alert-circle` or `check-circle-2`.
8. Footer: "View Profile" button (lucide chevron-right) only — remove Download Vaccine Passport button; on `bg-slate-50 border-t` bar.
9. Keep the empty-state "No pets registered yet" block unchanged (content only; optional minor restyle to match card aesthetic, but no content change).
10. Remove the now-redundant per-image "Vaccinated" overlay badge (status moved into the rabies badge; info preserved).

## Validation
- Open the dashboard in a browser (Laravel dev server) as an authenticated pet owner.
- Confirm section reads "My Registered Pets".
- Confirm pet cards render with new design, image/avatar, stats grid, rabies badge, and View Profile footer button (no Download Vaccine Passport button).
- Confirm search input filters cards by name/species.
- Confirm no console errors (lucide loaded, `createIcons()` called after DOM ready).
- Confirm dasma color classes resolve (rabies badges show emerald/rose colors, not unstyled gray).
- Run any lint/typecheck if the project provides one (none identified for blade files).

## Risks / open questions
- None remaining. dasma config requirement addressed in step 1. Download Vaccine Passport removal confirmed.
