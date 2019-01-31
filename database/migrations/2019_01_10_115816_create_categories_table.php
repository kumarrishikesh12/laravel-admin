<?php

use Illuminate\Support\Facades\Schema;
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
            $table->string('name')->unique();
            $table->string('image')->nullable();
            $table->integer('parent_id')->default('0')->unsigned()->nullable();
            $table->enum('status', ['0', '1'])->default('1');
            $table->integer('created_by')->default('0')->unsigned()->nullable();
            $table->timestamps();
            $table->index('created_by');
        });
        Schema::table('categories', function(Blueprint $table) {
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
        Schema::table('categories', function(Blueprint $table) {
            $table->dropForeign('categories_created_by_foreign');
            $table->dropIndex('categories_created_by_index');
            $table->dropColumn('created_by');
        });
        Schema::dropIfExists('categories');
    }
}
