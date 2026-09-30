<?php
  require_once('../private/initialize.php');
  $page_title = 'Sightings';

/*
 * The CSV in this project is separated by pipes (|), not commas.
 * $delimiter is a public static property on ParseCSV, so it belongs to the
 * class itself and can be changed from outside without an object or an edit
 * to the file. Editing parsecsv.class.php would mean modifying shared code
 * that every other page relies on, and my change would vanish the next time
 * that file is replaced or updated. Setting it here keeps the change local
 * to this page and must happen before parse() runs, because parse() reads
 * the delimiter at the moment it splits each line.
 */
ParseCSV::$delimiter = '|';

$parser = new ParseCSV(PRIVATE_PATH . '/wnc-birds.csv');
$rows = $parser->parse();

// parse() returns false if the file is missing or unreadable. Setting a flag
// lets the markup below print a message instead of looping over false.
$data_error = ($rows === false);

// Build the Bird objects up here so the markup below stays readable.
$birds = [];
if (!$data_error) {
  foreach ($rows as $row) {
    $birds[] = new Bird($row);
  }
}
?>
<?php include(SHARED_PATH . '/public_header.php'); ?>

<h2>Bird inventory</h2>
<p>This is a short list -- start your birding!</p>

<?php if ($data_error) { ?>
  <p>Sorry, the bird data could not be loaded. Please try again later.</p>
<?php } else { ?>

  <p>
    Records in file: <?php echo h($parser->row_count()); ?><br>
    Bird objects created: <?php echo h(Bird::$birdCount); ?>
  </p>

  <table border="1">
    <caption>Birds of western North Carolina</caption>
    <thead>
      <tr>
        <th scope="col">Bird</th>
        <th scope="col">Habitat</th>
        <th scope="col">Food</th>
        <th scope="col">Nest</th>
        <th scope="col">Behavior</th>
        <th scope="col">Wingspan (cm)</th>
        <th scope="col">Wingspan (in)</th>
        <th scope="col">Weight (g)</th>
        <th scope="col">Weight (oz)</th>
        <th scope="col">Size class</th>
        <th scope="col">Conservation</th>
        <th scope="col">Backyard tips</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($birds as $bird) { ?>
        <tr>
          <td><?php echo $bird->display_name(); ?></td>
          <td><?php echo h($bird->habitat); ?></td>
          <td><?php echo h($bird->food); ?></td>
          <td><?php echo h($bird->nest_placement); ?></td>
          <td><?php echo h($bird->behavior); ?></td>
          <td><?php echo h($bird->wingspan_cm()); ?></td>
          <td><?php echo h($bird->wingspan_in()); ?></td>
          <td><?php echo h($bird->weight_g()); ?></td>
          <td><?php echo h($bird->weight_oz()); ?></td>
          <td><?php echo h($bird->size_class()); ?></td>
          <td><?php echo h($bird->condition()); ?></td>
          <td><?php echo h($bird->backyard_tips); ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

<?php } ?>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
