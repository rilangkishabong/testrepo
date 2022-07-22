<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourReportAttchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_report_attches', function (Blueprint $table) {
            $table->id();//
            $table->unsignedBigInteger('dep_id')->nullable();
            $table->foreign('dep_id')->references('id')->on('depute_staff')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('tadastat_id')->nullable();
            $table->foreign('tadastat_id')->references('id')->on('tada_statuses')->onDelete('cascade')->onUpdate('cascade');
            $table->string('jr_type')->nullable();
            $table->date('ta_da_date')->nullable();//
            $table->string('tr_adv_allw')->nullable();
            $table->string('tr_tour_report')->nullable();
            $table->string('tr_travel_fare')->nullable();
            $table->string('tr_travel_amt')->nullable();
            $table->string('tr_lodg_fare')->nullable();
            $table->string('tr_lodg_amt')->nullable();
            $table->string('tr_other_exp')->nullable();
            $table->string('tr_other_amt')->nullable();
            $table->string('tr_da_amt')->nullable();
            $table->date('tr_departure_dt')->nullable();
            $table->string('tr_departure_tm')->nullable();
            $table->date('tr_arrival_dt')->nullable();
            $table->string('tr_arrival_tm')->nullable();
            $table->string('tr_pt_of_origin1')->nullable();
            $table->string('tr_pt_of_destination1')->nullable();
            $table->string('tr_pt_of_origin2')->nullable();
            $table->string('tr_pt_of_destination2')->nullable();
            $table->string('tr_no_of_days')->nullable();
            $table->string('tr_travel_mode')->nullable();
            $table->string('tr_mileage')->nullable();
            $table->string('tr_distance')->nullable();
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
        Schema::dropIfExists('tour_report_attches');
    }
}
