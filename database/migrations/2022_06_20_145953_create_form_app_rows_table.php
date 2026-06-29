<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormAppRowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_app_rows', function (Blueprint $table) {
            $table->id();
            $table->text('app_procurement_program')->nullable();
            $table->text('app_advertisement')->nullable();
            $table->text('app_contract_signing')->nullable();
            $table->text('app_notice_of_award')->nullable();
            $table->text('app_remarks')->nullable();
            $table->text('app_submission')->nullable();
            $table->foreignId('item_req_id')->constrained('form_poe_item_requirements')->onDelete('cascade')->onUpdate('cascade'); 
            $table->foreignId('app_id')->constrained('form_apps')->onDelete('cascade')->onUpdate('cascade'); 
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
        Schema::dropIfExists('form_app_rows');
    }
}
