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

        DB::table('users')->insert([

            'name' => 'admin',

            'email' => 'admin@hotmail.com',

            'password' => '$2y$10$AYGJxYwuu0WoJpgIr6aJ2OsY9lqyqHuokYOfh51AoKwzbcg6c2BXu', // 123456

            'is_admin' => '1',
        
            'created_at' => '2024-02-13 15:33:06',

        ]);



    }
}
