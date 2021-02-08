<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('users')->insert([
            'name' => 'George',
            'email' => 'georgeclm6@gmail.com',
            'password' => bcrypt('123456789')
        ]);
        DB::table('users')->insert([
            'name' => 'Arnetta',
            'email' => 'cavidjaja@gmail.com',
            'password' => bcrypt('123456789')
        ]);
        DB::table('users')->insert([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => bcrypt('123456789')
        ]);
    }
}
