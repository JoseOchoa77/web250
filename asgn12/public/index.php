<?php
require_once '../private/initialize.php';

$bird_count = Bird::count_all();
$message = display_session_message();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>WNC Birds</title>
</head>
<body>
    <h1>WNC Birds</h1>

    <?php if ($message !== ''): ?>
        <p><?= h($message) ?></p>
    <?php endif; ?>

    <p>Bird records: <?= h($bird_count) ?></p>

    <p><a href="birds.php">View birds</a></p>

    <?php if (is_logged_in()): ?>
        <p>Logged in as <?= h(current_username()) ?></p>
        <p><a href="bird_new.php">Create a bird</a></p>
        <p><a href="logout.php">Log out</a></p>
    <?php else: ?>
        <p><a href="signup.php">Sign up</a></p>
        <p><a href="login.php">Log in</a></p>
    <?php endif; ?>
</body>
</html>
