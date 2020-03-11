<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\District;
use Faker\Generator as Faker;

$factory->define(District::class, function (Faker $faker) {
    return [
        'region_id' => getRegion(),
        'name' =>$faker->city
    ];
});
