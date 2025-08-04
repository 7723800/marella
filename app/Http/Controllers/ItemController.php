<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products\Item;

class ItemController extends Controller
{
    public function index($categorySlug, $subcategorySlug, $itemID)
    {
        $item = Item::where('id', $itemID)
            ->with(['color', 'seasons', 'guideSizes', 'alsoBoughtProducts', 'extraColors', 'sourceState', 'manufactureState'])
            ->withoutGlobalScopes()
            ->withTrashed()
            ->first();

        if ($item?->category_id == null) {
            return redirect("/");
        }

        $mightLikeItems = Item::where(
            [
                ['category_id', $item->category_id],
                ['vendor_id', '!=', $item->vendor_id],
                ['brand_id', 2]
            ]
        )
            ->inRandomOrder()
            ->limit(10)
            ->get();

        $data = array(
            'item' => $item,
            'mightLikeItems' => $mightLikeItems,
            'isActive' => $item->published === 0 || $item->deleted_at !== null ? false : true
        );
        return view('item', compact('data'));
    }
}
