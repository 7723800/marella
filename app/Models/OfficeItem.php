<?php

namespace App\Models;

use App\Models\Products\Item;
use Illuminate\Database\Eloquent\Model;

class OfficeItem extends Model
{
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
