<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $body
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
    protected $fillable = ['title', 'body', 'image', 'thumb_128', 'thumb_255', 'thumb_1024', 'created_at', 'updated_at'];

}
