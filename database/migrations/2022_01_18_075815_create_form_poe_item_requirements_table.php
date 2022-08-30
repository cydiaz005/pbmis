<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormPoeItemRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_poe_item_requirements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subpap_id');
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('suggested_itemreq_id')->nullable();
            $table->string('itemreq_txt')->nullable();
            
            $table->double('per_capita_cost');
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->text('unit')->nullable();
            $table->unsignedBigInteger('procurement_mode_id');
            $table->integer('qty_pax');
            $table->integer('no_of_days');
            $table->double('total')->nullable();
            $table->timestamps();

            $table->foreign('subpap_id')->references('id')->on('form_poe_sub_paps')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('account_id')->references('id')->on('chart_of_accounts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('procurement_mode_id')->references('id')->on('procurement_modes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('suggested_itemreq_id')->references('id')->on('list_of_item_requirements')->onDelete('cascade')->onUpdate('cascade');
             
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_poe_item_requirements');
    }
}
