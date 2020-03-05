<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $address_id
 * @property string $first_name
 * @property string $last_name
 * @property string $image
 * @property string $email
 * @property string $email_verified_at
 * @property string $phone
 * @property string $password
 * @property string $api_token
 * @property string $remember_token
 * @property string $created_at
 * @property string $updated_at
 * @property Address $address
 * @property Favourite[] $favourites
 * @property Follower[] $followers
 * @property OrderHistory[] $orderHistories
 * @property Order[] $orders
 */
class User extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['address_id', 'name', 'image', 'email', 'phone', 'password', 'api_token', 'remember_token', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address()
    {
        return $this->belongsTo('App\Models\Address');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favourites()
    {
        return $this->hasMany('App\Models\Favourite');
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
    public function orderHistories()
    {
        return $this->hasMany('App\Models\OrderHistory');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
}
