# WEB-250 asgn11 Bird Solution

This instructor solution extends the existing WNC Birds CRUD project with member signup, login, logout, sessions, and protected Create/Update/Delete pages.

## Setup

1. Copy `.env.example` to `.env` and enter your local database credentials.
2. Run:

   ```bash
   composer install
   ```

3. Run `sql/create_members.sql` in the existing `wnc_birds` database.
4. Open `public/index.php` through MAMP/XAMPP.

## Access rules

- Visitors can view `birds.php` and `bird.php`.
- Members can also use `bird_new.php`, `bird_edit.php`, and `bird_delete.php`.
- Signup always assigns the role `member`.
- Passwords are stored with `password_hash()` and checked with `password_verify()`.
- Session data stores only the member ID, username, and role.

## PHP 8.1+ `htmlspecialchars()` fix

`private/functions.php` uses:

```php
function h($string = ''): string
{
    return htmlspecialchars((string) ($string ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
```

This prevents the PHP deprecation warning caused when `null` is passed to `htmlspecialchars()`.

## CSS

This solution intentionally contains no CSS file, no `<style>` block, no inline CSS, and no stylesheet link.
