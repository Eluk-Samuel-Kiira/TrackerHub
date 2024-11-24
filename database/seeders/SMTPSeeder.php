<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\DocumentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SMTPSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'app_name' => 'TrackHub',
        ]);

        DocumentType::create([
            'name' => 'pdf',
        ]);
    }
}
