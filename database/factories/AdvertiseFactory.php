<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Advertise::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'body' => $faker->text(200),
        'image' => $faker->text(50),
        'thumb_128' => $faker->text(50),
        'thumb_255' => $faker->text(50),
        'thumb_1024' => $faker->text(50),
    ];
});
