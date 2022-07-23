<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKdpkpksMfoCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kdpkpks_mfo_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kdpkpks_id');
            $table->unsignedBigInteger('mfo_id');
            $table->timestamps();

            $table->foreign('kdpkpks_id')->references('id')->on('kdp_kp_ks')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('mfo_id')->references('id')->on('mfos')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kdpkpks_mfo_categories');
    }
}
