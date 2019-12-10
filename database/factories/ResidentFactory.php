<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Resident;
use Faker\Generator as Faker;

$factory->define(Resident::class, function (Faker $faker) {
    $first = $faker->firstName;
    $last = $faker->lastName;
    $lowAge = random_int(1, 102);
    return [
        'name' => "$first $last",
        'first_name' => $first,
        'last_name' => $last,
        'alternate_names' => '[]',
        'age_range' => $lowAge . '-' . ($lowAge + random_int(1,10)),
        'gender' => $faker->randomElement(['Male', 'Female', 'Other']),
        'link_to_address_start_date' => $faker->text(64),
        'relation' => $faker->randomElement(['NoLink', 'Father', 'Daughter', 'Mother', 'Son']),
    ];
});
