<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestAnswer;
use App\Models\User;
use Inertia\Inertia;

class ResultController extends Controller
{
    public function index()
    {
        $results = Test::with('quiz')->withCount('questions')->where('user_id', auth()->id())->paginate();

        return Inertia::render('Results/Index', compact('results'));
    }

    public function show(Test $test)
    {
        $test->load('user', 'quiz');
        $total_questions = $test->quiz->questions->count();
        $users = null;

        $results = TestAnswer::where('test_id', $test->id)
            ->with('question.questionOptions')
            ->get();

        if ($test->quiz->public == 0) {
            $users = User::select('users.id', 'users.name', \DB::raw('sum(tests.result) as correct'), \DB::raw('sum(tests.time_spent) as time_spent'))
                ->join('tests', 'users.id', '=', 'tests.user_id')
                ->where('tests.quiz_id', $test->quiz_id)
                ->whereNotNull('tests.time_spent')
                ->groupBy('users.id', 'users.name')
                ->orderBy('correct', 'desc')
                ->orderBy('time_spent')
                ->get()
                ->map(function ($user) {
                    return [
                        'id'         => $user->id,
                        'name'       => $user->name,
                        'correct'    => $user->correct,
                        'time_spent' => intval($user->time_spent / 60) . ':' . gmdate('s', $user->time_spent),
                    ];
                });
        }

        $test = [
            'id'         => $test->id,
            'result'     => $test->result,
            'ip_address' => $test->ip_address,
            'time_spent' => intval($test->time_spent / 60) . ':' . gmdate('s', $test->time_spent),
            'quiz_id'    => $test->quiz_id,
            'created_at' => $test->created_at->format('d-m-Y H:i:s'),
            'user'       => $test->user ? ['name' => $test->user->name, 'email' => $test->user->email] : '',
            'quiz'       => $test->quiz,
        ];

        return Inertia::render('Results/Show', compact('test', 'results', 'users', 'total_questions'));
    }
}
