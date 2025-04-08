<?php

namespace App\Http\Controllers\Admin;

use App\Models\TestResult;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestResultController extends Controller
{
    public function index() 
    {
        $pageTitle = "Categories";
        $data = Category::orderBy('name', 'ASC')->paginate(getPaginate());
        return view('admin.category.list', compact('pageTitle', 'data'));
    }

    public function create() 
    {
        $pageTitle = "Add Category";
        return view('admin.category.add', compact('pageTitle')); 
    }

    public function store(Request $request) 
    {
        $validator = $this->fieldValidate($request->only(['title', 'slug', 'image']));
        if ($validator->passes()) {
            if ($request->hasFile('image')) {               
                $imagePath = fileUploader($request->image, getFilePath('categoryImage'));
            }
            $cat = Category::create([
                'name' => $request->title,
                'slug' => $request->slug,
                'image' => $imagePath ?? null,
            ]);
            return response()->json([
                'status' => true,
                'message' =>  'Category created successfully.',
                'redirect' => route('admin.categories.index')
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
        $pageTitle = 'Edit Category';
        $data = Category::find($id);
        if(!$data) {
            return redirect()->route('admin.categories.index')->withNotify('not found');
        }
        return view('admin.category.edit', compact('pageTitle', 'data'));
    }

    public function update(Request $request, $id) 
    {
        $data = Category::find($id);
        if(!$data) {
            return response()->json([
                'status' => false,
                'message' =>  'Category not found.',
                'redirect' => route('admin.categories.index')
            ]);    
        }
        $validator = $this->fieldValidate($request->only(['title', 'slug', 'image']), $id);
        if ($validator->passes()) {
            if ($request->hasFile('image')) {
                $old = $data->image;
                $data->image = fileUploader($request->image, getFilePath('categoryImage'), null, $old);
            }
            $data->update([
                'name' => $request->title,
                'slug' => $request->slug,
            ]);
            return response()->json([
                'status' => true,
                'message' =>  'Category updated successfully.',
                'redirect' => route('admin.categories.index')
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
        $data = Category::find($id);
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found.',
            ]);    
        }
        if ($data->image) { 
            $filePath = getFilePath('categoryImage') . '/' . $data->image;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        $data->delete();
        return response()->json([
            'status' => true,
            'message' => 'Category deleted successfully.',
        ]);
    }

    private function fieldValidate($data, $id = null)
    {
        $rules = [
            'title' => 'required',
            'slug' => [ 'required', 'unique:categories,slug,' . $id . ',id' ],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
        $messages = [
            'title.required' => 'The Name field is required.',
            'slug.required' => 'The Slug field is required.',
            'slug.unique' => 'The Slug has already been taken.',
        ];
        return Validator::make($data, $rules, $messages);
    }
}
