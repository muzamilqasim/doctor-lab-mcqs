<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExtensionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $extensions = [
            [
                'slug' => 'custom-captcha',
                'name' => 'Custom Captcha',
                'description' => 'Just put any random string',
                'image' => 'captcha.png',
                'script' => null,
                'shortcode' => json_encode([
                    'random_key' => [
                        'title' => 'Random String',
                        'value' => 'Secure'
                    ]
                ]),
                'support' => null,
                'status' => 0,
            ]
           
        ];
        DB::table('extensions')->insert($extensions);
    }
}
