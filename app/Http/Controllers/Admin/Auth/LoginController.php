<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.guest')->except('logout');
    } 

    public function showLoginForm() {
        $pageTitle = "Admin Login";
        return view('admin.auth.login', compact('pageTitle'));
    }  

    public function login(Request $request)
    {
        $validator = $this->validator($request->only(['email_or_username', 'password']));

        $request->session()->regenerateToken();

        if ($validator->passes()) {
            $loginField = filter_var($request['email_or_username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
            $credentials = [
                $loginField => $request->input('email_or_username'),
                'password' => $request->input('password'),
            ];
            if (auth()->guard('admin')->attempt($credentials)) {
                return response()->json([
                    'status' => true,
                    'redirect' => route('admin.dashboard.index'),
                    'message' => 'Login Successfully.'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'redirect' => true,
                    'message' => 'Email or Password is incorrect.'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed required',
                'errors' => $validator->errors()
            ]);
        }
    }

    public function logout(Request $request)
    {
        auth('admin')->logout();
        $request->session()->invalidate();
        return  to_route('admin.loginForm');
    }

    private function validator($data){
        $rules = [
            'email_or_username' => 'required',
            'password' =>'required'
        ];
        $messages = [
            'email_or_username.required' => 'Email or username must be required.',
            'password.required' => 'The Password field is required.',
        ];

        return Validator::make($data, $rules, $messages);
    }
}
