<?php
require_once __DIR__ . '/../private/initialize.php';
$salamanders = Salamander::find_all();
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>WNC Salamanders</title>
</head>

<body>
  <?php if (is_logged_in()): ?>
    <p>Logged in as <?= h($_SESSION['username']) ?> | <a href="logout.php">Log out</a></p>
  <?php else: ?>
    <p><a href="login.php">Log in</a> | <a href="register.php">Register</a></p>
  <?php endif; ?>
  <h1>WNC Salamanders - CRUD Sandbox</h1>
  <?php if (is_logged_in()): ?>
    <p><a href="salamander_new.php">Create Salamander</a></p>
  <?php endif; ?>
  <table>
    <caption>Salamander records</caption>
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Common Name</th>
        <th scope="col">Scientific Name</th>
        <th scope="col">Family</th>
        <th scope="col">Primary Habitat</th>
        <th scope="col">Field Note</th>
        <?php if (is_logged_in()): ?>
          <th scope="col">Actions</th>
        <?php endif; ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($salamanders as $salamander): ?>
        <tr>
          <td><?= (int) $salamander->id ?></td>
          <td><?= h($salamander->common_name) ?></td>
          <td><em><?= h($salamander->scientific_name) ?></em></td>
          <td><?= h($salamander->family_name) ?></td>
          <td><?= h($salamander->primary_habitat) ?></td>
          <td><?= h($salamander->field_note) ?></td>
          <td>

            <?php if (is_logged_in()): ?>
              <a href="salamander_edit.php?id=<?= (int) $salamander->id ?>">Update</a>
              <a href="salamander_delete.php?id=<?= (int) $salamander->id ?>">Delete</a>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <p><a href="index.php">Back to sandbox index</a></p>
</body>

</html>
