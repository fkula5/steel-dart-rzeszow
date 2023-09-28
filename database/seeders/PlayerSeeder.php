<?php

namespace Database\Seeders;

use App\Models\Player;
use Illuminate\Database\Seeder;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonFile = file_get_contents(__DIR__ . '/data/players.json');
        $data = json_decode($jsonFile);
        foreach ($data->players as $value) {
            Player::create([
                'name' => $value->name,
                'second_name' => $value->second_name,
                'league_id' => $value->league_id
            ]);
        }
    }
}
