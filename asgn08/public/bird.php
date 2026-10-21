<?php

declare(strict_types=1);

// Name: Jose Ochoa
// Course: WEB-250
// Assignment: asgn08 - Active Record Directory

require_once dirname(__DIR__) . '/private/initialize.php';

$bird = null;
$error_title = null;
$error_message = null;

// Accept only a positive whole number; missing, "abc", 0, and -5 all fail.
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1],
]);

if ($id === null || $id === false) {
    http_response_code(400);
    $error_title = 'Invalid bird ID';
    $error_message = 'Please choose a bird from the directory.';
} else {
    try {
        $bird = Bird::find_by_id($id);
    } catch (PDOException $exception) {
        error_log('asgn08 bird.php error: ' . $exception->getMessage());
        http_response_code(500);
        exit('The bird details could not be loaded. Please try again later.');
    }

    if ($bird === null) {
        http_response_code(404);
        $error_title = 'Bird not found';
        $error_message = 'No bird with that ID is in the directory.';
    }
}

$page_title = $bird !== null ? $bird->common_name : $error_title;
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= h($page_title) ?> | WNC Bird Directory</title>
</head>

<body>
  <?php if ($bird === null): ?>
    <h1><?= h($error_title) ?></h1>
    <p><?= h($error_message) ?></p>
  <?php else: ?>
    <h1><?= h($bird->common_name) ?></h1>
    <dl>
      <dt>Common name</dt>
      <dd><?= h($bird->common_name) ?></dd>

      <dt>Scientific name</dt>
      <dd><em><?= h($bird->scientific_name) ?></em></dd>

      <dt>Family</dt>
      <dd><?= h($bird->family_name) ?></dd>

      <dt>Primary habitat</dt>
      <dd><?= h($bird->primary_habitat) ?></dd>

      <dt>Seasonal status</dt>
      <dd><?= h($bird->seasonal_status) ?></dd>

      <dt>Description</dt>
      <dd><?= h($bird->description) ?></dd>

      <dt>Record ID</dt>
      <dd><?= (int) $bird->id ?></dd>
    </dl>
  <?php endif; ?>

  <p><a href="birds.php">Back to the bird directory</a></p>
</body>

</html>
