<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = Carbon::now()->addDays(rand(-14, -12));

        DB::table('users')->insertGetId([
            'name' => "osama",
            'phone_number' => '0900000007',
            'password' => "12345678",
            'created_at' => $date,
            'updated_at' => $date,
        ]);
    }
}
