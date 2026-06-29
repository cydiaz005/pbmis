<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormOpcItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('form_opc_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('success_indicator_mt')->nullable();
            //TODO MIGRATE
            $table->text('actual_accomplishments')->nullable();
            $table->text('division_accountable')->nullable();
            //END TODO
            $table->text('remarks')->nullable();
            $table->text('ps_outstanding')->nullable();
            $table->text('ps_very_satisfactory')->nullable();
            $table->text('ps_satisfactory')->nullable();
            $table->text('ps_unsatisfactory')->nullable();
            $table->text('ps_poor')->nullable();
            $table->unsignedBigInteger('form_opc_id')->nullable();
            $table->unsignedBigInteger('pc_id')->nullable();
            $table->unsignedBigInteger('mfo_id')->nullable();
            // $table->unsignedBigInteger('suggested_pap_id')->nullable();

            //  $table->foreign('suggested_pap_id')->references('id')->on('list_of_paps')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('pc_id')->references('id')->on('priority_classes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('mfo_id')->references('id')->on('mfos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('form_opc_id')->references('id')->on('form_opcs')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_opc_items');
    }
}
