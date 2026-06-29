<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExpenseClass;
class ExpenseClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $expenseClass = [];
        foreach ($expenseClass as $ec) {
            # code...
        }
        ExpenseClass::firstOrCreate([ ],[ ]);
    }
}
