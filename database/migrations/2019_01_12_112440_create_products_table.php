<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->default('0')->unsigned()->nullable();
            $table->string('name');
            $table->string('image')->nullable();
            $table->longtext('data')->nullable();
            $table->enum('status', ['0', '1'])->default('1');
            $table->integer('created_by')->default('0')->unsigned()->nullable();
            $table->timestamps();
            $table->index('category_id');
            $table->index('created_by');
        });
        Schema::table('products', function(Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::table('products', function(Blueprint $table) {
            $table->dropForeign('products_created_by_foreign');
            $table->dropIndex('products_created_by_index');
            $table->dropColumn('created_by');
            $table->dropForeign('products_category_id_foreign');
            $table->dropIndex('products_category_id_index');
            $table->dropColumn('category_id');
        });
        Schema::dropIfExists('products');
    }
}
