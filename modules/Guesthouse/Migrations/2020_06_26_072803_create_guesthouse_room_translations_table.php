<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuesthouseRoomTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bravo_guesthouse_room_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('origin_id')->unsigned();
            $table->string('locale')->index();

            //Info
            $table->string('title', 255)->nullable();
            $table->text('content')->nullable();

            //Extra Info
            $table->string('status', 50)->nullable();
            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bravo_guesthouses');
        Schema::dropIfExists('bravo_guesthouse_translations');
        Schema::dropIfExists('bravo_guesthouse_term');

        Schema::dropIfExists('bravo_guesthouse_rooms');
        Schema::dropIfExists('bravo_guesthouse_room_translations');
    }
}
