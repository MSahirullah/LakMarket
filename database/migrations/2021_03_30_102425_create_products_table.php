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
            $table->foreignId('product_category_id')->constrained('product_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->string('code')->nullable();
            $table->string('name');
            $table->string('url');
            $table->string('images');
            $table->string('short_desc');
            $table->string('long_desc')->nullable();
            $table->decimal('unit_price', 17, 2);
            $table->decimal('tax', 10, 2)->default(0.0);
            $table->decimal('discount', 10, 2)->default(0.0);
            $table->string('colors')->nullable();
            $table->string('sizes')->nullable();
            $table->boolean('blacklisted')->default(0);
            $table->boolean('delete_status')->default(0);
            $table->timestamps();
        });
    }

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