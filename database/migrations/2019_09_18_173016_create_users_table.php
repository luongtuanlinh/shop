<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create("users", function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('username');
            $table->tinyInteger('admin');
            $table->string('password');
            $table->string('phone');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create("groups", function (Blueprint $table){
            $table->bigIncrements('id');
            $table->tinyInteger("type");
            $table->string("name");
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create("user_groups", function (Blueprint $table){
            $table->bigIncrements('id');
            $table->integer("user_id");
            $table->integer("group_id");
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create("roles", function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string("name");
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create("permission_roles", function (Blueprint $table){
            $table->bigIncrements('id');
            $table->integer("role_id");
            $table->integer("permission_id");
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create("role_users", function (Blueprint $table){
            $table->bigIncrements('id');
            $table->integer("user_id");
            $table->integer("role_id");
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
        Schema::dropIfExists('groups');
        Schema::dropIfExists('user_groups');
        Schema::dropIfExists('permission_roles');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('role_users');
    }
}
