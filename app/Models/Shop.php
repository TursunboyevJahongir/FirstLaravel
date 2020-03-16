<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int $phone
 * @property string $password
 * @property string $description
 * @property string $image
 * @property string $thumb
 * @property string $longitude
 * @property string $latitude
 * @property string $created_at
 * @property string $updated_at
 * @property Follower[] $followers
 * @property News[] $news
 * @property Product[] $products
 */
class Shop extends Model
{
    // public $short_desc = true;
    /**
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'phone', 'password', 'description', 'image', 'thumb',
        'longitude', 'latitude', 'open_time', 'close_time', 'created_at', 'updated_at'
    ];
    protected $hidden = ['password', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function followers()
    {
        return $this->hasMany('App\Models\Follower');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function news()
    {
        return $this->hasMany('App\Models\News');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
}
