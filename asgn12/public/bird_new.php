<?php
require_once '../private/initialize.php';
require_login();

$bird = new Bird();
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

    if (empty($errors) && $bird->create()) {
        $_SESSION['message'] = 'Bird created.';
        redirect_to('bird.php?id=' . u((string) $bird->id));
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Create Bird</title>
</head>
<body>
    <h1>Create Bird</h1>

    <?php foreach ($errors as $error): ?>
        <p><?= h($error) ?></p>
    <?php endforeach; ?>

    <form method="post" action="bird_new.php">
        <p><label>Common name <input type="text" name="common_name" value="<?= h($bird->common_name) ?>"></label></p>
        <p><label>Scientific name <input type="text" name="scientific_name" value="<?= h($bird->scientific_name) ?>"></label></p>
        <p><label>Family name <input type="text" name="family_name" value="<?= h($bird->family_name) ?>"></label></p>
        <p><label>Primary habitat <input type="text" name="primary_habitat" value="<?= h($bird->primary_habitat) ?>"></label></p>
        <p><label>Seasonal status <input type="text" name="seasonal_status" value="<?= h($bird->seasonal_status) ?>"></label></p>
        <p><label>Description<br><textarea name="description" rows="5" cols="50"><?= h($bird->description) ?></textarea></label></p>
        <p><button type="submit">Create Bird</button></p>
    </form>

    <p><a href="birds.php">Cancel</a></p>
</body>
</html>
