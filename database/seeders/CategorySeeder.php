<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::insert([
            ['name' => 'Uncategorized'],
            ['name' => 'Billing/payment'],
            ['name' => 'Technical question'],
        ]);
    }
}
