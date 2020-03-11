<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\News;
use Faker\Generator as Faker;

$factory->define(News::class, function (Faker $faker) {
    return [
        'shop_id'=>getShop(),
        'title'=>$faker->title,
        'body'=>$faker->text(200),
        'image'=>$faker->text(20),
        'thumb_128'=>$faker->text(20),
        'thumb_255'=>$faker->text(20),
        'thumb_1024'=>$faker->text(20),
        'view'=>$faker->numberBetween(0,1000),
    ];
});
