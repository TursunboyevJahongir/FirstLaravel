<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $company_id
 * @property string $name
 * @property string $email
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $status
 * @property Company $company
 */
//https://github.com/krlove/eloquent-model-generator
class Customer extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
//    protected $fillable = ['company_id', 'name', 'email', 'created_at', 'updated_at', 'status'];
        protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
