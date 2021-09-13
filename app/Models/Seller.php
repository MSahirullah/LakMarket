<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;
    protected $table = 'sellers';
    protected $fillable = ['full_name', 'shop_category_id', 'store_name', 'store_logo', 'business_email', 'business_mobile', 'delivering_districts', 'city_id', 'district_id'];

    public function product_categories()
    {
        return $this->belongsToMany(SellerCategories::class);
    }
}
