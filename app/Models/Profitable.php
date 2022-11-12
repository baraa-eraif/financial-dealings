<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profitable extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'balance', 'seller_store_house_id', 'seller_id', 'created_at_alternative', 'notes',
    ];
}
