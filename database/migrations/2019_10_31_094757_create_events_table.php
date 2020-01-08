<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->bigInteger('organizer_id')->unsigned();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->datetime('start')->nullable();
            $table->datetime('end')->nullable();
            $table->json('location')->nullable();
            $table->bigInteger('fee')->default('0');
            $table->bigInteger('limit')->default('0');
            $table->boolean('exclusive')->default('0');
            $table->string('status')->default('ACTIVE');
            $table->string('photo')->default('');
            $table->timestamps();

            $table->foreign('organizer_id')
            ->references('id')
            ->on('users')
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
        Schema::dropIfExists('events');
    }
}
