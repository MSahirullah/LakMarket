<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onUpdate('cascade')->onDelete('cascade');
            $table->string('address', 500);
            $table->string('full_name', 500);
            $table->foreignId('province_id')->constrained('lkprovinces')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('district_id')->constrained('lkdistricts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('city_id')->constrained('lkcities')->onUpdate('cascade')->onDelete('cascade');
            $table->string('mobile_no', 50);
            $table->string('label', 100);
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
        Schema::dropIfExists('customer_addresses');
    }
}
