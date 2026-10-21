<?php

Class Bird
{
 public $commonName;
 public $latinName;

 public function __construct($args=[]) {
 $this->commonName = $args['commonName'] ?? NULL;
 $this->latinName = $args['latinName'] ?? NULL;
 }
} 

$reflection = new ReflectionClass('Bird');

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
