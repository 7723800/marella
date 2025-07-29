<?php

namespace App\Models\Products;

use App\Models\Giftcard;
use Illuminate\Database\Eloquent\Model;

class ItemColor extends Model
{
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
    protected $appends = ['imageUrl'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at', 'data'];

    /**
     * Get the color image url.
     *
     * @return bool
     */
    public function getImageUrlAttribute()
    {
        return env('APP_URL') . '/storage/' . $this->data;
    }
    
    public function item()
    {
        return $this->hasMany(Item::class);
    }

    public function giftcard()
    {
        return $this->hasMany(Giftcard::class);
    }
}

