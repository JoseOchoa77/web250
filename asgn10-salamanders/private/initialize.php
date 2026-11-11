<?php

declare(strict_types=1);

require_once __DIR__ . '/db_credentials.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/Salamander.php';

$pdo = Database::connect();
Salamander::set_database($pdo);
