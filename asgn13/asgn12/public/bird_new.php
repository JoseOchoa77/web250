<?php
require_once dirname(__DIR__) . '/private/initialize.php';
require_member(); // Protect BOTH the form (GET) and the INSERT (POST).

$bird = new Bird();
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
            $bird->create();
            redirect_to('birds.php');
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            $errors[] = 'The bird could not be saved. Check your database configuration.';
        }
    }
}
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><title>Create Bird</title></head><body>
<?php require __DIR__ . '/nav.php'; ?>
<h1>Create a Bird</h1>
<?php print_errors($errors); ?>
<form method="post">
    <input type="hidden" name="csrf_token" value="<?php print h(csrf_token()); ?>">
    <?php require __DIR__ . '/bird_fields.php'; ?>
    <button type="submit">Create Bird</button>
</form>
<p><a href="birds.php">Cancel</a></p>
</body></html>
