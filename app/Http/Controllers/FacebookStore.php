<?php

namespace App\Http\Controllers;

use App\Models\Products\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;

class FacebookStore extends Controller
{
    public function women()
    {
        return $this->create(1);
    }

    public function men()
    {
        return $this->create(2);
    }

    public function create($id)
    {
        $items = Item::where('category_id', $id)->orderBy('id', 'desc')->get()->toArray();
        $file = View::make('vendor.facebook.csv')->with('items', $items)->render();

        $file_with_bom = chr(239) . chr(187) . chr(191) . $file;

        $response = Response::make($file_with_bom, 200);
        $response->header('Content-Type', 'application/csv; charset=UTF-8');
        $response->header('Content-Disposition', 'attachment; filename=facebook.csv');
        return $response;
    }
}
