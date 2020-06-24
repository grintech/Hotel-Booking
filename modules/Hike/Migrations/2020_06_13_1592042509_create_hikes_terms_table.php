<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHikesTermsTable extends Migration
{
    public function up()
    {
        Schema::create('hikes_terms', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->text('content');
            $table->integer('attr_id')->nullable();
            $table->string('slug')->nullable();
            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
            $table->bigInteger('origin_id')->nullable();
            $table->string('lang', 10)->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('image_id')->nullable();
            $table->string('icon', 50)->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('hikes_terms');
    }
}
