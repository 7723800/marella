<?php

namespace App\Models;

use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Model;

class SubcategoryType extends Model
{

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }
}
