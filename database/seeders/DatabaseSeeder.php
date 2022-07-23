<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        $this->call([
            OfficeSeeder::class,
           
            //ORIGINAL
            DivisionSectionSeeder::class,
            PositionSeeder::class,
           
            ServiceRegionSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            DemoUserSeeder::class,
            ProcurementModeSeeder::class,
            ChartOfAccountsSeeder::class,
            AllotmentClassSeeder::class,
            FundChargeabilitySeeder::class,
            FundChargeabilityClassSeeder::class,
            FundChargeabilityClassAccountSeeder::class,
            PapTagSeeder::class,
            TargetSectorSeeder::class,
            UnitsSeeder::class,
            ListOfSubPapSeeder::class,
            ListOfPapSeeder::class,
            ListOfItemRequirementSeeder::class,
            PriorityClassSeeder::class,
            MfoSeeder::class,
            KdpKpKsSeeder::class,
            MfoKeySeeder::class,
            FormStatusSeeder::class,
            ThematicAreasClusterSeeder::class,
            QuarterTargetSeeder::class,
            StageSeeder::class,
            KdpkpksMfoCategorySeeder::class,
            PerformanceMeasuresSeeder::class,
            //END ORIGINAL
            OfficeMfoSeeder::class,
            FiscalLimitSeeder::class,

            // PoeSeeder::class,
            ResourceSeeder::class,
            PoeTargetSectorSeeder::class

        ]);
        // \App\Models\User::factory(50)->create();

        $file = new Filesystem;
        $file->cleanDirectory('storage/app');
    }
}
