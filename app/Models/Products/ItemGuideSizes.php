<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class ItemGuideSizes extends Model
{
    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
   protected $hidden = ['created_at', 'updated_at', 'id', 'name'];
}
