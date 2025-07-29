<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ["order_id", "item_data"];

    protected $casts = [
        "item_data" => "array",
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getImagePath($path)
    {
        $path = str_replace('storage', '', $path);
        return $path;
    }
}
