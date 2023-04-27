<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Test;
use App\Models\TestAnswer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TestAnswerFactory extends Factory
{
    protected $model = TestAnswer::class;

    public function definition(): array
    {
        return [
            'correct' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::pluck('id')->random(),
            'test_id' => Test::pluck('id')->random(),
            'question_id' => Question::pluck('id')->random(),
            'option_id' => QuestionOption::pluck('id')->random()
        ];
    }
}
