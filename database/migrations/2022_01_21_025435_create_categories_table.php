<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        // DB::statement('DROP VIEW categories');
        DB::statement('CREATE OR REPLACE VIEW categories AS (
            SELECT fund_chargeability_classes.id, allotment_classes.code as class_code, allotment_classes.class, fund_chargeabilities.code as fc_code, fund_chargeabilities.type, CONCAT(allotment_classes.accronym, "-", fund_chargeabilities.accronym) as category FROM fund_chargeability_classes, allotment_classes, fund_chargeabilities WHERE fund_chargeability_classes.ac_id = allotment_classes.id AND fund_chargeability_classes.fc_id = fund_chargeabilities.id
        )');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
