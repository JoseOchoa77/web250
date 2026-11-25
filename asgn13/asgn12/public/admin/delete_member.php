<?php
require_once __DIR__ . '/../../private/initialize.php';
require_admin(); // Protect the URL *and* the deletion action.
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!is_int($id) || $id <= 0) {
    http_response_code(400);
    exit('Invalid member ID.');
}
$member = Member::find_by_id($id);
if ($member === null) {
    http_response_code(404);
    exit('Member not found.');
}
$acting_admin_id = (int) current_member()->id;
$is_self = ((int) $member->id === $acting_admin_id);
$errors = [];
if (is_post_request()) {
    require_valid_csrf(); // Without a valid token, nothing can be deleted.
    if ($is_self) {
        http_response_code(403);
        exit('Administrators cannot delete their own accounts.');
    }
    try {
        if ($member->delete_by_admin($acting_admin_id)) {
            redirect_to('members.php');
        }
        $errors[] = 'The member was not deleted. Check delete_by_admin() in Member.php.';
    } catch (PDOException $exception) {
        error_log($exception->getMessage());
        $errors[] = 'The member could not be deleted.';
    }
}
$admin_nav = true;
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><title>Delete Member</title></head><body>
<?php require __DIR__ . '/../nav.php'; ?>
<h1>Delete Member</h1>
<?php print_errors($errors); ?>
<p>ID: <?php print $id; ?></p>
<p>Name: <?php print h($member->first_name . ' ' . $member->last_name); ?></p>
<p>Username: <strong><?php print h($member->username); ?></strong></p>
<?php if ($is_self) { ?>
    <p>You cannot delete your own administrator account.</p>
<?php } else { ?>
    <p>Are you sure you want to delete this member?</p>
    <form method="post">
        <input type="hidden" name="csrf_token" value="<?php print h(csrf_token()); ?>">
        <button type="submit">Yes, delete this member</button>
    </form>
<?php } ?>
<p><a href="members.php">Cancel / Back to Members</a></p>
</body></html>
