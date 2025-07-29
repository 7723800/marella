<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Subcategory;
use Ofcold\NovaSortable\SortableTrait;
use Illuminate\Database\Eloquent\Model;

class SecondSubcategory extends Model
{
    use SortableTrait;

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
