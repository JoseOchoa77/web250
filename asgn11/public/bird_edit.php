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

$errors = [];

if (is_post()) {
    $bird->common_name = trim((string) ($_POST['common_name'] ?? ''));
    $bird->scientific_name = trim((string) ($_POST['scientific_name'] ?? ''));
    $bird->family_name = trim((string) ($_POST['family_name'] ?? ''));
    $bird->primary_habitat = trim((string) ($_POST['primary_habitat'] ?? ''));
    $bird->seasonal_status = trim((string) ($_POST['seasonal_status'] ?? ''));
    $bird->description = trim((string) ($_POST['description'] ?? ''));

    if ($bird->common_name === '') {
        $errors[] = 'Common name is required.';
    }
    if ($bird->scientific_name === '') {
        $errors[] = 'Scientific name is required.';
    }

    if (empty($errors) && $bird->update()) {
        $_SESSION['message'] = 'Bird updated.';
        redirect_to('bird.php?id=' . u((string) $bird->id));
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Update Bird</title>
</head>
<body>
    <h1>Update Bird</h1>

    <?php foreach ($errors as $error): ?>
        <p><?= h($error) ?></p>
    <?php endforeach; ?>

    <form method="post" action="bird_edit.php">
        <input type="hidden" name="id" value="<?= h($bird->id) ?>">
        <p><label>Common name <input type="text" name="common_name" value="<?= h($bird->common_name) ?>"></label></p>
        <p><label>Scientific name <input type="text" name="scientific_name" value="<?= h($bird->scientific_name) ?>"></label></p>
        <p><label>Family name <input type="text" name="family_name" value="<?= h($bird->family_name) ?>"></label></p>
        <p><label>Primary habitat <input type="text" name="primary_habitat" value="<?= h($bird->primary_habitat) ?>"></label></p>
        <p><label>Seasonal status <input type="text" name="seasonal_status" value="<?= h($bird->seasonal_status) ?>"></label></p>
        <p><label>Description<br><textarea name="description" rows="5" cols="50"><?= h($bird->description) ?></textarea></label></p>
        <p><button type="submit">Update Bird</button></p>
    </form>

    <p><a href="bird.php?id=<?= u((string) $bird->id) ?>">Cancel</a></p>
</body>
</html>
