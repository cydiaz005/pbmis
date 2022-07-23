<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundChargeabilityClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_chargeability_classes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ac_id');
            $table->unsignedBigInteger('fc_id');
            $table->timestamps();

            $table->foreign('ac_id')->references('id')->on('allotment_classes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('fc_id')->references('id')->on('fund_chargeabilities')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fund_chargeability_classes');
    }
}
