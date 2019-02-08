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
            $table->string('accesstoken')->nullable()->comment('Access Token');
            $table->string('accesstokensecret')->nullable()->comment('Accesstoken secretName');
            $table->string('consumerkeyapikey')->nullable()->comment('Consumer Key API');
            $table->string('consumersecretapikey')->nullable()->comment('Consumer secretAPIKey');
            $table->string('instagram_access_token')->nullable()->comment('instagram_access_token');
            $table->string('hashtags')->default('#india')->comment('Hashtags Twitter');
            $table->string('app_id')->default('AppID')->comment('AppID Facebook');
            $table->string('appsecret')->default('AppSecret')->comment('AppSecret Facebook');
            $table->string('username')->default('zuck')->nullable()->comment('Facebook Username');
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
