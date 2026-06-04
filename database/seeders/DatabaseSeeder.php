<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(BhutanContentSeeder::class);

        // Seed a default admin user
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@accessbhutan.com'],
            [
                'name' => 'Admin Chimi',
                'password' => bcrypt('password123'),
                'email_verified_at' => now(),
            ]
        );
    }
}
