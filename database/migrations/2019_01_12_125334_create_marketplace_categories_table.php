<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarketplaceCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketplace_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('marketplace_id')->default('0')->unsigned()->nullable();
            $table->text('categories')->nullable();
            $table->integer('created_by')->default('0')->unsigned()->nullable();
            $table->timestamps();
            $table->index('marketplace_id');
            $table->index('created_by');
        });
        Schema::table('marketplace_categories', function(Blueprint $table) {
            $table->foreign('marketplace_id')->references('id')->on('marketplaces')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('marketplace_categories', function(Blueprint $table) {
            $table->dropForeign('marketplace_categories_created_by_foreign');
            $table->dropIndex('marketplace_categories_created_by_index');
            $table->dropColumn('created_by');
            $table->dropForeign('marketplace_categories_marketplace_id_foreign');
            $table->dropIndex('marketplace_categories_marketplace_id_index');
            $table->dropColumn('marketplace_id');
        });
        Schema::dropIfExists('marketplace_categories');
    }
}
