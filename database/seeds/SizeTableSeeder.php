<?php

use Illuminate\Database\Seeder;

class SizeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            'S' => '<1m55, 40-50kg',
            'M' => '1m50-1m60, 45-55kg',
            'L' => '1m55-1m65, 50-60kg',
            'XL' => '1m60-1m70, 55-65kg',
            'XXL' => '1m60-1m70, 60-70kg',
            'XXXL' => '>1m65, >70kg',
        ];

        foreach($data as $key => $value) {
            \Modules\Product\Entities\Size::create([
                'size_name' => $key,
                'introduction' => $value,
            ]);
        }
    }
}
