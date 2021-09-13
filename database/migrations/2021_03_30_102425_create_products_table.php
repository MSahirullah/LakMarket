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
            $table->string('code');
            $table->string('name', 500);
            $table->string('url');
            $table->string('type');
            $table->string('images', 1000);
            $table->string('short_desc', 200);
            $table->string('long_desc', 5000)->nullable();
            $table->decimal('unit_price', 17, 2);
            $table->decimal('tax', 2, 2)->default(0.0);
            $table->decimal('discount', 2, 2)->default(0.0);
            $table->decimal('discounted_price', 10, 2);
            $table->string('colors')->nullable()->default('-');
            $table->string('cod')->nullable()->default('0');
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
