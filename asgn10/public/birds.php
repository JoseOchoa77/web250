<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/private/initialize.php';

$birds = Bird::find_all();
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Bird Directory</title>

</head>

<body>
  <button onclick="forceRefresh()">Refresh Page</button>

  <script>
    function forceRefresh() {
      // Get the current URL without existing query parameters
      const url = new window.URL(window.location.href);

      // Append a unique timestamp as a query parameter (cache-busting)
      url.searchParams.set('t', new Date().getTime());

      // Reload the page with the new URL
      window.location.href = url.toString();
    }
  </script>
  <h1>Bird Directory</h1>

  <p>
    <a href="bird_new.php">Create bird</a></br>
    <a href="index.php">Back to index</a>
  </p>

  <!-- asgn09 TODO: Add the Create Bird link here, above the table. -->

  <?php if ($birds === []): ?>
    <p>No birds were found.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Common Name</th>
          <th scope="col">Scientific Name</th>
          <th scope="col">Primary Habitat</th>
          <th scope="col">Seasonal Status</th>
          <th scope="col">Details</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($birds as $bird): ?>
          <tr>
            <td><?= (int) $bird->id ?></td>
            <td><?= h($bird->common_name) ?></td>
            <td><em><?= h($bird->scientific_name) ?></em></td>
            <td><?= h($bird->primary_habitat) ?></td>
            <td><?= h($bird->seasonal_status) ?></td>
            <td><a href="bird.php?id=<?= (int) $bird->id ?>">View details</a></td>
            <td>
              <a href="bird_edit.php?id=<?= (int) $bird->id ?>">Update</a>
              <a href="bird_delete.php?id=<?= (int) $bird->id ?>">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</body>

</html>
