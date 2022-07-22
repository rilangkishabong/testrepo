<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            //$table->tinyInteger('table_id')->unsigned()->autoIncrement();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('emp_id')->nullable()->nullable();
            $table->unsignedBigInteger('office_id')->nullable();
            $table->foreign('office_id')->references('id')->on('office_mgmts')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('dept_id')->nullable();
            $table->foreign('dept_id')->references('id')->on('department_mgmts')->onDelete('cascade')->onUpdate('cascade');
            $table->string('desg')->nullable();
            $table->string('sex')->nullable();
            $table->string('account_type')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

        });
        DB::insert('insert into users (id, name, email, emp_id, office_id, dept_id, desg, sex, account_type, password) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [1, 'ADMIN', 'admin@admin.com', NULL, NULL, NULL, NULL, NULL, 'admin', Hash::make('admin@123')]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
