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
            $table->string('first_name');
            $table->string('last_name');
            $table->string('url');
            $table->string('email')->unique();
            $table->string('mobile_no');
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('profile_pic')->nullable();
            $table->string('verification_code')->nullable;
            $table->integer('is_verified')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->foreignId('city_id')->constrained('lkcities')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('district_id')->constrained('lkdistricts')->onUpdate('cascade')->onDelete('cascade');
            $table->string('location_la')->nullable();
            $table->string('location_lo')->nullable();
            $table->rememberToken();  //to remember me option
            $table->string('newsletters')->default(0);
            $table->string('password');
            $table->boolean('blacklisted')->default(0);
            $table->boolean('delete_status')->default(0);
            $table->boolean('status');
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
