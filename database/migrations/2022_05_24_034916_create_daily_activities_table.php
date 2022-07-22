<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usrId')->nullable();
            $table->foreign('usrId')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->date('actv_date')->nullable();
            $table->string('task')->nullable();
            $table->string('time_tkn')->nullable();
            $table->string('actv_stat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_activities');
    }
}
