<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class ItemSeason extends Model
{
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['pivot', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
    ];

    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_season_pivot', 'season_id', 'item_id');
    }
}
