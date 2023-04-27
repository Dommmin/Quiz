<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuizStoreRequest;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class QuizController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        $quizzes = Quiz::withCount('questions')->latest()->paginate();

        return Inertia::render('Admin/Quiz/Index', compact('quizzes'));
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        $questions = Question::get(['id', 'question_text'])->mapWithKeys(fn ($question) => [$question->id => $question->question_text])->toArray();

        return Inertia::render('Admin/Quiz/Create', compact('questions'));
    }

    /**
     * @param QuizStoreRequest $request
     * @return RedirectResponse
     */
    public function store(QuizStoreRequest $request): RedirectResponse
    {
        $quiz = Quiz::create($request->validated());
        $quiz->questions()->attach($request->get('questions'));

        return redirect()->route('quizzes.index')->with('message', 'Quiz successfully created.');
    }

    /**
     * @param Quiz $quiz
     * @return Response
     */
    public function edit(Quiz $quiz): Response
    {
        $quiz->questions = $quiz->questions()->pluck('id')->toArray();

        $questions = Question::get(['id', 'question_text'])->mapWithKeys(fn ($question) => [(int)$question->id => $question->question_text])->toArray();

        return Inertia::render('Admin/Quiz/Edit', compact('quiz', 'questions'));
    }

    /**
     * @param QuizStoreRequest $request
     * @param Quiz $quiz
     * @return RedirectResponse
     */
    public function update(QuizStoreRequest $request, Quiz $quiz): RedirectResponse
    {
        $quiz->update($request->validated());
        $quiz->questions()->sync($request->get('questions'));

        return redirect()->route('quizzes.index')->with('message', 'Quiz successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return redirect()->route('quizzes.index')->with('message', 'Quiz successfully deleted.');
    }
}
