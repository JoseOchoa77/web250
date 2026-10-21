# WEB-250 | asgn08 - Active Record Directory

A read-only bird directory for the `wnc_birds` MySQL database, built with plain PHP 8 and PDO.
It applies the Active Record idea: a `Bird` class knows how to load rows from the `birds` table and
turn each row into a `Bird` object, so the pages contain HTML and no SQL.

## Folder map

```
asgn08/
  index.html                    asgn08 landing page (links below)
  private/                      not web-accessible (.htaccess: Require all denied)
    initialize.php              loads helpers/classes, connects, calls Bird::set_database()
    functions.php               h() HTML-escaping helper
    db_credentials.php          local/host DB settings - git-ignored, never committed
    classes/Database.php        PDO connection (one per request)
    classes/Bird.php            Active Record model (graded)
    classes/SandboxBird.php     guided sandbox model (ungraded reference)
  public/
    index.php                   database check + navigation
    birds.php                   directory of all birds
    bird.php                    one bird's details (bird.php?id=...)
    sandbox_active_record.php   guided sandbox page
    images/birds/               image files saved for a later assignment
  sql/wnc_birds.sql             asgn07 schema + seed data
```

## Running it

1. Import `sql/wnc_birds.sql` into MySQL (it is additive; it does not drop data). On a webhost,
   import into the host-created database and omit `CREATE DATABASE` / `USE wnc_birds` if required.
2. Create `private/db_credentials.php` with your own `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`,
   and `DB_PASS` constants. This file is in `.gitignore`; keep real credentials out of GitHub and
   this README. Use separate copies locally and on the webhost.
3. Open the pages:
   - Local (XAMPP): `http://localhost/web250/asgn08/public/index.php`
   - Directory: `.../asgn08/public/birds.php`
   - Details: `.../asgn08/public/bird.php?id=<id from the directory>`
   - Sandbox: `.../asgn08/public/sandbox_active_record.php`
   - Webhost: `https://<my-domain>/web250/asgn08/public/birds.php`

## The Bird model

- `Bird::find_all()` - selects every bird sorted by common name and returns an array of `Bird`
  objects (`[]` when the table is empty).
- `Bird::find_by_id(int $id)` - uses a prepared statement with a bound integer parameter and
  returns one `Bird`, or `null` when no row has that ID.
- `Bird::from_row(array $row)` - private helper that hydrates one associative row into a fully
  populated `Bird` object; both finders use it.
- `Bird::count_all()` - returns `SELECT COUNT(*) FROM birds` as an integer without loading rows.

`bird.php` returns a friendly 400 page for a missing or non-positive ID and a 404 page for an ID
that is not in the database.

## Refactoring

I moved the row-to-object mapping into one `from_row()` method and moved the index page's birds
`COUNT(*)` query into `Bird::count_all()`. Keeping the SQL and mapping in the model means a column
change is made in one place, and the pages only deal with objects and HTML.

## Git workflow

Work was done on the `dev-active-record` branch, committed in steps, pushed to GitHub, and then
merged into `main` with `git merge --no-ff dev-active-record`. Both branches remain on GitHub.
