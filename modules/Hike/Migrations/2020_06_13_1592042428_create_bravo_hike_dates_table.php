<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBravoHikeDatesTable extends Migration
{
    public function up()
    {
        Schema::create('bravo_hike_dates', function (Blueprint $table) {

		$table->bigIncrements('id');
		$table->bigInteger('target_id')->nullable();
		$table->timestamp('start_date')->nullable();
		$table->timestamp('end_date')->nullable();
		$table->decimal('price',12,2)->nullable();
		$table->text('person_types')->nullable();
		$table->tinyInteger('max_guests')->nullable();
		$table->tinyInteger('active')->default('0');
		$table->text('note_to_customer')->nullable();
		$table->text('note_to_admin')->nullable();
		$table->tinyInteger('is_instant')->default('0');
		$table->bigInteger('create_user')->nullable();
		$table->bigInteger('update_user')->nullable();
		$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bravo_hike_dates');
    }
}
