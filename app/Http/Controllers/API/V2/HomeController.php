<?php

namespace App\Http\Controllers\API\V2;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Models\Products\Item;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GoodsController;
use App\Http\Controllers\API\V2\ItemController;

class HomeController extends Controller
{
    public function index(Request $request, $slug)
    {
        $itemController = new ItemController($request);
        $itemQuery = $itemController->query();
        $category_id = DB::table('categories')->where('slug', $slug)->first()->id;
        $goods = new GoodsController();
        $saleItems = $itemQuery
            ->where('discount', '!=', 0)
            ->where('category_id', $category_id)
            ->with(['sizes', 'color', 'media', 'seasons', 'brand'])
            ->inRandomOrder()
            ->limit(15)
            ->get();
        $newItems = Item::where('category_id', $category_id)
            ->with(['sizes', 'color', 'media', 'seasons', 'brand'])
            ->orderBy('id', 'desc')
            ->limit(15)
            ->get()
            ->shuffle();

        $data = (object) array(
            'saleItems' => $saleItems,
            'newItems' => $newItems,
        );
        return response()->json(['response' => $data]);
        // return view('home', compact('saleGoods', 'newGoods', 'pageContent', 'catalog'));
    }
}
