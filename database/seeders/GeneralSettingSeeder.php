<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'site_title' => 'Doctor MCQs',
            'email' => 'info@example.co',
            'contact' => '+123456789',
            'copyright_text' => 'Copyright © 2024 | All rights reserved.'
        ];
        DB::table('general_settings')->insert($data);
    }
}
