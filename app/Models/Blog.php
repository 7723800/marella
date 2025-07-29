<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at', 'active', 'image'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['imageUrl'];

    protected $dates = ['created_at'];

      /**
     * Get the post image path.
     *
     * @param  string  $value
     * @return string
     */
    public function getImageUrlAttribute()
    {
        return env('APP_URL'). '/storage/' .$this->image;
    }
}
