<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting')->insert([
            'id_setting' => 1,
            'company_name' => "POS APP",
            'address' => "Jl. Tentara Pelajar No.60 Muntilan",
            'telephone' => '083127381928',
            'tipe_nota' => 1,
            'logo_path' => 'coming soon',
            'card_member_path' => 'coming soon'
        ]);
    }
}
