<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_category')->unsigned();
            $table->string('name');
            $table->string('sysname');
            $table->string('img');
            $table->integer('price');
            $table->string('article');
            $table->text('text');
            $table->string('title');
            $table->text('description');
            $table->text('keywords');
            $table->boolean('status');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_category')->references('id')->on('categories');

            $table->index('status');
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('goods');
    }
}
