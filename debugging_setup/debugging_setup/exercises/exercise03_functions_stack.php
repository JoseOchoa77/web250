<?php

declare(strict_types=1);
header('Content-Type: text/plain; charset=UTF-8');

// EXERCISE 03: Step Into the two functions; inspect the Call Stack.
function formatObservation(string $name, int $count): string
{
    $word = ($count === 1) ? 'sighting' : 'sightings';
    return "{$name}: {$count} {$word}";
}

function describeBird(string $name, int $count): string
{
    $report = formatObservation($name, $count);
    return $report;
}

// Put your first breakpoint here, then Step Into.
$report = describeBird('Eastern Towhee', 2);
print "{$report}\n";

// Prediction: Step Into goes inside a function call. Each time I stepped into a function, it was added to the top of the Call Stack: first describeBird, then formatObservation. When each function returned, it was removed and I went back to the caller. $word was ‘sightings’ because $count was 2.
