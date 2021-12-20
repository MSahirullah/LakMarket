<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onUpdate('cascade')->onDelete('cascade');
            $table->string('full_name', 500);
            $table->foreignId('district_id')->constrained('lkdistricts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('city_id')->constrained('lkcities')->onUpdate('cascade')->onDelete('cascade');
            $table->string('shipping_phone', 50);
            $table->string('shipping_address', 500);
            $table->string('shipping_email', 500);
            $table->boolean('payment_status')->default(0);
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('orders');
    }
}
