<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public function category() 
    {
        return $this->belongTo(Category::class);
    }
}
