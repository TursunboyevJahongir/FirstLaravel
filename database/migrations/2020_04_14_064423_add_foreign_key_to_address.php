<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('address', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('address', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
        
            $table->foreign('user_id')->references('id')->on('users');
        });
        Schema::table('address', function (Blueprint $table) {
            $table->unsignedBigInteger('district_id');
        
            $table->foreign('district_id')->references('id')->on('districts');
        });
    }
}
