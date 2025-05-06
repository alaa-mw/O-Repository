<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ShoeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $shoes = Storage::json('/public/shoes.json');
        foreach ($shoes as $shoe) {

            $date = Carbon::now()->addDays(rand(-21, -14));

            $shoeId = DB::table('shoes')->insertGetId([
                'shoe_number' => $shoe['shoe_number'],
                'moodel_id' => $shoe['model_id'],
                // 'image'=> $shoe['image'],
                'created_at' => $date,
                'updated_at' => $date,
            ]);

        }
    }
}
