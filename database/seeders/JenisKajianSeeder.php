<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisKajianSeeder extends Seeder
{
    public function run()
    {
        DB::table('jeniskajians')->insert([
            ['name' => 'Tafsir Ayatul Ahkam'],
            ['name' => 'Hadist Tematik'],
            ['name' => 'Tafkiyatun Nafs'],
            ['name' => 'Tafsir Quran'],
            ['name' => 'Kajian PHBI'],
            ['name' => 'Kajian Umum'],
            // Tambahkan data jenis kajian lainnya jika diperlukan
        ]);
    }
}
