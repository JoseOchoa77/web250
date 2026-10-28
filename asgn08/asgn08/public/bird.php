<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/private/initialize.php';

// 1. Validate the id from the URL: it must be a whole number of 1 or more.
//    filter_input returns false for "abc", 0, or negatives, and null if missing.
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1],
]);

$bird = null;
$error_title = '';
$error_message = '';

if ($id === false || $id === null) {
    // 400: the id is missing or not a positive whole number.
    http_response_code(400);
    $error_title = 'Invalid bird ID';
    $error_message = 'Please choose a bird from the directory.';
} else {
    // 2. Valid id: ask the model for that bird.
    try {
        $pdo = Database::connect();
        Bird::set_database($pdo);
        $bird = Bird::find_by_id($id);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        http_response_code(500);
        exit('Could not load this bird. Please try again later.');
    }

    if ($bird === null) {
        // 404: the id looks fine, but no bird has it.
        http_response_code(404);
        $error_title = 'Bird not found';
        $error_message = 'No bird exists with that ID.';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $bird ? h($bird->common_name) : 'Bird Details' ?></title>
</head>
<body>
    <?php if ($bird === null): ?>
        <h1><?= h($error_title) ?></h1>
        <p><?= h($error_message) ?></p>
    <?php else: ?>
        <h1><?= h($bird->common_name) ?></h1>
        <dl>
            <dt>Record ID</dt>
            <dd><?= (int) $bird->id ?></dd>

            <dt>Common name</dt>
            <dd><?= h($bird->common_name) ?></dd>

            <dt>Scientific name</dt>
            <dd><?= h($bird->scientific_name) ?></dd>

            <dt>Family</dt>
            <dd><?= h($bird->family_name) ?></dd>

            <dt>Habitat</dt>
            <dd><?= h($bird->primary_habitat) ?></dd>

            <dt>Season</dt>
            <dd><?= h($bird->seasonal_status) ?></dd>

            <dt>Description</dt>
            <dd><?= h($bird->description) ?></dd>
        </dl>
    <?php endif; ?>

    <p><a href="birds.php">Back to the bird directory</a></p>
</body>
</html>
