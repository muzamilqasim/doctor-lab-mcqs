<?php

namespace App\Http\Controllers\Admin;

use App\Models\GoogleAd;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class GoogleAdController extends Controller
{
    public function index() 
    {
        $pageTitle = "Google Ads";
        $data = GoogleAd::orderBy('ad_name', 'ASC')->paginate(getPaginate());
        return view('admin.google_ad.list', compact('pageTitle', 'data'));
    }

    public function create() 
    {
        $pageTitle = "Create New Ad";
        return view('admin.google_ad.add', compact('pageTitle')); 
    }

    public function store(Request $request) 
    {
        $validator = $this->fieldValidate($request->only(['ad_name', 'position', 'ad_code', 'status']));
        if ($validator->passes()) {
            $ad = GoogleAd::create([
                'ad_name' => $request->ad_name,
                'position' => $request->position,
                'ad_code' => $request->ad_code,
                'status' => $request->status
            ]);
            return response()->json([
                'status' => true,
                'message' =>  'Ad created successfully.',
                'redirect' => route('admin.google_ad.index')
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
        $pageTitle = 'Edit Ad';
        $data = GoogleAd::find($id);
        if(!$data) {
            return redirect()->route('admin.google_ad.index')->withNotify('not found');
        }
        return view('admin.google_ad.edit', compact('pageTitle', 'data'));
    }

    public function update(Request $request, $id) 
    {
        $data = GoogleAd::find($id);
        if(!$data) {
            return response()->json([
                'status' => false,
                'message' =>  'Ad not found.',
                'redirect' => route('admin.google_ad.index')
            ]);    
        }
        $validator = $this->fieldValidate($request->only(['ad_name', 'position', 'ad_code', 'status']), $id);
        if ($validator->passes()) {
            
            $data->update([
                'ad_name' => $request->ad_name,
                'position' => $request->position,
                'ad_code' => $request->ad_code,
                'status' => $request->status
            ]);
            return response()->json([
                'status' => true,
                'message' =>  'Ad updated successfully.',
                'redirect' => route('admin.google_ad.index')
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
        $data = GoogleAd::find($id);
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Ad not found.',
            ]);    
        }
        $data->delete();
        return response()->json([
            'status' => true,
            'message' => 'Ad deleted successfully.',
        ]);
    }

    private function fieldValidate($data, $id = null)
    {
        $rules = [
            'ad_name' => 'required',
            'position' => [
                'required',
                'in:ad_1,ad_2,ad_3',
                Rule::unique('google_ads', 'position')->ignore($id), // Exclude current record during edit
            ],
            'ad_code' => 'required',
            'status' => 'required|in:Active,Inactive',
        ];
        $messages = [
            'ad_name.required' => 'The Ad Name field is required.',
            'position.required' => 'Please select the Position Number.',
            'position.in' => 'The position field must be ad_1, ad_2, or ad_3.',
            'position.unique' => 'The selected position is already in use.',
            'ad_code.required' => 'The Ad Code field is required.',
            'status.required' => 'The Status field is required.',
            'status.in' => 'The Status field must be either Active or Inactive.',
        ];
        return Validator::make($data, $rules, $messages);
    }

}
