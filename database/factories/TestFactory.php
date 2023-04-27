<?php

namespace Database\Factories;

use App\Models\Quiz;
use App\Models\Test;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TestFactory extends Factory
{
    protected $model = Test::class;

    public function definition(): array
    {
        return [
            'result'     => $this->faker->randomNumber(),
            'ip_address' => $this->faker->ipv4(),
            'time_spent' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::pluck('id')->random(),
            'quiz_id' => Quiz::pluck('id')->random(),
        ];
    }
}
