<?php

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
        $this->call(UserSeeder::class);
        $this->call(TaskSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(ProjectsSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(EvaluationSeeder::class);
    }
}
