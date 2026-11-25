<?php
require_once dirname(__DIR__) . '/private/initialize.php';
$bird_count = Bird::count_all();
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><title>WNC Birds</title></head><body>
<?php require __DIR__ . '/nav.php'; ?>
<h1>Western North Carolina Birds</h1>
<p>Our database currently includes <?php print (int) $bird_count; ?> birds.</p>
<p><a href="birds.php">View the bird directory</a></p>
<p>Visitors can read about birds. Signed-in members can create, update, and delete them.</p>
</body></html>
