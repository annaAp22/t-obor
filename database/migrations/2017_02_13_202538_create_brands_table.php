<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('sysname');
            $table->string('img');
            $table->text('text');
            $table->string('title');
            $table->text('description');
            $table->text('keywords');
            $table->boolean('status');
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('sysname');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('brands');
    }
}
