<?php

declare(strict_types=1);
header('Content-Type: text/plain; charset=UTF-8');

// EXERCISE 01: Place a breakpoint on the += line.
// Record $observations before and after Step Over using Variables + Watch.
$birdName = 'Carolina Wren';
$habitat = 'Thickets';
$observations = 3;

$observations += 2;

print "Bird: {$birdName}\n";
print "Habitat: {$habitat}\n";
print "Sightings: {$observations}\n";

// Observation: Before Step Over, $observations was 3. After Step Over, it was 5, because += 2 added 2 to the existing value.
