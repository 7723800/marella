<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\CategoryController;

class SearchController extends CategoryController
{

    public function index()
    {
        return view('search')->with('data', $this->getItems());
    }

    public function getKeywords()
    {
        $itemsID = DB::table('items')
            ->select('items.id')
            ->where([[$this->query], ['published', 1], ['deleted_at', null]])
            ->where(function ($q) {
                if ($this->request->has('c')) $q->where('category_id', json_decode($this->request->c));
            })
            ->join('item_search_keyword_pivot', 'items.id', '=', 'item_search_keyword_pivot.item_id')
            ->join('item_search_keywords', 'item_search_keywords.id', '=', 'item_search_keyword_pivot.keyword_id')
            ->where('item_search_keywords.name', 'LIKE', "%{$this->request->phrase}%")
            ->pluck('id');

        $keywords = DB::table('item_search_keyword_pivot')
            ->join('item_search_keywords', 'item_search_keyword_pivot.keyword_id', '=', 'item_search_keywords.id')
            ->whereIn('item_id', $itemsID)
            ->select('item_search_keywords.id', 'item_search_keywords.name')
            ->distinct('item_search_keyword_pivot.keyword_id')
            // ->orderBy('item_search_keywords.name', 'asc')
            ->orderByRaw("item_search_keywords.name LIKE '{$this->request->phrase}%' DESC, item_search_keywords.name LIKE '%{$this->request->phrase}%' DESC, LENGTH(item_search_keywords.name) ASC")
            ->limit(7)
            ->get();

        return $keywords;
    }

    public function getItems()
    {
        if (!$this->request->has('phrase')) $this->query[] = ['items.subcategory_id', '!=', 46];
        $query = Item::with(['keywords'])
            ->where($this->query)
            ->where(function ($q) {
                if ($this->request->has('c')) $q->where('category_id', json_decode($this->request->c));
                if ($this->request->has('price_min')) $q->where('final_price', '>=', json_decode($this->request->price_min));
                if ($this->request->has('price_max')) $q->where('final_price', '<=', json_decode($this->request->price_max));
            })
            ->whereHas('keywords', function ($q) {
                $q->select('id', 'name')->where('name', 'LIKE', "%{$this->request->phrase}%");
            })
            ->whereHas('brand', function ($q) {
                if ($this->request->has('brands')) $q->whereIn('value', json_decode($this->request->brands, true));
            })
            ->whereHas('seasons', function ($q) {
                if ($this->request->has('seasons')) $q->whereIn('value', json_decode($this->request->seasons, true));
            })
            ->whereHas('color', function ($q) {
                if ($this->request->has('colors')) $q->whereIn('value', json_decode($this->request->colors, true));
            })
            ->whereHas('sizes', function ($q) {
                if ($this->request->has('sizes')) $q->whereIn('value', json_decode($this->request->sizes, true));
            });

        $total = $query->distinct()->pluck('id')->count();
        $items = $query->orderBy($this->sort['column'], $this->sort['direction'])
            ->limit($this->limit)
            ->offset(($this->request->page - 1) * $this->limit)
            ->get();
        //   ->unique('id');

        return array(
            'page' => (object) array(
                'title' => 'Поиск',
                'slug' => 'search'
            ),
            'items' => $items,
            'paginate' => (object) array(
                'total' => $total,
                'perPage' => $this->limit
            ),
            'price' => $this->getPrice(),
            'colors' => $this->getColors(),
            'brands' => $this->getBrands(),
            'seasons' => $this->getSeasons(),
            'sizes' => $this->getSizes(),
            'subcategory' => $this->getSubcategory(),
            'isGendersItems' => $this->isGendersItems(),
            'catalog' => $this->getCatalog(),
        );
    }

    public function getColors()
    {

        $colors = DB::table('items')
            ->where([['deleted_at', '=', null], [$this->query], ['item_search_keywords.name', 'LIKE', "%{$this->request->phrase}%"]])
            ->join('item_size_pivot', 'items.id', '=', 'item_size_pivot.item_id')
            ->join('item_sizes', 'item_sizes.id', '=', 'item_size_pivot.size_id')
            ->join('item_season_pivot', 'items.id', '=', 'item_season_pivot.item_id')
            ->join('item_seasons', 'item_seasons.id', '=', 'item_season_pivot.season_id')
            ->join('item_search_keyword_pivot', 'items.id', '=', 'item_search_keyword_pivot.item_id')
            ->join('item_search_keywords', 'item_search_keywords.id', '=', 'item_search_keyword_pivot.keyword_id')
            ->join('item_colors', 'items.color_id', '=', 'item_colors.id')
            ->join('item_brands', 'items.brand_id', '=', 'item_brands.id')
            ->where(function ($q) {
                if ($this->request->has('c')) $q->where('items.category_id', json_decode($this->request->c));
                if ($this->request->has('sizes')) $q->whereIn('item_sizes.value', json_decode($this->request->sizes, true));
                if ($this->request->has('brands')) $q->whereIn('item_brands.value', json_decode($this->request->brands, true));
                if ($this->request->has('seasons')) $q->whereIn('item_seasons.value', json_decode($this->request->seasons, true));
                if ($this->request->has('price_min')) $q->where('final_price', '>=', json_decode($this->request->price_min));
                if ($this->request->has('price_max')) $q->where('final_price', '<=', json_decode($this->request->price_max));
            })
            ->select('item_colors.id', 'item_colors.name', 'item_colors.value', 'item_colors.data')
            ->orderBy('item_colors.name')
            ->distinct('item_colors.id')
            ->get();

        foreach ($colors as $color) {
            $color->data = Storage::url($color->data);
        }

        return $colors;
    }

    public function getBrands()
    {

        $brands = DB::table('items')
            ->where([['deleted_at', '=', null], [$this->query], ['item_search_keywords.name', 'LIKE', "%{$this->request->phrase}%"]])
            ->join('item_size_pivot', 'items.id', '=', 'item_size_pivot.item_id')
            ->join('item_sizes', 'item_sizes.id', '=', 'item_size_pivot.size_id')
            ->join('item_season_pivot', 'items.id', '=', 'item_season_pivot.item_id')
            ->join('item_seasons', 'item_seasons.id', '=', 'item_season_pivot.season_id')
            ->join('item_search_keyword_pivot', 'items.id', '=', 'item_search_keyword_pivot.item_id')
            ->join('item_search_keywords', 'item_search_keywords.id', '=', 'item_search_keyword_pivot.keyword_id')
            ->join('item_colors', 'items.color_id', '=', 'item_colors.id')
            ->join('item_brands', 'items.brand_id', '=', 'item_brands.id')
            ->where(function ($q) {
                if ($this->request->has('c')) $q->where('items.category_id', json_decode($this->request->c));
                if ($this->request->has('sizes')) $q->whereIn('item_sizes.value', json_decode($this->request->sizes, true));
                if ($this->request->has('colors')) $q->whereIn('item_colors.value', json_decode($this->request->colors, true));
                if ($this->request->has('seasons')) $q->whereIn('item_seasons.value', json_decode($this->request->seasons, true));
                if ($this->request->has('price_min')) $q->where('final_price', '>=', json_decode($this->request->price_min));
                if ($this->request->has('price_max')) $q->where('final_price', '<=', json_decode($this->request->price_max));
            })
            ->select('item_brands.id', 'item_brands.name', 'item_brands.value')
            ->orderBy('item_brands.name')
            ->distinct('item_brands.id')
            ->get();

        return $brands;
    }

    public function getSeasons()
    {
        $itemsIDs = DB::table('items')
            ->select('items.id')
            ->where([['deleted_at', '=', null], [$this->query], ['item_search_keywords.name', 'LIKE', "%{$this->request->phrase}%"]])
            ->join('item_size_pivot', 'items.id', '=', 'item_size_pivot.item_id')
            ->join('item_sizes', 'item_sizes.id', '=', 'item_size_pivot.size_id')
            ->join('item_search_keyword_pivot', 'items.id', '=', 'item_search_keyword_pivot.item_id')
            ->join('item_search_keywords', 'item_search_keywords.id', '=', 'item_search_keyword_pivot.keyword_id')
            ->join('item_colors', 'items.color_id', '=', 'item_colors.id')
            ->join('item_brands', 'items.brand_id', '=', 'item_brands.id')
            ->where(function ($q) {
                if ($this->request->has('c')) $q->where('category_id', json_decode($this->request->c));
                if ($this->request->has('colors')) $q->whereIn('item_colors.value', json_decode($this->request->colors, true));
                if ($this->request->has('brands')) $q->whereIn('item_brands.value', json_decode($this->request->brands, true));
                if ($this->request->has('sizes')) $q->whereIn('item_sizes.value', json_decode($this->request->sizes, true));
                if ($this->request->has('price_min')) $q->where('items.final_price', '>=', json_decode($this->request->price_min));
                if ($this->request->has('price_max')) $q->where('items.final_price', '<=', json_decode($this->request->price_max));
            })
            ->pluck('id');

        $seasons = DB::table('item_season_pivot')
            ->join('item_seasons', 'item_season_pivot.season_id', '=', 'item_seasons.id')
            ->whereIn('item_id', $itemsIDs)
            ->distinct('item_season_pivot.season_id')
            ->select('item_seasons.id', 'item_seasons.value', 'item_seasons.name')
            ->orderBy('item_seasons.name', 'asc')
            ->get();

        return $seasons;
    }

    public function getSizes()
    {
        $sizes = array();
        $items = DB::table('items')
            ->where([['deleted_at', '=', null], [$this->query], ['item_search_keywords.name', 'LIKE', "%{$this->request->phrase}%"], ['subcategories.subcategory_type_id', '!=', 3]])
            ->join('item_season_pivot', 'items.id', '=', 'item_season_pivot.item_id')
            ->join('item_seasons', 'item_seasons.id', '=', 'item_season_pivot.season_id')
            ->join('item_search_keyword_pivot', 'items.id', '=', 'item_search_keyword_pivot.item_id')
            ->join('item_search_keywords', 'item_search_keywords.id', '=', 'item_search_keyword_pivot.keyword_id')
            ->join('subcategories', 'items.subcategory_id', '=', 'subcategories.id')
            ->join('item_colors', 'items.color_id', '=', 'item_colors.id')
            ->join('item_brands', 'items.brand_id', '=', 'item_brands.id')
            ->where(function ($q) {
                if ($this->request->has('c')) $q->where('items.category_id', json_decode($this->request->c));
                if ($this->request->has('colors')) $q->whereIn('item_colors.value', json_decode($this->request->colors, true));
                if ($this->request->has('brands')) $q->whereIn('item_brands.value', json_decode($this->request->brands, true));
                if ($this->request->has('seasons')) $q->whereIn('item_seasons.value', json_decode($this->request->seasons, true));
                if ($this->request->has('price_min')) $q->where('final_price', '>=', json_decode($this->request->price_min));
                if ($this->request->has('price_max')) $q->where('final_price', '<=', json_decode($this->request->price_max));
            })
            ->select('items.id', 'subcategories.subcategory_type_id as sub_type')
            ->orderBy('sub_type', 'asc')
            ->get()
            ->groupBy('sub_type');

        foreach ($items as $item) {
            $sizes[] = (object) array(
                'title' => DB::table('subcategory_types')->select('name')->where('id', $item[0]->sub_type)->first()->name,
                'sizes' => $this->getSizeType($item->pluck('id')->all())
            );
        }

        return $sizes;
    }

    public function getPrice()
    {

        $query = DB::table('items')
            ->where([['deleted_at', '=', null], [$this->query], ['item_search_keywords.name', 'LIKE', "%{$this->request->phrase}%"]])
            ->join('item_season_pivot', 'items.id', '=', 'item_season_pivot.item_id')
            ->join('item_seasons', 'item_seasons.id', '=', 'item_season_pivot.season_id')
            ->join('item_size_pivot', 'items.id', '=', 'item_size_pivot.item_id')
            ->join('item_sizes', 'item_sizes.id', '=', 'item_size_pivot.size_id')
            ->join('item_search_keyword_pivot', 'items.id', '=', 'item_search_keyword_pivot.item_id')
            ->join('item_search_keywords', 'item_search_keywords.id', '=', 'item_search_keyword_pivot.keyword_id')
            ->join('item_colors', 'items.color_id', '=', 'item_colors.id')
            ->join('item_brands', 'items.brand_id', '=', 'item_brands.id')
            ->where(function ($q) {
                if ($this->request->has('c')) $q->where('category_id', json_decode($this->request->c));
                if ($this->request->has('colors')) $q->whereIn('item_colors.value', json_decode($this->request->colors, true));
                if ($this->request->has('sizes')) $q->whereIn('item_sizes.value', json_decode($this->request->sizes, true));
                if ($this->request->has('seasons')) $q->whereIn('item_seasons.value', json_decode($this->request->seasons, true));
                if ($this->request->has('brands')) $q->whereIn('item_brands.value', json_decode($this->request->brands, true));
                if ($this->request->has('price_min')) $q->where('final_price', '>=', json_decode($this->request->price_min));
                if ($this->request->has('price_max')) $q->where('final_price', '<=', json_decode($this->request->price_max));
            })
            ->select('items.final_price')
            ->distinct('items.final_price');

        $min = $query->min('final_price');
        $max = $query->max('final_price');
        return (object) array(
            'min' => $min,
            'max' => $max,
        );
    }

    private function getSubcategory()
    {
        $item = Item::select('id', 'subcategory_id')
            ->with(['keywords', 'subcategory'])
            ->whereHas('keywords', function ($q) {
                $q->select('id', 'name')->where('name', 'LIKE', "%{$this->request->phrase}%");
            })
            ->first();

        return (object) array(
            'id' => $item->subcategory->id,
            'name' => $item->subcategory->name,
        );
    }

    private function isGendersItems()
    {
        $checkGender = function ($category_id) {
            return Item::select('category_id')
                ->where('category_id', $category_id)
                ->with('keywords')
                ->where($this->query)
                ->whereHas('keywords', function ($q) {
                    $q->select('id', 'name')->where('name', 'LIKE', "%{$this->request->phrase}%");
                })
                ->first();
        };
        $women = $checkGender(1);
        $men = $checkGender(2);
        $isGendersItems = $women && $men ? true : false;

        return $isGendersItems;
    }
}
