<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name'); //
            $table->string('url');
            $table->string('email')->unique(); //
            $table->string('mobile_no'); //
            $table->string('verification_code')->nullable;
            $table->integer('is_verified')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
