<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'author_person_id', 'seller_store_house_id', 'debt_type', 'amount', 'seller_id', 'created_at_alternative', 'notes',
    ];
}
