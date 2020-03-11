<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use App\Models\District;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\Region;
use App\Models\Shop;
use App\Models\Image;
use Faker\Generator as Faker;

function getDistrict()
{
    $District = District::inRandomOrder()->first();
    if (!is_null($District)) {
        return $District->id;
    } else {
        $District = factory(District::class)->create();
        return $District->id;
    }
}

function getDistrict2()
{
    $District = District::inRandomOrder()->first();
    if (!is_null($District)) {
        return $District;
    } else {
        $District = factory(District::class)->create();
        return $District;
    }
}

function getRegion()
{
    $region = Region::inRandomOrder()->first();
    if (!is_null($region)) {
        return $region->id;
    } else {
        $region = factory(Region::class)->create();
        return $region->id;
    }
}

function getDisRegion($id)
{
    echo $id .'   ';

    $reg = District::where('id','=',$id)->first();
    echo $reg->region_id."<br>";
    return $reg->region_id;
}

function getParent()
{
    try {
        if (random_int(-1, 0)) {
            $category = Category::where(['parent_id' => 0])->inRandomOrder()->first();
            if (!is_null($category)) {
                return $category->id;
            } else {
                $category = factory(Category::class)->create();
                return $category->id;
            }
        } else {
            return null;
        }
    } catch (Exception $e) {
    }
}

function getCategory()
{
    $category = Category::inRandomOrder()->first();
    if (!is_null($category)) {
        return $category->id;
    } else {
        $category = factory(Category::class)->create();
        return $category->id;
    }
}

function getShop()
{
    $shop = Shop::inRandomOrder()->first();
    if (!is_null($shop)) {
        return $shop->id;
    } else {
        $shop = factory(Shop::class)->create();
        return $shop->id;
    }
}

function getManufacturer()
{
    $man = Manufacturer::inRandomOrder()->first();
    if (!is_null($man)) {
        return $man->id;
    } else {
        $man = factory(Manufacturer::class)->create();
        return $man->id;
    }
}

function getProduct()
{
    $product = Product::inRandomOrder()->first();
    if (!is_null($product)) {
        return $product->id;
    } else {
        $product = factory(Product::class)->create();
        return $product->id;
    }
}

function getImage()
{
    $Image = factory(Image::class)->create();
    return $Image->id;
}

