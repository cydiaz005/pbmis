<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Image;
use App\Models\ServiceRegion;
use App\Models\DivisionSection;
use App\Models\Position;
use App\Models\Role;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role as ModelsRole;


class DeployedUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $telmosolutions = User::find(1);
        $tester_superadmin = User::find(2);
        $tester_plansadmin = User::find(3); 
        $tester_budgetadmin = User::find(4); 
        $tester_procurement = User::find(5); 
        $tester_twg = User::find(6); 
        $tester_pfo = User::find(7); 
        $tester_encoder = User::find(8); 

        $super_admin = User::find(9); 
        $plans_admin1 = User::find(10); 
        $plans_admin2 = User::find(11); 
        $budget_admin1 = User::find(12); 
        $budget_admin2 = User::find(13); 
        $procurement_admin = User::find(14); 


        echo $super_admin->email."\n";
        echo $plans_admin1->email."\n";
        echo $plans_admin2->email."\n";
        echo $budget_admin1->email."\n";
        echo $budget_admin2->email."\n";
        echo $procurement_admin->email."\n";


        // $telmosolutions->assignRole('Developer');
        // $tester_superadmin->assignRole('Super Administrator');
        // $tester_plansadmin->assignRole('Plans Administrator');
        // $tester_budgetadmin->assignRole('Budget Administrator');
        // $tester_procurement->assignRole('Procurement Administrator');
        // $tester_twg->assignRole('Technical Working Group');
        // $tester_pfo->assignRole('Planning Focal/Officer');
        // $tester_encoder->assignRole('Encoder');

        $super_admin->assignRole('Super Administrator');
        $plans_admin1->assignRole('Plans Administrator');
        $plans_admin2->assignRole('Plans Administrator');
        $budget_admin1->assignRole('Budget Administrator');
        $budget_admin2->assignRole('Budget Administrator');
        $procurement_admin->assignRole('Procurement Administrator');


        for ($twgSeed=15; $twgSeed <=40 ; $twgSeed++) { 
            User::find($twgSeed)->assignRole('Technical Working Group'); 
        }

        for ($pfoSeed=41; $pfoSeed <=53 ; $pfoSeed++) { 
            User::find($pfoSeed)->assignRole('Planning Focal/Officer'); 
        }

        for ($encoderSeed=54; $encoderSeed <=User::count() ; $encoderSeed++) { 
            User::find($encoderSeed)->assignRole('Encoder'); 
        }

    }
}
