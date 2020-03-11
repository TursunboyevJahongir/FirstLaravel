<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Address;
use App\Models\District;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'district_id' => getDistrict(),
        'name' => $faker->unique()->address
    ];
});
