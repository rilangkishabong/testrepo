<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDeputStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deput_statuses', function (Blueprint $table) {
            $table->id();
            $table->string("deput_status");
            $table->timestamps();
        });
        DB::insert('insert into deput_statuses (id, deput_status) values (?, ?)', [1, 'Accepted']);
        DB::insert('insert into deput_statuses (id, deput_status) values (?, ?)', [2, 'Rejected']);
        DB::insert('insert into deput_statuses (id, deput_status) values (?, ?)', [3, 'Cancelled']);
        DB::insert('insert into deput_statuses (id, deput_status) values (?, ?)', [4, 'No Action']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deput_statuses');
    }
}
