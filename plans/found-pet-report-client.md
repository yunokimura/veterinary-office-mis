# Found Pet Report — Database Migration Plan

## Goal
Add dedicated columns to `missing_pets_reports` for fields currently validated but not stored (breed) or stuffed into `body_marks` (gender, estimated_age, fur_colors, condition, eye_color variants). Update `storeFound()` to persist these fields in their own columns instead of combining them into `body_marks`.

## Current Schema (verified from migrations)

**`missing_pets_reports` table** (`create_missing_pets_reports_table.php`):
- `report_id` (PK), `user_id` (nullable FK), `pet_id` (nullable FK)
- `body_marks` (text, nullable)
- `eye_color` (string) — **already exists**, currently unused by storeFound()
- `collar_harness`, `last_seen_at`, `location_barangay`, `location_description`
- `emergency_contact`, `status` (enum), `timestamps`
- `report_type`, `reported_by_name`, `reporter_contact`, `reporter_email`, `photo_path`

**Missing columns** (need migration):
- `gender`, `estimated_age`, `breed`, `fur_colors`, `condition`, `eye_color_left`, `eye_color_right`, `eye_color_other`

## Affected Files

| File | Change |
|---|---|
| `database/migrations/XXXX_XX_XX_add_found_pet_fields_to_missing_pets_reports_table.php` | NEW — add 8 columns |
| `app/Models/MissingPetsReport.php` | Add new columns to `$fillable` |
| `app/Http/Controllers/Client/MissingPetReportController.php` | Update `storeFound()` validation + `create()` mapping |

## Migration Details

**New migration file:** `database/migrations/2026_10_18_XXXXXX_add_found_pet_fields_to_missing_pets_reports_table.php`

**`up()`:**
```php
Schema::table('missing_pets_reports', function (Blueprint $table) {
    $table->string('gender')->nullable();
    $table->string('estimated_age')->nullable();
    $table->string('breed')->nullable();
    $table->string('fur_colors')->nullable();
    $table->string('condition')->nullable();
    $table->string('eye_color_left')->nullable();
    $table->string('eye_color_right')->nullable();
    $table->string('eye_color_other')->nullable();
});
```

Column placement recommendation: add after `collar_harness` to group related pet-description fields together.

**`down()`:** Drop all 8 columns.

## Model Update (`MissingPetsReport.php`)

Add to `$fillable`:
```php
'gender',
'estimated_age',
'breed',
'fur_colors',
'condition',
'eye_color_left',
'eye_color_right',
'eye_color_other',
```

`eye_color` is already in the table but NOT in `$fillable` — add it too:
```php
'eye_color',
```

## Controller Changes (`storeFound()`)

### Validation — add missing rules:
```php
'eye_color_left' => 'nullable|string|max:255',
'eye_color_right' => 'nullable|string|max:255',
'eye_color_other' => 'nullable|string|max:255',
```

### Remove from body_marks combination:
- `gender` → now has its own column, remove from `$parts`
- `estimated_age` → now has its own column, remove from `$parts`
- `fur_colors` → now has its own column, remove from `$parts`
- `condition` → now has its own column, remove from `$parts`

### `MissingPetsReport::create()` — add dedicated column mappings:
```php
'breed' => $validated['breed'] ?? null,
'gender' => $validated['gender'] ?? null,
'estimated_age' => $validated['estimated_age'] ?? null,
'fur_colors' => $validated['fur_colors'] ?? null,
'condition' => $validated['condition'] ?? null,
'eye_color' => $validated['eye_color'] ?? null,
'eye_color_left' => $validated['eye_color_left'] ?? null,
'eye_color_right' => $validated['eye_color_right'] ?? null,
'eye_color_other' => $validated['eye_color_other'] ?? null,
```

Keep `body_marks` empty/null for found reports (all structured fields now have dedicated columns).

## Validation Steps for Implementation Agent

1. Run `php artisan migrate:status` — confirm no pending migrations before adding new one
2. Create migration file, run `php artisan migrate` — confirm 8 new columns added
3. Run `php artisan migrate:refresh` (in dev) — verify rollback works cleanly
4. Update model `$fillable` — run `php artisan tinker` and verify new columns are mass-assignable
5. Update controller validation + create mapping — submit valid found report, query DB to confirm each field lands in its own column:
   - `breed`, `gender`, `estimated_age`, `fur_colors`, `condition`, `eye_color`, `eye_color_left`, `eye_color_right`, `eye_color_other` all populated correctly
6. Submit report with Heterochromia + left/right eye colors — confirm `eye_color` = 'Heterochromia (Two different colors)', left/right columns populated
7. Submit report with Eye Color = Other + custom text — confirm `eye_color` = 'Other', `eye_color_other` populated

## Out of Scope

- Guest (unauthenticated) found pet reporting
- Found pet detail/show page, map markers, admin approval workflow
- Changing `report_type` hardcoded `'missing'` in `AdminAsst\MissingPetController`
- View changes (form already has correct field names)
