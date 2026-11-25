<?php
require_once dirname(__DIR__) . '/private/initialize.php';
$birds = Bird::find_all();
$can_edit_birds = is_member();
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><title>Bird Directory</title></head><body>
<?php require __DIR__ . '/nav.php'; ?>
<h1>Bird Directory</h1>
<?php if ($can_edit_birds) { ?><p><a href="bird_new.php">Create a Bird</a></p><?php } ?>
<table border="1" cellpadding="5">
<tr><th>ID</th><th>Common Name</th><th>Scientific Name</th><th>Habitat</th><th>Action</th></tr>
<?php foreach ($birds as $bird) { ?>
<tr>
    <td><?php print (int) $bird->id; ?></td>
    <td><?php print h($bird->common_name); ?></td>
    <td><?php print h($bird->scientific_name); ?></td>
    <td><?php print h($bird->primary_habitat); ?></td>
    <td>
        <a href="bird.php?id=<?php print (int) $bird->id; ?>">View</a>
        <?php if ($can_edit_birds) { ?>
            | <a href="bird_edit.php?id=<?php print (int) $bird->id; ?>">Update</a>
            | <a href="bird_delete.php?id=<?php print (int) $bird->id; ?>">Delete</a>
        <?php } ?>
    </td>
</tr>
<?php } ?>
</table>
</body></html>
