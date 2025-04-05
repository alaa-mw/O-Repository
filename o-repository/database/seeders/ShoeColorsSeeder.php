<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\Shoe;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ShoeColorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        // Get all shoe IDs
        $shoeIds = \App\Models\Shoe::pluck('id')->toArray();

        foreach ($shoeIds as $shoeId) {
            $number = rand(1, 5); // Random number of color combinations per shoe

            while ($number--) {
                $date = now()->addDays(rand(1, 2));

                $color_id = rand(1, Color::query()->count());

                DB::table('shoe_colors')->insertGetId([
                    'color_id' => $color_id,
                    'shoe_id' => $shoeId,
                    // 'avaliable_amount'=>,
                    // 'sold_amount'=>,
                    // 'total_amount'=>,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            }
        }
    }
}
