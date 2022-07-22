<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateShiftTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shift_times', function (Blueprint $table) {
            $table->id();
            $table->string("timename");
            $table->timestamps();
        });
        DB::insert('insert into shift_times (id, timename) values (?, ?)', [1, 'Half day']);
        DB::insert('insert into shift_times (id, timename) values (?, ?)', [2, 'Full day']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shift_times');
    }
}
