<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\QuestionQuiz;
use App\Models\Quiz;
use App\Models\Test;
use App\Models\TestAnswer;
use App\Models\User;
use Exception;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * @throws Exception
     */
    public function run(): void
    {
        User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('user1234'),
            'is_admin' => true,
        ]);

        User::factory(9);

        Question::factory(100)->create();
        QuestionOption::factory(500)->create();

        Quiz::factory(30)->create()->each(function ($quiz) {
            $quiz->questions()->sync(Question::inRandomOrder()->limit(random_int(1, 5))->pluck('id'));
        });

        QuestionQuiz::factory(100);

        Test::factory(10);
        TestAnswer::factory(100);
    }
}
