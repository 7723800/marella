<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'name',
        'updated_at',
        'slug',
        'id'
    ];

    /**
     * Get the items of the branch.
     */
    public function items()
    {
        return $this->hasMany(Products\Item::class);
    }
}
