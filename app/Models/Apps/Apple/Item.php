<?php

namespace App\Models\Apps\Apple;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Products\Item as BaseItem;

class Item extends BaseItem
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
    }

    /**
     * Override care attribute.
     *
     * @return string
     */
    public function getCareAttribute()
    {
        $care = $this->subcategory->subcategoryType->item_care;
        return str_replace(["<div>", "</div>", "<br>"], ["", "", "\n"], $care);
    }

    /**
     * Get the item images.
     *
     * @return array
     */
    public function getImagesAttribute()
    {
        $itemImages = DB::table('media')
            ->select('id', 'file_name', 'order_column')
            ->where([['collection_name', 'item_images'], ['model_type', 'App\Models\Products\Item'], ['model_id', $this->id]])
            ->get();

        foreach ($itemImages as $image) {
            $images[] = array(
                'id' => (string) $image->id,
                'url' => env('APP_URL') . '/storage/' . $image->id . '/' . $image->file_name,
                'order' => $image->order_column,
            );
        }
        return $images;
    }
}
