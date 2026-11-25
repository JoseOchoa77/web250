<?php
require_once __DIR__ . '/../../private/initialize.php';
require_admin();
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!is_int($id) || $id <= 0) {
    http_response_code(400);
    exit('Invalid member ID.');
}
// BEGIN T04
// TODO T04: load this ID using the provided Member::find_by_id() method.
$member = null;
// END T04
if ($member === null) {
    http_response_code(404);
    exit('Member not found.');
}
$admin_nav = true;
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><title>Member Details</title></head><body>
<?php require __DIR__ . '/../nav.php'; ?>
<h1>Member Details</h1>
<p>ID: <?php print (int) $member->id; ?></p>
<p>Name: <?php print h($member->first_name . ' ' . $member->last_name); ?></p>
<p>Username: <?php print h($member->username); ?></p>
<p>Email: <?php print h($member->email); ?></p>
<p>Role: <?php print h($member->role); ?></p>
<p><a href="edit_member.php?id=<?php print $id; ?>">Update Member</a> |
<a href="delete_member.php?id=<?php print $id; ?>">Delete Member</a> |
<a href="members.php">Back to Members</a></p>
</body></html>
