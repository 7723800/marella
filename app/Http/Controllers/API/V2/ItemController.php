<?php

namespace App\Http\Controllers\API\V2;

use Illuminate\Http\Request;
use App\Models\Products\Item;
use App\Http\Controllers\Controller;

class ItemController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function wishlist()
    {
        $items = $this->items()->toArray();

        foreach ($items as &$item) {
            $item['isWishlist'] = true;
        }
        return json_encode($items);
    }

    public function basket()
    {
        return response()->json($this->items());
    }

    public function items()
    {
        $items = Item::whereIn('id', json_decode($this->request->ids, true))->with(['color', 'seasons'])->get();
        return $items;
    }
}
