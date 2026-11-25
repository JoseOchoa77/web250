<?php
require_once dirname(__DIR__) . '/private/initialize.php';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!is_int($id) || $id <= 0) {
    http_response_code(400);
    exit('Invalid bird ID.');
}
$bird = Bird::find_by_id($id);
$can_edit_birds = is_member();
if ($bird === null) {
    http_response_code(404);
    exit('Bird not found.');
}
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><title>Bird Details</title></head><body>
<?php require __DIR__ . '/nav.php'; ?>
<h1><?php print h($bird->common_name); ?></h1>
<p>ID: <?php print (int) $bird->id; ?></p>
<p>Scientific name: <?php print h($bird->scientific_name); ?></p>
<p>Family: <?php print h($bird->family_name); ?></p>
<p>Habitat: <?php print h($bird->primary_habitat); ?></p>
<p>Season: <?php print h($bird->seasonal_status); ?></p>
<p>Description: <?php print nl2br(h($bird->description)); ?></p>
<?php if ($can_edit_birds) { ?>
    <p><a href="bird_edit.php?id=<?php print $id; ?>">Update</a> |
       <a href="bird_delete.php?id=<?php print $id; ?>">Delete</a></p>
<?php } ?>
<p><a href="birds.php">Back to birds</a></p>
</body></html>
