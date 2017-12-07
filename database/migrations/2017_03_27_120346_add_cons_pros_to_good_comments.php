<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConsProsToGoodComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('good_comments', function (Blueprint $table) {
            $table->text('pros');
            $table->text('cons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('good_comments', function (Blueprint $table) {
            $table->dropColumn('pros');
            $table->dropColumn('cons');
        });
    }
}
