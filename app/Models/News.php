<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $shop_id
 * @property string $title
 * @property string $body
 * @property string $image
 * @property string $thumb_128
 * @property string $thumb_255
 * @property string $thumb_1024
 * @property int $view
 * @property string $created_at
 * @property string $updated_at
 * @property Shop $shop
 */
class News extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['shop_id', 'title', 'body', 'image', 'thumb_128', 'thumb_255', 'thumb_1024', 'view_count', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shop()
    {
        return $this->belongsTo('App\Models\Shop');
    }
}
