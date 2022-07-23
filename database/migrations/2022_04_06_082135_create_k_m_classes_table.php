<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateKMClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // DB::statement('DROP VIEW k_m_classes');

        DB::statement('CREATE OR REPLACE VIEW k_m_classes AS (SELECT kdpkpks_mfo_categories.id, kdp_kp_ks.desc as "kdpkpks_desc", mfos.desc as "mfos_desc" FROM kdpkpks_mfo_categories, kdp_kp_ks, mfos WHERE kdpkpks_mfo_categories.kdpkpks_id = kdp_kp_ks.id AND kdpkpks_mfo_categories.mfo_id = mfos.id 
        )');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('k_m_classes');
    }
}
