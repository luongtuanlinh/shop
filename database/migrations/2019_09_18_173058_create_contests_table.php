<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('exam_id');
            $table->string('code')->nullable()->comment('Ma truy cap vao ky thi');
            $table->string('name');
            $table->dateTime('start_time')->nullable()->comment('Thoi gian bat dau ky thi');
            $table->dateTime('end_time')->nullable()->comment('Thoi gian ket thuc ky thi');
            $table->string('status')->nullable()->comment('Trang thai ky thi');
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
        Schema::dropIfExists('contests');
    }
}
