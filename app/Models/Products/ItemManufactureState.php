<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class ItemManufactureState extends Model
{
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at', 'state_value', 'state_name'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['name'];

    /**
     * Get the color image url.
     *
     * @return bool
     */
    public function getNameAttribute()
    {
        return $this->state_name;
    }

    public function item()
    {
        return $this->hasMany(Item::class);
    }
}
