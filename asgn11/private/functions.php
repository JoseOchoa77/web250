<?php

function url_for(string $script_path): string
{
    return $script_path;
}

function u(string $string = ''): string
{
    return rawurlencode($string);
}

// PHP 8.1+ deprecates passing null to htmlspecialchars().
// Convert null to an empty string before escaping.
function h($string = ''): string
{
    return htmlspecialchars((string) ($string ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function is_post(): bool
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function redirect_to(string $location): never
{
    header('Location: ' . $location);
    exit;
}

function is_logged_in(): bool
{
    return isset($_SESSION['member_id']);
}

function require_login(): void
{
    if (!is_logged_in()) {
        $_SESSION['message'] = 'Please log in before managing birds.';
        redirect_to('login.php');
    }
}

function log_in_member(Member $member): void
{
    session_regenerate_id(true);
    $_SESSION['member_id'] = $member->id;
    $_SESSION['username'] = $member->username;
    $_SESSION['role'] = $member->role;
}

function log_out_member(): void
{
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    session_destroy();
}

function current_username(): string
{
    return (string) ($_SESSION['username'] ?? '');
}

function display_session_message(): string
{
    $message = (string) ($_SESSION['message'] ?? '');
    unset($_SESSION['message']);
    return $message;
}
