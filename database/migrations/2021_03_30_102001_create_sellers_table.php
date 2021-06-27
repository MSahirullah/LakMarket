<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_category_id')->constrained('shop_categories')->onUpdate('cascade')->onDelete('cascade')->nullable;
            $table->string('full_name')->nullable;
            $table->string('url')->nullable;
            $table->string('store_name')->nullable;
            $table->string('store_logo', 500)->nullable;
            $table->string('business_email')->unique();
            $table->string('hotline')->nullable;
            $table->string('business_mobile')->nullable;
            $table->boolean('is_cod_available')->default(0);
            $table->string('delivering_districts', 1000)->default('All Island');
            $table->string('verification_code')->nullable;
            $table->integer('visitors')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('verified_seller')->default(0);
            $table->date('date_of_birth')->nullable;
            $table->string('latitude')->nullable;
            $table->string('longitude')->nullable;
            $table->string('address')->nullable;
            $table->foreignId('city_id')->constrained('lkcities')->onUpdate('cascade')->onDelete('cascade')->nullable;
            $table->foreignId('district_id')->constrained('lkdistricts')->onUpdate('cascade')->onDelete('cascade')->nullable;
            $table->rememberToken()->nullable;  //to remember me option
            $table->string('password')->nullable;
            $table->boolean('blacklisted')->default(0);
            $table->boolean('delete_status')->default(0);
            $table->string('last_logged_at')->nullable;
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
        Schema::dropIfExists('sellers');
    }
}
