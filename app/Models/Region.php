<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property District[] $districts
 * @property OrderHistory[] $orderHistories
 * @property Order[] $orders
 */
class Region extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @return HasMany
     */
    public function districts()
    {
        return $this->hasMany('App\Models\District');
    }

    /**
     * @return HasMany
     */
    public function orderHistories()
    {
        return $this->hasMany('App\Models\OrderHistory');
    }

    /**
     * @return HasMany
     */
    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    /**
     * @return HasMany
     */
    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
}
