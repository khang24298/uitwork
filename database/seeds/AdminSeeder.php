<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin')->insert([
            [
                'username' => 'admin2',
                'password' => Hash::make('admin2'),
                'departmentID' => rand(1,10),
                'email' => Str::random(10).'@gmail.com',
                'name' => Str::random(20),
            ],
            [
                'username' => 'khang2',
                'password' => Hash::make('Khang1998!'),
                'departmentID' => rand(1,10),
                'email' => 'khangnguyen@gmail.com',
                'name' => 'Tien Khang',
            ]
        ]
        );
    }
}
