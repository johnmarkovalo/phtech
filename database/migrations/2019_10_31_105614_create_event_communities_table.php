<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventCommunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_community', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('event_id')->unsigned();
            $table->bigInteger('community_id')->unsigned();
            $table->string('position')->nullable();
            $table->timestamps();

            $table->foreign('event_id')
            ->references('id')
            ->on('event')
            ->onDelete('cascade');
            $table->foreign('community_id')
            ->references('id')
            ->on('community')
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
        Schema::dropIfExists('event_communities');
    }
}
