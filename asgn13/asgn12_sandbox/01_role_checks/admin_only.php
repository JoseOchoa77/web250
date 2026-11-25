<?php
require_once __DIR__ . '/config.php';
// The guard runs before any protected HTML is printed.
demo_require_admin();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sandbox 1 - Protected page</title>
</head>
<body>
    <h1>Admin practice page</h1>
    <?php require __DIR__ . '/nav.php'; ?>
    <p>You reached the protected practice page because the simulated visitor is an admin.</p>
    <p>Change the scenario to <code>member</code>, save, and refresh this page. What happens?</p>
    <p>This page is local practice only and contains no real member data.</p>
</body>
</html>
