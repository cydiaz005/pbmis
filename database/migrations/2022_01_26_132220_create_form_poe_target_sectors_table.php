<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormPoeTargetSectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_poe_target_sectors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('poe_id');
            $table->unsignedBigInteger('target_sector_id');
            $table->timestamps();

            $table->foreign('poe_id')->references('id')->on('form_poes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('target_sector_id')->references('id')->on('target_sectors')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_poe_target_sectors');
    }
}
