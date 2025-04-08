<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use App\Models\TestResult;
use App\Models\Subscription;
use App\Models\CareerStage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index() 
    {
        $pageTitle = 'Profile';
        $totalAttempt = TestResult::where('user_id', userId())->count();

        // Get the user's active subscription
        $subscription = auth()->user()->subscription;
        if($subscription) {
            if ($subscription->expires_at && now()->gt($subscription->expires_at) && $subscription->status !== 'expired') {
                $subscription->update(['status' => 'expired']);
            }
        }

        $remainingDays = null;

        // Use the isActive method to check validity
        if ($subscription && $subscription->isActive()) {
            $remainingDays = now()->diffInDays($subscription->expires_at, false);
        } else {
            $subscription = null; // Hide subscription if expired
        }

        return view('front.user.profile', compact('pageTitle', 'totalAttempt', 'subscription', 'remainingDays'));
    }

    public function history() 
    {
        $pageTitle = 'Plan History';
        $user = auth()->user();

        $subscriptions = Subscription::where('user_id', $user->id)
            ->with('package')
            ->get();
        foreach ($subscriptions as $subscription) {
            if ($subscription->expires_at && now()->gt($subscription->expires_at) && $subscription->status !== 'expired') {
                $subscription->update(['status' => 'expired']);
            }
        }

        $subscriptions = Subscription::where('user_id', $user->id)
            ->orderBy('expires_at', 'desc')
            ->with('package')
            ->get();

        return view('front.user.history', compact('pageTitle', 'subscriptions'));
    }

    public function testResult() 
    {
        $pageTitle = 'Test';
        $testResults = TestResult::where('user_id', userId())->get();
        return view('front.user.result', compact('pageTitle' ,'testResults'));
    }

    public function password() 
    {
        $pageTitle = 'Password';
        if(user()->google_login == 1) {
            return redirect()->route('front.users.edit');
        }
        return view('front.user.password', compact('pageTitle'));
    }

    public function passwordUpdate(Request $request) 
    {
        $validator = Validator::make($request->only('old_password', 'new_password'), [
            'old_password' => 'required|min:4',
            'new_password' => 'required|min:4',
        ]);
        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Please fill the required input field',
                'errors' => $validator->errors() 
            ]);
        }
        $user = auth()->user();
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Your old password is incorrect.'
            ]);
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
        return response()->json([
            'status' => true,
            'message' => 'Password updated successfully.'
        ]);
    }

    public function edit() 
    {
        $pageTitle = "Update Profile";
        $career = CareerStage::orderBy('name', 'ASC')->get();
        return view('front.user.edit', compact('pageTitle', 'career'));
    }

    public function update(Request $request) 
    {
        $user = auth()->user();
        $validator = $this->profileValidator($request->only(['first_name', 'last_name', 'email', 'phone_number', 'career_stage']), $user->id);
        if ($request->hasFile('image')) {               
            $old = $user->image;
            $user->image = fileUploader($request->image, getFilePath('userProfile'), getFileSize('userProfile'), $old);
        }
        if ($validator->passes()) {
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'career_stage_id' => $request->career_stage
            ]);
            return response()->json([
                'status'=> true,
                'redirect' => route('front.users.profile'),
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

    private function profileValidator($data, $id = null)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'career_stage' => 'required',
            'email' => [ 'required', 'email', Rule::unique('users')->ignore($id) ],
            'phone_number' => 'nullable|numeric',
        ];
        $messages = [
            'first_name.required' => 'The First Name field is required.',
            'last_name.required' => 'The Last Name field is required.',
            'email.required' => 'The Email field is required.',
            'email.email' => 'The Email must be a valid Email.',
            'career_stage.required' => 'Please select the Career Stage.',
            'email.unique' => 'The Email already used.',
            'phone_number.numeric' => 'The Phone Number field must be numeric.',
        ];
        return Validator::make($data, $rules, $messages);
    }


}
