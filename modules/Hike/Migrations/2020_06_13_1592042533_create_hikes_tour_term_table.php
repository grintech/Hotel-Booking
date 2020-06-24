<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHikesTourTermTable extends Migration
{
    public function up()
    {
        Schema::create('hikes_tour_term', function (Blueprint $table) {

		$table->bigIncrements('id');
		$table->integer('term_id')->nullable();
		$table->integer('tour_id')->nullable();
		$table->bigInteger('create_user')->nullable();
		$table->bigInteger('update_user')->nullable();
		$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hikes_tour_term');
    }
}
