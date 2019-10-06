<?php

use Illuminate\Database\Seeder;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $fake_data = ['Nhân viên', 'Quản lý', 'Giám đốc', 'Chuyên môn', 'Xã hội'];
        foreach($fake_data as $name)
        {
            \Modules\Exams\Entities\Tag::create([
                'name' => $name,
            ]);
        }
    }
}
