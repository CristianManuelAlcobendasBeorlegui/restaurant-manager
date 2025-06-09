<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
        'image',
        'quantity_type',
        'items_per_unit',
        'category_id',
        'description',
        'allergens',
        'has_supplement',
        'supplement_price',
    ];

    protected $casts = [
        'allergens' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
