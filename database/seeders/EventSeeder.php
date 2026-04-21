<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('events')->insert([
            [
                'user_id'     => 1,
                'title'       => 'Montreux Jazz Festival 2026',
                'description' => 'Le festival de jazz le plus célèbre du monde, au bord du lac Léman.',
                'date'        => '2026-07-03 18:00:00',
                'location'    => 'Montreux, Suisse',
                'genre'       => 'Jazz',
                'poster'      => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'user_id'     => 1,
                'title'       => 'Paléo Festival 2026',
                'description' => 'Le plus grand festival de musique en plein air de Suisse.',
                'date'        => '2026-07-21 14:00:00',
                'location'    => 'Nyon, Suisse',
                'genre'       => 'Rock / Pop',
                'poster'      => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'user_id'     => 2,
                'title'       => 'Geneva Electronic Music Festival',
                'description' => 'Une nuit dédiée à la musique électronique au cœur de Genève.',
                'date'        => '2026-09-12 22:00:00',
                'location'    => 'Genève, Suisse',
                'genre'       => 'Électro',
                'poster'      => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);

        DB::table('event_user')->insert([
            [
                'event_id'   => 1,
                'user_id'    => 2,
                'status'     => 'going',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'event_id'   => 2,
                'user_id'    => 2,
                'status'     => 'interested',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'event_id'   => 3,
                'user_id'    => 1,
                'status'     => 'going',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}