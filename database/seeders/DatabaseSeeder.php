<?php

namespace Database\Seeders;

use App\Models\SubcribtionPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
        $this->call(UserTableSeeder::class); 
        $this->call(SubcribtionPlanTableSeeder::class);
        $this->call(MovieTableSeeder::class);
        // \App\Models\User::factory(10)->create();
    }
}
