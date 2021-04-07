<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerProducts extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = ['id', 'product_catrgory_id', 'code', 'name', 'short_desc', 'long_desc', 'unit_price', 'tax', 'images', 'discount', 'colors', 'sizes'];
}
