<?php
require_once __DIR__ . '/../private/initialize.php';

$salamander = new Salamander();
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $salamander->common_name = trim($_POST['common_name'] ?? '');
    $salamander->scientific_name = trim($_POST['scientific_name'] ?? '');
    $salamander->family_name = trim($_POST['family_name'] ?? '');
    $salamander->primary_habitat = trim($_POST['primary_habitat'] ?? '');
    $salamander->field_note = trim($_POST['field_note'] ?? '');

    if ($salamander->common_name === '' || $salamander->scientific_name === '') {
        $error_message = 'Common name and scientific name are required.';
    } elseif ($salamander->create()) {
        header('Location: salamanders.php');
        exit;
    } else {
        $error_message = 'The Salamander could not be created.';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Create Salamander</title>
</head>
<body>
    <h1>Create Salamander</h1>

    <?php if ($error_message !== ''): ?>
        <p><?= h($error_message) ?></p>
    <?php endif; ?>

    <form action="salamander_new.php" method="post">
        <p>
            <label for="common_name">Common Name</label><br>
            <input type="text" id="common_name" name="common_name" value="<?= h($salamander->common_name) ?>" required>
        </p>
        <p>
            <label for="scientific_name">Scientific Name</label><br>
            <input type="text" id="scientific_name" name="scientific_name" value="<?= h($salamander->scientific_name) ?>" required>
        </p>
        <p>
            <label for="family_name">Family</label><br>
            <input type="text" id="family_name" name="family_name" value="<?= h($salamander->family_name) ?>">
        </p>
        <p>
            <label for="primary_habitat">Primary Habitat</label><br>
            <input type="text" id="primary_habitat" name="primary_habitat" value="<?= h($salamander->primary_habitat) ?>">
        </p>
        <p>
            <label for="field_note">Field Note</label><br>
            <textarea id="field_note" name="field_note" rows="5" cols="60"><?= h($salamander->field_note) ?></textarea>
        </p>
        <button type="submit">Create Salamander</button>
    </form>

    <p><a href="salamanders.php">Cancel</a></p>
</body>
</html>
