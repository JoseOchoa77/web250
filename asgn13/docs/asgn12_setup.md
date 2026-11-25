# WEB-250 Assignment 12 — Setup and recovery guide

Use this guide with the **new tutorial student package**. It supplies a common, working Assignment 11 foundation so that an unfinished earlier assignment does not prevent you from learning Assignment 12.

## 1. Put the two folders in the correct place

Keep your earlier assignments. If you already have an `asgn12` folder, save that work before putting this new starter in its place. Do not combine individual files from different versions.

Extract the student ZIP. Copy its **`asgn12`** and **`asgn12_sandbox`** folders into your existing `web250` folder. Keep `docs` somewhere convenient to read; it does not need to be uploaded to your webhost.

| Computer | Application folder | Sandbox folder |
|---|---|---|
| macOS with MAMP | `/Applications/MAMP/htdocs/web250/asgn12` | `/Applications/MAMP/htdocs/web250/asgn12_sandbox` |
| Windows with XAMPP | `C:\xampp\htdocs\web250\asgn12` | `C:\xampp\htdocs\web250\asgn12_sandbox` |

Open **the `asgn12` folder** in VS Code. It contains `composer.json`, `.env.example`, `private`, and `public`. The actual `.env` file and the generated `vendor` folder are created during setup.

## 2. Install the supplied dependency

Open VS Code's integrated terminal. Confirm that its current folder is `asgn12`, then run:

```bash
php -v
composer install
```

Use PHP **8.1 or later**. The PHP installation must include the PDO MySQL extension. The package supplies `composer.json` and `composer.lock`; Composer installs the listed dependency versions and generates `vendor/autoload.php`. You do not type that autoloader yourself. See [Composer's basic usage documentation](https://getcomposer.org/doc/01-basic-usage.md).

If `php` or `composer` is not recognized, use the PHP/Composer setup from Assignment 11. On Windows, the PHP executable is normally `C:\xampp\php\php.exe`. On macOS, use the PHP executable in **your installed MAMP PHP version**; the version folder differs between computers. Do not change your working server simply to match a screenshot.

## 3. Make the environment file

In VS Code, copy `.env.example` and name the copy **`.env`**. Put it directly inside `asgn12`, beside `composer.json`. Make sure its name is not `.env.txt`.

Use your existing working database settings:

```dotenv
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=wnc_birds
DB_USER=your_db_username
DB_PASS="your_db_password"
```

These are **placeholders**, not supplied credentials. MAMP may use a different MySQL port, such as 8889; use the port shown by your own installation. The **MySQL port** in `.env` and the **website port** in the browser are different settings. Copy the actual values from your working Assignment 11 `.env` when possible. Quote a value that includes spaces or `#`.

The initializer calls `Dotenv::createImmutable($project_root)->load()`. That directory is why `.env` belongs in the project root. See the [phpdotenv documentation](https://github.com/phpdotenv/phpdotenv).

The included `.gitignore` excludes `.env` and `vendor/` while allowing `.env.example`. Check your own repository before committing; adding an ignore rule does not remove a secret that Git already tracks.

## 4. Confirm the database structure

Start MySQL in MAMP or XAMPP. In phpMyAdmin, select your existing `wnc_birds` database and compare its structure with `asgn12/sql/reference_schema.sql`.

| Table | Columns used by this starter |
|---|---|
| `birds` | `id`, `common_name`, `scientific_name`, `family_name`, `primary_habitat`, `seasonal_status`, `description` |
| `members` | `id`, `first_name`, `last_name`, `email`, `username`, `password_hash`, `role` |

These names match the supplied recent Assignment 11/12 course solutions. Extra columns are fine if they do not impose additional required values on inserts.

**Existing course database:** keep it and its records. The reference SQL uses `CREATE TABLE IF NOT EXISTS`; it does not repair differently named columns in an existing table. If your structure differs, stop and compare it with your instructor before altering it.

**Missing tables or a fresh demonstration database:** select the intended database first, then import `sql/reference_schema.sql`. The script creates missing tables without dropping existing tables or inserting accounts. A new birds table can start empty; after signing in, use Create Bird to add a practice record. Keep your actual course bird data when it is already available.

## 5. Open the website through PHP

Use your working MAMP/XAMPP website address. The examples in this tutorial assume:

```text
http://localhost:55000/web250/asgn12/public/index.php
```

If your server uses a different port, substitute that port consistently. Do not open a PHP file by double-clicking it in Finder or File Explorer.

If you have been using PHP's local server in VS Code, start it **from the folder that contains `web250`**, not from `asgn12/public`:

**macOS**

```bash
cd /Applications/MAMP/htdocs
php -S localhost:55000
```

**Windows PowerShell**

```powershell
cd C:\xampp\htdocs
C:\xampp\php\php.exe -S localhost:55000
```

Leave that terminal running. MySQL must still be running separately. If your existing Apache server already uses port 55000, use that running server; do not start a second server on the same port. The local PHP server is for local practice. Use the normal Apache/PHP hosting setup for the webhost submission.

## 6. Make two test accounts

Use **Register** to create two accounts with distinct usernames and email addresses:

| Purpose | Suggested first name | Suggested username | Initial role |
|---|---|---|---|
| Ordinary member test | Riley | `member_demo` | `member` |
| Administrator test | Charlie | `admin_demo` | `member` |

Register the first account, then remain signed out—or click Logout if you tested its login—before registering the second. Register is hidden while signed in.

Choose your own practice passwords, using ordinary letters/numbers and at least eight characters. Do not put passwords in GitHub, screenshots, or your README. Public registration intentionally has no role selector.

To make the second account an administrator, select the correct database in phpMyAdmin and first verify the account:

```sql
SELECT id, first_name, username, role
FROM members
WHERE username = 'admin_demo';
```

After confirming that the result is your intended test account, run:

```sql
UPDATE members
SET role = 'admin'
WHERE username = 'admin_demo';
```

Refresh the database view and confirm that only the intended account changed. Log out and log in as that account. There is no public PHP page that grants administrator access.

**Expected starter limitation:** even this administrator receives a 403 response from `public/admin/index.php` before you complete **T01**. That is intentional. The regular login still works. Likewise, later empty member lists and unsaved admin forms correspond to the explicitly listed TODO steps; they do not indicate a broken database connection.

## 7. Starting checkpoint

Before completing T01–T07, verify:

- [ ] Home and Birds open without PHP warnings.
- [ ] Register creates a member account.
- [ ] Login and Logout work.
- [ ] A member can open Create Bird.
- [ ] A logged-out visitor is denied direct access to `bird_new.php`.
- [ ] Your designated administrator has `admin` in the database.
- [ ] Admin pages deny access until T01 is completed.

The starter initially shows a generic **Logout** link. T02 adds the person's first name and the administrator link. The application uses a separate session name for Assignment 12, so signing into an older assignment does not sign you into this one.

## 8. Troubleshooting

| Symptom | Check this first |
|---|---|
| Composer dependencies missing / `vendor/autoload.php` missing | Run `composer install` in the folder containing this application's `composer.json`. |
| Could not load the project-root `.env` file | Put `.env` beside `composer.json`; check spelling and hidden filename extensions. |
| Could not connect to MySQL | Start MySQL; verify database name, username, password, and **database** port. |
| "The request could not be completed. Check the PHP server log and your database setup." | Read the VS Code server terminal when using `php -S`, or the PHP error log in MAMP/XAMPP. It identifies the underlying table/column error without publishing database details to visitors. |
| Unknown column / table does not exist in that log | Compare phpMyAdmin Structure with `sql/reference_schema.sql`; do not replace your data to silence an error. |
| Every admin request gives 403 | Before T01 this is expected. After T01, verify that you logged into **asgn12** and the account's database role is exactly `admin`. |
| Admin list is empty | Before T03 this is expected. After T03, check the database selected in `.env`. |
| Member detail reports not found | Before T04 this is expected. After T04, use an ID actually shown in the member table. |
| Create/update/delete reports the tutorial step is incomplete | Finish the indicated method; the starter deliberately returns `false`. |
| Invalid form token | Reload the form after logging in/out, then submit it again. A form from an earlier session has an old token. |
| Links work on Birds but fail in Admin | Keep `$admin_nav = true` on admin pages and the shared `$prefix` logic in `nav.php`. |
| Headers already sent | Initialization, permission checks, and redirects belong before HTML or printed text. |
| Local server cannot bind to port 55000 | Another server is already using it. Use the running server or stop your own previous server before starting another. |

## 9. Webhost setup

Deploy the completed **application folder** and its Composer dependencies. Create the webhost's `.env` privately with the host's own database settings. Configure the same tables and make a test admin in the host's database. Upload `vendor/` through your normal file-transfer method if Composer is not available on the host; continue excluding it from GitHub.

The application includes Apache `.htaccess` files to deny direct access to environment/configuration files and to the `private` and `sql` folders. The host must honor those directives. Confirm that an unauthenticated request for `/asgn12/.env` or `/asgn12/sql/reference_schema.sql` is denied; do not submit a deployment that exposes them. If your host ignores `.htaccess`, use its supported document-root setting to expose only `public/` or ask the instructor/host to configure protection. PHP's local development server does not apply `.htaccess`.

Upload the completed app, not the sandboxes or instructor package. Test the three roles again using the final public URL.
