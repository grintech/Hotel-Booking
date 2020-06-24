<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHikesAttrsTable extends Migration
{
    public function up()
    {
        Schema::create('hikes_attrs', function (Blueprint $table) {

		$table->bigIncrements('id');
		$table->string('name')->nullable();
		$table->string('slug')->nullable();
		$table->string('service',50)->nullable();
		$table->bigInteger('create_user')->nullable();
		$table->bigInteger('update_user')->nullable();
		$table->timestamps();
		$table->timestamp('deleted_at')->nullable();
		$table->string('display_type')->nullable();
		$table->tinyInteger('hide_in_single')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('hikes_attrs');
    }
}
