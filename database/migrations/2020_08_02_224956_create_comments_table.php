<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
//            $table->unsignedBigInteger('user_id');
            $table->uuid('uuid');
            $table->string('text', 250);
            $table->unsignedBigInteger('wager_id');
            $table->boolean('published')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('wager_id')->references('id')->on('wagers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
