<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveApplicatnListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_applicatn_lists', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id')->nullable();
            $table->unsignedBigInteger('emp_name_id')->nullable();
            $table->foreign('emp_name_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('emp_sex')->nullable();
            $table->unsignedBigInteger('emp_depm_id')->nullable();
            $table->foreign('emp_depm_id')->references('id')->on('department_mgmts')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('emp_desg_id')->nullable();
            $table->foreign('emp_desg_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->string('no_of_days')->nullable();
            $table->string('shift_time')->nullable();
            $table->unsignedBigInteger('leave_type_id')->nullable();
            $table->foreign('leave_type_id')->references('id')->on('leave_type_mgmts')->onDelete('cascade')->onUpdate('cascade');
            $table->string('reason')->nullable();
            $table->unsignedBigInteger('leave_stats_id')->nullable();
            $table->foreign('leave_stats_id')->references('id')->on('leave_statuses')->onDelete('cascade')->onUpdate('cascade');
            $table->string('remks')->nullable();
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
        Schema::dropIfExists('leave_applicatn_lists');
    }
}
