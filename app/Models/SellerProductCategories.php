<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerProductCategories extends Model
{
    use HasFactory;

    protected $table = 'seller_product_category';

    protected $fillable = [
        'seller_id', 'product_category_id'
    ];
}
