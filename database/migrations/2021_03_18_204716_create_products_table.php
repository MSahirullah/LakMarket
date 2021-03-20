<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('sellers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('product_catrgory_id')->constrained('productcategories')->onUpdate('cascade')->onDelete('cascade');
            $table->string('code')->nullable();
            $table->string('name');
            $table->string('url'); 
            $table->string('short_desc'); 
            $table->string('long_desc')->nullable();
            $table->decimal('unit_price', 10, 2);
            $table->decimal('tax', 10, 2)->default(0.0);
            $table->string('images');
            $table->string('discount')->default(0);
            $table->string('colors')->nullable();
            $table->string('sizes')->nullable();
            $table->timestamps();
        });
    }

    // $table->id();
    // $table->foreignId('shop_category_id')->constrained('shopcategories')->onUpdate('cascade')->onDelete('cascade');
    // $table->string('full_name'); 
    // $table->string('url'); 
    // $table->string('store_name'); 
    // $table->string('image')->nullable;
    // $table->string('business_email')->unique(); 
    // $table->string('hotline')->nullable;
    // $table->string('business_mobile');
    // $table->string('verification_code')->nullable;
    // $table->integer('is_verified')->default(0);
    // $table->timestamp('email_verified_at')->nullable();
    // $table->string('address');
    // $table->string('postal_code');
    // $table->string('location');
    // $table->foreignId('city_id')->constrained('lkcities')->onUpdate('cascade')->onDelete('cascade');
    // $table->foreignId('district_id')->constrained('lkdistricts')->onUpdate('cascade')->onDelete('cascade');
    // $table->rememberToken();  //to remember me option
    // $table->string('password');
    // $table->boolean('blacklisted')->default(0);
    // $table->boolean('delete_status')->default(0);
    // $table->string('last_logged_at');
    // $table->timestamps();

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
