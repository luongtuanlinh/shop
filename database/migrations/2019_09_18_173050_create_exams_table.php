<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('question_list')->comment('danh sach cau hoi cua bai thi [1,2,5,8,20]'); // 
            $table->tinyInteger('status')->comment('Trang thai cua de thi { 0: "Cho duyet", 1: "Da duyet", 2: "Da tu choi"}'); // 
            $table->string('time')->nullable()->comment('Thoi gian bai thi'); // 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exams');
    }
}
