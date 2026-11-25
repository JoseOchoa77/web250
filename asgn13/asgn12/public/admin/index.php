<?php
require_once __DIR__ . '/../../private/initialize.php';
require_admin();
$admin_nav = true;
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><title>Admin Home</title></head><body>
<?php require __DIR__ . '/../nav.php'; ?>
<h1>Administration</h1>
<ul>
    <li><a href="members.php">View Members</a></li>
    <li><a href="new_member.php">Create Member</a></li>
    <li><a href="../birds.php">Return to Birds</a></li>
</ul>
</body></html>
