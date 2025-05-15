<?php

namespace App\Http\Controllers\Admin;

use Hash;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.only');
    }

    public function index()
    {
        $pageTitle = "Managers";
        $data = Admin::where('role', 1)->paginate(10);

        return view('admin.managers.list', compact('pageTitle', 'data'));
    }

    public function create() 
    {
        $pageTitle = "Add Manager";
        return view('admin.managers.add', compact('pageTitle')); 
    }

    public function store(Request $request) 
    {
        $validator = $this->fieldValidate($request->only(['name', 'email', 'username', 'password']));

        if ($validator->passes()) {
            Admin::create([
                'name' => $request->name, 
                'email' => $request->email, 
                'username' => $request->username, 
                'password' => Hash::make($request->password),
                'role' => 1,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Manager created successfully.',
                'redirect' => route('admin.managers.index'),
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
        $pageTitle = 'Edit Manager';
        $data = Admin::find($id);
        if(!$data) {
            return redirect()->route('admin.managers.index')->withNotify('not found');
        }
        return view('admin.managers.edit', compact('pageTitle', 'data'));
    }

    public function update(Request $request, $id) 
    {
        $data = Admin::find($id);
     
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Manager not found.',
                'redirect' => route('admin.managers.index')
            ]);    
        }

        $validator = $this->fieldValidate($request->only(['name', 'email', 'username', 'password']), $id);

        if ($validator->passes()) {
            $data->update([
                'name' => $request->name, 
                'email' => $request->email, 
                'username' => $request->username, 
                'role' => 1,
            ]);
            if ($request->password) {
                $data->update([
                    'password' => Hash::make($request->password)
                ]);
            }
            return response()->json([
                'status' => true,
                'message' => 'Manager updated successfully.',
                'redirect' => route('admin.managers.index')
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
        $data = Admin::find($id);
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Manager not found.',
            ]);    
        }
        $data->delete();
        return response()->json([
            'status' => true,
            'message' => 'Manager deleted successfully.',
        ]);
    }

    private function fieldValidate($data, $id = null)
    {
       $rules = [
            'name' => 'required',
            'username' => 'required|unique:admins,username,' . ($id ?? 'NULL'),
            'email' => 'required|email|unique:admins,email,' . ($id ?? 'NULL'),
            'password' => $id ? 'nullable|string' : 'required|string',
        ];

        $messages = [
            'name.required' => 'The Name field is required.',
            'username.required' => 'The Username field is required.',
            'username.unique' => 'This Username is already taken.',
            'email.required' => 'The Email field is required.',
            'email.email' => 'Please provide a valid Email address.',
            'email.unique' => 'This Email is already registered.',
            'password.required' => 'Password is required.',
            'password.string' => 'Password must be a valid string.',
        ];

        return Validator::make($data, $rules, $messages);
    }
}
