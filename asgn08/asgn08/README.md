# WEB-250 — asgn08: Active Record Directory

A read-only bird directory for the WNC Birds project. It uses PHP and PDO to read the `birds` table in the `wnc_birds` MySQL database. Each row is turned into a `Bird` object using the Active Record pattern. The project builds on my asgn07 WNC Birds site.

## Folder map

```
asgn08/
  private/
    classes/
      Database.php        Shared PDO connection (from asgn07)
      Bird.php            Active Record model for the birds table
      SandboxBird.php     Ungraded guided sandbox example
    initialize.php        Loads functions, credentials, Database, and Bird
    functions.php         h() helper for escaping HTML output
    db_credentials.php    Local database settings (NOT committed to GitHub)
  public/
    index.php             Home page with database summary and links
    birds.php             Directory of all birds
    bird.php              Details for one bird (bird.php?id=...)
    sandbox_active_record.php   Guided sandbox page
  README.md
  .gitignore
```

## How to run

**Locally (Windows / XAMPP)**

1. Start Apache and MySQL in the XAMPP Control Panel.
2. Make sure the `wnc_birds` database from asgn07 is imported in phpMyAdmin.
3. Create `private/db_credentials.php` with your own local `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, and `DB_PASS` values.
4. Open `http://localhost/web250/asgn08/asgn08/public/index.php`.

**Webhost**

1. Upload the project to `public_html/web250/asgn08/`, keeping the `private/` and `public/` folders side by side.
2. Import the `wnc_birds` tables into the host's MySQL database. Leave out the `CREATE DATABASE` and `USE` lines if the host requires it.
3. Create a separate `db_credentials.php` on the server with the host's database name, user, password, and hostname.
4. Block direct web access to `private/` (for example, `private/.htaccess` containing `Require all denied`).

Credentials are never committed to GitHub or written in this README. `private/db_credentials.php` is listed in `.gitignore`.

## Bird model methods

- **`set_database(PDO $pdo)`** stores the PDO connection from `Database::connect()` in a private static property. Every finder shares that one connection instead of opening a new one.
- **`find_all()`** selects all seven columns from `birds`, sorted by `common_name`, and returns an array of `Bird` objects. It returns an empty array if the table has no rows.
- **`find_by_id(int $id)`** uses a prepared statement with `:id` bound as `PDO::PARAM_INT`. It returns one `Bird` object, or `null` when no bird has that ID. The ID is never concatenated into the SQL.
- **`from_row(array $row)`** is a private helper that turns one associative database row into a fully populated `Bird` object. It casts `id` to an integer and the other six columns to strings. Both finders use it.
- **`count_all()`** runs `SELECT COUNT(*) FROM birds` and returns the number as an integer, without loading every bird.

## Refactoring

I moved the code that copies a database row into a `Bird` object into one private `from_row()` method that both `find_all()` and `find_by_id()` call, and replaced the bird count on the index page with `Bird::count_all()`. This means the property mapping and the bird SQL live in one place in the model, so a column change only has to be updated once and the pages contain no SQL.

## Pages and error handling

- `birds.php` shows a table of every bird with a "View details" link to `bird.php?id=<id>`, or a message if there are no birds.
- `bird.php` validates `id` with `filter_input(..., FILTER_VALIDATE_INT, min_range 1)`.
  - A missing, non-numeric, zero, or negative ID shows a friendly **400** page.
  - A valid ID that is not in the database shows a friendly **404** page.
  - Database errors are written to the server log, and visitors only see a neutral message.
- All database text is escaped with `h()` before it is displayed.

## Git workflow

```
git switch main
git pull --ff-only origin main
git switch -c dev-active-record
# ...work and commit on dev-active-record...
git push -u origin dev-active-record
git switch main
git merge --no-ff dev-active-record
git push origin main
```

The `dev-active-record` branch is kept on GitHub to show the workflow.

## Navigation

- Local home: http://localhost/web250/asgn08/asgn08/public/index.php
- Local directory: http://localhost/web250/asgn08/asgn08/public/birds.php
- Live directory: https://YOUR-DOMAIN/web250/asgn08/public/birds.php
- GitHub: https://github.com/YOUR-USERNAME/YOUR-REPOSITORY/tree/main/asgn08
