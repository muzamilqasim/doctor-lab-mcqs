<?php

namespace App\Http\Controllers\Admin;

use Hash;
use App\Models\User;
use App\Models\TestResult;
use App\Models\CareerStage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $pageTitle = "Users";
        $data = User::with('subscription.package')->paginate(10);
        foreach ($data as $user) {
            $subscription = $user->subscription;
    
            if ($subscription) {
                if ($subscription->expires_at && now()->gt($subscription->expires_at) && $subscription->status !== 'expired') {
                    $subscription->update(['status' => 'expired']);
                }
            }
        }
        
        return view('admin.users.list', compact('pageTitle', 'data'));
    }

    public function show($id) 
    {
        $pageTitle = "Profile";
        $user = User::with('subscription.package')->find($id);
        if (!$user) {
            return redirect()->route('admin.users.index');
        }
        $testResults = TestResult::where('user_id', $user->id)->get();
        $subscription = $user->subscription;
        $remainingDays = $subscription && $subscription->expires_at
            ? now()->diffInDays($subscription->expires_at, false)
            : 0;

        return view('admin.users.show', compact('pageTitle', 'user', 'testResults', 'subscription', 'remainingDays'));
    }

    public function create() 
    {
        $pageTitle = "Add User";
        $career = CareerStage::orderBy('name', 'ASC')->get();
        return view('admin.users.add', compact('pageTitle', 'career')); 
    }

    public function store(Request $request) 
    {
        $validator = $this->fieldValidate($request->only(['first_name', 'last_name', 'email', 'phone_number', 'career_stage', 'password', 'status']));

        if ($validator->passes()) {
            User::create([
                'first_name' => $request->first_name, 
                'last_name' => $request->last_name, 
                'email' => $request->email, 
                'phone_number' => $request->phone_number, 
                'career_stage_id' => $request->career_stage,  
                'password' => Hash::make($request->password),
                'status' => $request->status,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User created successfully.',
                'redirect' => route('admin.users.index'),
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function edit($id) 
    {
        $pageTitle = 'Edit User';
        $career = CareerStage::orderBy('name', 'ASC')->get();
        $data = User::find($id);
        if(!$data) {
            return redirect()->route('admin.users.index')->withNotify('not found');
        }
        return view('admin.users.edit', compact('pageTitle', 'data', 'career'));
    }

    public function update(Request $request, $id) 
    {
        $data = User::find($id);
     
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.',
                'redirect' => route('admin.users.index')
            ]);    
        }

        $validator = $this->fieldValidate($request->only(['first_name', 'last_name', 'email', 'career_stage', 'phone_number', 'status']), $id);

        if ($validator->passes()) {
            $data->update([
                'first_name' => $request->first_name, 
                'last_name' => $request->last_name, 
                'email' => $request->email,  
                'career_stage_id' => $request->career_stage,  
                'phone_number' => $request->phone_number, 
                'status' => $request->status,  
            ]);
            if ($request->password) {
                $data->update([
                    'password' => Hash::make($request->password)
                ]);
            }
            return response()->json([
                'status' => true,
                'message' => 'User updated successfully.',
                'redirect' => route('admin.users.index')
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function destroy($id) 
    {
        $data = User::find($id);
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.',
            ]);    
        }
        $data->delete();
        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully.',
        ]);
    }

    private function fieldValidate($data, $id = null)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'career_stage' => 'required',
            'email' => 'required|email|unique:users,email,' . ($id ?? 'NULL'),
            'phone_number' => 'nullable|numeric',
            'password' => $id ? 'nullable|string' : 'required|string',
            'status' => 'required|in:Active,Inactive',
        ];
        $messages = [
            'first_name.required' => 'The First Name field is required.',
            'last_name.required' => 'The Last Name field is required.',
            'career_stage.required' => 'Please select the Career Stage.',
            'phone_number.numeric' => 'The Phone Number field must be numeric.',
            'email.required' => 'The Email field is required.',
            'email.email' => 'Please provide a valid Email address.',
            'password.required' => 'Password is required.',
            'status.required' => 'The Status field is required.',
            'status.in' => 'The Status field must be either Active or Inactive.',
        ];

        return Validator::make($data, $rules, $messages);
    }
}
