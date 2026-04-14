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