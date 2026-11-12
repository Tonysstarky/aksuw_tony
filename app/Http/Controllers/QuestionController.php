<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /** Admin: ähli soraglar (whereHas('user') — hasaby bar ulanyjylaryň soraglary) */
    public function index()
    {
        $questions = Question::whereHas('user')->with('user')->latest()->paginate(15);

        return view('questions.index', compact('questions'));
    }

    public function create()
    {
        return view('questions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(Question::validationRules());

        // auth()->user()->questions()->create(): user_id awtomatiki goýulýar
        auth()->user()->questions()->create($validated);

        return redirect()->route('questions.my')->with('success', __('messages.question_sent'));
    }

    /** Meniň soraglarym + admin jogaplary */
    public function myQuestions()
    {
        $questions = auth()->user()->questions()->latest()->paginate(10);

        return view('questions.my', compact('questions'));
    }

    public function answer(Request $request, Question $question)
    {
        $validated = $request->validate([
            'answer' => 'required|string|max:5000',
        ]);

        $question->update([
            'answer' => $validated['answer'],
            'status' => 'answered',
        ]);

        return redirect()->route('questions.index')->with('success', __('messages.answer_sent'));
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('questions.index')->with('success', __('messages.question_deleted'));
    }
}
