<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $ico
 * @property Product[] $products
 */
class Manufacturer extends Model
{
    public $timestamps = false;
    
    /**
     * @var array
     */
    protected $fillable = ['name', 'ico'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany('App\Models\Product', 'manufacture_id');
    }
}
