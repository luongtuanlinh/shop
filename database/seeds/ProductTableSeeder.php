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
            DB::table('product_size')->insert([
                'product_id' => $product->id,
                'size_id' => rand(1,5),
                'count' => rand(0,100),
            ]);
        });
    }
}
