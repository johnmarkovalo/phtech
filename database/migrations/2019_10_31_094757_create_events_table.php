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
            $table->bigInteger('organizer_id')->unsigned();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->date('start_date')->nullable();
            $table->time('start_time')->nullable();
            $table->date('end_date')->nullable();
            $table->time('end_time')->nullable();
            $table->json('location')->nullable();
            $table->bigInteger('fee')->default('0');
            $table->bigInteger('limit')->default('0');
            $table->string('photo')->default('https://res.cloudinary.com/mactimestwo/image/upload/v1572071482/phtechpark/community/default.jpg');
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