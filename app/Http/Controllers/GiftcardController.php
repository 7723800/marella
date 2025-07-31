<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Giftcard;
use Illuminate\Http\Request;

class GiftcardController extends Controller
{
    public function index()
    {
        $items = Giftcard::with(['giftcardsizes', 'media', 'brand'])->where('giftcard_vendor_id', 2)->get();
        $categoryController = new CategoryController(new Request);
        $goodsController = new GoodsController();
        $page = Page::where('id', 9)->first();

        $data = array(
            'items' => $goodsController->buildGoods($items, 'createGiftcard'),
            'catalog' => $categoryController->getCatalog(),
            'page' => (object) array(
                'title' => $page ? $page->title : ''
            )
        );
        return view('giftcard', compact('data'));
    }

    public function item($id)
    {
        $goodsController = new GoodsController();
        $rawItem = Giftcard::where('id', $id)->with(['giftcardsizes', 'media', 'brand'])->first();
        $data = array(
            'item' => $goodsController->createGiftcard($rawItem),
            'isActive' => $rawItem->published === 0 || $rawItem->deleted_at !== null ? false : true
        );
        return view('item', compact('data'));
    }
}
