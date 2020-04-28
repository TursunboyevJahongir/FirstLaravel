<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int $phone
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
        'user_id', 'name', 'phone', 'description', 'image', 'thumb',
        'longitude', 'latitude', 'open_time', 'close_time', 'created_at','status' ,'updated_at'
    ];
    protected $hidden = [ 'created_at', 'updated_at'];

    public function getStatusAttribute($attribute)
    {
        return $this->activeOptions()[$attribute];
    }
    
    protected $attributes = [
        'status' => 1
    ];
    
    public function activeOptions()
    {
        return [
            '1' => 'Active',
            '0' => 'Inactive',
            '-1' => 'sdInactive',
        ];
    }

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
