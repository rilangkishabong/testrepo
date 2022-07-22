<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeputeStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depute_staff', function (Blueprint $table) {
            $table->id();
            $table->string('dep_emp_id')->nullable();
            $table->unsignedBigInteger('dep_emp_name_id')->nullable();
            $table->foreign('dep_emp_name_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('dep_emp_depm_id')->nullable();
            $table->foreign('dep_emp_depm_id')->references('id')->on('department_mgmts')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('dep_tour_id')->nullable();
            $table->foreign('dep_tour_id')->references('id')->on('tour_programmes')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('dep_emp_desg_id')->nullable();
            $table->foreign('dep_emp_desg_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->date('dep_date_from')->nullable();
            $table->date('dep_date_to')->nullable();
            $table->string('dep_desc')->nullable();
            $table->string('dep_locatn')->nullable();
            $table->string('dep_no_of_days')->nullable();
            $table->string('shift_time')->nullable();
            $table->string('dep_reason')->nullable();
            $table->unsignedBigInteger('dep_status')->nullable();
            $table->foreign('dep_status')->references('id')->on('deput_statuses')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('tada_status_id')->nullable();
            $table->foreign('tada_status_id')->references('id')->on('tada_statuses')->onDelete('cascade')->onUpdate('cascade');
            $table->date('date_posted')->nullable();
            $table->string('is_for')->nullable();
            $table->string('attch_id')->nullable();
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
        Schema::dropIfExists('depute_staff');
    }
}
