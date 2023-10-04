<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'raphael@example.com',
            'password' => 'password',
            'phone_number' => '08106924812',
            'role' => 'admin',
            'address_city' => 'Ikeja',
            'address_state' => 'Lagos',
            'bank_name' => 'GTBank',
            'account_number' => '0123456789',

        ]);


        \App\Models\ProductOne::factory(12)->create();
        \App\Models\ProductTwo::factory(15)->create();
    }
}
