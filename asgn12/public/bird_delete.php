<?php
require_once '../private/initialize.php';
require_login();

$id_source = is_post() ? ($_POST['id'] ?? null) : ($_GET['id'] ?? null);
$id = filter_var($id_source, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

if ($id === false || $id === null) {
    http_response_code(400);
    exit('Invalid bird ID.');
}

$bird = Bird::find_by_id((int) $id);
if ($bird === null) {
    http_response_code(404);
    exit('Bird not found.');
}

if (is_post()) {
    $bird->delete();
    $_SESSION['message'] = 'Bird deleted.';
    redirect_to('birds.php');
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Delete Bird</title>
</head>
<body>
    <h1>Delete Bird</h1>

    <p>Bird ID: <?= h($bird->id) ?></p>
    <p>Bird name: <?= h($bird->common_name) ?></p>
    <p>Are you sure you want to delete this bird?</p>

    <form method="post" action="bird_delete.php">
        <input type="hidden" name="id" value="<?= h($bird->id) ?>">
        <button type="submit">Yes, Delete Bird</button>
    </form>

    <p><a href="bird.php?id=<?= u((string) $bird->id) ?>">Cancel</a></p>
</body>
</html>
