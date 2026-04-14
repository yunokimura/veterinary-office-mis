# REFRESH_LOG.md - Identity System Refactoring

## Date: 2026-04-14

## Task: Rename admin_users table to users

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