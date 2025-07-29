<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Volume extends Model
{
    public function perfumes()
    {
        return $this->belongsToMany(Perfume::class);
    }
}

