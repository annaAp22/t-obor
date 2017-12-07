<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('good_category', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('good_id')->unsigned();
            $table->foreign('good_id')
                ->references('id')->on('goods')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->integer('sort');
            $table->index('sort');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('good_category');
    }
}
