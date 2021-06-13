<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // Product::truncate();
        // Category::truncate();

        $category = Category::create([
            'category_name' => 'Shirt',
            'category_description'=> 'These are the Shirt section',
        ]);

        // \App\Models\User::factory(10)->create();
        Product::create([
            'product_name' => 'blue shirt',
            'product_desc' => 'This is a blue shirt',
            'price' => '2500',
            'category_id' => $category->id,
        ]);

        Product::factory(2)->create([
            'category_id'=>'3',
        ]);

    }
}
