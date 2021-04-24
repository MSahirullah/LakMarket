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
            $table->foreignId('shop_category_id')->constrained('shop_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->string('full_name');
            $table->string('url');
            $table->string('store_name');
            $table->string('store_image', 500)->nullable;
            $table->string('profile_photo', 500)->nullable;
            $table->string('business_email')->unique();
            $table->string('hotline')->nullable;
            $table->string('business_mobile');
            $table->boolean('is_cod_available')->default(0);
            $table->string('delivering_districts', 1000)->default('All Island');
            $table->string('verification_code')->nullable;
            $table->integer('visitors')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->date('date_of_birth');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('address');
            $table->foreignId('city_id')->constrained('lkcities')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('district_id')->constrained('lkdistricts')->onUpdate('cascade')->onDelete('cascade');
            $table->rememberToken();  //to remember me option
            $table->string('password');
            $table->boolean('blacklisted')->default(0);
            $table->boolean('delete_status')->default(0);
            $table->string('last_logged_at');
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
