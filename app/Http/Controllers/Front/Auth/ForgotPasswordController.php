<?php

namespace App\Http\Controllers\Front\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        $pageTitle = 'Account Recovery';
        return view('front.auth.password.email', compact('pageTitle'));
    }

    public function sendResetEmail(Request $request)
    {
        $validator = Validator::make($request->only('email'), [
            'email' => 'required|email|exists:users,email'
        ],[
            'email.required' => 'Email is Required',
            'email.email' => 'Please enter a valid email address.',
            'email.exists' => 'This Email Does Not Exist.'
        ]);

        if($validator->passes()) {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return back()->withErrors(['Email Not Available']);
            }

            $code = verificationCode(5);
            $userPasswordReset = PasswordReset::updateOrCreate(['email' => $user->email], 
                                    ['token' => $code, 'created_at' => now()]);

            $email = $user->email;
            sendEmail('Password Reset', $email, 'reset_password', ['code' => $code]);
            session()->put('pass_res_mail', $email);
            session()->flash('status', 'A code has been sent to your email address. Please check your email and enter that code on this screen.');
            return response()->json([
                'status' => true,
                'redirect' => route('front.password.code.verify'),
                'message' => 'A code has been sent to your email address.'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Email not exist',
                'errors' => $validator->errors()
            ]);
        }
    }

    public function codeVerify()
    {
        $pageTitle = 'Verify Code';
        $email = session()->get('pass_res_mail');
        if (!$email) {
            return to_route('front.password.reset')->withError('Oops! session expired');
        }
        return view('front.auth.password.code_verify', compact('pageTitle','email'));
    }

    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->only('code'), [
            'code' => 'required'
        ],[ 'code.required' => 'Code field must required' ]);

        if ($validator->passes()) {
            $code = str_replace(' ', '', $request->code);
            return response()->json([
                'status' => true,
                'redirect' => route('front.password.reset.form', $code),
                'message' => '!! You can change your password !!',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Code field required',
                'errors' => $validator->errors()
            ]);
        }
    }
}
