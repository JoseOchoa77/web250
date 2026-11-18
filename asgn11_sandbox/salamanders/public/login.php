<?php
require_once __DIR__ . '/../private/initialize.php';

$errors = [];
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';

  $member = $username === '' ? null : Member::find_by_username($username);

  if ($member !== null && password_verify($password, $member->password_hash)) {
    // Logged in: give them a fresh session id, then remember who they are.
    session_regenerate_id(true);
    $_SESSION['member_id'] = $member->id;
    $_SESSION['username']  = $member->username;
    $_SESSION['role']      = $member->role;

    header('Location: salamanders.php');
    exit;
  }

  $errors[] = 'Username or password is incorrect.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Log In</title>
</head>
<body>
  <h1>Log In</h1>
  

  <?php if (!empty($errors)): ?>
    <ul>
      <?php foreach ($errors as $error): ?>
        <li><?= h($error) ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <form action="login.php" method="POST">
    <label for="username">Username</label><br>
    <input type="text" id="username" name="username" value="<?= h($username) ?>" required><br>
    <label for="password">Password</label><br>
    <input type="password" id="password" name="password" required><br>
    <input type="submit" value="Log In">
  </form>
</body>
</html>
