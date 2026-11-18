<?php
require_once __DIR__ . '/../private/initialize.php';

// 1. Clear the member's session
$_SESSION = [];
session_destroy();

// 2 & 3. They're now a visitor again; send them to a public page
header('Location: salamanders.php');
exit;
