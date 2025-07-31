<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        //DINAS ACC
        User::create([
            'name' => 'dinas',
            'email' => 'dinas@gmail.com',
            'password' => bcrypt('dinas'),
            'is_admin' => false,
            'role' => 'admin',
        ]);

        $this->call(AdminSeeder::class);
    }
}
