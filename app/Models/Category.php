<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property string $thumb
 * @property string $thumb_128
 * @property Category $category
 * @property Product[] $products
 */
class Category extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['parent_id', 'name','slug', 'thumb', 'thumb_128'];
    public $timestamps = false;
    /**
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id');
    }

    /**
     * @return HasMany
     */
    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
}
