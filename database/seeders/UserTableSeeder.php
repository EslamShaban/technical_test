<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::create([
            'name' => 'Eslam Shaban',
            'email' => 'test@test.com',
            'phone' => '01145451231',
            'password' => bcrypt('123456')
        ]);

        
        $user = \App\Models\User::create([
            'name' => 'Mohamed Shaban',
            'email' => 'user@test.com',
            'phone' => '01145451231',
            'password' => bcrypt('123456'),

        ]);

    }
}
