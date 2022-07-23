<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormPoeItemRequirementMonthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_poe_item_requirement_months', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_req_id');
            $table->integer('month');
            $table->decimal('amount',19,2);
            $table->string('qty');
            $table->timestamps();

            $table->foreign('item_req_id')->references('id')->on('form_poe_item_requirements')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_poe_item_requirement_months');
    }
}
