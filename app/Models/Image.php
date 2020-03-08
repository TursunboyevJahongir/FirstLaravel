<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $product_id
 * @property string $path
 * @property string $thumb_1024
 * @property string $thumb_255
 * @property Product $product
 * @property Product[] $products
 */
class Image extends Model
{
    public $timestamps=false;
    /**
     * @var array
     */
    protected $fillable = ['product_id', 'path', 'thumb_1024', 'thumb_255'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

}
