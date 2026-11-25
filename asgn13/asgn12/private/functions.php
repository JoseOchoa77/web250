<?php
// HTML output, sessions, authorization, and simple form helpers.
function h(mixed $value): string
{
  // Casting avoids PHP 8.3's htmlspecialchars(null) deprecation warning.
  return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function post_text(string $key, string $default = ''): string
{
  // An ordinary form field is a string. Reject unexpected array-shaped input.
  $value = $_POST[$key] ?? $default;
  return is_string($value) ? $value : '';
}

function is_post_request(): bool
{
  return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
}

function redirect_to(string $relative_path): never
{
  header('Location: ' . $relative_path);
  exit;
}

function log_in(Member $member): void
{
  // Regenerate the session ID after successful login.
  session_regenerate_id(true);
  $_SESSION['member_id'] = (int) $member->id;
  unset($_SESSION['csrf_token']); // Use a fresh form token after login.
}

function current_member(): ?Member
{
  // The session stores only the member ID, NOT their first name or role.
  // Each request reads the current member data from MySQL.
  $id = filter_var(
    $_SESSION['member_id'] ?? null,
    FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1]]
  );
  if ($id === false || $id === null) {
    return null;
  }
  return Member::find_by_id((int) $id);
}

function is_logged_in(): bool
{
  return current_member() !== null;
}

function is_member(): bool
{
  $member = current_member();
  // Admins may also do everything that ordinary members do with birds.
  return $member !== null && in_array($member->role, ['member', 'admin'], true);
}

// BEGIN T01
function is_admin(): bool
{
  // TODO T01: identify an administrator using current_member().
  // Until you finish this step, every admin page correctly refuses access.
  $member = current_member();
  return $member !== null && $member->role === 'admin';
}
// END T01

function require_member(): void
{
  // This is REAL authorization. Hiding a link is not authorization.
  if (!is_member()) {
    http_response_code(403);
    exit('<h1>403 - Member access required</h1><p><a href="login.php">Login</a></p>');
  }
}

function require_admin(): void
{
  // Every admin page checks this BEFORE output, even on a direct URL request.
  if (!is_admin()) {
    http_response_code(403);
    exit('<h1>403 - Administrator access required</h1>');
  }
}

function log_out(): void
{
  $_SESSION = [];
  if (ini_get('session.use_cookies')) {
    $settings = session_get_cookie_params();
    setcookie(
      session_name(),
      '',
      time() - 42000,
      $settings['path'],
      $settings['domain'],
      $settings['secure'],
      $settings['httponly']
    );
  }
  session_destroy();
}

function csrf_token(): string
{
  if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  }
  return (string) $_SESSION['csrf_token'];
}

function require_valid_csrf(): void
{
  $expected = $_SESSION['csrf_token'] ?? '';
  $received = post_text('csrf_token');
  if (!is_string($expected) || $expected === '' || !hash_equals($expected, $received)) {
    http_response_code(403);
    exit('<h1>403 - Invalid form token</h1>');
  }
}

function print_errors(array $errors): void
{
  if (!$errors) {
    return;
  }
  print '<h2>Please correct the following:</h2><ul>';
  foreach ($errors as $error) {
    print '<li>' . h($error) . '</li>';
  }
  print '</ul>';
}

function bird_form_errors(Bird $bird): array
{
  $errors = [];
  if ($bird->common_name === '' || strlen($bird->common_name) > 150) {
    $errors[] = 'Common name is required (maximum 150 characters).';
  }
  if ($bird->scientific_name === '' || strlen($bird->scientific_name) > 150) {
    $errors[] = 'Scientific name is required (maximum 150 characters).';
  }
  if (
    strlen($bird->family_name) > 150 || strlen($bird->primary_habitat) > 255 ||
    strlen($bird->seasonal_status) > 100
  ) {
    $errors[] = 'One of the bird fields is too long.';
  }
  return $errors;
}
