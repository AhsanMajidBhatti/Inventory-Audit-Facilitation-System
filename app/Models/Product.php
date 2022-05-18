<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'dateofpurchase' => 'date:Y-m-d'
    ];

    public function depreciations()
    {
        return $this->hasMany(Depreciation::class, 'product_id', 'id');
    }
}