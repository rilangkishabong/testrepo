<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTadaStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tada_statuses', function (Blueprint $table) {
            $table->id();
            $table->string("tada_stat");
            $table->timestamps();
        });
        DB::insert('insert into tada_statuses (id, tada_stat) values (?, ?)', [1, 'Approved']);
        DB::insert('insert into tada_statuses (id, tada_stat) values (?, ?)', [2, 'Rejected']);
        DB::insert('insert into tada_statuses (id, tada_stat) values (?, ?)', [3, 'Cancelled']);
        DB::insert('insert into tada_statuses (id, tada_stat) values (?, ?)', [4, 'No Action']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tada_statuses');
    }
}
