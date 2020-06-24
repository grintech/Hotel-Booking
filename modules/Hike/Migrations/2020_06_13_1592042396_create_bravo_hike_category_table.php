<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBravoHikeCategoryTable extends Migration
{
    public function up()
    {
        Schema::create('bravo_hike_category', function (Blueprint $table) {

		$table->bigIncrements('id');
		$table->string('name')->nullable();
		$table->text('content');
		$table->string('slug')->nullable();
		$table->string('status',50)->nullable();
		$table->integer('_lft')->unsigned()->default('0');
		$table->integer('_rgt')->unsigned()->default('0');
		$table->integer('parent_id')->unsigned()->nullable();
		$table->integer('create_user')->nullable();
		$table->integer('update_user')->nullable();
		$table->timestamp('deleted_at')->nullable();
		$table->bigInteger('origin_id')->nullable();
		$table->string('lang',10)->nullable();
		$table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('bravo_hike_category');
    }
}
