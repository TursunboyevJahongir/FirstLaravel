<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Manufacturer;
use Faker\Generator as Faker;

/**
 * @property int $id
 * @property string $name
 * @property string $ico
 * @property Product[] $products
 */
$factory->define(Manufacturer::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'ico' => $faker->text(5).'ico',
    ];
});
