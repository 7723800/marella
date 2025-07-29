<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerfumeSex extends Model
{
    public function perfume()
    {
        return $this->hasMany(Perfume::class);
    }
}

