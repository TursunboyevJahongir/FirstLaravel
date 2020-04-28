<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $shop_id
 * @property string $title
 * @property boolean $info_image
 * @property string $image
 * @property string $thumb_128
 * @property string $thumb_255
 * @property string $thumb_1024
 * @property string $created_at
 * @property string $updated_at
 */
class Advertise extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'advertise';


    /**
     * @var array
     */
    protected $fillable = ['shop_id', 'title', 'info_image', 'image', 'thumb_128', 'thumb_255', 'thumb_1024', 'created_at', 'updated_at'];

    protected $hidden = [ 'created_at', 'updated_at'];
    /**
     * @return void
     */
    public function shop(){
        $this->belongsTo('\App\Models\Shop');
    }
}
