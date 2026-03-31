<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Elektronik'],
            ['name' => 'Furniture'],
            ['name' => 'Stationery'],
            ['name' => 'Komputer'],
            ['name' => 'Peralatan Kantor'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
