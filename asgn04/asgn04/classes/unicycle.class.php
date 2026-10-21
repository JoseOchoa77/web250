<?php

require_once 'bicycle.class.php';
class Unicycle extends Bicycle
{
  // visibility must match property being overridden
  protected static $wheels = 1;

  public static function create()
  {
    static::$instance_count++;
    $name = new Unicycle;
    return $name;
  }

  public function bug_test()
  {
    return $this->weight_kg;
  }
}

$reflection = new ReflectionClass('Unicycle');

// 2. Identify the file path and line constraints
$filePath  = $reflection->getFileName();
$startLine = $reflection->getStartLine();
$endLine   = $reflection->getEndLine();

// 3. Extract the lines from the source file
$fileLines = file($filePath);
$totalLines = $endLine - $startLine + 1;
$classLines = array_slice($fileLines, $startLine - 1, $totalLines);

// 4. Join the lines together into a single block
$rawSourceCode = implode('', $classLines);

// 5. Render safely as formatted HTML on the page
echo "<pre><code>" . htmlspecialchars($rawSourceCode) . "</code></pre>";
?>
