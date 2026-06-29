<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormOpcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_opcs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->float('add_point_score')->default(0);
            $table->integer('year')->nullable();
            $table->unsignedBigInteger('status_id')->nullable()->default(1);
            $table->unsignedBigInteger('locker_user_id')->nullable();
            $table->dateTime('datetime_locked')->nullable();

            $table->foreign('status_id')->references('id')->on('form_statuses')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('stage_id')->nullable();
            $table->unsignedBigInteger('serreg_id');
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->integer('semester')->nullable();
            $table->boolean('locked')->default(0);
            $table->foreign('locker_user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('serreg_id')->references('id')->on('service_regions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('stage_id')->references('id')->on('stages')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_opcs');
    }
}
