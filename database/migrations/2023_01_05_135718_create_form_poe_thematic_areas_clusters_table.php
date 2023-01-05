<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormPoeThematicAreasClustersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_poe_thematic_areas_clusters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poe_id')->constrained('form_poes')->onDelete('cascade')->onUpdate('cascade'); 
            $table->foreignId('tac_id')->constrained('thematic_areas_clusters')->onDelete('cascade')->onUpdate('cascade'); 
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
        Schema::dropIfExists('form_poe_thematic_areas_clusters');
    }
}
