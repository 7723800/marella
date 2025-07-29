<?php

namespace App\Http\Controllers;

use App\Models\Perfume;
use App\Models\Category;
use App\Models\Giftcard;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Models\Products\Item;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class GoodsController extends Controller
{
    public function buildGoods(Collection $collect, $methodName)
    {
        $goods = array();
        foreach ($collect as $index => $item) {
            $goods[$index] = $this->{$methodName}($item);
        }
        return $goods;
    }

    public function createPerfume(Perfume $item)
    {
        return array(
            'id' => $item->id,
            'vendor' => $item->vendor_id,
            'name' => $item->name,
            'brand' => $item->brand,
            'price' => $item->price,
            'composition' => $item->composition,
            'description' => $item->description,
            'features' => $item->features,
            'isWishlist' => false,
            'inCart' => 0,
            'quantity' => $item->quantity,
            'sizes' => $this->getItemSizes($item->volumes),
            'sex' => $item->sex,
            'type' => $item->type,
            'images' => $this->getItemImages($item->media),
            'discount' => $item->discount,
            'finalPrice' => $item->final_price,
            'slug' => $item->slug,
            'url' => '/catalog/perfume' . '/' . $item->id,
            'perfume' => true,
            'sourceState' => $item->sourceState->state_name ?? null,
            'manufactureState' => $item->manufactureState->state_name ?? null,
        );
    }
    public function createGiftcard(Giftcard $item)
    {
        return array(
            'id' => $item->id,
            'vendor' => $item->vendor_id,
            'name' => $item->name,
            'price' => $item->price,
            'finalPrice' => $item->price,
            'description' => $item->description,
            'isWishlist' => false,
            'inCart' => 0,
            'sizes' => $this->getItemSizes($item->giftcardsizes),
            'images' => $this->getItemImages($item->media),
            'slug' => $item->slug,
            'url' => '/catalog/giftcard' . '/' . $item->id,
            'giftcard' => true
        );
    }

    public function getItemImages($media)
    {
        $images = array();
        foreach ($media as $index => $image) {
            $images[$index] = array(
                'id' => (string) $image->id,
                'url' => $image->getUrl(),
                'order' => $image->order_column,
            );
        }
        return $images;
    }

    public function getItemSizes($itemSizes)
    {
        $sizes = array();
        $isSelected = count($itemSizes) <= 1 ? true : false;
        foreach ($itemSizes as $index => $size) {
            $sizes[$index] = array(
                'id' => $size->id,
                'value' => $size->value,
                'isSelected' => $isSelected,
            );
        }
        return $sizes;
    }

    public function getItemColor($color)
    {
        return (object) array(
            'id' => $color->id,
            'name' => $color->name,
            'value' => $color->value,
            'data' => env('APP_URL') . Storage::url($color->data),
        );
    }
}
