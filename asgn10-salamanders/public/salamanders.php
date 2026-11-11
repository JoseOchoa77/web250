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
  <h1>WNC Salamanders - CRUD Sandbox</h1>

  <p><a href="salamander_new.php">Create Salamander</a></p>

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
        <th scope="col">Actions</th>
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
            <a href="salamander_edit.php?id=<?= (int) $salamander->id ?>">Update</a>
            <a href="salamander_delete.php?id=<?= (int) $salamander->id ?>">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <p><a href="index.php">Back to sandbox index</a></p>
</body>

</html>
