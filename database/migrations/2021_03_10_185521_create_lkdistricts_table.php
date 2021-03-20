<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLkdistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lkdistricts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('province_id')->constrained('lkprovinces')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name_en');
            $table->string('name_si');
            $table->string('name_ta');
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
        Schema::dropIfExists('lkdistricts');
    }
}
