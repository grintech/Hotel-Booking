<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBravoHikesTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('bravo_hikes_translations', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->bigInteger('origin_id')->nullable();
            $table->string('locale', 30)->nullable();
            $table->string('title', 765)->nullable();
            $table->string('slug', 765)->nullable();
            $table->text('content')->nullable();
            $table->text('short_desc')->nullable();
            $table->string('address', 765)->nullable();
            $table->text('faqs')->nullable();
            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->timestamps();
            $table->text('include')->nullable();
            $table->text('exclude')->nullable();
            $table->text('itinerary')->nullable();
            $table->text('the_tour')->nullable();
            $table->text('Turn_by_turn_locations')->nullable();
            $table->text('getting_there')->nullable();
            $table->text('literature')->nullable();
            $table->text('current_information')->nullable();
            $table->text('gpx_file')->nullable();
            $table->text('highest_point')->nullable();
            $table->text('lowest_point')->nullable();
            $table->text('landscape')->nullable();
            $table->text('best_time')->nullable();
            $table->text('safety_information')->nullable();
            $table->text('experience')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('bravo_hikes_translations');
    }
}
