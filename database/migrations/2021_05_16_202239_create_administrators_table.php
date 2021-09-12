<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdministratorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrators', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('profile_photo', 500)->nullable();
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->string('verification_code')->nullable();
            $table->integer('is_verified')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->date('date_of_birth');
            $table->string('address');
            $table->rememberToken();  //to remember me option
            $table->string('password');
            $table->string('role');
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
        Schema::dropIfExists('administrators');
    }
}
