<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Front\Auth\{
	LoginController,
	PasswordResetController,
	ForgotPasswordController,
};

use App\Http\Controllers\Front\{
	HomeController,
	TestController,
	UserController,
	PaypalController,
};

Route::name('front.')->group(function () {

	Route::controller(HomeController::class)->group(function () {
		Route::get('/', 'home')->name('home');
		Route::get('/categories', 'showCategories')->name('category.showCategories');
		Route::get('/package', 'package')->name('package');
	});
	Route::controller(LoginController::class)->group(function () {
		Route::get('/auth/google', 'redirectToGoogle')->name('auth.google');
		Route::get('/auth/google/callback', 'handleGoogleCallback');
		Route::get('/sign-in', 'showLoginForm')->name('loginForm');
		Route::post('/submit-login', 'login')->name('login');
		Route::get('/sign-up', 'register')->name('register');
		Route::post('/signup-submit', 'signUp')->name('signUp');
		Route::get('/logout', 'logout')->name('logout');
	});

	// Password Reset
	Route::controller(ForgotPasswordController::class)->prefix('password')->name('password.')->group(function () {
		Route::get('reset', 'index')->name('reset');
		Route::post('reset', 'sendResetEmail')->name('sendResetEmail');
		Route::get('resendEmail/{email}', 'resendEmail')->name('resendEmail');
		Route::get('code-verify', 'codeVerify')->name('code.verify');
		Route::post('verify-code', 'verifyCode')->name('verify.code');
	});

	Route::controller(PasswordResetController::class)->prefix('password')->name('password.')->group(function () {
		Route::get('reset/{token}', 'showResetForm')->name('reset.form');
		Route::post('reset/change', 'reset')->name('change');
	});

	Route::middleware('auth')->group(function () {

		Route::controller(PayPalController::class)->prefix('/paypal')->name('paypal.')->group(function () {
   			Route::post('subscribe',  'createSubscription')->name('subscribe');
	    	Route::get('success',  'success')->name('success');
    		Route::get('cancel', 'cancel')->name('cancel');
		});

		Route::controller(UserController::class)->name('users.')->group(function () {
			Route::get('profile', 'index')->name('profile');
			Route::get('plan-history', 'history')->name('history');
			Route::get('testResult', 'testResult')->name('result');
			Route::get('edit-profile', 'edit')->name('edit');
			Route::post('update-profile', 'update')->name('update');
			Route::get('password', 'password')->name('password');
			Route::post('password-update', 'passwordUpdate')->name('passwordUpdate');
		});
		Route::controller(TestController::class)->name('test.')->middleware('check.subscription')->group(function () {
	        Route::post('/start-test', 'startTest')->name('start');
    	    Route::get('/question/{questionId}', 'loadQuestion')->name('question');
	        Route::post('/question/submitAnswer', 'submitAnswer')->name('submitAnswer');
    	});
	});
});