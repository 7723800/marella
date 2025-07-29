<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class ItemSearchKeyword extends Model
{
    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_search_keyword_pivot', 'keyword_id', 'item_id')->select('id', 'name');
    }
}
