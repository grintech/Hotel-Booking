<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHikesTermsTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('hikes_terms_translations', function (Blueprint $table) {

		$table->bigIncrements('id');
		$table->bigInteger('origin_id')->nullable();
		$table->string('locale',10)->nullable();
		$table->string('name')->nullable();
		$table->text('content');
		$table->bigInteger('create_user')->nullable();
		$table->bigInteger('update_user')->nullable();
		$table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('hikes_terms_translations');
    }
}
