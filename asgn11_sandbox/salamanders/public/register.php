<?php

require_once __DIR__ . '/../private/initialize.php';

$errors = [];
$first_name = '';
$last_name = '';
$username = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Read the form into plain variables first.
  $first_name = trim($_POST['first-name'] ?? '');
  $last_name  = trim($_POST['last-name'] ?? '');
  $username   = trim($_POST['username'] ?? '');
  $email      = trim($_POST['email'] ?? '');
  $password   = $_POST['password'] ?? '';
  $confirm    = $_POST['confirm-password'] ?? '';

  // Required fields
  if ($first_name === '' || $last_name === '' || $username === '' || $email === '' || $password === '') {
    $errors[] = 'All fields are required.';
  }

  // Valid email
  if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email address.';
  }

  // Username not taken
  if ($username !== '' && Member::username_exists($username)) {
    $errors[] = 'That username is already in use.';
  }

  // Email not taken
  if ($email !== '' && Member::email_exists($email)) {
    $errors[] = 'That email address is already in use.';
  }

  // Password length
  if (strlen($password) < 8) {
    $errors[] = 'Password must be at least 8 characters.';
  }

  // Passwords match
  if ($password !== $confirm) {
    $errors[] = 'Passwords do not match.';
  }

  // Only save if every check passed.
  if (empty($errors)) {
    $member = new Member();
    $member->first_name    = $first_name;
    $member->last_name     = $last_name;
    $member->username      = $username;
    $member->email         = $email;
    $member->password_hash = password_hash($password, PASSWORD_DEFAULT);

    if ($member->create()) {
      header('Location: salamanders.php');
      exit;
    }
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <h1>Register Account</h1>
  <?php if (!empty($errors)): ?>
    <ul>
      <?php foreach ($errors as $error): ?>
        <li><?= h($error) ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
  <form action="register.php" method="POST">
    <label for="first-name">First Name</label></br>
    <input type="text" id="first-name" name="first-name" required></br>
    <label for="last-name">Last Name</label></br>
    <input type="text" name="last-name" id="last-name" required></br>
    <label for="username">Username</label></br>
    <input type="text" id="username" name="username" required></br>
    <label for="email">Email</label></br>
    <input type="text" id="email" name="email" required></br>
    <label for="password">Password</label></br>
    <input type="password" id="password" name="password" required></br>
    <label for="confirm-password">Confirm Password</label></br>
    <input type="password" id="confirm-password" name="confirm-password" required></br>
    <input type="submit" value="submit">
  </form>

</body>

</html>
