<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goods', function (Blueprint $table) {
            $table->boolean('new')->default(0);
            $table->boolean('act')->default(0);
            $table->boolean('hit')->default(0);

            $table->integer('brand_id')->unsigned()->nullable()->default(null);
            $table->foreign('brand_id')->references('id')->on('brands');

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
        Schema::table('goods', function (Blueprint $table) {
            $table->dropColumn('new');
            $table->dropColumn('act');
            $table->dropColumn('hit');

            $table->dropIndex('goods_sysname_index');
            $table->dropForeign('goods_brand_id_foreign');

            $table->dropColumn('brand_id');
        });
    }
}
