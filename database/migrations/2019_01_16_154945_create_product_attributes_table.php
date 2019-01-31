<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('marketplace_id')->default('0')->unsigned()->nullable();
            $table->integer('attribute_id')->default('0')->unsigned()->nullable();
            $table->string('name');
            $table->enum('status', ['0', '1'])->default('1');
            $table->integer('created_by')->default('0')->unsigned()->nullable();
            $table->timestamps();
            $table->index('created_by');
            $table->index('attribute_id');
            $table->index('marketplace_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_attributes', function(Blueprint $table) {
            $table->dropForeign('product_attributes_created_by_foreign');
            $table->dropIndex('product_attributes_created_by_index');
            $table->dropColumn('created_by');
            $table->dropForeign('product_attributes_category_id_foreign');
            $table->dropIndex('product_attributes_category_id_index');
            $table->dropColumn('category_id');
            $table->dropForeign('product_attributes_marketplace_id_foreign');
            $table->dropIndex('product_attributes_marketplace_id_index');
            $table->dropColumn('marketplace_id');
        });
        Schema::dropIfExists('product_attributes');
    }
}
