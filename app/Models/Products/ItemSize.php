<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class ItemSize extends Model
{
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['pivot', 'created_at', 'updated_at', 'data'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['isSelected'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
    ];

    /**
     * Get the sizes of the item.
     */

    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_size_pivot', 'size_id', 'item_id');
    }

    /**
     * Init item quantity attribute.
     *
     * @return int
     */
    public function getIsSelectedAttribute()
    {
        return false;
    }
}
