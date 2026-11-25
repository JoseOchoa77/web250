<?php
require_once '../private/initialize.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

if ($id === false || $id === null) {
    http_response_code(400);
    exit('Invalid bird ID.');
}

$bird = Bird::find_by_id((int) $id);

if ($bird === null) {
    http_response_code(404);
    exit('Bird not found.');
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= h($bird->common_name) ?></title>
</head>
<body>
    <h1><?= h($bird->common_name) ?></h1>

    <p><strong>ID:</strong> <?= h($bird->id) ?></p>
    <p><strong>Scientific name:</strong> <?= h($bird->scientific_name) ?></p>
    <p><strong>Family:</strong> <?= h($bird->family_name) ?></p>
    <p><strong>Habitat:</strong> <?= h($bird->primary_habitat) ?></p>
    <p><strong>Seasonal status:</strong> <?= h($bird->seasonal_status) ?></p>
    <p><strong>Description:</strong> <?= h($bird->description) ?></p>

    <p><a href="birds.php">Back to bird directory</a></p>

    <?php if (is_logged_in()): ?>
        <p><a href="bird_edit.php?id=<?= u((string) $bird->id) ?>">Update</a></p>
        <p><a href="bird_delete.php?id=<?= u((string) $bird->id) ?>">Delete</a></p>
    <?php endif; ?>
</body>
</html>
