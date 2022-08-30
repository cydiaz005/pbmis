<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateAFClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // DB::statement('DROP VIEW a_f_classes');
        DB::statement('CREATE OR REPLACE VIEW a_f_classes AS (
            SELECT fund_chargeability_class_accounts.id, CONCAT(allotment_classes.accronym, "-", fund_chargeabilities.accronym) as category, chart_of_accounts.code, chart_of_accounts.expense_object FROM fund_chargeability_classes, allotment_classes, fund_chargeabilities, fund_chargeability_class_accounts, chart_of_accounts WHERE fund_chargeability_classes.ac_id = allotment_classes.id AND fund_chargeability_classes.fc_id = fund_chargeabilities.id AND fund_chargeability_classes.id = fund_chargeability_class_accounts.fcc_id AND fund_chargeability_class_accounts.coa_id = chart_of_accounts.id
        )');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('a_f_classes');
    }
}
