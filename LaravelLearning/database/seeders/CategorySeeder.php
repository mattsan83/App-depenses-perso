<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Salary', 'type' => 'income', 'slug' => 'salary', 'color' => '#4CAF50'],
            ['name' => 'Freelance', 'type' => 'income', 'slug' => 'freelance', 'color' => '#2196F3'],
            ['name' => 'Investments', 'type' => 'income', 'slug' => 'investments', 'color' => '#FF9800'],
            ['name' => 'Food', 'type' => 'expense', 'slug' => 'food', 'color' => '#F44336'],
            ['name' => 'Rent', 'type' => 'expense', 'slug' => 'rent', 'color' => '#9C27B0'],
            ['name' => 'Utilities', 'type' => 'expense', 'slug' => 'utilities', 'color' => '#3F51B5'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
