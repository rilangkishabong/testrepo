<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAllowancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allowances', function (Blueprint $table) {
            $table->id();
            $table->string('allwn')->nullable();
            $table->string('allwn_desc')->nullable();
            // $table->unsignedBigInteger('appl_to')->nullable();
            // $table->foreign('appl_to')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
        DB::insert('insert into allowances (id, allwn, allwn_desc) values (?, ?, ?)', [1, 'TA', NULL]);
        DB::insert('insert into allowances (id, allwn, allwn_desc) values (?, ?, ?)', [2, 'DA', NULL]);
        DB::insert('insert into allowances (id, allwn, allwn_desc) values (?, ?, ?)', [3, 'Lodging', NULL]);
        DB::insert('insert into allowances (id, allwn, allwn_desc) values (?, ?, ?)', [4, 'Others', NULL]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('allowances');
    }
}
