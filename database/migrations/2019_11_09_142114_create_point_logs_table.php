<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('point_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('point_id')->unsigned();
            $table->bigInteger('event_id')->unsigned();
            $table->string('position')->nullable();
            $table->string('point')->nullable();
            $table->timestamps();

            $table->foreign('point_id')
            ->references('id')
            ->on('points')
            ->onDelete('cascade');
            $table->foreign('event_id')
            ->references('id')
            ->on('event')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('point_logs');
    }
}
