<?php

namespace App\Http\Controllers;

use App\Models\QuestionQuiz;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        $quizzes = Quiz::where('public', 1)->where('published', 1)->get();

        $total_questions = QuestionQuiz::select('question_id')
            ->join('quizzes', 'question_quiz.quiz_id', '=', 'quizzes.id')
            ->where('quizzes.published', 1)
            ->when($request->input('quizId') > 0, function ($query) use($request) {
                return $query->where('quiz_id', $request->input('quizId'));
            })
            ->count();

        $users = User::select('users.name', \DB::raw('sum(tests.result) as correct'), \DB::raw('sum(tests.time_spent) as time_spent'))
            ->join('tests', 'users.id', '=', 'tests.user_id')
            ->whereNotNull('tests.quiz_id')
            ->whereNotNull('tests.time_spent')
            ->whereNull('tests.deleted_at')
            ->when($request->input('quizId') > 0, function ($query) use($request) {
                return $query->where('tests.quiz_id', $request->input('quizId'));
            })
            ->groupBy('users.id', 'users.name')
            ->orderBy('correct', 'desc')
            ->orderBy('time_spent')
            ->get();

        $filters = $request->only(['quizId']);

        return Inertia::render('Leaderboard/Index', compact('quizzes', 'total_questions', 'users', 'filters'));
    }
}
