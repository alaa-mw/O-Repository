<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = Storage::json('/public/colors.json');
        foreach ($colors as $color) {

            $date = Carbon::now()->addDays(rand(-21, -14));

            DB::table('colors')->insert([
                'name' => $color['name'],
                'hexa'=>$color['hexa'],
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
    }
}
