<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWagerSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wager_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wager_id');
            $table->integer('bets_limit')->nullable();
            $table->char('status', 10)->default('created');
            $table->char('type', 30)->nullable();;
            $table->boolean('enabled')->default(true);
            $table->string('visibility', 15)->nullable();
            $table->integer('options_number')->nullable();
            $table->integer('allotted_time_for_first_bet')->default(2); //задаем время, за которое должен быть дан хотя бы 1 ответ. Иначе вейджер станет неактивным
//            $table->boolean('only_for_authizided')->default(false);
            $table->timestamps();
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
        Schema::dropIfExists('wager_settings');
    }
}
