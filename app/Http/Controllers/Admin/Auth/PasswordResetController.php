<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.guest');
    }

    public function showResetForm(Request $request, $token)
    {
        $pageTitle = "Account Recovery";
        $resetToken = PasswordReset::where('token', $token)->first();
        if (!$resetToken) {
            return to_route('admin.password.reset')->withNotify('Verification code mismatch');
        }
        $email = $resetToken->email;
        return view('admin.auth.password.reset', compact('pageTitle', 'email', 'token'));
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|confirmed|min:4', 
        ]);
        $reset = PasswordReset::where('token', $request->token)->first();
        if($validator->passes()){
            if (empty($reset)) {
                return response()->json([
                    'status' => false,
                    'redirect' => route('admin.loginForm'),
                    'message' => 'Invalid code.'
                ]);
            }
            $admin = Admin::where('email', $reset->email)->first();
            $admin->password = Hash::make($request->password);
            $admin->save();
            PasswordReset::where('email', $reset->email)->delete();
            return response()->json([
                'status' => true,
                'redirect' => route('admin.loginForm'),
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
