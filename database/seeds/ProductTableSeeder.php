<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        return $product = factory(\Modules\Product\Entities\Product::class, 1000)
        ->create()
        ->each(function($product) {
            \Modules\Product\Entities\ProductSize::create([
                'product_id' => $product->id,
                'size_id' => rand(1,5),
                'count' => rand(1,100),
            ]);
        });
    }
}
