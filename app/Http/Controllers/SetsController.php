<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\ItemSet;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\Products\Item;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CategoryController;
use Inani\LaravelNovaConfiguration\Helpers\Configuration;

class SetsController extends Controller
{
    protected $slug;
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
     * Show the application main page.
     *
     * @return view sets with data
     */
    public function index($slug)
    {
        $this->slug = $slug;
        $data = $this->getData();
        return view('sets', compact('data'));
    }

    public function getData()
    {
        $items = collect(array());
        [$category] = DB::table('categories')
            ->join('item_sets', 'item_sets.category_id', '=', 'categories.id')
            ->select('categories.slug', 'item_sets.category_id as id')
            ->where('categories.slug', '=', $this->slug)
            ->get()
            ->toArray();
        $page = Page::where('id', 10)->first();
        $limit = (int) Configuration::get('ITEMS_PER_PAGE');
        $query = ItemSet::select('item_id_first', 'item_id_second')->where('category_id', '=', $category->id);
        $total = $query->count();
        $sets = $query->limit($limit / 2)->offset(($this->request->page - 1) * ($limit / 2))->orderBy('id', 'desc')->get()->toArray();
        $ids = Arr::flatten($sets);

        foreach ($ids as $key => $id) {
            $items[$key] = Item::where('id', $id)->first();
        }

        return array(
            'items' => $items,
            'catalog' => $this->getCatalog(),
            'paginate' => (object) array(
                'total' => $total * 2,
                'perPage' => $limit
            ),
            'page' => (object) array(
                'title' => $page ? $page->title : ''
            )
        );
    }

    public function getCatalog()
    {
        $categoryController = new CategoryController(new Request());
        return $categoryController->getCatalog();
    }

    public function getDataAPI($slug)
    {
        $this->slug = $slug;
        $data = $this->getData();
        return $data;
    }
}
