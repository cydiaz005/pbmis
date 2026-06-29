<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMfoKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mfo_keys', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mfo_id');
            $table->unsignedBigInteger('key_id');
            $table->timestamps();

            $table->foreign('mfo_id')->references('id')->on('mfos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('key_id')->references('id')->on('kdp_kp_ks')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mfo_keys');
    }
}
