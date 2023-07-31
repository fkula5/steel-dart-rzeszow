<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User as UserAlias;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        UserAlias::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $this->call([
            LeagueSeeder::class,
            HighOutTypeSeeder::class,
            FastOutTypeSeeder::class,
            PlayerSeeder::class,
            DummyGamesSeeder::class
        ]);
    }
}
