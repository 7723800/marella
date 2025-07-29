<?php

namespace App\Models\Nova;

use Illuminate\Database\Eloquent\Model;

class NovaItemExtraColor extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'items';

    public function color()
    {
        return $this->belongsTo(\App\Models\Products\ItemColor::class);
    }
}
