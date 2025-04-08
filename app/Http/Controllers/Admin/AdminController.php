<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Category;
use App\Models\Question;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
        $pageTitle = 'Dashboard';
        $totalUser = User::count();
        $totalCategories = Category::count();
        $totalSubCategories = SubCategory::count();
        $totalQuestions = Question::count();
        return view('admin.dashboard', compact('pageTitle', 'totalCategories', 'totalUser', 'totalSubCategories', 'totalQuestions'));
    }

    public function profile()
    {
        $pageTitle = 'Profile';
        $admin = auth('admin')->user();
        return view('admin.profile', compact('pageTitle', 'admin'));
    }

    public function profileUpdate(Request $request)
    {
        $admin = auth('admin')->user();
        $validator = $this->profileValidator($request->only(['name', 'email', 'username']), $admin->id);
        if ($validator->passes()) {
            $admin->update([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
            ]);
            return response()->json([
                'status'=> true,
                'redirect' => route('admin.dashboard.profile'),
                'message'=> 'Profile Updated Succesfully.'
            ]);
        } else {
            return response()->json([
                'status'=> false,
                'message' => 'Validation faileds required',
                'errors'=> $validator->errors()
            ]);
        }
    }

    public function password()
    {
        $pageTitle = 'Password Setting';
        $admin = auth('admin')->user();
        return view('admin.password', compact('pageTitle', 'admin'));
    }

    public function passwordUpdate(Request $request)
    {
        $validator = Validator::make($request->only('old_password', 'new_password', 'confirm_password'), [
            'old_password' => 'required|min:4',
            'new_password' => 'required|min:4',
            'confirm_password' => 'required|same:new_password',
        ]);
        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation faileds required',
                'errors' => $validator->errors() 
            ]);
        }
        $admin = auth('admin')->user();
        if (!Hash::check($request->old_password, $admin->password)) {
            return response()->json([
                'status' => false,
                'redirect' => true,
                'message' => 'Your old password is incorrect.'
            ]);
        }
        $admin->password = Hash::make($request->new_password);
        $admin->save();
        return response()->json([
            'status' => true,
            'redirect' => route('admin.dashboard.password'),
            'message' => 'Password updated successfully.'
        ]);
    }

    private function profileValidator($data, $id = null)
    {
        $rules = [
            'name' => 'required',
            'email' => [ 'required', 'email', Rule::unique('admins')->ignore($id) ],
            'username' => ['required', 'string', Rule::unique('admins')->ignore($id) ],
        ];
        $messages = [
            'name.required' => 'The Name field is required.',
            'email.required' => 'The Email field is required.',
            'email.email' => 'The Email must be a valid Email.',
            'email.unique' => 'The Email already used.',
            'username.unique' => 'The Username already used.',
            'username.required' => 'The Username field is required.',
        ];
        return Validator::make($data, $rules, $messages);
    }
}
