<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLeaveStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('leave_status')->nullable();
        });
        DB::insert('insert into leave_statuses (id, leave_status) values (?, ?)', [1, 'Approved']);
        DB::insert('insert into leave_statuses (id, leave_status) values (?, ?)', [2, 'Rejected']);
        DB::insert('insert into leave_statuses (id, leave_status) values (?, ?)', [3, 'Cancelled']);
        DB::insert('insert into leave_statuses (id, leave_status) values (?, ?)', [4, 'No Action']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_statuses');
    }
}
