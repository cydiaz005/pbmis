<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormPoeTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_poe_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('poe_id');
            $table->unsignedBigInteger('paptag_id');
            $table->timestamps();
            $table->foreign('poe_id')->references('id')->on('form_poes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('paptag_id')->references('id')->on('pap_tags')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_poe_tags');
    }
}
