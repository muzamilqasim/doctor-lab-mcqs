<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
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
        $validator = $this->fieldValidate($request->only(['title', 'slug']));
        if ($validator->passes()) {
            $cat = Category::create([
                'name' => $request->title,
                'slug' => $request->slug,
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
        $validator = $this->fieldValidate($request->only(['title', 'slug']), $id);
        if ($validator->passes()) {
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
        ];
        $messages = [
            'title.required' => 'The Name field is required.',
            'slug.required' => 'The Slug field is required.',
            'slug.unique' => 'The Slug has already been taken.',
        ];
        return Validator::make($data, $rules, $messages);
    }
}
