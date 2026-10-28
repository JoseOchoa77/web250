<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/private/initialize.php';

try {
  $pdo = Database::connect();
  Bird::set_database($pdo);
  $birds = Bird::find_all();
} catch (PDOException $e) {
  error_log($e->getMessage());
  http_response_code(500);
  exit('DB error: ' . $e->getMessage());
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>WNC Bird Directory</title>
</head>

<body>
  <h1>WNC Bird Directory</h1>

  <p><a href="index.php">Back to home</a></p>

  <?php if (count($birds) === 0): ?>
    <p>No birds were found.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th scope="col">Common name</th>
          <!-- add 3 more <th scope="col"> headings:
                         scientific name, habitat, season, and one for "Details" -->
        </tr>
      </thead>
      <tbody>
        <?php foreach ($birds as $bird): ?>
          <tr>
            <td><?= h($bird->common_name) ?></td>
            <!-- add <td>s for scientific_name, primary_habitat, seasonal_status -->
            <td><a href="bird.php?id=<?= (int) $bird->id ?>">View details</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</body>

</html>
