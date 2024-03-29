<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'iramaroliveira1@hotmail.com',
            'password' => Hash::make('123456'),
            'role' => 'SUPER_ADMIN',
            'created_at' => now()
        ]);
    }
}
