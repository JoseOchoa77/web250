<?php
// Expected layout: web250/asgn12 and web250/asgn12_sandbox are sibling folders.
$projectRoot = dirname(__DIR__, 2) . '/asgn12';
$autoload = $projectRoot . '/vendor/autoload.php';
if (!is_file($autoload)) {
    http_response_code(500);
    exit('Finish asgn12 setup first: run composer install inside the asgn12 folder.');
}
require_once $autoload;

try {
    Dotenv\Dotenv::createImmutable($projectRoot)->load();
} catch (Throwable $exception) {
    error_log('Sandbox dotenv: ' . $exception->getMessage());
    http_response_code(500);
    exit('Could not read asgn12/.env. Finish the main application setup first.');
}

// Use the same session settings as asgn12 so its login works in this sandbox.
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name('WEB250_ASGN12');
    ini_set('session.use_strict_mode', '1');
    ini_set('session.cookie_httponly', '1');
    ini_set('session.cookie_samesite', 'Lax');
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        ini_set('session.cookie_secure', '1');
    }
    session_start();
}

require_once $projectRoot . '/private/classes/Database.php';
require_once __DIR__ . '/Member.php';
require_once __DIR__ . '/functions.php';

try {
    $pdo = Database::connect();
    Member::set_database($pdo);
} catch (Throwable $exception) {
    error_log('Sandbox database: ' . $exception->getMessage());
    http_response_code(500);
    exit('Could not connect to MySQL. Check asgn12/.env and start your local database server.');
}

set_exception_handler(function (Throwable $exception): void {
    error_log('Sandbox: ' . $exception->getMessage());
    http_response_code(500);
    exit('Could not read the members table. Check the asgn12 database setup.');
});
