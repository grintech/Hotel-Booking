<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBravoHikeCategoryTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('bravo_hike_category_translations', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->bigInteger('origin_id')->nullable();
            $table->string('locale', 10)->nullable();
            $table->string('name')->nullable();
            $table->text('content');
            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('bravo_hike_category_translations');
    }
}
