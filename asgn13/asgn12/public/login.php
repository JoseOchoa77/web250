<?php
require_once dirname(__DIR__) . '/private/initialize.php';

// A logged-in user should not see the Login form again.
if (is_logged_in()) {
    redirect_to('birds.php');
}

$errors = [];
$username = '';
if (is_post_request()) {
    require_valid_csrf();
    $username = trim(post_text('username', ''));
    $password = post_text('password', '');
    $member = Member::find_by_username($username);

    // The submitted password is compared with the stored HASH.
    if ($member !== null && password_verify($password, $member->password_hash)) {
        log_in($member);
        redirect_to('birds.php');
    }
    $errors[] = 'Invalid username or password.';
}
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><title>Member Login</title></head><body>
<?php require __DIR__ . '/nav.php'; ?>
<h1>Login</h1>
<?php if (isset($_GET['registered'])) { ?><p>Registration succeeded. Please log in.</p><?php } ?>
<?php print_errors($errors); ?>
<form method="post">
    <input type="hidden" name="csrf_token" value="<?php print h(csrf_token()); ?>">
    <p><label>Username: <input type="text" name="username" required value="<?php print h($username); ?>"></label></p>
    <p><label>Password: <input type="password" name="password" required></label></p>
    <button type="submit">Login</button>
</form>
</body></html>
