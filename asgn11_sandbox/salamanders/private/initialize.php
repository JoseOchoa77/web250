<?php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/db_credentials.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/Salamander.php';
require_once __DIR__ . '/classes/Member.php';

$root = dirname(__DIR__);
require_once $root . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable($root);
$dotenv->load();


$pdo = Database::connect();
Member::set_database($pdo);
Salamander::set_database($pdo);

