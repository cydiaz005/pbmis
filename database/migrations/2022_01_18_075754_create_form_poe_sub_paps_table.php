<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormPoeSubPapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_poe_sub_paps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('poe_id');
            $table->unsignedBigInteger('suggested_subpap_id')->nullable();
            $table->unsignedBigInteger('quarter_target_id')->nullable();
            $table->string('subpap_txt')->nullable();

            $table->foreign('poe_id')->references('id')->on('form_poes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('suggested_subpap_id')->references('id')->on('list_of_sub_paps')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('quarter_target_id')->references('id')->on('quarter_targets')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('form_poe_sub_paps');
    }
}
