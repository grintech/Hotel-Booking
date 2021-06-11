<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBravoHikesTable extends Migration
{
    public function up()
    {
        Schema::create('bravo_hikes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 765)->nullable();
            $table->string('slug', 765)->nullable();
            $table->text('content');
            $table->text('the_tour')->nullable();
            $table->text('Turn_by_turn_locations')->nullable();
            $table->text('getting_there')->nullable();
            $table->text('literature')->nullable();
            $table->text('current_information')->nullable();
            $table->text('gpx_file')->nullable();
            $table->integer('image_id')->nullable();
            $table->integer('banner_image_id')->nullable();
            $table->text('short_desc')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('location_id')->nullable();
            $table->string('address', 765)->nullable();
            $table->string('map_lat', 60)->nullable();
            $table->string('map_lng', 60)->nullable();
            $table->integer('map_zoom')->nullable();
            $table->tinyInteger('is_featured')->nullable();
            $table->string('gallery', 765)->nullable();
            $table->string('video', 765)->nullable();
            $table->decimal('price', 14, 0)->nullable();
            $table->decimal('sale_price', 14, 0)->nullable();
            $table->integer('duration')->nullable();
            $table->integer('min_people')->nullable();
            $table->integer('max_people')->nullable();
            $table->text('faqs')->nullable();
            $table->string('status', 150)->nullable();
            $table->datetime('publish_date')->nullable();
            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->bigInteger('origin_id')->nullable();
            $table->string('lang', 30)->nullable();
            $table->tinyInteger('default_state')->nullable();
            $table->text('include')->nullable();
            $table->text('exclude')->nullable();
            $table->text('itinerary')->nullable();
            $table->text('highest_point')->nullable();
            $table->text('lowest_point')->nullable();
            $table->text('experience')->nullable();
            $table->text('landscape')->nullable();
            $table->text('best_time')->nullable();
            $table->text('safety_information')->nullable();
            $table->string('distance')->nullable();
            $table->string('ascent')->nullable();
            $table->string('descent')->nullable();
            $table->string('technique', 25)->nullable();
            $table->string('techniques', 25)->nullable();
            $table->text('ical_import_url')->nullable();

            $table->decimal('review_score', 10, 0)->nullable();
            $table->text('surrounding')->nullable();
            $table->tinyInteger('enable_service_fee')->nullable();
            $table->text('service_fee')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bravo_hikes');
    }
}
