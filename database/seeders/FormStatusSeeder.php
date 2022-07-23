<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormStatus;

class FormStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            "Draft", "Published", "For Review", "Returned", "Resolved"
        ];
        foreach ($statuses as $status) {
            
            FormStatus::create([
                "status"=>$status,
            ]);
        }
       
    }
}
