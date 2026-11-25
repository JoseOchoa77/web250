# WEB-250 — Assignment 12 Tutorial
## Personalized navigation, roles, and member administration

**Points:** 100  
**Due date:** See Moodle  
**Starting files:** The new `asgn12` starter supplied with this tutorial  
**Tools:** Your existing MAMP/XAMPP PHP and MySQL setup, VS Code, Composer, Git/GitHub  
**Format:** Plain HTML tables and forms; no CSS required  
**Practice:** Two optional, ungraded sandboxes; neither is submitted

## 1. What you are building

Your bird application already knows how to register a person, check a password, and remember who signed in. This assignment uses that information to decide what the person may do and which navigation choices they should see.

**Authentication** asks, “Who is signed in?” **Authorization** asks, “What may that person do?”

| Person using the site | View birds | Create/update/delete birds | View/manage members |
|---|:---:|:---:|:---:|
| Visitor — not signed in | Yes | No | No |
| Member — role is `member` | Yes | Yes | No |
| Administrator — role is `admin` | Yes | Yes | Yes |

When Charlie signs in, the navigation will display **Logout, Charlie**. Login and Register will disappear. Only an administrator will see **Manage Members**. The first name comes from the current database record; it is not a hard-coded label or the username.

You will also finish an administrator area that lists, creates, updates, and deletes members. The starter contains the page structure, forms, validation, session handling, and working Bird features. Your job is to complete **seven marked edits**, follow the flow through the supplied code, and test the result.

**This is a guided assignment.** You may copy the code blocks from this tutorial. Read the explanation, predict the result, make the change, and run the checkpoint. You are not expected to invent the solution from a list of requirements. You will explain a few decisions in your README and demonstrate the completed behavior.

Images/API work and the MVC refactor remain later assignments. Keep the familiar `public/`, `private/`, PDO, and Active Record organization.

### Learning goals

By the end, you should be able to:

1. Distinguish authentication from authorization.
2. Explain a role-checking helper and a page guard.
3. Display a shared, personalized navigation bar.
4. Trace a database row into a `Member` object and then into HTML.
5. Follow Create, Update, and Delete requests through pages and methods.
6. Explain why member editing preserves the existing password hash.
7. Test visitor, member, and administrator access locally and on your webhost.

### Plan your work in small sessions

| Session | Work | A useful stopping point |
|---|---|---|
| 1 | Setup; optional Sandbox 1; T01–T02 | Your admin sees “Logout, Charlie” and Manage Members. |
| 2 | Optional Sandbox 2; T03–T05 | Your admin can list, view, and create members. |
| 3 | T06–T07; final tests; README and deployment | Your completed app is ready to submit. |

Allow approximately **2½–4 hours** including practice and testing, with additional time if your local setup needs attention. You can stop after any checkpoint. Commit working progress so you know where to resume.

## 2. Start from the same working foundation

Read **`docs/asgn12_setup.md`** and complete its starting checkpoint. The setup guide covers exact folder placement, `composer install`, `.env`, the database structure, and making a test administrator.

Everyone may use this common starter, including students whose Assignment 11 is unfinished. You do not have to repair that earlier project before beginning this tutorial. Keep it for reference and complete any separate earlier-assignment requirements with your instructor.

Use these two folders beside one another:

| Folder | Purpose |
|---|---|
| `web250/asgn12` | The application you will complete and submit. |
| `web250/asgn12_sandbox` | Optional practice that stays on your computer. |

Open the starter's `asgn12` folder in VS Code. You will edit only these four files for the seven required code steps:

| File | Markers |
|---|---|
| `private/functions.php` | T01 |
| `public/nav.php` | T02 |
| `private/classes/Member.php` | T03, T05, T06, T07 |
| `public/admin/member.php` | T04 |

The other files are complete examples to read and trace. Do not replace the working Bird class, change the schema to match an unrelated example, or add a second set of helper functions.

### What already works, and what intentionally waits

| Feature in the unmodified starter | Expected result |
|---|---|
| Home, bird directory, bird detail | Work after setup. An empty new database may have no birds yet. |
| Register, login, logout | Work. Public registration creates only `member` accounts. |
| Bird Create/Update/Delete | Available to signed-in members and admins. Visitors receive 403. |
| Navigation | Shows generic Logout when signed in. T02 adds the first name and admin link. |
| Administrator pages | Return 403 for everyone until T01. |
| Member directory after T01 | Empty until T03. |
| Member detail after T03 | Reports not found until T04. |
| Admin Create/Update/Delete | Forms are supplied; writes report "The member was not created/updated/deleted. Check ... in Member.php" until T05/T06/T07. |

These temporary limits are deliberate. An unfinished permission check denies access, and an unfinished write method returns `false`. The starter does not pretend an unfinished change succeeded.

### Begin the Git branch

From your existing `web250` repository, save any current work, then create the assignment branch:

```bash
git switch main
git switch -c dev-admin-roles
```

If this branch already exists from an earlier attempt, use `git switch dev-admin-roles` and continue there. Do not delete prior work just to repeat these commands. Keep `.env` and `vendor/` excluded from Git.

## 3. Sandbox 1 — Who can see this menu and enter this page?

**Optional • Ungraded • Not submitted • About 15–20 minutes**

### Introduction

This small example isolates role checks and navigation. It does not need MySQL, Composer, registration, or a browser session. A local PHP fixture simulates a visitor, a member, or an admin. The completed practice code is in `asgn12_sandbox/01_role_checks/`.

### Guided practice

1. Open `01_role_checks/config.php`. Find `$scenario = 'visitor';`.
2. Open `http://localhost:55000/web250/asgn12_sandbox/01_role_checks/index.php` using your normal local server. Substitute your actual port if necessary.
3. With `visitor`, observe Login/Register and the two permission answers.
4. Read `demo_current_member()`, `demo_is_member()`, and `demo_is_admin()` in this sandbox's `functions.php`.
5. Change the scenario to `admin`, save, and refresh. You should see **Logout, Charlie** and **Admin practice**.
6. Open `admin_only.php`. Its guard runs before its HTML.

The Login/Register/Logout labels are display-only in this simulation. The actual application uses real accounts and sessions. Do not copy the fixture or simulated-role helpers into the application.

### Experiment: predict, change, run

- Before changing to `member`, predict which labels will appear. Then change, save, and refresh. You should see **Logout, Morgan**, bird-edit permission, and no admin permission.
- While the scenario is `member`, type the `admin_only.php` address directly. Expect **403** even though you bypassed the menu.
- Repeat the direct-address test as `visitor` and `admin`.
- Change the admin fixture's first name to your own, refresh, and observe the greeting. Restore `Charlie` and the `visitor` scenario afterward.

### Checkpoint

| Scenario | May manage birds? | May enter admin-only page? |
|---|:---:|:---:|
| Visitor | No | No |
| Member | Yes | No |
| Admin | Yes | Yes |

Explain: What does an `is_...()` helper return? What does a `require_...()` helper do when access is denied? Why is hiding a link insufficient?

### Apply the idea

T01 uses the same kind of Boolean decision, but the member's role will come from MySQL. T02 uses that information to display the real shared navigation. The longer sandbox walkthrough is in `asgn12_sandbox/README.md`.

## 4. Sandbox 2 — A database row becomes a member object

**Optional • Ungraded • Not submitted • About 20–25 minutes**

### Introduction

This exercise gives you a small, completed version of the reading code. It uses your real `members` table and real admin login, but it only reads records. Its miniature `Member` class is separate from the application class so the unfinished T03 does not prevent practice.

### Guided practice

1. Complete the application setup and first-admin promotion in `asgn12_setup.md`.
2. Log into **asgn12** as `admin_demo`. Admin pages in the starter may still deny access before T01; this completed sandbox uses its own working guard.
3. Open `http://localhost:55000/web250/asgn12_sandbox/02_member_directory/index.php`.
4. Follow the call to `Member::find_all()` in the sandbox's `index.php`.
5. In the sandbox's `Member.php`, follow the SELECT, `fetch()`, `from_row()`, and returned array of objects.
6. Return to the table loop. Observe how `$member->first_name` reads a property from one object.
7. Click a View link. Follow its `id` into `member.php` and then `Member::find_by_id($id)`.

The sandbox loads the main application's Composer dependency and database settings. It shares the Assignment 12 login session, but it does **not** load the unfinished application `Member` class. Keep the two classes in their separate folders.

### Experiment: predict, change, run

- In the sandbox's `find_all()`, change `ORDER BY last_name, first_name, id` to `ORDER BY username, id`. Predict the order, then reload. Restore the original afterward.
- In the sandbox's table, move the Role heading and its matching data cell to a different position. Both must move together.
- As an admin, try `member.php?id=abc`, then `member.php?id=999999999` after confirming that ID is unused. Expect **400** and **404** respectively.
- Log out of the real application and revisit the sandbox directory. Expect **403**. A normal member is denied too.

### Checkpoint

Describe this flow in your own words: **PDO row → `from_row()` → `Member` object → table cell**.

`find_by_id()` can return one object or `null`. The sandbox writes this using an ordinary `if`. Your main application uses the equivalent shorter line:

```php
return $row ? self::from_row($row) : null;
```

Read it as: “If a row was found, return a Member object made from that row. Otherwise, return null.” `null` means no matching member was found. It is not a partly filled object.

### Apply the idea

T03 completes the application's list method; T04 connects its detail page to the existing lookup method. You will keep SQL in the class and HTML in the page. Neither sandbox earns points or is submitted.

## 5. How to make each tutorial edit

Use VS Code's Find command to locate the exact marker. A region begins with `// BEGIN T01`, for example, and ends with `// END T01`.

For T01 and T03–T07, **replace the entire marked region, including its BEGIN/END marker lines, with the corresponding code block below**. Leave the surrounding file and class braces in place. Do not add a second method with the same name.

For **T02 only**, replace the entire contents of `public/nav.php` with the provided complete file. It switches between PHP and HTML, so replacing the whole file is clearer.

Code blocks for methods do not contain a new opening `<?php` tag because the surrounding file is already inside PHP. T02 does contain its opening tag because it is a complete file.

After every edit: save, run the check, and explain the result before continuing.

## 6. T01 — Recognize a real administrator

### Goal and file

Allow the real admin account into protected pages while continuing to deny visitors and ordinary members. Open **`private/functions.php`** and replace the **T01** region:

```php
// BEGIN T01
function is_admin(): bool
{
    $member = current_member();
    return $member !== null && $member->role === 'admin';
}
// END T01
```

### Follow the code

`current_member()` reads the numeric member ID from the session, then calls `Member::find_by_id()`. The result is an object or `null`. The `&&` expression requires both a member object and a role exactly equal to `admin`.

The supplied `require_admin()` calls `is_admin()`. When the answer is false, it sets HTTP status 403 and stops the page with `exit`. You have changed the decision it uses; you do not need to rewrite the guard.

At the top of every admin page you will find this order:

```php
require_once __DIR__ . '/../../private/initialize.php';
require_admin();
```

The path goes from `public/admin/` up to the application root and into `private/`. The guard runs before protected data is read, HTML is sent, or a form submission changes a record. The same guard therefore applies to GET and POST requests.

The supplied `is_member()` accepts both `member` and `admin`, allowing an admin to maintain birds too. Do not change it to accept only the literal `member` role.

### Run the checkpoint

Using the same browser, log out and back in between roles. Type this address directly:

```text
http://localhost:55000/web250/asgn12/public/admin/index.php
```

| State | Expected |
|---|---|
| Logged out | 403 |
| Logged in as `member_demo` | 403 |
| Logged in as `admin_demo` | Administrator page opens |

**Explain:** Why should `require_admin()` appear on all six admin pages even when only one link leads to them?

## 7. T02 — Personalize the shared navigation

### Goal and file

Show the first name beside Logout and show Manage Members only for an administrator. Open **`public/nav.php`**, select its entire contents, and replace them with:

```php
<?php
// BEGIN T02
// Shared navigation for all public/ and public/admin/ pages.
// Admin pages set $admin_nav=true before including this partial.
$prefix = !empty($admin_nav) ? '../' : '';

// Member is looked up by session ID: fresh first_name and role from MySQL.
$nav_member = current_member();
$nav_can_edit_birds = $nav_member !== null &&
    in_array($nav_member->role, ['member', 'admin'], true);
$nav_is_admin = $nav_member !== null && $nav_member->role === 'admin';
?>
<nav>
    <a href="<?php print $prefix; ?>index.php">Home</a> |
    <a href="<?php print $prefix; ?>birds.php">Birds</a>
    <?php if ($nav_can_edit_birds) { ?>
        | <a href="<?php print $prefix; ?>bird_new.php">Create Bird</a>
    <?php } ?>
    <?php if ($nav_is_admin) { ?>
        | <a href="<?php print $prefix; ?>admin/index.php">Manage Members</a>
    <?php } ?>
    <?php if ($nav_member !== null) { ?>
        | <a href="<?php print $prefix; ?>logout.php">Logout</a>, <?php print h($nav_member->first_name); ?>
    <?php } else { ?>
        | <a href="<?php print $prefix; ?>login.php">Login</a>
        | <a href="<?php print $prefix; ?>signup.php">Register</a>
    <?php } ?>
</nav>
<hr>
<?php
// END T02
?>
```

### Follow the code

There are three decisions. One decides whether bird-edit links are available. One decides whether to show Manage Members. One chooses between Logout plus a first name and the Login/Register links.

`$nav_member->first_name` comes from the database record. `h()` converts special HTML characters for safe display. It does not modify the database. The provided helper also handles `null` safely, avoiding the warning that can occur when passing `null` directly to `htmlspecialchars()`.

The same file is included by normal pages and admin pages. An admin page sets `$admin_nav = true`, making `$prefix` equal to `../`. This makes links work from the extra `admin/` directory without copying the menu into every file. `__DIR__` is used for filesystem includes; the HTML links are browser URLs.

### Run the checkpoint

| State | Must appear | Must not appear in navigation |
|---|---|---|
| Visitor | Home, Birds, Login, Register | Create Bird, Manage Members, Logout |
| Member named Riley | Home, Birds, Create Bird, Logout, Riley | Login, Register, Manage Members |
| Admin named Charlie | Home, Birds, Create Bird, Manage Members, Logout, Charlie | Login, Register |

Check both `public/birds.php` and `public/admin/index.php`. Follow Home, Birds, and Logout from the admin page to test the relative links. Admin `members.php` can open now, but its table still has no members until T03.

**Explain:** If Charlie's username is `admin_demo`, why does the navigation say Charlie? Which part stops a normal member who types the admin URL anyway?

Commit this working milestone. For example:

```bash
git add asgn12
git commit -m "Add admin role check and personalized navigation"
```

Run these Git commands from the `web250` repository root, and inspect staged files before committing.

## 8. T03 — Read the member directory

### Goal and file

Return an array of member objects for the supplied HTML table. Open **`private/classes/Member.php`** and replace the **T03** region:

```php
    // BEGIN T03
    public static function find_all(): array
    {
        $sql = 'SELECT id, first_name, last_name, email, username, password_hash, role
                FROM members ORDER BY last_name, first_name, id';
        $statement = self::$database->query($sql);
        $members = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $members[] = self::from_row($row);
        }
        return $members;
    }
    // END T03
```

### Follow the code

The query is fixed text, so it uses `query()`. No browser value is inserted into this SELECT. Each `fetch(PDO::FETCH_ASSOC)` returns one associative array. `from_row()` creates an object from that array. `$members[]` adds the object to the result array. When there are no more rows, the loop ends.

Now open the supplied `public/admin/members.php`. Trace:

```php
$members = Member::find_all();
```

to its `foreach` loop and the table cells. The page displays ID, name, username, email, role, and View/Update/Delete links. Each link carries one member ID.

The main class selects `password_hash` because its existing `from_row()` fills that property for other operations, including login. The directory **never displays it**. The sandbox's smaller class did not need that property, so its SELECT omitted it.

### Run the checkpoint

Log in as your admin and open **Manage Members → View Members**. You should see the test accounts. Confirm that no password or hash appears. View links still reach the intentional T04 not-found result; finish T04 next.

**Explain:** Does `find_all()` return HTML, database rows, or Member objects? Which file decides the table's columns?

## 9. T04 — Read one selected member

### Goal and file

Connect the detail page to the lookup method. Open **`public/admin/member.php`** and replace the **T04** region:

```php
// BEGIN T04
$member = Member::find_by_id($id);
// END T04
```

### Follow the code

The page validates the URL ID before calling the method. The existing `find_by_id()` uses a prepared statement with `:id` and returns either one object or `null`. The page checks for `null` before reading properties.

Unlike the fixed SELECT in T03, this query receives a value that began in the browser. The parameter binds the ID as data in the prepared SQL statement.

### Run the checkpoint

As admin, click View for an actual account, then test these cases:

| Address ending | Expected |
|---|---|
| `member.php?id=` plus a listed member ID | That member's details |
| `member.php?id=abc` | 400 — invalid member ID |
| `member.php` with no ID | 400 — invalid member ID |
| `member.php?id=999999999`, after confirming unused | 404 — member not found |

Use the first name and ID to confirm you opened the intended row. Log in as an ordinary member and try the same valid detail URL; expect 403 before any member information is shown.

**Explain:** Why is an invalid ID different from a valid ID that has no matching record?

## 10. T05 — Let an administrator create an account

### Goal and file

Complete the administrator-specific creation method. Open **`private/classes/Member.php`** and replace the **T05** region:

```php
    // BEGIN T05
    public function create_by_admin(): bool
    {
        return $this->insert_with_role($this->role);
    }
    // END T05
```

### Follow the complete request

The edit is small because the insertion code is already supplied. Open `public/admin/new_member.php` and follow these steps in order:

1. Initialization and `require_admin()` protect the page.
2. A GET request displays the form.
3. A POST request checks the CSRF token and reads the form fields.
4. `validation_errors()` checks required values, permitted roles, and username/email uniqueness.
5. Password validation checks the supplied password. For this tutorial, use an ASCII practice password of 8–72 characters; the actual PHP check counts bytes.
6. `set_password()` hashes the plaintext password once.
7. `create_by_admin()` calls the existing `insert_with_role()` helper, which prepares and executes the INSERT.
8. Only a successful write redirects to the directory. An error redisplays the form with a message.

The plaintext password is not redisplayed in the form, placed in the session, or written to a log by the form code. MySQL stores the hash. The existing login page uses `password_verify()` to check a supplied password against that stored hash.

Compare the two creation entry points in `Member.php`:

| Method | Used by | Role behavior |
|---|---|---|
| `create()` | Public `signup.php` | Forces `member`, regardless of a submitted role. |
| `create_by_admin()` | Guarded admin page | Uses the validated `member` or `admin` choice. |

Do not make the public registration page call the admin method. The method name itself does not authenticate anyone; the calling page's guard provides that boundary.

### Run the checkpoint

As admin, create a disposable account with a unique username/email and role `member`. Confirm it appears in the directory. Log out and verify the new account can log in, edit birds, and is denied admin pages. Log back in as your admin.

Next create a second disposable account with role `admin`; verify its admin access, then return to the original admin. Use your own test passwords and record no passwords in GitHub.

Try creating another account using an existing username or email. Expect a helpful error and **no additional row**. For a password shorter than eight characters, the browser may stop submission first; the supplied PHP validation also checks on the server.

**Explain:** Why is `password_hash()` called on creation, while `password_verify()` is called on login? Why are there separate public and admin creation methods?

## 11. T06 — Update a member while keeping the password

### Goal and file

Save changes to name, email, username, and role. Open **`private/classes/Member.php`** and replace the **T06** region:

```php
    // BEGIN T06
    public function update_by_admin(int $acting_admin_id): bool
    {
        if ($this->id === null) {
            throw new LogicException('Cannot update a Member without an ID.');
        }
        if (!in_array($this->role, ['member', 'admin'], true)) {
            throw new InvalidArgumentException('Invalid role.');
        }
        if ($this->id === $acting_admin_id && $this->role !== 'admin') {
            throw new DomainException('Administrators cannot remove their own admin role.');
        }
        // Note: no password_hash in UPDATE. Password reset is outside asgn12.
        $sql = 'UPDATE members
                SET first_name=:first_name, last_name=:last_name, email=:email,
                    username=:username, role=:role WHERE id=:id';
        $statement = self::$database->prepare($sql);
        return $statement->execute([
            ':first_name' => $this->first_name,
            ':last_name' => $this->last_name,
            ':email' => $this->email,
            ':username' => $this->username,
            ':role' => $this->role,
            ':id' => $this->id,
        ]);
    }
    // END T06
```

### Follow the code

The supplied `edit_member.php` reads and displays the existing member on GET. On POST, it checks the token, updates that object's editable properties, and validates them. Its duplicate checks exclude the current record's ID; keeping your own email should not be treated as a conflict with yourself.

The page gets `$acting_admin_id` from `current_member()`, not from a hidden form field. The method uses that ID to prevent a signed-in admin from changing their own role to `member`. The page also provides a helpful validation message for that case.

The prepared UPDATE names each editable column explicitly. **There is no password field in this form, and `password_hash` is absent from the UPDATE statement.** Therefore, editing a name or role preserves the existing hash. Password reset is outside this assignment.

### Run the checkpoint

1. Update your disposable member's first name and email. Reopen View and confirm the new values.
2. Save the record with its unchanged username. It should succeed because uniqueness checks exclude that row.
3. Try an email already used by a different account. Expect an error; the saved record should remain unchanged.
4. Change the disposable member's role to `admin`, then back to `member`, while signed in as your original admin.
5. Log in with the disposable account's original password. It should still work.
6. As the original admin, edit your own first name to another value. After saving, the shared Logout greeting should update. Restore your preferred name.
7. Try changing your own role to `member`. Expect an explanatory error and no role change.

For an additional role check, sign into the disposable account in a second browser. Change its role using your original admin in the first browser. The disposable account's next protected request should use its new database role. You do not need to recreate its session to refresh that role.

**Explain:** Which missing column in the UPDATE is intentional? Why does storing the member ID rather than a username in the session allow the admin to edit their own username safely?

## 12. T07 — Delete another member after confirmation

### Goal and file

Complete the deletion method. Open **`private/classes/Member.php`** and replace the **T07** region:

```php
    // BEGIN T07
    public function delete_by_admin(int $acting_admin_id): bool
    {
        if ($this->id === null) {
            throw new LogicException('Cannot delete a Member without an ID.');
        }
        if ($this->id === $acting_admin_id) {
            throw new DomainException('An administrator cannot delete their own account.');
        }
        $statement = self::$database->prepare('DELETE FROM members WHERE id = :id');
        $statement->bindValue(':id', $this->id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->rowCount() === 1;
    }
    // END T07
```

### Follow the page and method together

Open `public/admin/delete_member.php`. A normal visit uses GET and displays the selected member's name/username and ID with a confirmation form. It does not call the delete method merely because the page opened.

The submitted confirmation uses POST. The page checks authorization and the CSRF token before calling `delete_by_admin()`. The method checks the acting admin's ID again and then binds the target ID in its prepared DELETE. `rowCount() === 1` reports that one row was deleted.

The ID is not the person's name. Two accounts could share a first name, so confirm both the name/username and ID before submitting.

### Run the checkpoint

1. Choose a disposable account, not your real admin. Click its Delete link.
2. Confirm the page shows the intended account and its ID.
3. Click Cancel. Verify the account remains in the directory.
4. Open Delete again and confirm. Verify exactly that account disappears.
5. Try to delete the currently signed-in admin. Expect an error or a protected confirmation page; the account must remain.

**Explain:** Why does the link itself not delete the row? Which checks occur before the prepared DELETE can run?

## 13. Review the supplied safety helpers

These helpers are complete in the starter. You are expected to recognize their purpose and preserve them, not design a new authentication system.

| Supplied feature | Why it is used |
|---|---|
| `current_member()` | Reads the current account by session ID, including the latest name and role. |
| `require_member()` / `require_admin()` | Stop unauthorized requests before protected work. |
| `post_text()` | Reads a string form field without treating an unexpected array as text. |
| `h()` | Escapes database/form text when printing it in HTML. |
| `csrf_token()` / `require_valid_csrf()` | Match a submitted form token with the session token before a write. |
| `password_hash()` / `password_verify()` | Store a password hash and check login passwords against it. |
| Prepared statements | Keep browser-supplied values separate from SQL syntax. |
| Self-delete and self-demotion checks | Keep the current admin from removing their own access in this assignment. |

A hidden token field needs its matching server check. A hidden link needs its matching page guard. The browser interface makes the application easier to use; PHP still makes the permission decisions.

## 14. Final testing — local application and webhost

Keep one working admin and one ordinary member after deleting your disposable accounts. Use distinct browsers or log out between role tests. Normal tabs in one browser share the session.

### Access and navigation matrix

| Test | Visitor | Member | Admin |
|---|:---:|:---:|:---:|
| Bird list and detail | Allow | Allow | Allow |
| Bird Create, Update, Delete pages | 403 | Allow | Allow |
| All six admin pages, including typed URLs | 403 | 403 | Allow |
| Login/Register navigation | Show | Hide | Hide |
| Personalized Logout | Hide | Show | Show |
| Manage Members navigation | Hide | Hide | Show |

Test valid IDs when checking update/delete/detail authorization. An admin with an invalid ID may receive 400 or 404 instead of a form; that is expected.

### Data and form checks

- [ ] Public registration always creates a member.
- [ ] Admin can create both member and admin accounts.
- [ ] Duplicate username/email produces an error without an extra record.
- [ ] Edit preserves the existing password and prevents self-demotion.
- [ ] Editing the signed-in first name updates the Logout greeting.
- [ ] Delete shows a confirmation; Cancel and an ordinary GET do not delete.
- [ ] Confirmed POST deletes only the intended other account.
- [ ] An admin cannot delete their own account.
- [ ] Invalid IDs produce 400; positive IDs with no matching row produce 404 for an authorized admin.
- [ ] No HTML page displays passwords or password hashes.
- [ ] The shared menu works from both the normal and nested admin pages.

### Test that a POST also checks the role

Open an admin Create form while signed in as admin. Leave that tab open. In another normal tab of the **same browser**, log out and log in as the ordinary member. Submit the first tab's admin form. Expect 403 and no created account. This proves that the page checks permission when the form is submitted, not only when it was first opened. Log back into your admin and reload a fresh form afterward.

### Test the form token

On a fresh admin form, use the browser's Inspect tool to locate the hidden input named `csrf_token`. Change its value to `invalid`, then submit valid form data. Expect 403 and no database change. Reload the page to obtain a valid token again. Keep the token check in place; do not remove it to bypass an error.

## 15. README, GitHub, webhost, and Moodle

### Update your README

The starter's `README.md` contains a section for your own completion notes. Fill it in with:

1. Your name and a short description of the finished project.
2. Setup instructions: `composer install`, `.env.example`, and the schema reference. Include no actual passwords.
3. The three role levels and the six admin page names.
4. Your local and webhost test results, including any remaining issue.
5. Brief answers to these four questions in your own words:
   - Why do we need `require_admin()` when the Admin link is already hidden?
   - What does `from_row()` return, and how does the member list use it?
   - Why does updating a member preserve their password?
   - Why does Delete use a confirmation GET followed by a checked POST?

A few clear sentences per question are enough. No separate essay, screenshots, or sandbox submission is required.

### Finish the Git workflow

After the final tests, commit from the repository root, merge, and push:

```bash
git status
git add asgn12
git commit -m "Complete Assignment 12 member administration tutorial"
git switch main
git merge dev-admin-roles
git push origin main
git push origin dev-admin-roles
```

If Git reports that there is nothing new to commit, continue with the merge. Resolve any actual merge conflict before pushing. Commit `composer.json`, `composer.lock`, and `.env.example`; keep `.env`, database credentials, and `vendor/` out of GitHub.

### Deploy and submit

Follow the webhost section of `asgn12_setup.md`. Configure the host's private `.env`, tables, and test roles. Deploy the application and generated dependencies, then repeat the role checks at its public address.

Submit **two clickable links in Moodle**:

1. Your GitHub **`asgn12` folder on `main`**.
2. Your working **Assignment 12 public entry page** on your webhost.

Add: **“I tested visitor, member, and admin access.”** Describe any known remaining problem. If the instructor needs a test account to verify protected features, provide it only through the instructor's private course submission method; never put its password in GitHub or a public README.

The sandboxes are optional practice and are **not submitted**. All 100 points come from the finished application, explanations, testing, and submission requirements below.

## 16. Grading rubric — 100 points

| Category | Points | Evidence |
|---|---:|---|
| Roles and page authorization | 18 | Correct three-level access; guards on every admin page/POST and Bird write page; public signup remains member-only. |
| Personalized navigation | 8 | Shared nav; escaped current first name beside Logout; Login/Register hidden after login; correct admin links. |
| Member Active Record / PDO | 14 | SQL stays in the class; dynamic values use parameters; row-to-object flow works and README explanation is accurate. |
| Admin directory and detail | 10 | Correct plain table/detail data, no hashes, valid links, clear 400/404 handling. |
| Admin Create | 14 | Both allowed roles, validation and uniqueness, password hashing, successful redirect only after a write. |
| Admin Update | 12 | Saved fields and roles, duplicate checks exclude self, password preserved, no self-demotion. |
| Admin Delete | 10 | Correct account confirmation, POST-only delete, Cancel leaves data, no self-delete. |
| Validation and safety | 8 | Output escaping, CSRF checks, helpful errors, no exposed passwords/secrets; requested tests recorded. |
| GitHub, README, webhost, Moodle | 6 | Required branch merged to main, completion notes and four explanations, working host, two correct links. |
| **Total** | **100** | |

You may use all supplied tutorial blocks and practice examples. Optional challenges are not required. If your first score is below 100, correct the identified issues and resubmit for full credit according to the course resubmission process.

## 17. Final self-check

- [ ] All seven marked regions are complete and the app still uses the supplied file organization.
- [ ] I can explain authentication, authorization, and the difference between an `is_...()` helper and a `require_...()` guard.
- [ ] Logout displays the actual first name; Login/Register are hidden when signed in.
- [ ] My three-role tests pass, including direct URLs and an unauthorized form submission.
- [ ] Member Create, Read, Update, and Delete work with the stated validation and safeguards.
- [ ] My README records what I tested and answers the four questions.
- [ ] My webhost is configured and tested, including private-file protection.
- [ ] My branch is merged to main and my two Moodle links point to asgn12.

## Reference pages

These are reference links, not additional assigned readings. The tutorial follows the existing course code and the documented behavior of these tools.

- [PHP sessions: session_start](https://www.php.net/manual/en/function.session-start.php)
- [PHP PDO prepared statements](https://www.php.net/manual/en/pdo.prepare.php)
- [PHP password_hash](https://www.php.net/manual/en/function.password-hash.php) and [password_verify](https://www.php.net/manual/en/function.password-verify.php)
- [PHP htmlspecialchars](https://www.php.net/manual/en/function.htmlspecialchars.php)
- [PHP header and redirects](https://www.php.net/manual/en/function.header.php)
- [Composer basic usage](https://getcomposer.org/doc/01-basic-usage.md)
- [phpdotenv documentation](https://github.com/phpdotenv/phpdotenv)
