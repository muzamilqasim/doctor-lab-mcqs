<?php

namespace App\Http\Controllers\Front\Auth;

use Auth, Hash;
use App\Models\User;
use App\Models\CareerStage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
     public function __construct()
    {
        $this->middleware('guest')->except('logout');
    } 

    public function register() 
    {
        $pageTitle = 'Register';
        $career = CareerStage::orderBy('name', 'ASC')->get();
        return view('front.auth.register', compact('pageTitle', 'career'));
    }

    public function signUp(Request $request) 
    {
        $validator = $this->fieldValidate($request->only(['first_name', 'last_name', 'email', 'phone_number', 'career_stage', 'password', 'password_confirmation']));
        if(!verifyCaptcha()){
            return response()->json([
                'status' => false,
                'message' => 'Invalid captcha provided',
            ]);
        }

        if ($validator->passes()) {
            $user = User::create([
                'first_name' => $request->first_name, 
                'last_name' => $request->last_name, 
                'email' => $request->email, 
                'phone_number' => $request->phone_number, 
                'career_stage_id' => $request->career_stage,  
                'password' => Hash::make($request->password),
            ]);

            Notification::create([
                'title' => 'New user has been registered',
                'click_url' => urlPath('admin.users.show', $user->id),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Registration successfully completed.',
                'redirect' => route('front.loginForm'),
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function showLoginForm() {
        $pageTitle = "Login";
        return view('front.auth.login', compact('pageTitle'));
    }  

    public function login(Request $request)
    {
        $validator = $this->validator($request->only(['email', 'password']));

        if ($validator->passes()) {
            $credentials = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ];
            if (auth()->attempt($credentials)) {
                $user = auth()->user();
            
                if ($user->status !== 'Active') {
                    auth()->logout();
                    $request->session()->invalidate();
                    return response()->json([
                        'status' => false,
                        'redirect' => route('front.logout'),
                        'message' => 'Your account is blocked'
                    ]);
                }
                return response()->json([
                    'status' => true,
                    'redirect' => route('front.users.profile'),
                    'message' => 'Login Successfully.'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Email or Password is incorrect.'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'validation errors', 
                'errors' => $validator->errors()
            ]);
        }
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $fullName = $googleUser->getName();
            $nameParts = explode(' ', $fullName, 2); 
            $firstName = $nameParts[0]; 
            $lastName = $nameParts[1] ?? '';

            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'password' => Hash::make(Str::random(8)),
                    'google_login' => 1
                ]
            );

            Auth::login($user);
            Notification::create([
                'title' => 'New user has been registered',
                'click_url' => urlPath('admin.users.show', $user->id),
            ]);

            return redirect()->route('front.users.profile')->with('success', 'Logged in with Google successfully.');
        } catch (\Exception $e) {
            return redirect()->route('front.login')->with('error', 'Something went wrong while logging in with Google.');
        }
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        return  to_route('front.loginForm');
    }

    private function validator($data){
        $rules = [
            'email' => 'required',
            'password' =>'required'
        ];
        $messages = [
            'email.required' => 'Email must be required.',
            'password.required' => 'The Password field is required.',
        ];
        return Validator::make($data, $rules, $messages);
    }

    private function fieldValidate($data, $id = null)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'career_stage' => 'required',
            'email' => 'required|email|unique:users,email,' . ($id ?? 'NULL'),
            'phone_number' => 'nullable|numeric',
            'password' => $id ? 'nullable|string' : 'required|string|confirmed',
        ];
        $messages = [
            'first_name.required' => 'The First Name field is required.',
            'last_name.required' => 'The Last Name field is required.',
            'career_stage.required' => 'Please select the Career Stage.',
            'phone_number.numeric' => 'The Phone Number field must be numeric.',
            'email.required' => 'The Email field is required.',
            'email.email' => 'Please provide a valid Email address.',
            'password.required' => 'Password is required.',
            'password.confirmed' => 'The Password confirmation does not match.',
        ];

        return Validator::make($data, $rules, $messages);
    }

}
