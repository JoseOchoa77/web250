<?php
require_once __DIR__ . '/../private/initialize.php';

$source = $_SERVER['REQUEST_METHOD'] === 'POST' ? INPUT_POST : INPUT_GET;

$id = filter_input(
  $source,
  'id',
  FILTER_VALIDATE_INT,
  ['options' => ['min_range' => 1]]
);
$salamander = $id === false || $id === null
  ? null
  : Salamander::find_by_id($id);

// SANDBOX EXERCISE 2
// 1. GET should load the Salamander and display its ID and common name.
// 2. Do not delete on GET.
// 3. The confirmation form should POST a hidden id back to this page.
// 4. On POST, load the Salamander again, call $salamander->delete(),
//    and redirect to salamanders.php.
// 5. Include a Cancel link that returns without changing the database.

if ($salamander === null) {
  header('Location: salamanders.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $salamander->delete();
  header('Location: salamanders.php');
  exit;
}

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Delete Salamander</title>
</head>

<body>
  <form method="post" action="salamander_delete.php">
    <h1>Delete Salamander</h1>
    <p>ID: <?php echo $salamander->id ?></p>
    <p>Name: <?php echo $salamander->common_name ?></p>
    <p>Are you sure you want to delete this Salamander?</p>
    <input type="submit" value="Yes">
    <input type="hidden" name="id" value="<?= (int) $salamander->id ?>">
  </form>
  <p><a href="salamanders.php">Back to Salamanders</a></p>
</body>

</html>
