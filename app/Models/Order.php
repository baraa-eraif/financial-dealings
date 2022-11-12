<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'price', 'notes', 'transportation', 'total_items_price', 'order_items_names', 'total', 'user_id',
    ];
}
