<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoTechesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_tech', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tech_id')->unsigned();
            $table->bigInteger('info_id')->unsigned();
            $table->timestamps();

            $table->foreign('info_id')
            ->references('id')
            ->on('information')
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
        Schema::dropIfExists('info_teches');
    }
}
