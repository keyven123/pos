<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //to run this seeder php artisan db:seed --class=ProductSeeder
        //Categories
        $categories = ['MILKTEA', 'FRUITEA', 'FRAPPE', 'BLENDED', 'SINKERS'];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category
            ]);
        }

        //Products

        $products_1 = [
            'Jollitea', 'Wintermelon', 'Hazelnut', 'Mango', 'Strawberry', 'Tiramisu', 'Thai Tea', 'Taro', 'Chocolate', 'Dark Chocolate', 'Caramel', 'Matcha', 'Okinawa',
            'Choco Hazelnut', 'Choco Matcha'
        ];
        $products_2 = [
            'Wintermelon', 'Green Apple', 'Mango', 'Orange', 'Honey Dew', 'Blueberry', 'Strawberry', 'Lemon'
        ];
        $products_3 = [
            'Mocha', 'Dark Mocha', 'Coffee Jelly', 'Milk Choco'
        ];
        $products_4 = [
            'Mango Graham', 'Avocado Graham', 'Chocolate', 'Dark Chocolate', 'Matcha', 'Taro', 'Mango Overload', 'Hokkaido'
        ];

        foreach ($products_1 as $product) {
            Product::create([
                'category_id' => 1,
                'name' => $product,
                'description' => $product,
                'barcode' => $product,
                'variation' => 1,
            ]);
        }
        foreach ($products_2 as $product) {
            Product::create([
                'category_id' => 2,
                'name' => $product,
                'description' => $product,
                'barcode' => $product,
                'variation' => 1,
            ]);
        }
        foreach ($products_3 as $product) {
            Product::create([
                'category_id' => 3,
                'name' => $product,
                'description' => $product,
                'barcode' => $product,
                'variation' => 1,
            ]);
        }
        foreach ($products_4 as $product) {
            Product::create([
                'category_id' => 4,
                'name' => $product,
                'description' => $product,
                'barcode' => $product,
                'variation' => 1,
            ]);
        }

        //Variants
        $variant_1 = [
            ['product_id' => 1, 'variation_name' => 'Medium', 'variation_price' => 39],
            ['product_id' => 1, 'variation_name' => 'Large', 'variation_price' => 59],
            ['product_id' => 2, 'variation_name' => 'Medium', 'variation_price' => 45],
            ['product_id' => 2, 'variation_name' => 'Large', 'variation_price' => 65],
            ['product_id' => 3, 'variation_name' => 'Medium', 'variation_price' => 45],
            ['product_id' => 3, 'variation_name' => 'Large', 'variation_price' => 65],
            ['product_id' => 4, 'variation_name' => 'Medium', 'variation_price' => 45],
            ['product_id' => 4, 'variation_name' => 'Large', 'variation_price' => 65],
            ['product_id' => 5, 'variation_name' => 'Medium', 'variation_price' => 45],
            ['product_id' => 5, 'variation_name' => 'Large', 'variation_price' => 65],
            ['product_id' => 6, 'variation_name' => 'Medium', 'variation_price' => 45],
            ['product_id' => 6, 'variation_name' => 'Large', 'variation_price' => 65],
            ['product_id' => 7, 'variation_name' => 'Medium', 'variation_price' => 45],
            ['product_id' => 7, 'variation_name' => 'Large', 'variation_price' => 65],
            ['product_id' => 8, 'variation_name' => 'Medium', 'variation_price' => 45],
            ['product_id' => 8, 'variation_name' => 'Large', 'variation_price' => 65],
            ['product_id' => 9, 'variation_name' => 'Medium', 'variation_price' => 39],
            ['product_id' => 9, 'variation_name' => 'Large', 'variation_price' => 59],
            ['product_id' => 10, 'variation_name' => 'Medium', 'variation_price' => 45],
            ['product_id' => 10, 'variation_name' => 'Large', 'variation_price' => 65],
            ['product_id' => 11, 'variation_name' => 'Medium', 'variation_price' => 45],
            ['product_id' => 11, 'variation_name' => 'Large', 'variation_price' => 65],
            ['product_id' => 12, 'variation_name' => 'Medium', 'variation_price' => 49],
            ['product_id' => 12, 'variation_name' => 'Large', 'variation_price' => 65],
            ['product_id' => 13, 'variation_name' => 'Medium', 'variation_price' => 49],
            ['product_id' => 13, 'variation_name' => 'Large', 'variation_price' => 65],
            ['product_id' => 14, 'variation_name' => 'Medium', 'variation_price' => 49],
            ['product_id' => 14, 'variation_name' => 'Large', 'variation_price' => 65],
            ['product_id' => 15, 'variation_name' => 'Medium', 'variation_price' => 49],
            ['product_id' => 15, 'variation_name' => 'Large', 'variation_price' => 65],
            
            ['product_id' => 16, 'variation_name' => 'Medium', 'variation_price' => 45],
            ['product_id' => 16, 'variation_name' => 'Large', 'variation_price' => 65],
            ['product_id' => 17, 'variation_name' => 'Medium', 'variation_price' => 45],
            ['product_id' => 17, 'variation_name' => 'Large', 'variation_price' => 65],
            ['product_id' => 18, 'variation_name' => 'Medium', 'variation_price' => 45],
            ['product_id' => 18, 'variation_name' => 'Large', 'variation_price' => 65],
            ['product_id' => 19, 'variation_name' => 'Medium', 'variation_price' => 45],
            ['product_id' => 19, 'variation_name' => 'Large', 'variation_price' => 65],
            ['product_id' => 20, 'variation_name' => 'Medium', 'variation_price' => 45],
            ['product_id' => 20, 'variation_name' => 'Large', 'variation_price' => 65],
            ['product_id' => 21, 'variation_name' => 'Medium', 'variation_price' => 45],
            ['product_id' => 21, 'variation_name' => 'Large', 'variation_price' => 65],
            ['product_id' => 22, 'variation_name' => 'Medium', 'variation_price' => 45],
            ['product_id' => 22, 'variation_name' => 'Large', 'variation_price' => 65],
            ['product_id' => 23, 'variation_name' => 'Medium', 'variation_price' => 45],
            ['product_id' => 23, 'variation_name' => 'Large', 'variation_price' => 65],

            ['product_id' => 24, 'variation_name' => 'Medium', 'variation_price' => 85],
            ['product_id' => 24, 'variation_name' => 'Large', 'variation_price' => 95],
            ['product_id' => 25, 'variation_name' => 'Medium', 'variation_price' => 85],
            ['product_id' => 25, 'variation_name' => 'Large', 'variation_price' => 95],
            ['product_id' => 26, 'variation_name' => 'Medium', 'variation_price' => 85],
            ['product_id' => 26, 'variation_name' => 'Large', 'variation_price' => 95],
            ['product_id' => 27, 'variation_name' => 'Medium', 'variation_price' => 85],
            ['product_id' => 27, 'variation_name' => 'Large', 'variation_price' => 95],
            
            ['product_id' => 28, 'variation_name' => 'Medium', 'variation_price' => 55],
            ['product_id' => 28, 'variation_name' => 'Large', 'variation_price' => 65],
            ['product_id' => 29, 'variation_name' => 'Medium', 'variation_price' => 55],
            ['product_id' => 29, 'variation_name' => 'Large', 'variation_price' => 65],
            ['product_id' => 30, 'variation_name' => 'Medium', 'variation_price' => 55],
            ['product_id' => 30, 'variation_name' => 'Large', 'variation_price' => 65],
            ['product_id' => 31, 'variation_name' => 'Medium', 'variation_price' => 55],
            ['product_id' => 31, 'variation_name' => 'Large', 'variation_price' => 65],
            ['product_id' => 32, 'variation_name' => 'Medium', 'variation_price' => 55],
            ['product_id' => 32, 'variation_name' => 'Large', 'variation_price' => 65],
            ['product_id' => 33, 'variation_name' => 'Medium', 'variation_price' => 55],
            ['product_id' => 33, 'variation_name' => 'Large', 'variation_price' => 65],
            ['product_id' => 34, 'variation_name' => 'Medium', 'variation_price' => 85],
            ['product_id' => 34, 'variation_name' => 'Large', 'variation_price' => 95],
            ['product_id' => 35, 'variation_name' => 'Medium', 'variation_price' => 49],
            ['product_id' => 35, 'variation_name' => 'Large', 'variation_price' => 69],

            
        ];


        foreach ($variant_1 as $var) {
            Variant::create([
                'product_id' => $var['product_id'],
                'variation_name' => $var['variation_name'],
                'variation_price' => $var['variation_price']
            ]);
        }

        //Sinkers
        $sinkers = [
            'Tapioca Pearl', 'Nata Crystal', 'Poppong Boba', 'Rainbow Jelly', 'Coffee Jelly'
        ];
        
        foreach ($sinkers as $sinker) {
            Product::create([
                'category_id' => 5,
                'name' => $sinker,
                'description' => $sinker,
                'barcode' => $sinker,
                'variation' => 1,
            ]);
        }

        $sink_var = [
            ['product_id' => 36, 'variation_name' => 'Free', 'variation_price' => 0],
            ['product_id' => 37, 'variation_name' => 'Free', 'variation_price' => 0],
            ['product_id' => 38, 'variation_name' => 'Free', 'variation_price' => 0],
            ['product_id' => 39, 'variation_name' => 'Free', 'variation_price' => 0],
            ['product_id' => 40, 'variation_name' => 'Free', 'variation_price' => 0],
        ];

        foreach ($sink_var as $var) {
            Variant::create([
                'product_id' => $var['product_id'],
                'variation_name' => $var['variation_name'],
                'variation_price' => $var['variation_price']
            ]);
        }

        //Ingredients

        $ingredients_kg = [
            'Creamer', 'Taro', 'Thai Tea', 'Chocolate', 'Dark Chocolate', 'Matcha', 'Okinawa', 'Hokkaido', 'Coffee', 'Whip Cream', 'Pearl', 'Coffee Jelly', 
            'Nata de Coco', 'Choco Chips', 'Graham', 'Cream Cheese', 'Fresh Avocado'
        ];
        $ingredients_L = [
            'Fructose', 'Wintermelon', 'Hazelnut', 'Mango', 'Strawberry', 'Tiramisu', 'Caramel', 'Green Apple',
            'Orange', 'Honey Dew', 'Blueberry', 'Lemon', 'Fresh Mango', 'Doreen'
        ];

        foreach ($ingredients_kg as $in) {
            Ingredient::create([
                'name' => $in,
                'unit' => 'Kg'
            ]);
        }
        foreach ($ingredients_L as $in) {
            Ingredient::create([
                'name' => $in,
                'unit' => 'Liter'
            ]);
        }
    }
}
