<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@nu.edu.pk',
                'password' => Hash::make('password'),
                'admin' => 1
            ],
            [
                'name' => 'User',
                'email' => 'user@nu.edu.pk',
                'password' => Hash::make('password1'),
                'admin' => 0
            ]
        ]);
    }
}