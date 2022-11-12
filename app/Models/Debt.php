<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Debt extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'balance', 'debt_type','seller_store_house_id' , 'author_person_id', 'created_at_alternative', 'seller_id', 'notes'
    ];
}
