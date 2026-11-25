<?php
require_once __DIR__ . '/../../private/initialize.php';
require_admin(); // Also applies to any POST to this page.
$member = new Member();
$errors = [];
if (is_post_request()) {
    require_valid_csrf(); // Validate BEFORE any INSERT.
    $member->first_name = trim(post_text('first_name', ''));
    $member->last_name = trim(post_text('last_name', ''));
    $member->email = trim(post_text('email', ''));
    $member->username = trim(post_text('username', ''));
    $member->role = post_text('role', '');
    $password = post_text('password', '');

    $errors = $member->validation_errors();
    if (strlen($password) < 8 || strlen($password) > 72 || str_contains($password, "\0")) {
        $errors[] = 'Use a password of 8–72 bytes without null characters.';
    }
    if (!$errors) {
        try {
            $member->set_password($password); // A single password_hash() call.
            if ($member->create_by_admin()) { // Only this protected path honors a role.
                redirect_to('members.php');
            }
            $errors[] = 'The member was not created. Check create_by_admin() in Member.php.';
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            $errors[] = 'Member could not be created. Verify username and email uniqueness.';
        }
    }
}
$admin_nav = true;
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><title>Create Member</title></head><body>
<?php require __DIR__ . '/../nav.php'; ?>
<h1>Create Member (Administrator)</h1>
<?php print_errors($errors); ?>
<form method="post">
    <input type="hidden" name="csrf_token" value="<?php print h(csrf_token()); ?>">
    <p><label>First name: <input type="text" name="first_name" required maxlength="80" value="<?php print h($member->first_name); ?>"></label></p>
    <p><label>Last name: <input type="text" name="last_name" required maxlength="80" value="<?php print h($member->last_name); ?>"></label></p>
    <p><label>Email: <input type="email" name="email" required maxlength="190" value="<?php print h($member->email); ?>"></label></p>
    <p><label>Username: <input type="text" name="username" required maxlength="50" value="<?php print h($member->username); ?>"></label></p>
    <p><label>Password (8–72 bytes): <input type="password" name="password" required minlength="8" maxlength="72"></label></p>
    <p><label>Role:
        <select name="role">
            <option value="member" <?php if ($member->role === 'member') print 'selected'; ?>>member</option>
            <option value="admin" <?php if ($member->role === 'admin') print 'selected'; ?>>admin</option>
        </select>
    </label></p>
    <button type="submit">Create Member</button>
</form>
<p><a href="members.php">Cancel</a></p>
</body></html>
