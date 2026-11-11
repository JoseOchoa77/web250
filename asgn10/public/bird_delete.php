<?php
require_once __DIR__ . '/../private/initialize.php';

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


if ($bird === null) {
  header('Location: birds.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $bird->delete();
  header('Location: birds.php');
  exit;
}

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Delete Birds</title>
</head>

<body>
  <form method="post" action="bird_delete.php">
    <h1>Delete Bird</h1>
    <p>ID: <?php echo $bird->id ?></p>
    <p>Name: <?php echo $bird->common_name ?></p>
    <p>Are you sure you want to delete this bird?</p>
    <input type="submit" value="Yes">
    <input type="hidden" name="id" value="<?= (int) $bird->id ?>">
  </form>
  <p><a href="birds.php">Back to Birds</a></p>
</body>

</html>
