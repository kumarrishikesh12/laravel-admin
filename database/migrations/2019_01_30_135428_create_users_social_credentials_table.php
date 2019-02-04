<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersSocialCredentialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userssocial_credentials', function (Blueprint $table) {
            
            $table->increments('id');
            $table->string('social_webname')->comment('SocialWebsite Name');
            $table->string('accesstoken')->comment('Access Token');
            $table->string('accesstokensecret')->comment('Accesstoken secretName');
            $table->string('consumerkeyapikey')->comment('Consumer Key API');
            $table->string('consumersecretapikey')->comment('Consumer secretAPIKey');
            $table->string('hashtags')->default('#india')->comment('Hashtags Twitter');

            $table->integer('user_id')->unsigned()->comment('User ID');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
            $table->rememberToken();

        // fk
        //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('userssocial_credentials');
    }
}
