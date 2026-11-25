<?php
require_once dirname(__DIR__) . '/private/initialize.php';
require_member(); // Prevent direct-URL update as well as unauthorized POST.
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
    $bird->common_name = trim(post_text('common_name', ''));
    $bird->scientific_name = trim(post_text('scientific_name', ''));
    $bird->family_name = trim(post_text('family_name', ''));
    $bird->primary_habitat = trim(post_text('primary_habitat', ''));
    $bird->seasonal_status = trim(post_text('seasonal_status', ''));
    $bird->description = trim(post_text('description', ''));
    $errors = bird_form_errors($bird);
    if (!$errors) {
        try {
            $bird->update();
            redirect_to('bird.php?id=' . $id);
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            $errors[] = 'The bird could not be updated.';
        }
    }
}
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><title>Update Bird</title></head><body>
<?php require __DIR__ . '/nav.php'; ?>
<h1>Update Bird #<?php print $id; ?></h1>
<?php print_errors($errors); ?>
<form method="post">
    <input type="hidden" name="csrf_token" value="<?php print h(csrf_token()); ?>">
    <?php require __DIR__ . '/bird_fields.php'; ?>
    <button type="submit">Update Bird</button>
</form>
<p><a href="birds.php">Cancel</a></p>
</body></html>
