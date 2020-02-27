<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property string $password
 * @property string $longitude
 * @property string $latitude
 * @property string $created_at
 * @property string $updated_at
 */
class Deliver extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'deliver';

    /**
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'phone', 'password', 'longitude', 'latitude', 'created_at', 'updated_at'];

}
