<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wagers', function (Blueprint $table) {
            $table->id('id');
            // добавить поле слаг и сделать его уникальным,а не кондишн !!
            // не rate должно быть уникальным, а сочетание condition + rate лно быть уникальным!!!
            $table->text('condition'); // думать, как сделать єто поле ->unique();
            $table->string('rate', 50);//->unique();
            $table->string('img', 100)->nullable();
//            $table->char('status', 10);
//            $table->char('type', 30);
//            $table->boolean('enabled')->default(true);
//            $table->string('visibility', 15);
            $table->unsignedBigInteger('user_id');
            $table->boolean('first_bet_at_allotted_time')->default(false);
            $table->dateTime('start_date');
            $table->dateTime('finish_date');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wagers');
    }
}
