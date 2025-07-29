<?php

namespace App\Http\Controllers;

use App\Models\Products\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;

class KaspiStore extends Controller
{
    public function create()
    {
        $items = Item::with('brand')->get()->unique('vendor_id');
        $output = View::make('vendor.kaspi.xml')->with('items', $items)->render();

        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?> \n" . $output;

        $response = Response::make($xml, 200);
        $response->header('Content-Type', 'text/xml');
        $response->header('Cache-Control', 'public');
        $response->header('Content-Description', 'File Transfer');
        $response->header('Content-Disposition', 'attachment; filename=kaspi.xml');
        $response->header('Content-Transfer-Encoding', 'binary');
        return $response;
    }
}
