<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConnectedUser extends Model
{
    protected $fillable = ['code', 'name', 'table_code', 'is_admin'];

    protected $casts = [
        'is_admin' => 'boolean',
    ];

    public function table()
    {
        return $this->belongsTo(Table::class, 'table_code', 'code');
    }
}
