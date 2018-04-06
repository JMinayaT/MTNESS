<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('langs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('image');
            $table->timestamps();
        });

        Schema::create('lang_user', function (Blueprint $table) {
            $table->integer('lang_id')->unsigned()->index();
            $table->foreign('lang_id')->references('id')->on('langs')->onDelete('cascade');
 
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('langs');
        Schema::dropIfExists('lang_user');
    }
}
