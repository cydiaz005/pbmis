<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
            $table->string('firstname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('lastname')->nullable();
            $table->string('ext')->nullable();
            $table->string('gender')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->enum('status', [0, 1, 2])->default(0);
            $table->unsignedBigInteger('approver_id')->nullable();
            $table->unsignedBigInteger('pos_id')->nullable();
            $table->unsignedBigInteger('divsec_id')->nullable();
            $table->unsignedBigInteger('serreg_id')->nullable();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();
            $table->foreign('approver_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('pos_id')->references('id')->on('positions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('divsec_id')->references('id')->on('division_sections')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('serreg_id')->references('id')->on('service_regions')->onDelete('cascade')->onUpdate('cascade');
        });
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
