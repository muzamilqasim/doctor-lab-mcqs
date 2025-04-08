<?php

namespace App\Http\Controllers\Front\Auth;

use Hash;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showResetForm(Request $request, $token)
    {
        $pageTitle = "Account Recovery";
        $resetToken = PasswordReset::where('token', $token)->first();
        if (!$resetToken) {
            return to_route('front.password.reset')->withNotify('Verification code mismatch');
        }
        $email = $resetToken->email;
        return view('front.auth.password.reset', compact('pageTitle', 'email', 'token'));
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|confirmed|min:4', 
        ]);
        $reset = PasswordReset::where('token', $request->token)->first();
        if($validator->passes()) {
            if (empty($reset)) {
                return response()->json([
                    'status' => false,
                    'redirect' => route('front.loginForm'),
                    'message' => 'Invalid code.'
                ]);
            }
            $user = User::where('email', $reset->email)->first();
            $user->password = Hash::make($request->password);
            $user->save();
            PasswordReset::where('email', $reset->email)->delete();
            return response()->json([
                'status' => true,
                'redirect' => route('front.loginForm'),
                'message' => 'Password Changed Successfully.'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
}
