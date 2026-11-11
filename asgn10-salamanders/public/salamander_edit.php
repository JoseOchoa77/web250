<?php
require_once __DIR__ . '/../private/initialize.php';

// SANDBOX EXERCISE 1
// 1. Read a positive id from GET on the first request.
// 2. Use Salamander::find_by_id() to load the selected record.

$id = filter_input(
  INPUT_GET,
  'id',
  FILTER_VALIDATE_INT,
  ['options' => ['min_range' => 1]]
);
$salamander = $id === false || $id === null
  ? null
  : Salamander::find_by_id($id);

// 3. On POST, read the hidden id, load the object again, copy form values,

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $salamander->common_name = trim($_POST['common_name'] ?? '');
  $salamander->scientific_name = trim($_POST['scientific_name'] ?? '');
  $salamander->family_name = trim($_POST['family_name'] ?? '');
  $salamander->primary_habitat = trim($_POST['primary_habitat'] ?? '');
  $salamander->field_note = trim($_POST['field_note'] ?? '');
}
//    call $salamander->update(), and redirect to salamanders.php.

$salamander->update();

// 4. Reuse the field structure from salamander_new.php so the current values
//    appear in the form.

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Update Salamander</title>
</head>

<body>
  <h1>Update Salamander</h1>
  <p>Complete this page during Sandbox Exercise 1.</p>
  <p><a href="salamanders.php">Back to Salamanders</a></p>
  <form method="post" action="salamander_edit.php?id=<?= (int) $salamander->id ?>">
    <p>
      <label for="common_name">Common name</label><br>
      <input
        type="text"
        id="common_name"
        name="common_name"
        value="<?= h($salamander->common_name) ?>"
        required>
    </p>

    <p>
      <label for="scientific_name">Scientific name</label><br>
      <input
        type="text"
        id="scientific_name"
        name="scientific_name"
        value="<?= h($salamander->scientific_name) ?>"
        required>
    </p>

    <p>
      <label for="family_name">Family name</label><br>
      <input
        type="text"
        id="family_name"
        name="family_name"
        value="<?= h($salamander->family_name) ?>">
    </p>

    <p>
      <label for="primary_habitat">Primary habitat</label><br>
      <input
        type="text"
        id="primary_habitat"
        name="primary_habitat"
        value="<?= h($salamander->primary_habitat) ?>">
    </p>

    <p>
      <label for="field_note">field note</label><br>
      <textarea id="field_note" name="field_note" rows="5" cols="50"><?= h($salamander->field_note) ?></textarea>
    </p>

    <p>
      <button type="submit">Edit salamander</button>
    </p>
    <input type="hidden" name="id" value="<?= (int) $salamander->id ?>">
  </form>
</body>

</html>
