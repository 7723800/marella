<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Perfume;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\GoodsController;
use App\Http\Controllers\CategoryController;
use Illuminate\Database\Eloquent\Collection;

class PerfumeController extends Controller
{
    public function index()
    {
        $items = Perfume::with(['volumes', 'sex', 'media', 'type', 'brand'])->where('published', 1)->get();
        $categoryController = new CategoryController(new Request);
        $goodsController = new GoodsController();
        $page = Page::where('id', 8)->first();

        $data = array(
            'items' => $goodsController->buildGoods($items, 'createPerfume'),
            'catalog' => $categoryController->getCatalog(),
            'page' => (object) array(
                'title' => $page ? $page->title : ''
            ),
        );
        return view('perfume', compact('data'));
    }

    public function item($id)
    {
        $goodsController = new GoodsController();
        $rawItem = Perfume::where('id', $id)->with(['volumes', 'sex', 'media', 'type', 'brand'])->first();
        $data = array(
            'item' => $goodsController->createPerfume($rawItem),
            'isActive' => $rawItem->published == 1 || isset($rawItem->deleted_at)
        );
        return view('item', compact('data'));
    }
}
