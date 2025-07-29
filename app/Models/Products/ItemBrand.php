<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ItemBrand extends Model
{
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at', 'data'];

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
     * Get the color image url.
     *
     * @return bool
     */
    public function getImageUrlAttribute()
    {
        return $this->data ? env('APP_URL') . Storage::url($this->data) : $this->data;
    }


    public function item()
    {
        return $this->hasMany(Item::class);
    }
}
