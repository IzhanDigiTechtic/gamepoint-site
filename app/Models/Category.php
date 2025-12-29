<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    protected $fillable = ['name', 'slug', 'is_active', 'icon_url', 'display_order'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}