<?php
// GRADED ASSIGNMENT: Build the bird directory page here.
// TODO: require private/initialize.php, get Bird::find_all(), output an
// accessible HTML table of bird names, scientific names, habitat, season,
// and links to bird.php?id=... . Escape all database-derived text.

require_once dirname(__DIR__) . '/private/initialize.php';
require_once dirname(__DIR__) . '/private/classes/Bird.php';
Bird::find_all();
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>WNC Bird Directory</title></head>
<body>
    <h1>WNC Bird Directory</h1>
    <p>TODO: Replace this paragraph with your directory table.</p>
</body>
</html>
