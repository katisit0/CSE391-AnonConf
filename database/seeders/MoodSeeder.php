<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $moods = ['Happy', 'Sad', 'Angry', 'Excited', 'Anxious', 'Relaxed'];

        foreach ($moods as $mood) {
            DB::table('moods')->insert([
                'name' => $mood,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
