<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'Super Administrator',
            'Administrator',
            'Technical Working Group',
            'Planning Focal/Officer', 
            'Guest', 
            'Developer',
            'Plans Administrator',
            'Budget Administrator',
            'Procurement Administrator',
            'Encoder',
            'Banned'
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
