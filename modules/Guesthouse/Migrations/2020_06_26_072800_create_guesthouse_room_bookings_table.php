<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuesthouseRoomBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bravo_guesthouse_room_bookings', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->bigInteger('room_id')->nullable();
            $table->bigInteger('parent_id')->nullable();
            $table->bigInteger('booking_id')->nullable();

            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->smallInteger('number')->nullable();
            $table->decimal('price',12,2)->nullable();

            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
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
        Schema::dropIfExists('bravo_guesthouse_room_bookings');
    }
}
