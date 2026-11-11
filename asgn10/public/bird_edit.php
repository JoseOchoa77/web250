<?php
require_once __DIR__ . '/../private/initialize.php';

// SANDBOX EXERCISE 1
// 1. Read a positive id from GET on the first request.
// 2. Use Salamander::find_by_id() to load the selected record.

// On POST the id comes from the hidden field; on GET it comes from the URL.
$source = $_SERVER['REQUEST_METHOD'] === 'POST' ? INPUT_POST : INPUT_GET;

$id = filter_input(
  $source,
  'id',
  FILTER_VALIDATE_INT,
  ['options' => ['min_range' => 1]]
);
$bird = $id === false || $id === null
  ? null
  : Bird::find_by_id($id);

// Bad or missing id: nothing to edit, go back to the list.
if ($bird === null) {
  header('Location: birds.php');
  exit;
}

// 3. On POST, read the hidden id, load the object again, copy form values,
//    call update(), and redirect to birds.php.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $bird->common_name = trim($_POST['common_name'] ?? '');
  $bird->scientific_name = trim($_POST['scientific_name'] ?? '');
  $bird->family_name = trim($_POST['family_name'] ?? '');
  $bird->primary_habitat = trim($_POST['primary_habitat'] ?? '');
  $bird->seasonal_status = trim($_POST['seasonal_status'] ?? '');
  $bird->description = trim($_POST['description'] ?? '');

  $bird->update();
  header('Location: birds.php');
  exit;
}

// 4. Reuse the field structure from salamander_new.php so the current values
//    appear in the form.

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Update Bird</title>
</head>

<body>
  <h1>Update Bird</h1>
  <p><a href="birds.php">Back to Birds</a></p>
  <form method="post" action="bird_edit.php?id=<?= (int) $bird->id ?>">
    <p>
      <label for="common_name">Common name</label><br>
      <input
        type="text"
        id="common_name"
        name="common_name"
        value="<?= h($bird->common_name) ?>"
        required>
    </p>

    <p>
      <label for="scientific_name">Scientific name</label><br>
      <input
        type="text"
        id="scientific_name"
        name="scientific_name"
        value="<?= h($bird->scientific_name) ?>"
        required>
    </p>

    <p>
      <label for="family_name">Family name</label><br>
      <input
        type="text"
        id="family_name"
        name="family_name"
        value="<?= h($bird->family_name) ?>">
    </p>

    <p>
      <label for="primary_habitat">Primary habitat</label><br>
      <input
        type="text"
        id="primary_habitat"
        name="primary_habitat"
        value="<?= h($bird->primary_habitat) ?>">
    </p>

    <p>
      <label for="seasonal_status">Seasonal_status</label><br>
      <textarea id="seasonal_status" name="seasonal_status" rows="5" cols="50"><?= h($bird->seasonal_status) ?></textarea>
    </p>

    <p>
      <label for="description">Description</label><br>
      <textarea id="description" name="description" rows="5" cols="50"><?= h($bird->description) ?></textarea>
    </p>

    <p>
      <button type="submit">Edit bird</button>
    </p>
    <input type="hidden" name="id" value="<?= (int) $bird->id ?>">
  </form>
</body>

</html>
