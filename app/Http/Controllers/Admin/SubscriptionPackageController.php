<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubscriptionPackage;
use Illuminate\Support\Facades\Validator;

class SubscriptionPackageController extends Controller
{
    public function index() 
    {
        $pageTitle = "Subscription Package";
        $count = SubscriptionPackage::count();
        $data = SubscriptionPackage::orderBy('title', 'ASC')->paginate(getPaginate());
        return view('admin.package.list', compact('pageTitle', 'data', 'count'));
    }

    public function create() 
    {
        $count = SubscriptionPackage::count();
        if($count == 3) {
            return redirect()->route('admin.package.index');
        }
        $pageTitle = "Add Subscription Package";
        return view('admin.package.add', compact('pageTitle')); 
    }

    public function store(Request $request) 
    {
        $validator = $this->fieldValidate($request->only(['title', 'duration', 'price']));
        if ($validator->passes()) {
            $sub = SubscriptionPackage::create([
                'title' => $request->title,
                'duration' => $request->duration,
                'price' => $request->price,
            ]);
            return response()->json([
                'status' => true,
                'message' =>  'Subscription Package created successfully.',
                'redirect' => route('admin.package.index')
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Please fill the required input field',
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit($id) 
    {
        $pageTitle = 'Edit Subscription Package';
        $data = SubscriptionPackage::find($id);
        if(!$data) {
            return redirect()->route('admin.package.index')->withNotify('not found');
        }
        return view('admin.package.edit', compact('pageTitle', 'data'));
    }

    public function update(Request $request, $id) 
    {
        $data = SubscriptionPackage::find($id);
        if(!$data) {
            return response()->json([
                'status' => false,
                'message' =>  'Subscription Package not found.',
                'redirect' => route('admin.package.index')
            ]);    
        }
        $validator = $this->fieldValidate($request->only(['title', 'duration', 'price']), $id);
        if ($validator->passes()) {
            $data->update([
                'title' => $request->title,
                'duration' => $request->duration,
                'price' => $request->price,
            ]);
            return response()->json([
                'status' => true,
                'message' =>  'Subscription Package updated successfully.',
                'redirect' => route('admin.package.index')
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Please fill the required input field',
                'errors' => $validator->errors()
            ]);
        }
    }

    public function destroy($id) 
    {
        $data = SubscriptionPackage::find($id);
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Subscription Package not found.',
            ]);    
        }
        $data->delete();
        return response()->json([
            'status' => true,
            'redirect' => route('admin.package.index'),
            'message' => 'Subscription Package deleted successfully.',
        ]);
    }

    private function fieldValidate($data, $id = null)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ];

        $messages = [
            'title.required' => 'The Title field is required.',
            'duration.required' => 'The Duration field is required.',
            'duration.integer' => 'The Duration must be a valid number of days.',
            'price.required' => 'The Price field is required.',
            'price.numeric' => 'The Price must be a valid number.',
        ];

        return Validator::make($data, $rules, $messages);
    }
}
