<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivityLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {

            $date = Carbon::now()->addDays(rand(-10, -3));

            DB::table('activity_logs')->insert([
                'type' => rand(0, 1) ? 'production' : 'sale',
                'shoe_color_id' =>  rand(1, 6),
                'user_id' => 1,
                'quantity' => rand(1, 10),
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
    }
}
