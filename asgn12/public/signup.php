<?php
require_once '../private/initialize.php';

if (is_logged_in()) {
    redirect_to('index.php');
}

$first_name = '';
$last_name = '';
$email = '';
$username = '';
$errors = [];

if (is_post()) {
    $first_name = trim((string) ($_POST['first_name'] ?? ''));
    $last_name = trim((string) ($_POST['last_name'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $username = trim((string) ($_POST['username'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    $confirm_password = (string) ($_POST['confirm_password'] ?? '');

    if ($first_name === '') {
        $errors[] = 'First name is required.';
    }
    if ($last_name === '') {
        $errors[] = 'Last name is required.';
    }
    if ($email === '') {
        $errors[] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Enter a valid email address.';
    }
    if ($username === '') {
        $errors[] = 'Username is required.';
    }
    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters.';
    }
    if ($password !== $confirm_password) {
        $errors[] = 'Passwords do not match.';
    }

    if ($username !== '' && Member::username_exists($username)) {
        $errors[] = 'That username is already in use.';
    }
    if ($email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL) && Member::email_exists($email)) {
        $errors[] = 'That email address is already in use.';
    }

    if (empty($errors)) {
        $member = new Member();
        $member->first_name = $first_name;
        $member->last_name = $last_name;
        $member->email = $email;
        $member->username = $username;
        $member->password_hash = password_hash($password, PASSWORD_DEFAULT);
        $member->role = 'member';

        if ($member->create()) {
            $_SESSION['message'] = 'Account created. Please log in.';
            redirect_to('login.php');
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sign Up</title>
</head>
<body>
    <h1>Sign Up</h1>

    <?php foreach ($errors as $error): ?>
        <p><?= h($error) ?></p>
    <?php endforeach; ?>

    <form method="post" action="signup.php">
        <p><label>First name <input type="text" name="first_name" value="<?= h($first_name) ?>"></label></p>
        <p><label>Last name <input type="text" name="last_name" value="<?= h($last_name) ?>"></label></p>
        <p><label>Email <input type="email" name="email" value="<?= h($email) ?>"></label></p>
        <p><label>Username <input type="text" name="username" value="<?= h($username) ?>"></label></p>
        <p><label>Password <input type="password" name="password"></label></p>
        <p><label>Confirm password <input type="password" name="confirm_password"></label></p>
        <p><button type="submit">Create Account</button></p>
    </form>

    <p><a href="login.php">Already have an account? Log in</a></p>
    <p><a href="index.php">Home</a></p>
</body>
</html>
