<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerCategories extends Model
{
    use HasFactory;


    protected $table = 'product_categories';

    protected $fillable = ['id', 'name', 'image', 'blacklisted', 'delete_status'];

    public function sellers()
    {
        return $this->belongsToMany(Seller::class);
    }
}
