<?php

declare(strict_types=1);
header('Content-Type: text/plain; charset=UTF-8');

// EXERCISE 02: Trace the running total with Watch and a breakpoint.
// Then change the breakpoint to a conditional one: $dayIndex === 2
$dailyCounts = [2, 4, 1, 3];
$total = 0;

foreach ($dailyCounts as $dayIndex => $count) {
    $total += $count;
}

$average = $total / count($dailyCounts);
print "Total sightings: {$total}\n";
print 'Average per day: ' . number_format($average, 2) . "\n";

// I put a breakpoint on $total += $count; and watched $dayIndex, $count and $total. Because the breakpoint is inside the loop, it paused once per pass, four times in all. Each pass added that day’s count to the total: 0 → 2 → 6 → 7 → 10. The final total was 10, and the average was 10 ÷ 4 = 2.50.
