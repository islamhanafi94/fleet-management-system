<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_stations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')
                    ->constrained('trips')
                    ->onUpdate('cascade')
                    ->onDelete('cascade')
                    ->nullable(false);

            $table->foreignId('station_id')
                    ->constrained('stations')
                    ->onUpdate('cascade')
                    ->onDelete('cascade')
                    ->nullable(false);

            $table->integer('order');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trip_stations');
    }
}
