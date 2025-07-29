<?php

namespace App\Models;

use App\Models\SecondSubcategory;
use Spatie\MediaLibrary\HasMedia;
use Ofcold\NovaSortable\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Subcategory extends Model implements HasMedia
{
    use InteractsWithMedia;
    use SortableTrait;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['imageUrl'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at', 'subcategory_type_id', 'sort_order', 'category_id', 'subcategoryType', 'media'];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['media'];

    /**
     * Get subcategory image url
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        $image = $this->getMedia('subcategory_image')->first();
        return $image ? $image->getFullUrl() : null;
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function secondSubcategories()
    {
        return $this->hasMany(SecondSubcategory::class);
    }

    public function subcategoryType()
    {
        return $this->belongsTo(SubcategoryType::class);
    }

    /**
     * Set single image for media collection
     *
     *
     * @return  void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('subcategory_image')->singleFile();
    }
}
