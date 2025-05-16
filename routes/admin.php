<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::namespace('Auth')->group(function () {
    Route::controller('LoginController')->group(function () {
        Route::get('/login', 'showLoginForm')->name('loginForm');
        Route::post('/login-submit', 'login')->name('login');
        Route::get('/logout', 'logout')->name('logout');
    });

     // Admin Password Reset
    Route::controller('ForgotPasswordController')->prefix('password')->name('password.')->group(function () {
        Route::get('reset', 'index')->name('reset');
        Route::post('reset', 'sendResetEmail')->name('sendResetEmail');
        Route::get('code-verify', 'codeVerify')->name('code.verify');
        Route::post('verify-code', 'verifyCode')->name('verify.code');
    });

    Route::controller('PasswordResetController')->prefix('password')->name('password.')->group(function () {
        Route::get('reset/{token}', 'showResetForm')->name('reset.form');
        Route::post('reset/change', 'reset')->name('change');
    });
});

Route::middleware('admin')->group(function () {
    
    // Slug
    Route::get('getSlug', function(Request $request) {
        return response()->json(['status' => true, 'slug' => slug($request->title)]);
    })->name('getSlug');

    // Admin Controller
    Route::controller('AdminController')->prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('profile', 'profile')->name('profile');
        Route::put('profile', 'profileUpdate')->name('profile.update');
        Route::get('password', 'password')->name('password');
        Route::post('password', 'passwordUpdate')->name('password.update');
    });


    Route::controller('NotificationController')->prefix('notification')->name('notification.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/mark-all', 'markAll')->name('markAll');
        Route::get('/{id}/read', 'read')->name('read');
        Route::delete('/{id}/destroy', 'destroy')->name('destroy');
    });
    Route::controller('SubCategoryController')->prefix('subCategories')->name('subCategories.')->group(function () {
        Route::get('/get-subcategories', 'getSubcategories')->name('getSubcategories');
    });
    
    Route::resource('managers', ManagerController::class);
    Route::resource('google_ad', GoogleAdController::class);
    Route::resource('users', UserController::class);
    Route::resource('questions', QuestionController::class);
    Route::resource('results', TestResultController::class);
    Route::resource('careers', CareerStageController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('subCategories', SubCategoryController::class);
    Route::resource('package', SubscriptionPackageController::class);
    Route::resource('users-plan-history', PlanHistoryController::class);

    // General Setting
    Route::controller('GeneralSettingController')->name('setting.')->group(function () {
        Route::get('general-setting', 'index')->name('index');
        Route::post('general-setting', 'update')->name('update');
    });

    // Home Setting
    Route::controller('HomeController')->name('home.')->group(function () {
        Route::get('home-setting', 'index')->name('index');
        Route::post('home-setting', 'update')->name('update');
    });

      Route::controller('ExtensionController')->prefix('extension')->name('extension.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('update/{id}', 'update')->name('update');
        Route::get('status/{id}', 'status')->name('status');
    });
});