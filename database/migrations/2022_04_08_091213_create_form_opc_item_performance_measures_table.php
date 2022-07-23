<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormOpcItemPerformanceMeasuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_opc_item_performance_measures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_opc_item_id');
            $table->unsignedBigInteger('pm_id');
            $table->double('rating')->nullable();
            $table->string('target')->nullable();
            $table->foreign('pm_id')->references('id')->on('performance_measures')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('form_opc_item_id')->references('id')->on('form_opc_items')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_opc_item_performance_measures');
    }
}
