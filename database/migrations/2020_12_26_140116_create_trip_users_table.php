<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')
                    ->constrained('trips')
                    ->onUpdate('cascade')
                    ->onDelete('cascade')
                    ->nullable(false);

            $table->foreignId('user_id')
                    ->constrained('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade')
                    ->nullable(false);


            $table->foreignId('start_station')
                    ->constrained('stations')
                    ->onUpdate('cascade')
                    ->onDelete('cascade')
                    ->nullable(false);


            $table->foreignId('end_station')
                    ->constrained('stations')
                    ->onUpdate('cascade')
                    ->onDelete('cascade')
                    ->nullable(false);

            $table->foreignId('seat_id')
                    ->constrained('trip_seats')
                    ->onUpdate('cascade')
                    ->onDelete('cascade')
                    ->nullable(false);        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trip_users');
    }
}
