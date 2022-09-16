<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiscalLimitItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fiscal_limit_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('serreg_id');
            $table->unsignedBigInteger('cat_id');
            
            $table->double('amount', 2);
            $table->timestamps();
            
            $table->foreign('stage_id')->references('id')->on('stages')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('cat_id')->references('id')->on('fund_chargeability_classes')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('fiscal_limit_items');
    }
}
