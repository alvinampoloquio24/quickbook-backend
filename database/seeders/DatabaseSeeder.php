<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
 public function run(): void
{
  \App\Models\User::factory()->create([
    'first_name' => 'John',
    'last_name' => 'Doe',
    'email' => 'admin@example.com',
    'password' => bcrypt('password'),
    'phone' => '0916121221',
    'role' => 'admin',
]);
}

}
