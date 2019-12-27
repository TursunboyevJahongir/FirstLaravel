<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
//    protected $table = 'customers'; default

    /*
     *  protected $fillable = ['name','email','status'];
     *  $fillable = 1/$guarded
     */
    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where('status', 1);

    }
}
