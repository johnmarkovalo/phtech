<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('community', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('organizer_id')->unsigned();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->json('location')->nullable();
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
        Schema::dropIfExists('communities');
    }
}
