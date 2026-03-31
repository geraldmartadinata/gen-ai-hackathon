<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
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
            ['name' => 'Pakaian'],
            ['name' => 'Makanan'],
            ['name' => 'Peralatan Rumah Tangga'],
            ['name' => 'Buku'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
