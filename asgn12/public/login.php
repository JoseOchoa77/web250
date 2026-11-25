<?php
require_once '../private/initialize.php';

if (is_logged_in()) {
    redirect_to('index.php');
}

$username = '';
$errors = [];
$message = display_session_message();

if (is_post()) {
    $username = trim((string) ($_POST['username'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $errors[] = 'Username and password are required.';
    } else {
        $member = Member::find_by_username($username);

        if ($member !== null && password_verify($password, $member->password_hash)) {
            log_in_member($member);
            $_SESSION['message'] = 'You are now logged in.';
            redirect_to('index.php');
        }

        $errors[] = 'Username or password was not recognized.';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Log In</title>
</head>
<body>
    <h1>Log In</h1>

    <?php if ($message !== ''): ?>
        <p><?= h($message) ?></p>
    <?php endif; ?>

    <?php foreach ($errors as $error): ?>
        <p><?= h($error) ?></p>
    <?php endforeach; ?>

    <form method="post" action="login.php">
        <p><label>Username <input type="text" name="username" value="<?= h($username) ?>"></label></p>
        <p><label>Password <input type="password" name="password"></label></p>
        <p><button type="submit">Log In</button></p>
    </form>

    <p><a href="signup.php">Create an account</a></p>
    <p><a href="index.php">Home</a></p>
</body>
</html>
