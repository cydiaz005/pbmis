<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormPpmpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_ppmps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('poe_id');
            $table->string('enduser_unit');
            $table->unsignedBigInteger('status_id');
            $table->enum('funded',[0,1])->nullable();
            $table->enum('request_status',[0,1])->nullable();
            $table->enum('locked',[0,1])->default(0);
            $table->dateTime('datetime_locked')->nullable();
            $table->unsignedBigInteger('locker_user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('locker_user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('poe_id')->references('id')->on('form_poes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('status_id')->references('id')->on('form_statuses')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_ppmps');
        Schema::table('form_ppmps', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
