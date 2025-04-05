<?php

namespace Database\Seeders;

use App\Models\Shoe;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MoodelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $models = Storage::json('/public/models.json');
        foreach ($models as $model) {

            $date = Carbon::now()->addDays(rand(-21, -14));

            $model_id = DB::table('moodels')->insert([
                'model_number' => $model['model_number'],
                'created_at' => $date,
                'updated_at' => $date,
            ]);

        }
    }
}
