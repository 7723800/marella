<?php

namespace App\Http\Controllers;

use App\Models\OfficeItem;
use Illuminate\Http\Request;
use App\Models\Products\Item;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CategoryController;
use Inani\LaravelNovaConfiguration\Helpers\Configuration;

class OfficeController extends Controller
{
    protected $request;

    /**
     * Create a new sets instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Show the catalog ofiice page.
     *
     * @return view sets with data
     */
    public function index()
    {
        // $this->slug = $slug;
        $data = $this->getData();
        return view('office', compact('data'));
    }

    public function getData()
    {
        $limit = (int) Configuration::get('ITEMS_PER_PAGE');
        $total = OfficeItem::all()->count();
        $ids = OfficeItem::select('item_id')->limit($limit / 2)->offset(($this->request->page - 1) * ($limit / 2))->orderBy('id', 'desc')->pluck('item_id')->toArray();
        $items = Item::whereIn('id', $ids)->get();

        return array(
            'items' => $items,
            'catalog' => $this->getCatalog(),
            'paginate' => (object) array(
                'total' => $total * 2,
                'perPage' => $limit
            ),
            'page' => (object) array(
                'title' => "Офис"
            )
        );
    }

    public function getCatalog()
    {
        $categoryController = new CategoryController(new Request());
        return $categoryController->getCatalog();
    }

    public function getDataAPI()
    {
        $data = $this->getData();
        return $data;
    }
}
