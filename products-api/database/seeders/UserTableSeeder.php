<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user')->insert([
            'first_name' => 'Ronny',
            'last_name' => 'Matute',
            'email' => 'rgmatute91@gmail.com',
            'password' => Hash::make('Funiber2@24')
        ]);
    }
}
