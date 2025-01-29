<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use League\CommonMark\Node\Block\Document;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            UserSeeder::class,
            ProjectCategorySeeder::class,
            DepartmentSeeder::class,
            ClientSeeder::class,
            CurrencySeeder::class,
            DocumentTypeSeeder::class,
            SMTPSeeder::class,
            UOMSeeder::class,
        ]);
    }
}
