<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class GeneralSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.only');
    }
    
    public function index()
    { 
        $pageTitle = 'General Setting';
        return view('admin.setting.general', compact('pageTitle'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->only('site_title', 'email', 'contact', 'copyright_text'), [
            'site_title' => 'nullable|string|max:50',
            'email' => 'nullable|string|max:50|email',
            'contact' => 'nullable|string',
            'copyright_text' => 'nullable|string|max:100',
        ]);
        if($validator->passes()) {
            $general = gs();
            $general->site_title = $request->site_title;
            $general->email = $request->email;
            $general->contact = $request->contact;
            $general->copyright_text = $request->copyright_text;
            $general->save();
            return response()->json([
                'status' => true,
                'redirect' => route('admin.setting.index'),
                'message' => 'General Setting Updated Succesfully.'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ]);
        }
    }
}
