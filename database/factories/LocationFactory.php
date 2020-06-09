<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Location;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Location::class, function (Faker $faker) {
    return [
        'location' => 'World',
        'parent' => 1,
        'level' => -1
    ];
});
