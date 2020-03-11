<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

/**
 * @property int $id
 * @property int $district_id
 * @property int $region_id
 * @property int $category_id
 * @property int $shop_id
 * @property int $manufacture_id
 * @property int $default_image
 * @property string $name
 * @property float $price
 * @property string $description
 * @property int $discount
 */
$factory->define(Product::class, function (Faker $faker) {
    $des = getDistrict2();
    return [
        'district_id'=> $des,
        'region_id'=> $des->region_id,
        'category_id'=>getCategory(),
        'shop_id'=>getShop(),
        'manufacturer_id'=>getManufacturer(),
        'name'=>$faker->text(20),
        'default_image'=>getImage(),
        'price'=>$faker->randomNumber(5),
        'description'=>$faker->text(20),
        'discount'=> $faker->numberBetween(0,95),
    ];
});
