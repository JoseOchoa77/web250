<?php

declare(strict_types=1);

// Name: Jose Ochoa
// Course: WEB-250
// Assignment: asgn08 - Active Record Directory

require_once dirname(__DIR__) . '/private/initialize.php';

try {
    $birds = Bird::find_all();
} catch (PDOException $exception) {
    error_log('asgn08 birds.php error: ' . $exception->getMessage());
    http_response_code(500);
    exit('The bird directory could not be loaded. Please try again later.');
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WNC Bird Directory</title>
</head>

<body>
  <h1>WNC Bird Directory</h1>
  <p><a href="index.php">Back to the asgn08 home page</a></p>

  <?php if (count($birds) === 0): ?>
    <p>No birds are in the directory yet.</p>
  <?php else: ?>
    <table>
      <caption><?= count($birds) ?> bird species</caption>
      <thead>
        <tr>
          <th scope="col">Common name</th>
          <th scope="col">Scientific name</th>
          <th scope="col">Primary habitat</th>
          <th scope="col">Seasonal status</th>
          <th scope="col">Details</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($birds as $bird): ?>
          <tr>
            <td><?= h($bird->common_name) ?></td>
            <td><em><?= h($bird->scientific_name) ?></em></td>
            <td><?= h($bird->primary_habitat) ?></td>
            <td><?= h($bird->seasonal_status) ?></td>
            <td>
              <a href="bird.php?id=<?= (int) $bird->id ?>">View details</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</body>

</html>
