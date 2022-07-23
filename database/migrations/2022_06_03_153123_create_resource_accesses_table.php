<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourceAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resource_accesses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger("resource_id");
            $table->unsignedBigInteger("access_id");
            $table->foreign('resource_id')->references('id')->on('resources')->onDelete('cascade')->onUpdate('cascade'); 
            $table->foreign('access_id')->references('id')->on('resource_accounts')->onDelete('cascade')->onUpdate('cascade');  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resource_accesses');
    }
}
