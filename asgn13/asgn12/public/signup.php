<?php
require_once dirname(__DIR__) . '/private/initialize.php';

// If already signed in, do not show another registration form.
if (is_logged_in()) {
    redirect_to('birds.php');
}

$member = new Member();
$errors = [];
if (is_post_request()) {
    require_valid_csrf();
    $member->first_name = trim(post_text('first_name', ''));
    $member->last_name = trim(post_text('last_name', ''));
    $member->email = trim(post_text('email', ''));
    $member->username = trim(post_text('username', ''));
    $password = post_text('password', '');

    // No role field in the HTML. Even a forged POST role=admin is ignored.
    $member->role = 'member';
    $errors = $member->validation_errors();
    if (strlen($password) < 8 || strlen($password) > 72 || str_contains($password, "\0")) {
        $errors[] = 'Use a password of 8–72 bytes without null characters.';
    }

    if (!$errors) {
        try {
            $member->set_password($password);
            $member->create(); // Guarantees a new public account has role 'member'.
            redirect_to('login.php?registered=1');
        } catch (PDOException $exception) {
            error_log('Member registration: ' . $exception->getMessage());
            $errors[] = 'Registration could not be completed. Try another email or username.';
        }
    }
}
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><title>Register</title></head><body>
<?php require __DIR__ . '/nav.php'; ?>
<h1>Register as a Member</h1>
<?php print_errors($errors); ?>
<form method="post">
    <input type="hidden" name="csrf_token" value="<?php print h(csrf_token()); ?>">
    <p><label>First name: <input type="text" name="first_name" maxlength="80" required value="<?php print h($member->first_name); ?>"></label></p>
    <p><label>Last name: <input type="text" name="last_name" maxlength="80" required value="<?php print h($member->last_name); ?>"></label></p>
    <p><label>Email: <input type="email" name="email" maxlength="190" required value="<?php print h($member->email); ?>"></label></p>
    <p><label>Username: <input type="text" name="username" maxlength="50" required value="<?php print h($member->username); ?>"></label></p>
    <p><label>Password (8–72 bytes): <input type="password" name="password" minlength="8" maxlength="72" required></label></p>
    <button type="submit">Create Member Account</button>
</form>
</body></html>
