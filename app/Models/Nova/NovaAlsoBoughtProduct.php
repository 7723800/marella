<?php

namespace App\Models\Nova;

use Illuminate\Database\Eloquent\Model;

class NovaAlsoBoughtProduct extends Model
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
