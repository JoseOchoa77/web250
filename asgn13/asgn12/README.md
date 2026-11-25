# WEB-250 Assignment 12 — Tutorial starter

This project supplies a working Assignment 11 foundation plus seven clearly marked Assignment 12 edits. Start with the accompanying **`docs/asgn12_setup.md`**, then follow **`docs/asgn12_tutorial.md`** in order.

## Setup

1. Place this folder at `web250/asgn12` in your existing MAMP/XAMPP project area.
2. From this folder, run `composer install` using PHP 8.1 or later with PDO MySQL.
3. Copy `.env.example` to `.env` in this folder. Enter your own MySQL settings.
4. Compare your tables with `sql/reference_schema.sql`. Import it only to create missing tables in the intended database; it does not migrate an existing different schema or remove data.
5. Open `public/index.php` through your PHP server. The course example is `http://localhost:55000/web250/asgn12/public/index.php` when serving the `htdocs` folder.
6. Register two test accounts while signed out. In phpMyAdmin, promote only your intended admin test account as described in the setup guide.

Do not commit `.env`, database passwords, or `vendor/`. Commit `composer.json`, `composer.lock`, and `.env.example`. When deploying to a host without Composer, privately upload the generated `vendor` folder using your normal file-transfer method.

## Before the seven edits

Home, bird browsing, registration, login/logout, and member/admin Bird CRUD work after setup. Navigation shows a generic Logout link when signed in. Every admin route intentionally returns 403 until T01. Later incomplete methods return an empty array or `false`, so unfinished work never silently writes data.

| Marker | File | Your tutorial step |
|---|---|---|
| T01 | `private/functions.php` | Complete `is_admin()`. |
| T02 | `public/nav.php` | Personalize Logout and add the conditional admin link. |
| T03 | `private/classes/Member.php` | Complete `find_all()`. |
| T04 | `public/admin/member.php` | Look up the selected member by ID. |
| T05 | `private/classes/Member.php` | Complete `create_by_admin()`. |
| T06 | `private/classes/Member.php` | Complete `update_by_admin()`. |
| T07 | `private/classes/Member.php` | Complete `delete_by_admin()`. |

Replace each marked region once. T02 replaces the whole shared navigation file. All six admin page structures and their forms are provided. Keep the supplied authorization, validation, hashing, escaping, and CSRF checks.

## Finished application permissions

| Role | Read birds | Change birds | Manage members |
|---|---|---|---|
| Visitor | Yes | No | No |
| Member | Yes | Yes | No |
| Admin | Yes | Yes | Yes |

The admin pages are `index.php`, `members.php`, `member.php`, `new_member.php`, `edit_member.php`, and `delete_member.php`, all inside `public/admin`.

The real session stores the member ID. The current first name and role are read from MySQL. Public signup always creates a member. Admin editing preserves the existing password hash; password resets are outside this assignment.

## My completion notes — fill in before submission

**Student:** [your name]  
**Project description:** [brief description]  
**GitHub asgn12 URL:** [link]  
**Webhost public URL:** [link]  
**Branch:** `dev-admin-roles`, merged into `main` after testing

### Test results

Replace the blank cells with Pass/Needs work and a short note. Record the actual result, not the expected result.

| Check | Local result | Webhost result |
|---|---|---|
| Visitor can read birds and is denied Bird writes/admin pages | | |
| Member can manage birds and is denied admin pages, including POST | | |
| Admin can manage birds and members | | |
| Personalized menu and nested admin links | | |
| Create validates roles, uniqueness, and password | | |
| Update saves fields, preserves password, and blocks self-demotion | | |
| Delete confirms, uses POST, and blocks self-deletion | | |
| Invalid IDs / missing rows produce appropriate responses | | |
| Invalid CSRF token makes no database change | | |
| Private files denied on the host | Local-only server may ignore `.htaccess` | |

**Known remaining issues:** [none, or describe accurately]

### Explain these four ideas in your own words

1. Why do we need `require_admin()` when the Admin link is already hidden?

   [Your explanation]

2. What does `from_row()` return, and how does the member list use it?

   [Your explanation]

3. Why does updating a member preserve their password?

   [Your explanation]

4. Why does Delete use a confirmation GET followed by a checked POST?

   [Your explanation]

Submit the two required links in Moodle. The two sandboxes are optional, ungraded, local practice and are not submitted.
