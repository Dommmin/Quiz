<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionStoreRequest;
use App\Models\Question;
use Inertia\Inertia;
use Inertia\Response;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::latest()->paginate();

        return Inertia::render('Admin/Question/Index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Question/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestionStoreRequest $request)
    {
        $question = Question::create($request->validated());

        foreach ($request->get('question_options') as $option) {
            $question->questionOptions()->create($option);
        }

        return redirect()->route('questions.index')->with('message', 'Question successfully created.');
    }

    /**
     * @param Question $question
     * @return Response
     */
    public function edit(Question $question)
    {
        $question->questionOptions->pluck(['id', 'option', 'correct']);

        return Inertia::render('Admin/Question/Edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionStoreRequest $request, Question $question)
    {
        $question->update($request->validated());

        $question->questionOptions()->delete();

        foreach ($request->get('question_options') as $option) {
            $question->questionOptions()->create($option);
        }

        return redirect()->route('questions.index')->with('message', 'Question successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('questions.index')->with('message', 'Question successfully deleted.');
    }
}
