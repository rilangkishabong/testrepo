<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_lists', function (Blueprint $table) {
            $table->id();
            $table->string('tr_emp_id')->nullable();
            $table->unsignedBigInteger('tr_emp_name_id')->nullable();
            $table->foreign('tr_emp_name_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('tr_emp_depm_id')->nullable();
            $table->foreign('tr_emp_depm_id')->references('id')->on('department_mgmts')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('tr_tour_id')->nullable();
            $table->foreign('tr_tour_id')->references('id')->on('tour_programmes')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('tr_emp_desg_id')->nullable();
            $table->foreign('tr_emp_desg_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->date('tr_date_from')->nullable();
            $table->date('tr_date_to')->nullable();
            $table->string('tr_desc')->nullable();
            $table->string('tr_locatn')->nullable();
            $table->string('tr_no_of_days')->nullable();
            $table->string('shift_time')->nullable();
            $table->string('tr_reason')->nullable();
            $table->unsignedBigInteger('tr_status')->nullable();
            $table->foreign('tr_status')->references('id')->on('tour_statuses')->onDelete('cascade')->onUpdate('cascade');
            $table->date('date_posted')->nullable();
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
        Schema::dropIfExists('tour_lists');
    }
}
