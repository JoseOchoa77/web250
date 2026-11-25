<?php
// Every public page loads this file BEFORE printing HTML.
$project_root = dirname(__DIR__);
$autoload = $project_root . '/vendor/autoload.php';
if (!is_file($autoload)) {
    http_response_code(500);
    exit('Composer dependencies missing. Run composer install from the project root.');
}
require_once $autoload;

try {
    // .env belongs beside composer.json, not inside public/ or private/.
    Dotenv\Dotenv::createImmutable($project_root)->load();
} catch (Throwable $exception) {
    error_log('Dotenv: ' . $exception->getMessage());
    http_response_code(500);
    exit('Could not load the project-root .env file. Check your setup.');
}

if (session_status() !== PHP_SESSION_ACTIVE) {
    // Keep this course project's login separate from other PHP projects.
    session_name('WEB250_ASGN12');
    ini_set('session.use_strict_mode', '1');
    ini_set('session.cookie_httponly', '1');
    ini_set('session.cookie_samesite', 'Lax');
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        ini_set('session.cookie_secure', '1');
    }
    session_start();
}

require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/Bird.php';
require_once __DIR__ . '/classes/Member.php';
require_once __DIR__ . '/functions.php';

try {
    $pdo = Database::connect();
    Bird::set_database($pdo);
    Member::set_database($pdo);
} catch (Throwable $exception) {
    error_log('Database connection: ' . $exception->getMessage());
    http_response_code(500);
    exit('Could not connect to MySQL. Check .env and your local server.');
}

// Unhandled database errors belong in the server log, not in a public page.
set_exception_handler(function (Throwable $exception): void {
    error_log(get_class($exception) . ': ' . $exception->getMessage());
    http_response_code(500);
    exit('The request could not be completed. Check the PHP server log and your database setup.');
});
