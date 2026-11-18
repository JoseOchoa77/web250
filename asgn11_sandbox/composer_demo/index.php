<?php
require_once __DIR__ . '/vendor/autoload.php';
// Faker\Factory is a class supplied by the Faker package.
// create() builds a Faker generator object and stores it in $faker.
// We can then use $faker to generate fake names, emails, cities, and more.
$faker = Faker\Factory::create();
print '<h1>Composer Demo</h1>';
print '<p>Name: ' . $faker->name() . '</p>';
print '<p>Email: ' . $faker->email() . '</p>';
print '<p>City: ' . $faker->city() . '</p>';
print '<p>Phone: ' . $faker->phoneNumber() . '</p>';

