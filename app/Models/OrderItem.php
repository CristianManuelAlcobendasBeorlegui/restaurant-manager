<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'item_id',
        'status',
        'quantity',
        'has_supplement',
        'supplement_price',
        'parent_id',
        'connected_user_code',
    ];

    protected $casts = [
        'has_supplement' => 'boolean',
        'supplement_price' => 'float',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function subitems()
    {
        return $this->hasMany(OrderItem::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(OrderItem::class, 'parent_id');
    }

    public function connectedUser()
    {
        return $this->belongsTo(
            ConnectedUser::class,
            'connected_user_code',
            'code'
        );
    }
}
