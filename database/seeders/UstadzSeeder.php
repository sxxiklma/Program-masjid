<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UstadzSeeder extends Seeder
{
    public function run()
    {
        DB::table('ustadzs')->insert([
            ['name' => 'Ustadz Ahmad Arqom, M.Sos'],
            // Tambahkan data ustadz lainnya jika diperlukan
        ]);
    }
}
