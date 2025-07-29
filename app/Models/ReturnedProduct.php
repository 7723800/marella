<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnedProduct extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lastname', 'email', 'order', 'phone', 'vendor_id', 'comment'
    ];
}
