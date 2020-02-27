<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $region_id
 * @property int $address_id
 * @property string $type_pay
 * @property string $comment
 * @property float $sum
 * @property boolean $paid
 * @property string $created_at
 * @property string $updated_at
 * @property Address $address
 * @property Region $region
 * @property User $user
 * @property OrderProduct[] $orderProducts
 */
class Order extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'region_id', 'address_id', 'type_pay', 'comment', 'sum', 'paid', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address()
    {
        return $this->belongsTo('App\Models\Address');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region()
    {
        return $this->belongsTo('App\Models\Region');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderProducts()
    {
        return $this->hasMany('App\Models\OrderProduct');
    }
}
