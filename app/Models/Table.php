<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = [
        'status',
        'max_guests',
        'guests',
        'code',
        'data',
        'handle',
    ];
    protected $casts = [
        'data' => 'array',
        'handle' => 'array',
    ];
}
