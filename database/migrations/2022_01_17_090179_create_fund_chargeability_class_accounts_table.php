<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundChargeabilityClassAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_chargeability_class_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coa_id');
            $table->unsignedBigInteger('fcc_id');
            $table->timestamps();

            $table->foreign('coa_id')->references('id')->on('chart_of_accounts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('fcc_id')->references('id')->on('fund_chargeability_classes')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fund_chargeability_class_accounts');
    }
}
