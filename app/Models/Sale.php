<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'price', 'total_price', 'notes', 'transportation', 'profitable', 'created_at', 'seller_id', 'seller_store_house_id', 'seller_order_id', 'created_at_alternative'
    ];
}
