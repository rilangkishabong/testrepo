<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyAllowanceManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_allowance_management', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('allw_id')->nullable();
            $table->foreign('allw_id')->references('id')->on('allowances')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('dep_id')->nullable();
            $table->foreign('dep_id')->references('id')->on('depute_staff')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('usr_id')->nullable();
            $table->foreign('usr_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('allw_amt')->nullable();
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
        Schema::dropIfExists('my_allowance_management');
    }
}
