<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Models\Manufacturer::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'ico' => $faker->text(20)
    ];
});
