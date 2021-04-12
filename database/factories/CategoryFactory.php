<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Category;
use Faker\Generator as Faker;

/**
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property string $thumb
 * @property string $thumb_128
 * @property Product[] $products
 */
$factory->define(Category::class, function (Faker $faker) {
    return [
        'parent_id' => getParent(),
        'slug' =>$faker->slug,
        'name' => $faker->FirstName,
        'thumb' => $faker->randomNumber,
        'thumb_128' => $faker->randomNumber,
    ];
});
