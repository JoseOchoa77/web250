<?php
require_once __DIR__ . '/../../private/initialize.php';
require_admin();
$members = Member::find_all();
$admin_nav = true;
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><title>Member Directory</title></head><body>
<?php require __DIR__ . '/../nav.php'; ?>
<h1>Manage Members</h1>
<p><a href="new_member.php">Create Member</a></p>
<table border="1" cellpadding="5">
<tr><th>ID</th><th>Full Name</th><th>Username</th><th>Email</th><th>Role</th><th>Actions</th></tr>
<?php if (!$members) { ?>
<tr><td colspan="6">No members returned. In the starter, complete T03 to load the directory.</td></tr>
<?php } ?>
<?php foreach ($members as $member) { ?>
<tr>
    <td><?php print (int) $member->id; ?></td>
    <td><?php print h($member->first_name . ' ' . $member->last_name); ?></td>
    <td><?php print h($member->username); ?></td>
    <td><?php print h($member->email); ?></td>
    <td><?php print h($member->role); ?></td>
    <td>
        <a href="member.php?id=<?php print (int) $member->id; ?>">View</a> |
        <a href="edit_member.php?id=<?php print (int) $member->id; ?>">Update</a> |
        <a href="delete_member.php?id=<?php print (int) $member->id; ?>">Delete</a>
    </td>
</tr>
<?php } ?>
</table>
<p>The password hash is deliberately NOT displayed.</p>
</body></html>
