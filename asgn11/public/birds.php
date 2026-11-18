<?php
require_once '../private/initialize.php';

$birds = Bird::find_all();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Bird Directory</title>
</head>
<body>
    <h1>Bird Directory</h1>

    <p><a href="index.php">Home</a></p>

    <?php if (is_logged_in()): ?>
        <p><a href="bird_new.php">Create a bird</a> | <a href="logout.php">Log out</a></p>
    <?php else: ?>
        <p><a href="login.php">Log in</a> | <a href="signup.php">Sign up</a></p>
    <?php endif; ?>

    <?php if (empty($birds)): ?>
        <p>No birds were found.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Common Name</th>
                    <th>Scientific Name</th>
                    <th>Habitat</th>
                    <th>Season</th>
                    <th>Details</th>
                    <?php if (is_logged_in()): ?>
                        <th>Update</th>
                        <th>Delete</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($birds as $bird): ?>
                <tr>
                    <td><?= h($bird->common_name) ?></td>
                    <td><?= h($bird->scientific_name) ?></td>
                    <td><?= h($bird->primary_habitat) ?></td>
                    <td><?= h($bird->seasonal_status) ?></td>
                    <td><a href="bird.php?id=<?= u((string) $bird->id) ?>">View</a></td>
                    <?php if (is_logged_in()): ?>
                        <td><a href="bird_edit.php?id=<?= u((string) $bird->id) ?>">Update</a></td>
                        <td><a href="bird_delete.php?id=<?= u((string) $bird->id) ?>">Delete</a></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
