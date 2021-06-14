<?php

// use Database\Seeders\LaravelEntrustSeeder;
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
        $this->call([
            UserSeeder::class,
            TaskSeeder::class,
            AdminSeeder::class,
            ProjectsSeeder::class,
            DepartmentSeeder::class,
            EvaluationSeeder::class,
            CriteriaSeeder::class,
            LaravelEntrustSeeder::class,
        ]);
    }
}
