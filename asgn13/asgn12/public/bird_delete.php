<?php
require_once dirname(__DIR__) . '/private/initialize.php';
require_member(); // A GET can only show confirmation; only POST can delete.
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!is_int($id) || $id <= 0) {
    http_response_code(400);
    exit('Invalid bird ID.');
}
$bird = Bird::find_by_id($id);
if ($bird === null) {
    http_response_code(404);
    exit('Bird not found.');
}
$errors = [];
if (is_post_request()) {
    require_valid_csrf();
    try {
        $bird->delete();
        redirect_to('birds.php');
    } catch (PDOException $exception) {
        error_log($exception->getMessage());
        $errors[] = 'Could not delete this bird.';
    }
}
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><title>Delete Bird</title></head><body>
<?php require __DIR__ . '/nav.php'; ?>
<h1>Delete Bird</h1>
<?php print_errors($errors); ?>
<p>Are you sure you want to delete ID <?php print $id; ?>:
<strong><?php print h($bird->common_name); ?></strong>?</p>
<form method="post">
    <input type="hidden" name="csrf_token" value="<?php print h(csrf_token()); ?>">
    <button type="submit">Yes, delete bird</button>
</form>
<p><a href="birds.php">Cancel</a></p>
</body></html>
