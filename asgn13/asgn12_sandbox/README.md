# WEB 250 — Assignment 12 sandboxes

These two exercises are **optional, ungraded practice**. They are not submitted in Moodle. They give you working examples to keep in your personal code reference collection. If you can already explain and demonstrate every checkpoint, you may proceed to the assignment tutorial.

Keep the sandboxes on your local computer. Upload only your completed `asgn12` application to your webhost.

## Folder placement and opening the exercises

Place `asgn12_sandbox` next to `asgn12`, inside your `web250` folder. For example:

| Platform | Sandbox folder |
|---|---|
| MAMP on macOS | `/Applications/MAMP/htdocs/web250/asgn12_sandbox` |
| XAMPP on Windows | `C:\xampp\htdocs\web250\asgn12_sandbox` |

The examples below assume your local web server serves its `htdocs` folder at `http://localhost:55000`. Start Apache in MAMP or XAMPP. Sandbox 1 does not need MySQL; Sandbox 2 does. If your working local server uses a different port, substitute that port consistently.

Open PHP files through the local web address, not by double-clicking them in Finder or File Explorer.

| Exercise | Browser address |
|---|---|
| Sandbox 1 | `http://localhost:55000/web250/asgn12_sandbox/01_role_checks/index.php` |
| Sandbox 2 | `http://localhost:55000/web250/asgn12_sandbox/02_member_directory/index.php` |

## Sandbox 1 — Who is visiting this page?

**Time:** approximately 15–20 minutes. **Optional, ungraded, not submitted.**

### 1. Introduction

The same website can behave differently for a visitor, member, or administrator. A role check answers a yes/no question. A page guard uses that answer to decide whether PHP should continue processing a protected page.

This exercise uses a small **simulation**. It has no database, Composer packages, login form, or browser session. You choose a scenario by editing a PHP value on your computer. The real assignment will obtain the signed-in member and role from MySQL.

### 2. Guided practice

1. Open `01_role_checks/config.php` in VS Code. Find:

   ```php
   $scenario = 'visitor';
   ```

2. Leave it set to `visitor` and open the Sandbox 1 browser address above. The page should show **Login | Register**. Both permission questions should say **No**.

3. Open `functions.php`. Follow `demo_current_member()`. For the visitor scenario it returns `null`. In this exercise, `null` means there is no signed-in member record.

4. Read `demo_is_member()` and `demo_is_admin()`. The first permits both members and admins to manage birds. The second permits only admins to manage members. In a condition, `&&` means both conditions must be true.

5. Open `nav.php`. Find the two separate decisions: one controls the Admin practice link, and the other chooses between the visitor labels and a personalized Logout label. Login/Register/Logout are **display labels in this simulation**, so clicking a real login or logout is not part of this exercise.

6. Change the scenario to `admin`, save, and refresh:

   ```php
   $scenario = 'admin';
   ```

   You should now see **Admin practice** and **Logout, Charlie**. Login and Register should disappear. Both permission questions should say **Yes**.

7. Click **Admin practice**. Open `admin_only.php` in VS Code and find the call to `demo_require_admin()`. It appears before the HTML. The helper stops the page if the simulated visitor is not an administrator.

### 3. Experiment: predict, change, run

**Experiment A — A member is not an admin**

Before changing anything, predict which links and labels a member should see. Change `$scenario` to `member`, save, and refresh the home page. You should see **Logout, Morgan**, permission to manage birds, and no permission to manage members.

**Experiment B — Try the address directly**

Keep the member scenario. Replace `index.php` with `admin_only.php` in the browser address and press Enter. You should receive **403 — Administrator access required**. The hidden link was convenient, but the guard is what stopped the request.

While still on the protected page, change `$scenario` to `admin`, save, and refresh. The page should open. Change it to `visitor`, save, and refresh again. Access should be denied.

**Experiment C — Personalize the name**

In the admin fixture inside `config.php`, temporarily change `Charlie` to your first name. Select the admin scenario, save, and refresh the home page. Check that the Logout label changes. Restore `Charlie` and set the scenario back to `visitor` when finished.

### 4. Checkpoints

Your results should match this table:

| Scenario | Navigation labels | May manage birds? | May open `admin_only.php`? |
|---|---|---:|---:|
| `visitor` | Login, Register | No | No; 403 |
| `member` | Logout, Morgan | Yes | No; 403 |
| `admin` | Admin practice; Logout, Charlie | Yes | Yes |

Explain these questions to yourself or a classmate:

- What does `null` represent in this exercise?
- Why does the member permission check also allow an admin?
- Which code hides the Admin practice link? Which code protects the target page?
- Why can typing a URL still reach a PHP file whose link is hidden?

### 5. Apply this to the assignment

The assignment uses the same decisions with an actual `Member` object. Its session stores the member ID, and a database lookup supplies the current name and role. Do not copy the simulated records or `$scenario` into your real application. Use the completed sandbox to remind yourself where conditions and guards belong.

## Sandbox 2 — A database row becomes a Member object

**Time:** approximately 20–25 minutes after application setup. **Optional, ungraded, not submitted.**

### 1. Introduction

This exercise uses your real local `members` table, but it only reads records. It cannot create, update, or delete a member. You will follow a database row into an object and then into an HTML table.

The sandbox has its own small `Member` class and its own completed administrator check. It does **not** depend on the assignment's unfinished `find_all()` or role-helper TODOs. You can use it before completing those TODOs.

### 2. Guided practice

**Get ready**

1. Complete the main assignment's setup: put the starter in `web250/asgn12`, run `composer install` there, create `asgn12/.env`, and connect to your local database. The `.env` file belongs beside `composer.json` in `asgn12`; do not make another `.env` in the sandbox.
2. Follow the main setup instructions to register your first account and promote that specific account to administrator in phpMyAdmin. This sandbox does not create or promote administrators.
3. Sign in to that administrator account at `http://localhost:55000/web250/asgn12/public/login.php`.
4. In the **same browser**, open the Sandbox 2 address. Use `localhost` consistently in both addresses; switching to `127.0.0.1` changes the host used by the browser cookie.

You should see your first name and a table of the member records. If you see **403 — Administrator access required**, confirm you signed in to `asgn12` with an account whose database role is `admin`. The sandbox reads the role from MySQL on each request.

**Follow the code**

1. Open `02_member_directory/initialize.php`. It loads Composer from `asgn12/vendor/autoload.php`, loads the `.env` in that same project, and reuses its `Database` class. It starts the same named session, `WEB250_ASGN12`, used by the application. It then loads the sandbox's own small `Member` class and functions.
2. Open `index.php`. First it initializes the code, then it calls `sandbox_require_admin()`, then it calls `Member::find_all()`. The directory query happens after permission is checked.
3. Open the sandbox's `Member.php` and find `find_all()`. Read the SQL column names and `ORDER BY`. This query deliberately does not retrieve `password_hash`.
4. Follow the loop. Each `fetch()` returns one associative array. `from_row()` creates one `Member` object and copies the selected values into its properties. `$members[]` adds that object to the list being returned.
5. Return to `index.php`. The `foreach` loop receives those objects and displays properties such as `$member->first_name`. The `sandbox_h()` helper escapes values before they are printed into HTML.
6. Click **View** beside a member. Notice the `?id=` value in the address. Open `member.php` and follow the positive-integer check, `Member::find_by_id()`, and the not-found check.

**Read this expanded `if` carefully**

In the sandbox's `find_by_id()` method:

```php
$row = $statement->fetch(PDO::FETCH_ASSOC);

if ($row === false) {
    return null;
}
return self::from_row($row);
```

If the query finds no row, PDO returns `false`. The method returns `null` to mean “there is no Member object for this ID.” Otherwise, the method passes the row to `from_row()` and returns a `Member` object. The `?Member` return type allows those two possibilities: a Member object or `null`.

The original course code may express the same choice as `return $row ? self::from_row($row) : null;`. This sandbox spells it out so you can follow the two paths separately.

### 3. Experiment: predict, change, run

**Experiment A — Change the order**

Predict how the table will change if members are ordered by username. In the sandbox's `Member.php`, change only the end of the `find_all()` SQL:

```sql
FROM members ORDER BY username, id
```

Save and refresh. Update the table caption in `index.php` so it describes the new order. With only one account, the visible order cannot change; compare the SQL or use the test accounts you create during the main tutorial. Restore the original ordering and caption afterward.

**Experiment B — Follow the role column**

Locate the role property in `Member.php`, the `role` column in the SELECT, the assignment in `from_row()`, and the output in `index.php`. Then move the Role heading and matching data cell immediately after the ID column. Predict what would happen if you moved only the heading. Run the page and check that each heading still matches its values. Restore the original column order.

**Experiment C — Try missing and invalid records**

While signed in as an admin, try these addresses relative to the directory:

| Address ending | Expected result |
|---|---|
| `member.php` | 400 — A positive member ID is required |
| `member.php?id=abc` | 400 — A positive member ID is required |
| `member.php?id=0` | 400 — A positive member ID is required |
| `member.php?id=999999` | 404 — Member not found, provided that ID is absent from your table |
| `member.php?id=` followed by a listed ID | The matching member's detail table |

For the not-found test, use a positive ID you have confirmed is absent. A valid number is not a guarantee that a matching row exists.

Finally, return to the main application and log out. Refresh the sandbox directory. You should receive **403**. If you have an ordinary member test account, sign in to it and repeat; access should still be denied. Sign back in as your administrator to continue.

### 4. Checkpoints

- [ ] The directory opens only while an actual administrator is signed in.
- [ ] The table displays the expected members and contains no passwords or hashes.
- [ ] Each View link opens the selected member's detail page.
- [ ] Missing or invalid IDs return 400; a valid but absent ID returns 404.
- [ ] Logging out, or logging in as a non-admin, causes a direct request to return 403.
- [ ] I can explain what `find_all()`, `find_by_id()`, and `from_row()` each return.
- [ ] I can explain why the role is read from the database rather than chosen in the browser.

### 5. Apply this to the assignment

The assignment adds writing operations to the same pattern: initialize, check permission, validate input, call a `Member` method, then display or redirect. Keep this read-only example as a reference when completing your member list and detail pages.

## If something does not work

| Message or symptom | Check |
|---|---|
| Sandbox 1 reports an invalid scenario | Use exactly `visitor`, `member`, or `admin` in `config.php`. |
| Browser displays PHP source or a file download | Use the `http://localhost:55000/...` address and confirm Apache/PHP is running. |
| Composer dependencies missing | Run `composer install` inside `web250/asgn12`, where its `composer.json` is located. |
| Cannot read `.env` | Put `.env` in `web250/asgn12`, beside `composer.json`, and use your database settings. |
| Cannot connect to MySQL | Start MySQL and check the host, MySQL port, database name, username, and password in `.env`. |
| Could not read the members table | Complete the main assignment's schema/setup instructions; this example expects `id`, `first_name`, `last_name`, `email`, `username`, and `role`. |
| Sandbox 2 gives 403 after login | Sign in to this `asgn12` application, confirm the account has role `admin`, and use the same browser and host for both pages. |

## Official reference pages

- [PHP sessions: `session_start()`](https://www.php.net/manual/en/function.session-start.php)
- [PHP prepared statements: `PDO::prepare()`](https://www.php.net/manual/en/pdo.prepare.php)
- [PHP row fetching: `PDOStatement::fetch()`](https://www.php.net/manual/en/pdostatement.fetch.php)
- [PHP return types and nullable types](https://www.php.net/manual/en/language.types.declarations.php)
- [PHP HTML escaping: `htmlspecialchars()`](https://www.php.net/manual/en/function.htmlspecialchars.php)

The sandbox pages are a local learning aid. The graded work and submission requirements are in the main assignment tutorial.
