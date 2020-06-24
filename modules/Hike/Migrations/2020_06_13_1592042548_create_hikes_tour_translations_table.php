<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHikesTourTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('hikes_tour_translations', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->bigInteger('origin_id')->nullable();
            $table->string('locale', 10)->nullable();
            $table->string('title')->nullable();
            $table->string('slug');
            $table->text('content');
            $table->text('short_desc');
            $table->string('address')->nullable();
            $table->text('faqs');
            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->timestamps();
            $table->text('include');
            $table->text('exclude');
            $table->text('itinerary');
            $table->text('the_tour');
            $table->text('Turn_by_turn_locations');
            $table->text('getting_there');
            $table->text('literature');
            $table->text('current_information');
            $table->text('gpx_file');
            $table->text('highest_point');
            $table->text('lowest_point');
            $table->text('landscape');
            $table->text('best_time');
            $table->text('safety_information');
            $table->text('experience');
        });
    }

    public function down()
    {
        Schema::dropIfExists('hikes_tour_translations');
    }
}
