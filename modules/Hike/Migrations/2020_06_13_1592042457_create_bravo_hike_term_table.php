<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBravoHikeTermTable extends Migration
{
    public function up()
    {
        Schema::create('bravo_hike_term', function (Blueprint $table) {

		$table->bigIncrements('id');
		$table->integer('term_id')->nullable();
		$table->integer('hike_id')->nullable();
		$table->bigInteger('create_user')->nullable();
		$table->bigInteger('update_user')->nullable();
		$table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('bravo_hike_term');
    }
}
