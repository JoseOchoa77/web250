<?php

// __DIR__ is this file's directory, independent of the working directory.
// Load files explicitly. Autoloading and callbacks are not used.
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/db_credentials.php';
require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/Bird.php';

// asgn08: connect once per request and share that PDO connection with the
// Bird model. Database::connect() reuses the same connection if called again.
try {
    $pdo = Database::connect();
    Bird::set_database($pdo);
} catch (PDOException $exception) {
    error_log('asgn08 database error: ' . $exception->getMessage());
    http_response_code(500);
    exit('The bird database is unavailable right now. Please try again later.');
}
