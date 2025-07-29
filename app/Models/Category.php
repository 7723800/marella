<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get the subcategory of the category.
     */
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

     /**
     * Get the item of the category.
     */
    public function item()
    {
        return $this->hasMany(Products\Item::class);
    }
}
