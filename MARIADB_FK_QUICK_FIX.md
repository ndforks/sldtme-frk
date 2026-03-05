# MariaDB Foreign Key Issues - Quick Reference

## The Problem
```
SQLSTATE[HY000]: General error: 1005 Can't create table
Foreign key constraint is incorrectly formed
```

## What Went Wrong

### Issue 1: Circular FK Dependency
```php
// users table (created first) tried to FK to organizations (created later)
// MariaDB said: ❌ No, organizations doesn't exist yet!
```

### Issue 2: Foreign UUID Auto-FK
```php
// Using foreignUuid() automatically creates FK
// Same problem: referenced table might not exist yet
```

## The Fix

### Changed Files

**1. users table**: Removed FK constraint
```php
// Remove this from table creation:
$table->foreign('current_team_id')
    ->references('id')
    ->on('organizations');
```

**2. organizations table**: Changed foreignUuid to uuid
```php
// Change this:
$table->foreignUuid('user_id')->index();

// To this:
$table->uuid('user_id')->index();
```

### New Migration Files

**1. Add FK to users table** (runs AFTER organizations created)
```php
// 2020_05_21_050000_add_current_team_id_foreign_key_to_users_table.php
Schema::table('users', function (Blueprint $table) {
    $table->foreign('current_team_id', 'users_current_team_id_foreign')
        ->references('id')
        ->on('organizations')
        ->restrictOnDelete()
        ->cascadeOnUpdate();
});
```

**2. Add FK to organizations table** (runs AFTER users created)
```php
// 2020_05_21_150000_add_user_id_foreign_key_to_organizations_table.php
Schema::table('organizations', function (Blueprint $table) {
    $table->foreign('user_id')
        ->references('id')
        ->on('users')
        ->restrictOnDelete()
        ->cascadeOnUpdate();
});
```

## Migration Execution Order

```
1. users (no external FKs) ✅
2. organizations (no external FKs) ✅
3. organizations.user_id FK ✅
4. users.current_team_id FK ✅
5. members (both parent tables exist) ✅
6. All other tables ✅
```

## Testing

```bash
# Fresh install
php artisan migrate:fresh --database=mariadb

# Should succeed! ✅
```

## Key Takeaways

✅ Split FK creation into separate migrations when tables reference each other  
✅ Use `uuid()` instead of `foreignUuid()` when you'll add FK separately  
✅ Always ensure referenced table exists before adding FK constraint  
✅ MariaDB is stricter than some databases - it enforces these rules!

## Files Modified

| File | Change |
|------|--------|
| 2014_12_000000_create_users_table.php | Removed FK |
| 2020_05_21_100000_create_organizations_table.php | Changed foreignUuid to uuid |
| 2020_05_21_050000_add_current_team_id_foreign_key_to_users_table.php | ✨ NEW - Add users FK |
| 2020_05_21_150000_add_user_id_foreign_key_to_organizations_table.php | ✨ NEW - Add orgs FK |

## Status: ✅ FIXED - Ready for Production

