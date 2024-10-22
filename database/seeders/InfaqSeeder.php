<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InfaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('infaqs')->insert([
            [
                'code' => 'OP',
                'name' => 'Operasional',
                'description' => 'Operasional'
            ],
            [
                'code' => 'PB',
                'name' => 'Pembangunan',
                'description' => 'Pembangunan Masjid'
            ],
            [
                'code' => 'OQ',
                'name' => 'Operasional Qurban',
                'description' => 'Operasional Qurban'
            ],
        ]);
    }
}
