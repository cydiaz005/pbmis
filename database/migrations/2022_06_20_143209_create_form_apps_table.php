<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_apps', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('status_id')->constrained('form_statuses')->onDelete('cascade')->onUpdate('cascade'); 
            $table->foreignId('stage_id')->constrained()->onDelete('cascade')->onUpdate('cascade'); 
            $table->foreignId('service_region_id')->constrained()->onDelete('cascade')->onUpdate('cascade'); 
            $table->integer('year');
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
        Schema::dropIfExists('form_apps');
    }
}
