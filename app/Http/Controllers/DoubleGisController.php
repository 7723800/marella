<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products\Item;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;

class DoubleGisController extends Controller
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
        $items = Item::where('category_id', $id)->orderBy('id', 'desc')->limit(200)->get()->unique('vendor_id');
        $file = View::make('vendor.doublegis.yml')->with('items', $items)->render();

        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?> \n" . $file;

        $response = Response::make($xml, 200);
        $response->header('Content-Type', 'text/xml');
        $response->header('Cache-Control', 'public');
        $response->header('Content-Description', 'File Transfer');
        $response->header('Content-Disposition', 'attachment; filename=doublegis.yml');
        $response->header('Content-Transfer-Encoding', 'binary');
        return $response;
    }
}
