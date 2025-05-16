<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.guest');
    }

    public function index()
    {
        $pageTitle = 'Account Recovery';
        return view('admin.auth.password.email', compact('pageTitle'));
    }

    public function sendResetEmail(Request $request)
    {
        $validator = Validator::make($request->only('email'), [
            'email' => 'required|email|exists:admins,email'
        ],[
            'email.required' => 'Email field must required',
            'email.email' => 'Please enter a valid email address.',
            'email.exists' => 'Your email is not exist.'
        ]);

        if($validator->passes()) {
            $admin = Admin::where('email', $request->email)->first();
            if (!$admin) {
                return back()->withErrors(['Email Not Available']);
            }

            $code = verificationCode(6);
            $adminPasswordReset = PasswordReset::updateOrCreate(['email' => $admin->email], ['token' => $code,'created_at' => now()]);

            $email = $admin->email;
            sendEmail('Password Reset', $email, 'reset_password', ['code' => $code]);
            session()->put('pass_res_mail', $email);
            return response()->json([
                'status' => true,
                'redirect' => route('admin.password.code.verify'),
                'message' => '!! Please Verify Code !!',
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
            return to_route('admin.password.reset')->withError('Oops! session expired');
        }
        return view('admin.auth.password.code_verify', compact('pageTitle','email'));
    }

    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->only(['code', 'email']), ['code' => 'required', 'email' => 'required',],[ 'code.required' => 'Code field must required' ]);
        
        $resetToken = PasswordReset::where('email', $request->email)->where('token', $request->code)->first();

         if (!$resetToken) {
            return response()->json([
                'status' => false,
                'message' => 'Verification code mismatch' 
            ]);
        }
        if ($validator->passes()) {
            $code = str_replace(' ', '', $request->code);
            return response()->json([
                'status' => true,
                'redirect' => route('admin.password.reset.form', $code),
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
