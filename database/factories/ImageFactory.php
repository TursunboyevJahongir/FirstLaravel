<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Image;
use Faker\Generator as Faker;

/**
 * @property int $id
 * @property int $product_id
 * @property string $path
 * @property string $thumb_1024
 * @property string $thumb_256
 */
$factory->define(Image::class, function (Faker $faker) {
    return [
        'product_id' => getProduct(),
        'path' => $faker->text(5),
        'thumb_1024' => $faker->text(5),
        'thumb_255' => $faker->text(5),
    ];
});
