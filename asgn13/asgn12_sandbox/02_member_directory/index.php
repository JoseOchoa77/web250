<?php
require_once __DIR__ . '/initialize.php';
$currentMember = sandbox_require_admin();
// The directory query runs only after the visitor passes the admin check.
$members = Member::find_all();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sandbox 2 - Member directory</title>
</head>
<body>
    <h1>Sandbox 2: Member directory</h1>
    <p>Signed in as <?= sandbox_h($currentMember->first_name) ?> (administrator).</p>
    <p>Optional, ungraded local practice. This directory can only read records.</p>
    <p><a href="../../asgn12/public/index.php">Return to asgn12</a></p>

    <table border="1" cellpadding="6">
        <caption>Members ordered by last name, first name, then ID</caption>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">First name</th>
            <th scope="col">Last name</th>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <th scope="col">Role</th>
            <th scope="col">Action</th>
        </tr>
        <?php foreach ($members as $member): ?>
            <tr>
                <td><?= sandbox_h($member->id) ?></td>
                <td><?= sandbox_h($member->first_name) ?></td>
                <td><?= sandbox_h($member->last_name) ?></td>
                <td><?= sandbox_h($member->username) ?></td>
                <td><?= sandbox_h($member->email) ?></td>
                <td><?= sandbox_h($member->role) ?></td>
                <td><a href="member.php?id=<?= sandbox_h($member->id) ?>">View</a></td>
            </tr>
        <?php endforeach; ?>
        <?php if ($members === []): ?>
            <tr><td colspan="7">No member records were found.</td></tr>
        <?php endif; ?>
    </table>
    <p>Keep this exercise local. Do not upload the sandbox to your webhost.</p>
</body>
</html>
