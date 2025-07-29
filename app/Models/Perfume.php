<?php

namespace App\Models;

use App\Scopes\ItemScope;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Perfume extends Model implements HasMedia
{
    use InteractsWithMedia;

    public function manufactureState()
    {
        return $this->belongsTo(\App\Models\Products\ItemManufactureState::class);
    }

    public function brand()
    {
        return $this->belongsTo(\App\Models\Products\ItemBrand::class);
    }

    public function sex()
    {
        return $this->belongsTo(PerfumeSex::class);
    }

    public function type()
    {
        return $this->belongsTo(PerfumeType::class);
    }

    public function volumes()
    {
        return $this->belongsToMany(Volume::class);
    }
}
