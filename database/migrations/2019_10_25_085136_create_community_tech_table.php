<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityTechTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('community_tech', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tech_id')->unsigned();
            $table->bigInteger('community_id')->unsigned();
            $table->timestamps();

            $table->foreign('community_id')
            ->references('id')
            ->on('community')
            ->onDelete('cascade');
            $table->foreign('tech_id')
            ->references('id')
            ->on('technology')
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
        Schema::dropIfExists('community_teches');
    }
}
