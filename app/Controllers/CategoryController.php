<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\Products\Item;
use App\Models\SubcategoryType;
use App\Models\SecondSubcategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\GoodsController;
use Inani\LaravelNovaConfiguration\Helpers\Configuration;

class CategoryController extends Controller
{
    public $request;
    public $query = array();
    public $limit = 24;
    public $sort;

    public function __construct(Request $request)
    {
        $this->request = $request;
        // $this->limit = (int) Configuration::get('ITEMS_PER_PAGE');
        $this->sort = $this->getSortData($request->sort);
    }

    public function index()
    {
        $data = $this->getData();
        return empty($data) ? redirect('/') : view('category')->with('data', $data);
    }

    public function getData()
    {
        $data = $this->getItems();
        if (empty($data)) return array();
        return array(
            'page' => $this->getPageData(1),
            'items' => $data->items,
            'subcategories' => $this->getSubcategories(1),
            'colors' => $this->getColors(),
            'sizes' => $this->getSizes(),
            'brands' => $this->getBrands(),
            'seasons' => $this->getSeasons(),
            'branches' => $this->getBranches(),
            'price' => $this->getPrice(),
            'paginate' => $data->paginate,
            'catalog' => $this->getCatalog(),
        );
    }

    public function getSortData($sort)
    {
        switch ($sort) {
            case 'price_asc':
                $column = 'final_price';
                $direction = 'asc';
                break;
            case 'price_desc':
                $column = 'final_price';
                $direction = 'desc';
                break;
            case 'discount':
                $column = 'discount';
                $direction = 'desc';
                break;
            default:
                $column = 'new';
                $direction = 'desc';
                break;
        }
        return array(
            'column' => $column,
            'direction' => $direction
        );
    }

    public function getPageData($id)
    {
        $slug = Page::where('id', $id)->first()->slug;
        if ($this->request->is_new) $slug .= '-new';
        if ($this->request->is_discount) $slug .= '-discount';
        $title = Page::select('title')->where('slug', $slug)->first()->title;
        return (object) array(
            'title' => $title,
            'slug' => $slug
        );
    }

    public function getItems()
    {
        $column = 'subcategory_id';
        $where = [['category_id', $this->request->c], ['slug', $this->request->items]];

        if ($this->request->is_new) $this->query[] = ['new', $this->request->is_new];
        if ($this->request->is_kaspi) $this->query[] = ['isKaspi', $this->request->is_kaspi];
        if ($this->request->is_discount) $this->query[] = ['discount', '!=', 0];
        if ($this->request->sale) $this->query[] = ['discount', '=', $this->request->sale];
        if ($this->request->is_outlet) $this->query[] = ['outlet', '!=', 0];

        if ($this->request->items === 'all') array_push($this->query, ['items.category_id', $this->request->c], ['items.subcategory_id', '!=', 46]);
        else {
            $result = Subcategory::where($where)->first();
            if ($result === null) {
                $result = SecondSubcategory::where($where)->first() ?? abort(404);
                $column = 'second_subcategory_id';
            }
            $this->query[] = [$column, $result->id];
        }

        $query = Item::where($this->query)
            // ->with(['color', 'seasons'])
            ->whereHas('brand', function ($q) {
                if ($this->request->has('brands')) $q->whereIn('value', json_decode($this->request->brands, true));
            })->whereHas('seasons', function ($q) {
                if ($this->request->has('seasons')) $q->whereIn('value', json_decode($this->request->seasons, true));
            })->whereHas('color', function ($q) {
                if ($this->request->has('colors')) $q->whereIn('value', json_decode($this->request->colors, true));
            })->where(function ($q) {
                if ($this->request->has('price_min')) $q->where('final_price', '>=', json_decode($this->request->price_min));
                if ($this->request->has('price_max')) $q->where('final_price', '<=', json_decode($this->request->price_max));
            })->whereHas('sizes', function ($q) {
                if ($this->request->has('sizes')) $q->whereIn('value', json_decode($this->request->sizes, true));
            })->whereHas('branch', function ($q) {
                if ($this->request->has('branches')) $q->whereIn('slug', json_decode($this->request->branches, true));
            });
        if ($this->request->items === 'all') {
            $query->where(function ($query) {
                $query->whereNotIN('second_subcategory_id', [8, 9, 10, 11])
                    ->orWhereNull('second_subcategory_id');
            });
        }

        $total = $query->select('*')->distinct()->pluck('id')->count();
        $items = $query->orderBy($this->sort['column'], $this->sort['direction'])->orderBy('discount', 'ASC')->orderBy('created_at', 'DESC')->limit($this->limit)->offset(($this->request->page - 1) * $this->limit)->get()->unique('id');

        if (!count($items)) return array();

        return (object) array(
            'items' => $items,
            'paginate' => (object) array(
                'total' => $total,
                'perPage' => $this->limit
            )
        );
    }

    protected function getSubcategories($categoryID)
    {
        $query = ['category_id' => $categoryID];
        if ($this->request->is_new) $query[] = ['new', $this->request->is_new];
        if ($this->request->is_discount) $query[] = ['discount', '!=', 0];

        $allSubcategories = array(
            'id' => 0,
            'name' => 'Все товары',
            'category_id' => $categoryID,
            'second_subcategories' => array(),
            'slug' => 'all',
        );

        $subcategoryIDs = Item::select('subcategory_id')
            ->where($query)
            ->distinct('subcategory_id')
            ->pluck('subcategory_id')
            ->toArray();

        $secondSubcategoryIDs = Item::select('second_subcategory_id')
            ->where($query)
            ->whereNotNull('second_subcategory_id')
            ->distinct('second_subcategory_id')
            ->pluck('second_subcategory_id')
            ->toArray();

        $subcategories = Subcategory::select('id', 'name', 'category_id', 'slug')
            ->with(['secondSubcategories' => function ($q) use ($secondSubcategoryIDs) {
                $q->select('id', 'name', 'category_id', 'subcategory_id', 'slug')->whereIn('id', $secondSubcategoryIDs)->get();
            }])
            ->whereIn('id', $subcategoryIDs)
            ->orderBy('name', 'ASC')
            ->get()
            ->makeVisible('category_id')
            ->toArray();

        if (count($subcategories)) array_unshift($subcategories, $allSubcategories);

        return $subcategories;
    }

    public function getPrice()
    {
        $query = Item::select('final_price')->where($this->query);
        $max = $query->max('final_price');
        $min = $query->min('final_price');
        return (object) array(
            'min' => $min,
            'max' => $max,
        );
    }

    public function getColors()
    {
        $items = Item::select('color_id')
            // ->where(function ($query) { // Это аксессуары и шапки
            //     $query->whereNotIN('second_subcategory_id', [8, 9, 10, 11])
            //         ->orWhereNull('second_subcategory_id');
            // })
            ->where($this->query)
            ->with(['color', 'sizes', 'seasons', 'brand', 'branch'])
            ->whereHas('sizes', function ($q) {
                if ($this->request->has('sizes')) $q->whereIn('value', json_decode($this->request->sizes, true));
            })
            ->whereHas('seasons', function ($q) {
                if ($this->request->has('seasons')) $q->whereIn('value', json_decode($this->request->seasons, true));
            })
            ->whereHas('brand', function ($q) {
                if ($this->request->has('brands')) $q->whereIn('value', json_decode($this->request->brands, true));
            })
            ->whereHas('branch', function ($q) {
                if ($this->request->has('branches')) $q->whereIn('slug', json_decode($this->request->branches, true));
            })
            ->where(function ($q) {
                if ($this->request->has('price_min')) $q->where('final_price', '>=', json_decode($this->request->price_min));
                if ($this->request->has('price_max')) $q->where('final_price', '<=', json_decode($this->request->price_max));
            })
            ->distinct('color_id')
            ->groupBy('color_id')
            ->get();

        foreach ($items as $item) {
            $color = (object) array(
                'id' => $item->color->id,
                'name' => $item->color->name,
                'value' => $item->color->value,
                'data' => Storage::url($item->color->data),
            );
            $colors[] = $color;
        }
        usort($colors, function ($a, $b) {
            return $a->name <=> $b->name;
        });

        return $colors;
    }

    public function getSizes()
    {
        $sizes = array();
        $items = DB::table('items')
            ->where(function ($query) { // Это аксессуары и шапки
                $query->whereNotIN('second_subcategory_id', [8, 9, 10, 11])
                    ->orWhereNull('second_subcategory_id');
            })
            ->where($this->query)
            ->join('item_season_pivot', 'items.id', '=', 'item_season_pivot.item_id')
            ->join('item_seasons', 'item_seasons.id', '=', 'item_season_pivot.season_id')
            ->join('subcategories', 'items.subcategory_id', '=', 'subcategories.id')
            ->whereExists(function ($q) {
                if ($this->request->has('colors'))
                    $q->select('value')->from('item_colors')->whereRaw('item_colors.id = items.color_id')->whereIn('value', json_decode($this->request->colors, true));
            })
            ->whereExists(function ($q) {
                if ($this->request->has('brands'))
                    $q->select('value')->from('item_brands')->whereRaw('item_brands.id = items.brand_id')->whereIn('value', json_decode($this->request->brands, true));
            })
            ->whereExists(function ($q) {
                if ($this->request->has('branches'))
                    $q->select('slug')->from('branches')->whereRaw('branches.id = items.brand_id')->whereIn('slug', json_decode($this->request->branches, true));
            })
            ->where(function ($q) {
                if ($this->request->has('seasons'))
                    $q->whereIn('item_seasons.value', json_decode($this->request->seasons, true));
            })
            ->where(function ($q) {
                if ($this->request->has('price_min')) $q->where('final_price', '>=', json_decode($this->request->price_min));
                if ($this->request->has('price_max')) $q->where('final_price', '<=', json_decode($this->request->price_max));
            })
            ->select('items.id', 'subcategories.subcategory_type_id as sub_type')
            ->where('subcategories.subcategory_type_id', '!=', 3)
            ->orderBy('sub_type', 'asc')
            ->get()
            ->groupBy('sub_type');

        foreach ($items as $item) {
            $sizes[] = (object) array(
                'title' => SubcategoryType::select('name')->where('id', $item[0]->sub_type)->first()->name,
                'sizes' => $this->getSizeType($item->pluck('id')->all())
            );
        }
        return $sizes;
    }

    public function getSizeType($ids)
    {
        return DB::table('item_size_pivot')
            ->join('item_sizes', 'item_size_pivot.size_id', '=', 'item_sizes.id')
            ->whereIn('item_id', $ids)
            ->distinct('item_size_pivot.size_id')
            ->select('item_sizes.id', 'item_sizes.value', 'item_sizes.data')
            ->orderBy('item_sizes.data', 'ASC')
            ->get();
    }

    public function getBrands()
    {
        $items = Item::select('brand_id')
            // ->where(function ($query) { // Это аксессуары и шапки
            //     $query->whereNotIN('second_subcategory_id', [8, 9, 10, 11])
            //         ->orWhereNull('second_subcategory_id');
            // })
            ->where($this->query)
            ->with(['color', 'sizes', 'seasons', 'brand', 'branch'])
            ->whereHas('color', function ($q) {
                if ($this->request->has('colors')) $q->whereIn('value', json_decode($this->request->colors, true));
            })
            ->whereHas('seasons', function ($q) {
                if ($this->request->has('seasons')) $q->whereIn('value', json_decode($this->request->seasons, true));
            })
            ->whereHas('sizes', function ($q) {
                if ($this->request->has('sizes')) $q->whereIn('value', json_decode($this->request->sizes, true));
            })
            ->whereHas('branch', function ($q) {
                if ($this->request->has('branches')) $q->whereIn('slug', json_decode($this->request->branches, true));
            })
            ->where(function ($q) {
                if ($this->request->has('price_min')) $q->where('final_price', '>=', json_decode($this->request->price_min));
                if ($this->request->has('price_max')) $q->where('final_price', '<=', json_decode($this->request->price_max));
            })->distinct('brand_id')
            ->get();

        foreach ($items as $item) {
            try {
                $brand = (object) [
                    'id' => $item->brand['id'],
                    'name' => $item->brand['name'],
                    'value' => $item->brand['value'],
                ];
            } catch (\Throwable $th) {
                // report($th);
            }
            $brands[] = $brand;
        }
        usort($brands, function ($a, $b) {
            return $a->value <=> $b->value;
        });

        return $brands;
    }

    public function getSeasons()
    {
        $itemsID = DB::table('items')
            ->select('items.id')
            ->where($this->query)
            ->join('item_size_pivot', 'items.id', '=', 'item_size_pivot.item_id')
            ->join('item_sizes', 'item_sizes.id', '=', 'item_size_pivot.size_id')
            ->whereExists(function ($q) {
                if ($this->request->has('colors')) $q->select('value')->from('item_colors')->whereRaw('item_colors.id = items.color_id')->whereIn('value', json_decode($this->request->colors, true));
            })
            ->whereExists(function ($q) {
                if ($this->request->has('brands')) $q->select('value')->from('item_brands')->whereRaw('item_brands.id = items.brand_id')->whereIn('value', json_decode($this->request->brands, true));
            })
            ->whereExists(function ($q) {
                if ($this->request->has('branches')) $q->select('slug')->from('branches')->whereRaw('branches.id = items.branch_id')->whereIn('slug', json_decode($this->request->branches, true));
            })
            ->where(function ($q) {
                if ($this->request->has('sizes'))
                    $q->whereIn('item_sizes.value', json_decode($this->request->sizes, true));
            })
            ->where(function ($q) {
                if ($this->request->has('price_min')) $q->where('final_price', '>=', json_decode($this->request->price_min));
                if ($this->request->has('price_max')) $q->where('final_price', '<=', json_decode($this->request->price_max));
            })
            ->pluck('id');

        $seasons = DB::table('item_season_pivot')
            ->join('item_seasons', 'item_season_pivot.season_id', '=', 'item_seasons.id')
            ->whereIn('item_id', $itemsID)
            ->distinct('item_season_pivot.season_id')
            ->select('item_seasons.id', 'item_seasons.value', 'item_seasons.name')
            ->orderBy('item_seasons.name', 'asc')
            ->get();

        return $seasons;
    }

    public function getBranches()
    {
        $items = Item::select('branch_id')
            ->where(function ($query) { // Это аксессуары и шапки
                $query->whereNotIN('second_subcategory_id', [8, 9, 10, 11])
                    ->orWhereNull('second_subcategory_id');
            })
            ->where($this->query)
            ->with(['color', 'sizes', 'seasons', 'brand', 'branch'])
            ->whereHas('color', function ($q) {
                if ($this->request->has('colors')) $q->whereIn('value', json_decode($this->request->colors, true));
            })
            ->whereHas('seasons', function ($q) {
                if ($this->request->has('seasons')) $q->whereIn('value', json_decode($this->request->seasons, true));
            })
            ->whereHas('sizes', function ($q) {
                if ($this->request->has('sizes')) $q->whereIn('value', json_decode($this->request->sizes, true));
            })
            ->where(function ($q) {
                if ($this->request->has('price_min')) $q->where('final_price', '>=', json_decode($this->request->price_min));
                if ($this->request->has('price_max')) $q->where('final_price', '<=', json_decode($this->request->price_max));
            })
            ->get()
            ->unique('branch_id');

        $branches = [];
        foreach ($items as $item) {
            try {
                $branch = (object) [
                    'id' => $item->branch['id'],
                    'address' => $item->branch['address'],
                    'slug' => $item->branch['slug'],
                ];
                if (!in_array($branch, $branches, true)) {
                    $branches[] = $branch;
                }
            } catch (\Throwable $th) {
                // report($th);
            }
        }

        return $branches;
    }

    public function getCatalog()
    {
        $momen = 1; //women category id
        $men = 2; //men category id
        $sets = array();
        $catalog = new self(new Request());
        $hasWomenNew = DB::table('items')->select('id')->where([['category_id', $momen], ['new', 1]])->first();
        $hasWomenKaspi = DB::table('items')->select('id')->where([['category_id', $momen], ['isKaspi', 1], ['deleted_at', null]])->first();
        // $hasMenNew = DB::table('items')->select('id')->where([['category_id', $men], ['new', 1]])->first();
        $hasWomenDiscount = DB::table('items')->select('id')->where([['category_id', $momen], ['discount', '!=', 0]])->first();
        $hasWomenOutlet = DB::table('items')->select('id')->where([['category_id', $momen], ['outlet', '!=', 0]])->first();
        // $hasMenOutlet = DB::table('items')->select('id')->where([['category_id', $men], ['outlet', '!=', 0]])->first();
        // $hasMenDiscount = DB::table('items')->select('id')->where([['category_id', $men], ['discount', '!=', 0]])->first();
        $deliveryPrice = number_format((int) Configuration::get("DELIVERY_PRICE"), 0, ".", " ");
        $giftcards = DB::table('pages')->select('title')->where('id', 9)->first();
        // $perfumes = DB::table('pages')->select('title')->where('id', 8)->first();
        $kits = DB::table('pages')->select('title')->where('id', 10)->first();
        $category_id =  1;
        $categories = DB::table('categories')
            ->join('item_sets', 'item_sets.category_id', '=', 'categories.id')
            ->select('categories.name', 'categories.slug', 'item_sets.category_id')
            ->distinct('item_sets.category_id')
            ->get()
            ->toArray();


        $category_data = Arr::where($categories, function ($c) use ($category_id) {
            return $c->category_id === $category_id;
        });
        $category_data = array_shift($category_data);

        foreach ($categories as $category) {
            $sets[$category->slug] = $category;
        }

        return (object) array(
            'women_title' => Category::where("id", $momen)->first()->name,
            'men_title' => '',
            'women' => $catalog->getSubcategories($momen),
            'men' => [],
            'women_category_id' => $momen,
            'men_category_id' => $men,
            'is_women_new' => isset($hasWomenNew),
            'is_men_new' => false,
            'is_women_discount' => isset($hasWomenDiscount),
            'is_men_discount' => false,
            'is_women_outlet' => isset($hasWomenOutlet),
            'is_men_outlet' => false,
            'delivery_price' => $deliveryPrice,
            'giftcards' => $giftcards->title,
            'perfumes' => '',
            'category_id' => $category_id,
            'sets' => $sets,
            'sets_title' => $kits->title,
            'category_data' => $category_data,
            'is_kaspi' => isset($hasWomenKaspi),
        );
    }

    public function routeCategoryId()
    {
        $category_id = null;
        $route = Route::currentRouteName();
        switch ($route) {
            case 'home-women':
                $category_id = 1;
                break;
            case 'home-men':
                $category_id = 2;
                break;
        }
        return $category_id;
    }

    protected function getDataAPI()
    {
        $data = $this->getItems();
        if (empty($data)) return array();
        return array(
            'page' => $this->getPageData(1),
            'items' => $data->items,
            'subcategories' => $this->getSubcategories(1),
            'colors' => $this->getColors(),
            'sizes' => $this->getSizes(),
            'brands' => $this->getBrands(),
            'seasons' => $this->getSeasons(),
            'branches' => $this->getBranches(),
            'paginate' => $data->paginate,
            'price' => $this->getPrice()
        );
    }
}
