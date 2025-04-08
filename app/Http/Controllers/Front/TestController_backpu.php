<?php

namespace App\Http\Controllers\Front;

use App\Models\{Option, Category, Question, TestResult, Explanation};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TestController extends Controller
{
    public function startTest(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('front.loginForm')->with('error', 'You need to log in to start the test.');
        }

        $validator = Validator::make($request->all(), [
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id'
        ]);

        if ($validator->fails()) {
            return redirect()->route('front.category.showCategories')->with('error', 'Please select categories.');
        }

        $categoryIds = $request['category_ids'];
        $categoriesWithQuestions = Category::whereIn('id', $categoryIds)
            ->with('questions')
            ->orderByRaw('FIELD(id, ' . implode(',', $categoryIds) . ')')
            ->get();

        $allQuestions = $categoriesWithQuestions->flatMap->questions;

        if ($allQuestions->isEmpty()) {
            return redirect()->route('front.category.showCategories')->with('error', 'No questions available for the selected categories.');
        }

        $answeredQuestions = TestResult::where('user_id', auth()->id())
            ->whereIn('question_id', $allQuestions->pluck('id'))
            ->pluck('question_id')
            ->toArray();

        $remainingQuestions = $allQuestions->reject(fn($q) => 
            in_array($q->id, $answeredQuestions) || 
            $q->options->isEmpty() || 
            !Explanation::where('question_id', $q->id)->exists()
        );

        if ($remainingQuestions->isEmpty()) {
            return redirect()->route('front.users.profile')->with('success', 'You have already answered all the questions!');
        }

        session([
            'questions' => $remainingQuestions->pluck('id')->toArray(),
            'questionsByCategory' => $categoriesWithQuestions->map(fn($c) => [
                'category' => $c->name,
                'questions' => $c->questions->pluck('id')->toArray()
            ])->toArray(),
            'currentIndex' => 0
        ]);
        
        return redirect()->route('front.test.question', ['questionId' => $remainingQuestions->first()->id]);
    }
    
    public function loadQuestion($questionId)
    {
        $questions = session('questions', []);
        if (($currentIndex = array_search($questionId, $questions)) === false) return redirect()->route('front.category.showCategories')->withError(['Question not found in selected categories.']);
        
        session(['currentIndex' => $currentIndex]);
        $question = Question::with(['category', 'subCategory', 'options'])->findOrFail($questionId);
        if ($question->options->isEmpty() || !Explanation::where('question_id', $question->id)->exists()) {
            return $this->skipToNextQuestion($questions, $currentIndex);
        }
        
        $alreadyAnswered = TestResult::where('user_id', auth()->id())->where('question_id', $questionId)->exists();
        if ($alreadyAnswered) return $this->skipToNextQuestion($questions, $currentIndex);
        
        $previousQuestionId = $questions[$currentIndex - 1] ?? null;
        $nextQuestionId = $questions[$currentIndex + 1] ?? null;
        $currentCategory = collect(session('questionsByCategory'))->firstWhere(fn($c) => in_array($questionId, $c['questions']))['category'] ?? null;
        
        return view('front.question', compact('question', 'previousQuestionId', 'nextQuestionId', 'currentCategory'));
    }

    public function submitAnswer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'answer' => 'required|exists:options,id'
        ]);
        $questionId = session('questions')[session('currentIndex')];
        if($validator->fails()) {
            return redirect()->route('front.test.question', ['questionId' => $questionId])->with('error', 'Please select an option');
        }

        if (TestResult::where('user_id', auth()->id())->where('question_id', $questionId)->exists()) {
            return redirect()->route('front.test.question', ['questionId' => $questionId])->withError(['You have already answered this question.']);
        }

        TestResult::create(['user_id' => auth()->id(), 'question_id' => $questionId, 'answer' => $request['answer'], 'is_correct' => Option::find($request['answer'])->is_correct]);

        return view('front.question', [
            'question' => Question::with(['category', 'subCategory', 'options'])->findOrFail($questionId),
            'previousQuestionId' => session('questions')[session('currentIndex') - 1] ?? null,
            'nextQuestionId' => session('questions')[session('currentIndex') + 1] ?? null,
            'explanation' => Explanation::where('question_id', $questionId)->first(),
        ]);
    }

    private function skipToNextQuestion($questions, $currentIndex)
    {
        foreach (array_slice($questions, $currentIndex + 1) as $next) {
            $nextQuestion = Question::with('options')->find($next);
            if ($nextQuestion && !$nextQuestion->options->isEmpty() && Explanation::where('question_id', $nextQuestion->id)->exists()) {
                session(['currentIndex' => array_search($next, $questions)]);
                return redirect()->route('front.test.question', ['questionId' => $next]);
            }
        }
        return redirect()->route('front.users.profile')->with('success', 'You have completed the test!');
    }
}