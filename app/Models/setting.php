<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $key
 * @property string $display_name
 * @property string $value
 * @property string $details
 * @property string $type
 * @property int $order
 * @property string $group
 */
class setting extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['key', 'display_name', 'value', 'details', 'type', 'order', 'group'];

}
