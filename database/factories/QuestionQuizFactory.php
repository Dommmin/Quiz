<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\QuestionQuiz;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionQuizFactory extends Factory
{
    protected $model = QuestionQuiz::class;

    public function definition(): array
    {
        return [
            'question_id' => Question::pluck('id')->random(),
            'quiz_id'     => Quiz::pluck('id')->random(),
        ];
    }
}
