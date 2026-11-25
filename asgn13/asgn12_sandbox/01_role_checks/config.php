<?php
// LOCAL SIMULATION: change only this value, save, and refresh the browser.
// Valid choices: 'visitor', 'member', or 'admin'. No login or database is used.
$scenario = 'visitor';

$demoScenarios = [
    'visitor' => null,
    'member' => ['first_name' => 'Morgan', 'role' => 'member'],
    'admin' => ['first_name' => 'Charlie', 'role' => 'admin'],
];

if (!array_key_exists($scenario, $demoScenarios)) {
    http_response_code(500);
    exit('Use visitor, member, or admin for $scenario in config.php.');
}

require_once __DIR__ . '/functions.php';
