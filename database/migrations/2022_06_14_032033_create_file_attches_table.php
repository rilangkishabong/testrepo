<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileAttchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_attches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tr_att_id')->nullable();
            $table->foreign('tr_att_id')->references('id')->on('tour_report_attches')->onDelete('cascade')->onUpdate('cascade');
            $table->string('doc_id')->nullable();
            $table->string('doc_name')->nullable();
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
        Schema::dropIfExists('file_attches');
    }
}
