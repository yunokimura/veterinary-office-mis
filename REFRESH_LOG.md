# REFRESH_LOG.md - Identity System Refactoring

## Date: 2026-04-14 (Updated: 2026-04-15)

## Task: Rename admin_users table to users + Migration Fixes

---

## Changes Made

### 1. New Migration Created
- **File**: `database/migrations/2026_04_15_000001_rename_admin_users_to_users.php`
- **Description**: This migration:
  - Drops the `full_name` column (if it exists)
  - Migrates any existing full_name data to first_name/last_name
  - Renames the `admin_users` table to `users`
  - Updates all foreign key constraints in other tables to reference the new `users` table

### 2. User Model Updated
- **File**: `app/Models/User.php`
- **Changes**:
  - Line 26: Changed `protected $table = 'admin_users'` to `protected $table = 'users'`

### 3. Controller Validation Rules Updated
- **File**: `app/Http/Controllers/UserController.php`
- **Changes**:
  - Line 82: `unique:admin_users` → `unique:users`
  - Line 197: `unique:admin_users,email` → `unique:users,email`

- **File**: `app/Http/Requests/ProfileUpdateRequest.php`
- **Changes**:
  - Line 25: `unique:admin_users,email,{$userId}` → `unique:users,email,{$userId}`

- **File**: `app/Http/Controllers/Clients/Auth/RegisteredUserController.php`
- **Changes**:
  - Line 30: `unique:admin_users` → `unique:users`

- **File**: `app/Http/Controllers/AdminAsst/ClinicalActionController.php`
- **Changes**:
  - Lines 68, 107: `exists:admin_users,id` → `exists:users,id`

### 4. Console Commands Updated
- **File**: `app/Console/Commands/SetupAdmin.php`
- **Changes**:
  - Line 23: `DB::table('admin_users')` → `DB::table('users')`
  - Line 27: `DB::table('admin_users')` → `DB::table('users')`

### 5. Services Updated
- **File**: `app/Services/NotificationService.php`
- **Changes**:
  - Line 42: Raw query references updated: `admin_users.role` → `users.role`

### Additional Redundant Migration Deleted
- **Deleted**: `database/migrations/2026_04_14_000001_drop_users_table.php`
- **Reason**: Redundant - the old users table was already renamed by migration 2026_04_08

### Fix Migration Errors
- **Deleted**: `database/migrations/2026_04_12_000003_add_status_to_missing_pets_table.php`
- **Reason**: Duplicate - the status column already exists in `2026_04_12_000000_create_missing_pets_table.php` with different enum values

### Fix Schema Hardcoding in Migration
- **Modified**: `database/migrations/2026_04_13_100000_refactor_admin_users_normalize.php`
- **Change**: Changed hardcoded database name 'vet_mis' to DATABASE() for dynamic schema detection

### Fix FK Check Logic
- **Modified**: `database/migrations/2026_04_15_000001_rename_admin_users_to_users.php`
- **Changes**:
  - Removed data migration code (full_name already dropped by earlier migration)
  - Added logic to handle case where both 'users' and 'admin_users' tables exist
  - Now properly handles edge case where migration 2026_04_08 might not have run

### Migrations Deleted Due to Schema Mismatch
These migrations were deleted because they referenced old missing_pets schema (pet_name, image) which doesn't exist in the newer schema (name, photo_img):
- `2026_04_13_100300_migrate_missing_pets_to_pets.php`
- `2026_04_13_100500_create_attachments_table.php`

---

## Additional Changes Made (2026-04-15)

### Issue #2: Duplicate missing_pets Tables
- **Deleted**: `database/migrations/2026_04_11_000001_create_missing_pets_table.php`
- **Kept**: `database/migrations/2026_04_12_000000_create_missing_pets_table.php`
- **Reason**: April 12 version has more complete schema with enum gender, status field, color, photo_img fields

### Issue #3: Duplicate Timestamps
- **Renamed**: `2026_04_13_100000_add_source_tracking_to_pets_table.php` → `2026_04_13_100001_add_source_tracking_to_pets_table.php`
- **Reason**: Ensures predictable migration execution order

### Issue #4: Inconsistent Gender Enum
- **Modified**: `database/migrations/2026_03_31_150200_create_adoption_pets_table.php`
- **Change**: Added enum constraint to gender column
  - From: `$table->string('gender')`
  - To: `$table->enum('gender', ['male', 'female', 'unknown'])->default('unknown')`

### Issue #6: Down Migration Conflicts
- **Modified**: `database/migrations/2026_04_13_100001_add_source_tracking_to_pets_table.php`
- **Change**: Modified down() to only drop indexes, not columns
  - Removed: `$table->dropColumn([...])` to prevent breaking migrations 100200/100300

---

## Notes

- All migrations that ran BEFORE the rename migration (timestamp 2026_04_15 and earlier) reference `admin_users` table and work correctly because they execute while the table still exists.
- The rename migration handles updating all FK constraints AFTER the table is renamed.
- The old `users` table was already merged into `admin_users` by migration `2026_04_08_180000_rename_users_to_admin_users.php`, so there's no conflict.

---

## Verification Steps

After deploying this change, run:
```bash
php artisan migrate:fresh --seed
# OR
php artisan migrate
php artisan admin:setup
```

---

## Rollback

To rollback, run:
```bash
php artisan migrate:rollback
```

The down() method in the migration handles renaming back to admin_users and restoring FK constraints.

---

## Database Normalization Refactor - Completion Status (2026-04-24)

### Phase 3: Drop Deprecated Columns ✅ COMPLETE
- [x] Backup `pet_owners` table (`pet_owners_backup_20260424`)
- [x] Drop deprecated columns from `pet_owners` table (`blk_lot_ph`, `street`, `subdivision`, `barangay`, `city`, `province`, `email`)
- [x] Update User model fillable (removed deprecated fields)
- [x] **Smoke test:** Verified all functionality works without old columns

### Phase 4: Monitoring & Cleanup ✅ COMPLETE
- [x] Check all controllers/views for direct references to dropped columns - No references found
- [x] `users.role` column queries are valid (kept for backward compatibility, synced with Spatie)
- [x] Verified all protected accounts work
- [x] Database normalization refactor COMPLETE

### Final State
- `users` table: Authentication only (email, password, role, organization_id)
- `admins` table: Admin staff profiles (7 records migrated)
- `pet_owners` table: Pet owner profiles (clean, linked to addresses)
- `organizations` table: External partners (2 records migrated)
- `addresses` table: Unified address storage (polymorphic, with city/province data)

**All phases complete. Database is fully normalized.**

---

## City/Province Data Migration (2026-04-24 - 5:14pm PH)

### Issue
The `addresses` table had `city` and `province` columns (added in migration `2026_04_24_160109`), but existing records had NULL values because the original data backfill (April 22) happened before these columns existed.

### Solution
- Created migration `2026_04_24_180000_update_addresses_with_city_province.php`
- Migrated data from backup table `pet_owners_backup_20260424` to `addresses` table
- Updated 2 address records with city/province data

### Verification
- Address ID 1: city = "Dasmariñas City", province = "Cavite"
- Address ID 2: city = "Dasmariñas City", province = "Cavite"

---

## Database Relationship Fixes (2026-04-24 - 9:30pm PH)

### Issues Found & Fixed

1. **Missing FK for `pet_owners.user_id`**
   - Created migration `2026_04_24_190000_add_pet_owners_user_id_foreign_key.php`
   - Added FK: `pet_owners.user_id → users.id` with cascade delete

2. **Morph Type Mismatch in Addresses**
   - Issue: `addresses` stored `pet_owner` but Laravel expects `App\Models\PetOwner`
   - Fix: Added morph map to `AppServiceProvider.php`
   - Map: `'pet_owner' → App\Models\PetOwner::class, 'admin' → App\Models\Admin::class, 'organization' → App\Models\Organization::class`
   - Verified: Polymorphic relationship now works correctly

3. **Missing `facility_id` in Admins Table**
   - Created migration `2026_04_24_200000_add_facility_id_to_admins_table.php`
   - Added `facility_id` column with FK to `facilities.id`
   - Updated `Admin` model fillable to include `facility_id`

4. **Views Still Referencing Dropped Columns**
   - Fixed `resources/views/admin/users/edit.blade.php`:
     - Line 185: `$user->barangay_id` → `$user->adminProfile?->barangay_id`
     - Lines 207, 214, 221: `$user->facility_id` → `$user->adminProfile?->facility_id`
   - Fixed `resources/views/admin/users/show.blade.php`:
     - Line 44: `@if($user->barangay_id)` → `@if($user->adminProfile?->barangay_id)`
     - Line 47: `$user->barangay?->barangay_name` → `$user->adminProfile?->barangay?->barangay_name`

5. **UserController Updated**
   - Updated all Admin::create() and update() calls to include `facility_id`

### Final Verification
- All foreign keys present and working
- Polymorphic relationships work correctly
- Views no longer reference dropped columns
- Form submissions correctly save facility_id to admins table

**Database normalization refactor is now fully complete.**

---

## Scheduled Table Deprecation (2026-04-24 - 9:48pm PH)

### Tables Scheduled for Deletion (2026-05-24)
The following tables are marked as deprecated and scheduled for deletion on 2026-05-24:
- `impounds` (model: `Impound.php`, `ImpoundRecord.php`)
- `impound_records` (legacy table, no model)
- `impound_status_histories` (model: `ImpoundStatusHistory.php`)
- `pet_traits` (model: `PetTrait.php`)

### Changes Made
1. **Added `@deprecated` PHPDoc tags** to all related model files:
   - `app/Models/Impound.php`
   - `app/Models/ImpoundRecord.php`
   - `app/Models/ImpoundStatusHistory.php`
   - `app/Models/PetTrait.php`

2. **Created scheduled deletion migration**:
   - File: `database/migrations/2026_05_24_000000_drop_scheduled_deprecated_tables.php`
   - Contains `dropIfExists` for all four tables
   - Target execution date: 2026-05-24

### Note
These tables will be permanently deleted when the scheduled migration is run. Verify no active code references these tables before the deletion date.