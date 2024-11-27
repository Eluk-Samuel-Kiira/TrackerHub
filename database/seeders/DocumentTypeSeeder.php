<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DocumentType::create([
            'name'=> 'Project Plan',
            'created_by' => User::where('status', 'active')->get()->random()->id,
        ]);

        DocumentType::create([
            'name'=> 'Project Charter',
            'created_by' => User::where('status', 'active')->get()->random()->id,
        ]);

        DocumentType::create([
            'name'=> 'Project Schedule',
            'created_by' => User::where('status', 'active')->get()->random()->id,
        ]);
    }
}
