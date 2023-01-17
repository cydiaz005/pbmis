<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropThematicAreaClusterIdColumnInFormPoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('form_poes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('thematic_area_cluster_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('form_poes', function (Blueprint $table) {
        //     //
        // });
    }
}
