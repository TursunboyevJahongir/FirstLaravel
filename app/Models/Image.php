<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $product_id
 * @property string $main_img
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
    protected $fillable = ['product_id','main_img', 'path', 'thumb_1024', 'thumb_255'];

    protected $hidden = [ 'main_img','product_id'];

    /**
     * @return BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
