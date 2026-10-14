<?php
require_once __DIR__ . '/../private/initialize.php';

// Set a known starting state before attempting database operations.
$database_name = '';
$summary = [];
$error_message = null;

try {
    $database = Database::connect();

    // query() returns a statement object. fetchColumn() retrieves one value.
    $statement = $database->query('SELECT DATABASE()');
    $database_name = (string) $statement->fetchColumn();

    $statement = $database->query('SELECT COUNT(*) FROM salamanders');
    $salamander_count = (int) $statement->fetchColumn();

    $statement = $database->query('SELECT COUNT(*) FROM habitats');
    $habitat_count = (int) $statement->fetchColumn();

    $statement = $database->query('SELECT COUNT(*) FROM salamander_habitat_links');
    $link_count = (int) $statement->fetchColumn();

    // The labels are fixed, but every count came from a SQL query.
    $summary = [
        ['table_name' => 'salamanders', 'row_count' => $salamander_count],
        ['table_name' => 'habitats', 'row_count' => $habitat_count],
        ['table_name' => 'salamander_habitat_links', 'row_count' => $link_count],
    ];
} catch (PDOException $exception) {
    // Set the status before sending any HTML to the browser.
    http_response_code(500);

    // Technical details go to the local PHP error log, not to visitors.
    error_log('Salamanders database error: ' . $exception->getMessage());
    $error_message = 'Database check failed. Check the local PHP error log.';
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Salamanders - Database Summary</title>
</head>
<body>
    <h1>WNC Salamanders Database Check</h1>
    <p>Configured PHP error log: <?= h((string) ini_get('error_log')) ?></p>
   <?php if ($error_message !== null): ?>        <p><?= h($error_message) ?></p>
    <?php else: ?>        <p>Database: <?= h($database_name) ?></p>
        <table>
            <caption>Database record counts</caption>
            <thead>
                <tr>
                    <th scope="col">Table</th>
                    <th scope="col">Rows</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($summary as $item): ?>                    <tr>
                        <th scope="row"><?= h($item['table_name']) ?></th>
                        <td><?= h((string) $item['row_count']) ?></td>
                    </tr>
                <?php endforeach; ?>            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
