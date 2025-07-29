<?php

namespace App\Models;

namespace App\Models\Products;

use App\Models\Branch;
use App\Models\Category;
use App\Scopes\ItemScope;
use App\Models\Subcategory;
use Laravel\Scout\Searchable;
use App\Models\SecondSubcategory;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes, Searchable;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['images', 'url', 'finalPrice', 'isWishlist', 'inCart', 'care', 'vendor'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'new' => 'bool',
        'isKaspi' => 'bool'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'media',
        'vendor_id',
        'category_id',
        'subcategory_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'brand_id',
        'color_id',
        'final_price',
        'is_const_discount',
        'laravel_through_key',
        'manufacture_state_id',
        'onec_id',
        'source_state_id',
        'published',
        'guide_sizes_id',
        'second_subcategory_id',
        'branch_id'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['onec_id', 'price', 'final_price'];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['category', 'media', 'subcategory', 'brand', 'sizes', 'branch'];


    /**
     * Set the item's vendor id.
     *
     * @param  string  $value
     * @return string
     */
    public function setVendorIdAttribute($value)
    {
        return $this->attributes['vendor_id'] = strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', $value));
    }

    /**
     * Indicates whether attributes are snake cased on arrays.
     *
     * @return bool
     */
    public static $snakeAttributes = false;

    /**
     * Set the item's vendor id.
     *
     * @return string
     */
    public function getSourceStateAttribute()
    {
        return $this->sourceState->state_name ?? null;
    }

    /**
     * Set the item's vendor id.
     *
     * @return string
     */
    public function getManufactureStateAttribute()
    {
        return $this->manufactureState->state_name ?? null;
    }


    /**
     * Get the item images.
     *
     * @return array
     */
    public function getImagesAttribute()
    {
        $data = [];
        $images = $this->media()->orderBy('order_column', 'ASC')->get();
        foreach ($images  as $image) {
            $data[] = array(
                'id' => (string) $image->id,
                'url' => $image->getFullUrl(),
                'order' => $image->order_column,
            );
        }
        return $data;
    }

    /**
     * Get the item final price.
     *
     * @return int
     */
    public function getFinalPriceAttribute()
    {
        return $this->price - ($this->price * ($this->discount / 100));
    }

    /**
     * Init item wislist status.
     *
     * @return bool
     */
    public function getIsWishlistAttribute()
    {
        return false;
    }

    /**
     * Init item quantity attribute.
     *
     * @return int
     */
    public function getInCartAttribute()
    {
        return 0;
    }

    /**
     * Init item quantity attribute.
     *
     * @return string
     */
    public function getCareAttribute()
    {
        return $this->subcategory->subcategoryType->item_care;
    }

    /**
     * Init item quantity attribute.
     *
     * @return string
     */
    public function getVendorAttribute()
    {
        return $this->vendor_id;
    }

    /**
     * Get the item path in catalog.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return env('APP_URL') . '/catalog/' . $this->category->slug . '/' . $this->subcategory->slug . '/' . $this->id;
    }

    public function sourceState()
    {
        return $this->belongsTo(ItemSourceState::class);
    }

    public function manufactureState()
    {
        return $this->belongsTo(ItemManufactureState::class);
    }

    public function guideSizes()
    {
        return $this->belongsTo(ItemGuideSizes::class);
    }

    public function brand()
    {
        return $this->belongsTo(ItemBrand::class);
    }

    public function sizes()
    {
        return $this->belongsToMany(ItemSize::class, 'item_size_pivot', 'item_id', 'size_id')->orderBy('data', 'ASC');
    }

    public function color()
    {
        return $this->belongsTo(ItemColor::class);
    }

    public function seasons()
    {
        return $this->belongsToMany(ItemSeason::class, 'item_season_pivot', 'item_id', 'season_id');
    }

    public function keywords()
    {
        return $this->belongsToMany(ItemSearchKeyword::class, 'item_search_keyword_pivot', 'item_id', 'keyword_id');
    }

    public function alsoBoughtProducts()
    {
        return $this->hasManyThrough(
            'App\Models\Products\Item',
            'App\Models\AlsoBoughtProduct',
            'item_id',
            'id',
            'id',
            'related_id'
        );
    }

    public function extraColors()
    {
        return $this->hasManyThrough(
            'App\Models\Products\Item',
            'App\Models\Products\ItemExtraColor',
            'item_id',
            'id',
            'id',
            'extra_color_id'
        );
    }

    public function novaAlsoBoughtProducts()
    {
        return $this->belongsToMany(\App\Models\Nova\NovaAlsoBoughtProduct::class, 'also_bought_products', 'item_id', 'related_id');
    }

    public function novaItemExtraColors()
    {
        return $this->belongsToMany(\App\Models\Nova\NovaItemExtraColor::class, 'item_extra_colors', 'item_id', 'extra_color_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function secondSubcategory()
    {
        return $this->belongsTo(SecondSubcategory::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray(): array
    {
        $keywords = [];
        foreach ($this->keywords as $keyword) {
            $keywords[] = $keyword->name;
        }

        $seasons = [];
        foreach ($this->seasons as $season) {
            $seasons[] = $season->name;
        }

        $sizes = [];
        foreach ($this->sizes as $size) {
            $sizes[] = $size->value;
        }

        return [
            'name' => $this->name,
            'keywords' => $keywords,
            'imageUrl' => $this->media()->orderBy('order_column', 'ASC')->first()->getFullUrl(),
            'sizes' => $sizes,
            'brand' => $this->brand->name ?? "",
            'color' => $this->color->name,
            'seasons' => $seasons,
            'categoryName' => $this->category->name
        ];
    }

    /**
     * Get the name of the index associated with the model.
     */
    public function searchableAs(): string
    {
        return 'products_index';
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ItemScope);
    }
}
