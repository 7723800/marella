<?php

namespace App\Http\Controllers\API\V2;

use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use App\Models\Apps\Apple\Item;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CategoryController as BaseCategoryController;

class CategoryController extends BaseCategoryController
{
    use ApiResponder;

    /**
     * Get product
     *
     * @param string $id
     * @return object
     */
    public function product($id)
    {
        $query = $this->itemsQuery();
        $item = $query->where('id', $id)->first();

        if (is_null($item)) return $this->errorResponse("Product not found", 500);

        return $this->successResponse(array($item));
    }

    /**
     * Get products depends on params
     *
     * @param string $category
     * @param string $slug
     * @return object
     */
    public function items($category, $slug)
    {
        $category_id = DB::table('categories')->where('slug', $category)->first()->id;
        if ($slug === 'all') $this->query[] = ['items.subcategory_id', '!=', 46];
        else {
            $subcategory_id = DB::table('subcategories')->select('id', 'slug')->where('slug', $slug)->first()->id;
            $this->query[] = ['subcategory_id', $subcategory_id];
        }
        $query = $this->itemsQuery($category_id);
        $items = $query->orderBy($this->sort['column'], $this->sort['direction'])->limit($this->limit)->offset(($this->request->page - 1) * $this->limit)->get();

        return $items->count() == 0 ? $this->errorResponse("Products not found", 500) : $this->successResponse($items);
    }

    /**
     * Only products with discount
     *
     * @param string $slug
     * @return response
     */
    public function saleItems($slug)
    {
        $category_id = DB::table('categories')->where('slug', $slug)->first()->id;
        $query = $this->itemsQuery($category_id);
        $items = $query->where('discount', '!=', 0)->inRandomOrder()->limit($this->limit)->get();

        // if ($items->count() == 0) return $this->errorResponse("Products not found", 500);

        return $items->count() == 0 ? $this->errorResponse("Products not found", 500) : $this->successResponse($items);
    }

    /**
     * Only new products
     *
     * @param string $slug
     * @return response
     */
    public function newItems($slug)
    {
        $category_id = DB::table('categories')->where('slug', $slug)->first()->id;
        $query = $this->itemsQuery($category_id);
        $items = $query->where([['new', '!=', 0], ['items.subcategory_id', '!=', 46]])->orderBy('id', 'desc')->limit($this->limit)->get()->shuffle();

        // if (!count($items)) return $this->errorResponse("Products not found", 500);

        return $items->count() == 0 ? $this->errorResponse("Products not found", 500) : $this->successResponse($items);
    }

    /**
     * Only popular products
     *
     * @param string $slug
     * @return response
     */
    public function popularItems($slug)
    {
        $category_id = DB::table('categories')->where('slug', $slug)->first()->id;
        $populars = DB::table('popular_items')->pluck('item_id')->toArray();
        $query = $this->itemsQuery($category_id);
        $items = $query->whereIn('id', $populars)->orderBy('id', 'desc')->limit($this->limit)->get()->unique('id')->shuffle();

        // if (!count($items)) return $this->errorResponse("Products not found", 500);

        return $items->count() == 0 ? $this->errorResponse("Products not found", 500) : $this->successResponse($items);;
    }


    /**
     * Query for items
     *
     * @param int $id
     * @return query Query Builder
     */
    public function itemsQuery($categoryId = null)
    {
        if ($categoryId) $this->query[] = ['category_id', '=', $categoryId];
        return Item::where($this->query)
            ->with(['color', 'seasons', 'sourceState', 'manufactureState', 'alsoBoughtProducts'])
            ->whereHas('sizes', function ($q) {
                if ($this->request->has('sizes')) $q->whereIn('value', json_decode($this->request->sizes, true));
            })->whereHas('brand', function ($q) {
                if ($this->request->has('brands')) $q->whereIn('value', json_decode($this->request->brands, true));
            })->whereHas('seasons', function ($q) {
                if ($this->request->has('seasons')) $q->whereIn('value', json_decode($this->request->seasons, true));
            })->whereHas('color', function ($q) {
                if ($this->request->has('colors')) $q->whereIn('value', json_decode($this->request->colors, true));
            })->where(function ($q) {
                if ($this->request->has('price_min')) $q->where('final_price', '>=', json_decode($this->request->price_min));
                if ($this->request->has('price_max')) $q->where('final_price', '<=', json_decode($this->request->price_max));
            });
    }
}
