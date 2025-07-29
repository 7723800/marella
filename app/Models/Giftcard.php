<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use App\Models\Products\ItemBrand;
use App\Models\Products\ItemColor;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Giftcard extends Model implements HasMedia
{
    use InteractsWithMedia;

    public function color()
    {
        return $this->belongsTo(ItemColor::class);
    }

    public function giftcardsizes()
    {
        return $this->belongsToMany(GiftcardSize::class, 'giftcard_size', 'giftcard_id', 'giftcard_size_id');
    }

    public function brand()
    {
        return $this->belongsTo(ItemBrand::class);
    }
}
