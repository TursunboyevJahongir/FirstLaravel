<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $district_id
 * @property int $category_id
 * @property int $shop_id
 * @property int $manufacturer_id
 * @property int $image
 * @property string $name
 * @property float $price
 * @property float $slug
 * @property float $count_product
 * @property string $description
 * @property int $discount
 * @property string $created_at
 * @property string $updated_at
 * @property Category $category
 * @property Manufacturer $manufacturer
 * @property Shop $shop
 * @property int $image_id
 * @property District $district
 * @property Favourite[] $favourites
 * @property Image[] $images
 * @property Order_product[] $orderProducts
 * @property Popular[] $populars
 * @property Recome[] $recomes
 */
class Product extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['district_id', 'region_id','slug', 'view_count', 'category_id', 'shop_id', 'manufacturer_id', 'image_id', 'name', 'price', 'description', 'discount','count_product', 'created_at', 'updated_at'];

    protected $hidden = [ 'created_at', 'updated_at'];
    /**
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    /**
     * @return BelongsTo
     */
    public function manufacturer()
    {
        return $this->belongsTo('App\Models\Manufacturer', 'manufacturer_id');
    }

    /**
     * @return BelongsTo
     */
    public function shop()
    {
        return $this->belongsTo('App\Models\Shop');
    }

    /**
     * @return BelongsTo
     */
    public function image()
    {
        return $this->belongsTo('App\Models\Image', 'image_id');
    }

    /**
     * @return BelongsTo
     */
    public function district()
    {
        return $this->belongsTo('App\Models\District');
    }

    public function region()
    {
        return $this->belongsTo('App\Models\Region');
    }

    /**
     * @return HasMany
     */
    public function favourites()
    {
        return $this->hasMany('App\Models\Favourite');
    }

    /**
     * @return HasMany
     */
    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }

    /**
     * @return HasMany
     */
    public function order_products()
    {
        return $this->hasMany('App\Models\Order_product');
    }

    /**
     * @return HasMany
     */
    public function populars()
    {
        return $this->hasMany('App\Models\Popular');
    }

    /**
     * @return HasMany
     */
    public function recomes()
    {
        return $this->hasMany('App\Models\Recome');
    }
}
