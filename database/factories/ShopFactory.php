<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Shop;
use Faker\Generator as Faker;

$factory->define(Shop::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'phone' => $faker->e164PhoneNumber,
        'description' => $faker->text(200),
        'image' => $faker->text(20),
        'thumb' => $faker->text(20),
        'longitude' =>$faker->longitude,
        'latitude'=>$faker->latitude,
        'status' =>$faker->slug,
    ];
});
