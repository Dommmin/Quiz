<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuizAnswersStoreRequest;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Quiz;
use App\Models\Test;
use App\Models\TestAnswer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $query = Quiz::withCount(['questions'])
            ->has('questions')
            ->when(auth()->guest() || ! auth()->user()->is_admin, function($query) {
                return $query->where('published', 1);
            })
            ->orderBy('id')
            ->get();

        $public = $query->where('public', true);
        $registered = $query->where('public', false);

        return Inertia::render('Index', compact('public', 'registered'));
    }

    public function show(Quiz $quiz)
    {
        $startTimeSeconds = now()->timestamp;

        $questions = Question::query()
            ->inRandomOrder()
            ->whereRelation('quizzes','id', $quiz->id)
            ->with('questionOptions')
            ->get();

        $quizTime = config('quiz.secondsPerQuestion');

        $questionsCount = $questions->count();

        return Inertia::render('Quiz/Show', compact( 'quiz', 'startTimeSeconds', 'questionsCount', 'questions', 'quizTime'));
    }

    public function store(Request $request)
    {
        $result = 0;
        $quizId = $request->get('quizId');

        $questions = Question::query()
            ->inRandomOrder()
            ->whereRelation('quizzes','id', $quizId)
            ->with('questionOptions')
            ->get();

        $test = Test::create([
            'user_id'    => auth()->id(),
            'quiz_id'    => $quizId,
            'result'     => 0,
            'ip_address' => request()->ip(),
            'time_spent' => now()->timestamp - $request->get('startTimeSeconds')
        ]);

        foreach ($request->get('questionsAnswers') as $key => $option) {
            $status = 0;

            if (! empty($option) && QuestionOption::find($option)->correct) {
                $status = 1;
                $result++;
            }

            TestAnswer::create([
                'user_id'     => auth()->id(),
                'test_id'     => $test->id,
                'question_id' => $questions[$key]->id,
                'option_id'   => $option ?? null,
                'correct'     => $status,
            ]);
        }

        $test->update([
            'result' => $result,
        ]);

        return redirect()->route('quiz.index');
    }
}
