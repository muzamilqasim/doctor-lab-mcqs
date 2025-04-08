<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    { 
        $pageTitle = 'Home Page Setting';
        return view('admin.setting.home', compact('pageTitle'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->only('heading', 'sub_heading', 'about_title', 'about_content', 'image'), [
            'heading' => 'required|string',
            'sub_heading' => 'required|string',
            'about_title' => 'required|string',
            'about_content' => 'required|string',
        ]);
        if($validator->passes()) {
            $home = hs();
            if ($request->hasFile('image')) {               
                $old = $home->image;
                $home->image = fileUploader($request->image, getFilePath('homeImage'), null, $old);
            }
            $home->heading = $request->heading;
            $home->sub_heading = $request->sub_heading;
            $home->about_title = $request->about_title;
            $home->about_content = $request->about_content;
            $home->save();
            return response()->json([
                'status' => true,
                'redirect' => route('admin.home.index'),
                'message' => 'Home Setting Updated Succesfully.'
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
