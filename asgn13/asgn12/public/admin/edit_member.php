<?php
require_once __DIR__ . '/../../private/initialize.php';
require_admin(); // Check role before both GET and POST.
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
$actor = current_member();
$acting_admin_id = (int) $actor->id;
$editing_self = ($id === $acting_admin_id);
$errors = [];
if (is_post_request()) {
    require_valid_csrf();
    $member->first_name = trim(post_text('first_name', ''));
    $member->last_name = trim(post_text('last_name', ''));
    $member->email = trim(post_text('email', ''));
    $member->username = trim(post_text('username', ''));
    $member->role = post_text('role', '');

    $errors = $member->validation_errors($id); // Exclude own ID from duplicate checks.
    if ($editing_self && $member->role !== 'admin') {
        $errors[] = 'You cannot remove your own administrator role.';
    }
    if (!$errors) {
        try {
            if ($member->update_by_admin($acting_admin_id)) {
                // The next request reads the new name/role using the same session ID.
                redirect_to('members.php');
            }
            $errors[] = 'The member was not updated. Check update_by_admin() in Member.php.';
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            $errors[] = 'Member could not be updated. Verify username and email uniqueness.';
        }
    }
}
$admin_nav = true;
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><title>Update Member</title></head><body>
<?php require __DIR__ . '/../nav.php'; ?>
<h1>Update Member #<?php print $id; ?></h1>
<?php print_errors($errors); ?>
<form method="post">
    <input type="hidden" name="csrf_token" value="<?php print h(csrf_token()); ?>">
    <p><label>First name: <input type="text" name="first_name" required maxlength="80" value="<?php print h($member->first_name); ?>"></label></p>
    <p><label>Last name: <input type="text" name="last_name" required maxlength="80" value="<?php print h($member->last_name); ?>"></label></p>
    <p><label>Email: <input type="email" name="email" required maxlength="190" value="<?php print h($member->email); ?>"></label></p>
    <p><label>Username: <input type="text" name="username" required maxlength="50" value="<?php print h($member->username); ?>"></label></p>
    <p><label>Role:
        <select name="role">
            <option value="member" <?php if ($member->role === 'member') print 'selected'; ?>>member</option>
            <option value="admin" <?php if ($member->role === 'admin') print 'selected'; ?>>admin</option>
        </select>
    </label></p>
    <?php if ($editing_self) { ?><p>Your own role must remain admin.</p><?php } ?>
    <p>Notice: no password field. Updating a member preserves the existing password hash.</p>
    <button type="submit">Update Member</button>
</form>
<p><a href="members.php">Cancel</a></p>
</body></html>
