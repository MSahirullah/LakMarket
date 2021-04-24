<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerStocks extends Model
{
    use HasFactory;


    protected $table = 'stocks';

    protected $fillable = ['id', 'product_id', 'added_stock', 'stock_usage', 'outof_stock', 'delete_status', 'created_at', 'updated_at'];
}
