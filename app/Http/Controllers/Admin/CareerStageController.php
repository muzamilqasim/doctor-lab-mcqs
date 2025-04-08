<?php

namespace App\Http\Controllers\Admin;

use App\Models\CareerStage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CareerStageController extends Controller
{
    public function index() 
    {
        $pageTitle = "Career Stage";
        $data = CareerStage::orderBy('name', 'ASC')->paginate(getPaginate());
        return view('admin.career_stage.list', compact('pageTitle', 'data'));
    }

    public function create() 
    {
        $pageTitle = "Add Career Stage";
        return view('admin.career_stage.add', compact('pageTitle')); 
    }

    public function store(Request $request) 
    {
        $validator = $this->fieldValidate($request->only(['name']));
        if ($validator->passes()) {
            CareerStage::create([
                'name' => $request->name,
            ]);
            return response()->json([
                'status' => true,
                'message' =>  'Career Stage created successfully.',
                'redirect' => route('admin.careers.index')
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
        $pageTitle = 'Edit Career Stage';
        $data = CareerStage::find($id);
        if(!$data) {
            return redirect()->route('admin.careers.index')->withNotify('not found');
        }
        return view('admin.career_stage.edit', compact('pageTitle', 'data'));
    }

    public function update(Request $request, $id) 
    {
        $data = CareerStage::find($id);
        if(!$data) {
            return response()->json([
                'status' => false,
                'message' =>  'Career Stage not found.',
                'redirect' => route('admin.careers.index')
            ]);    
        }
        $validator = $this->fieldValidate($request->only(['name']), $id);
        if ($validator->passes()) {
            $data->update([
                'name' => $request->name
            ]);
            return response()->json([
                'status' => true,
                'message' =>  'Career Stage updated successfully.',
                'redirect' => route('admin.careers.index')
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
        $data = CareerStage::find($id);
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Career Stage not found.',
            ]);    
        }
        $data->delete();
        return response()->json([
            'status' => true,
            'message' => 'Career Stage deleted successfully.',
        ]);
    }

    private function fieldValidate($data, $id = null)
    {
        $rules = [
            'name' => 'required',
        ];
        $messages = [
            'name.required' => 'The Name field is required.',
        ];
        return Validator::make($data, $rules, $messages);
    }
}
