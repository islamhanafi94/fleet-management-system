<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripSeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_seats', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->foreignId('trip_id')
                    ->constrained('trips')
                    ->onUpdate('cascade')
                    ->onDelete('cascade')
                    ->nullable(false);

            $table->foreignId('empty_at_station')
                    ->constrained('stations')
                    ->nullable(true)
                    ->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trip_seats');
    }
}
