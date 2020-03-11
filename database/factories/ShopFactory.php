<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Shop;
use Faker\Generator as Faker;

$factory->define(Shop::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'phone' => $faker->e164PhoneNumber,
        'password' => $faker ->password,
        'description' => $faker->text(200),
        'longitude' =>$faker->longitude,
        'latitude'=>$faker->latitude,
    ];
});
