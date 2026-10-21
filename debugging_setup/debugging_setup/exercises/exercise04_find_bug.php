<?php

declare(strict_types=1);
header('Content-Type: text/plain; charset=UTF-8');

/**
 * EXERCISE 04: The code runs without a PHP exception but produces the
 * wrong answer. Use Watch and Step Over before making a minimal correction.
 * Add a short comment near your correction describing the original mistake.
 */
function countBirds(array $counts): int
{
    $total = 0;
    foreach ($counts as $count) {
        $total += $count;  // Deliberate logic error. Investigate before fixing.
    }
    return $total;
}

$counts = [2, 3, 4];
$result = countBirds($counts);
print "Birds counted: {$result}\n";

// The loop used = instead of +=, so $total was overwritten with each count instead of adding to it. The function returned only the last value (4). Changing it to += makes the loop add each count, giving 9.
