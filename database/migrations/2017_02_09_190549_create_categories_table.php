<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_parent')->default(0);
            $table->string('name');
            $table->string('sysname');
            $table->string('icon');
            $table->string('img');
            $table->text('text');
            $table->string('title');
            $table->text('description');
            $table->text('keywords');
            $table->integer('sort');
            $table->boolean('status');
            $table->timestamps();
            $table->softDeletes();


            $table->index('id_parent');
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
        Schema::drop('categories');
    }
}
