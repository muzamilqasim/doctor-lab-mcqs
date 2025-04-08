<?php

namespace App\Http\Controllers\Front;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\SubscriptionPackage;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        $pageTitle = 'Home';
        
        $categories = Category::withCount([
            'questions' => function($query) {
                $query->has('options')->has('explanation');
            }
        ])->having('questions_count', '>', 0)->orderBy('name', 'ASC')->get();
        
        $packages = SubscriptionPackage::orderBy('created_at', 'asc')->get();
        
        // Check if user is logged in
        $userSubscription = auth()->check() ? auth()->user()->subscription : null;

        return view('front.home', compact('pageTitle', 'categories', 'packages', 'userSubscription'));
    }

    public function showCategories()
    {
        $pageTitle = 'Categories';

        $categories = Category::with([
            'subcategories' => function ($query) {
                $query->withCount([
                    'questions' => function ($q) {
                        $q->has('options')->has('explanation');
                    }
                ])->having('questions_count', '>', 0);
            }
        ])->withCount([
            'questions' => function ($q) {
                $q->has('options')->has('explanation');
            }
        ])->get();

        $categories->each(function ($category) {
            $totalQuestions = $category->questions_count + $category->subcategories->sum('questions_count');
            $category->total_questions_count = $totalQuestions;
        });

        return view('front.category', compact('pageTitle', 'categories'));
    }

    public function package() 
    {
        $pageTitle = 'Packages';
        $packages = SubscriptionPackage::orderBy('created_at', 'asc')->get();
        $userSubscription = auth()->check() ? auth()->user()->subscription : null;
        return view('front.package', compact('pageTitle', 'packages', 'userSubscription'));
    }


}
