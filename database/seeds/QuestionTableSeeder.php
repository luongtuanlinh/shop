<?php

use Illuminate\Database\Seeder;

class QuestionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return $questions = factory(\Modules\Exams\Entities\Question::class, 1000)
            ->create()
            ->each(function ($question){
                $question->answers()->saveMany(factory(\Modules\Exams\Entities\Answer::class, 4)->make());
                \Modules\Exams\Entities\QuestionTag::create([
                    'question_id' => $question->id,
                    'tag_id' => 1,
                ]);
                \Modules\Exams\Entities\QuestionTag::create([
                    'question_id' => $question->id,
                    'tag_id' => rand(2,5),
                ]);
            });
    }
}
