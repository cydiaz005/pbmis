<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnedFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('returned_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('returner_id')->nullable();
            $table->text('reason');
            $table->morphs('returnable');
            $table->timestamps();

            $table->foreign('returner_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('returned_forms');
    }
}
