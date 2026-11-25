<?php
require_once __DIR__ . '/config.php';
$member = demo_current_member();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sandbox 1 - Role checks</title>
</head>
<body>
    <h1>Sandbox 1: Who is visiting this page?</h1>
    <?php require __DIR__ . '/nav.php'; ?>

    <p>This is optional, ungraded local practice. It uses simulated data and does not connect to MySQL.</p>
    <table border="1" cellpadding="6">
        <caption>Results for the current scenario</caption>
        <tr><th scope="col">Question</th><th scope="col">Result</th></tr>
        <tr><td>Scenario</td><td><?= demo_h($scenario) ?></td></tr>
        <tr><td>Is a member record present?</td><td><?= $member !== null ? 'Yes' : 'No' ?></td></tr>
        <tr><td>May this visitor manage birds?</td><td><?= demo_is_member() ? 'Yes' : 'No' ?></td></tr>
        <tr><td>May this visitor manage members?</td><td><?= demo_is_admin() ? 'Yes' : 'No' ?></td></tr>
    </table>

    <h2>Try a direct address</h2>
    <p>Replace <code>index.php</code> in the browser address with <code>admin_only.php</code>.
        Predict the result before you press Enter.</p>
    <p>The Admin practice link appears only for an admin. The target page also checks permission.</p>
    <p>Keep this exercise on your local computer; do not upload it to your webhost.</p>
</body>
</html>
