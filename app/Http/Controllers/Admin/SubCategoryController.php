<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    public function index() 
    {
        $pageTitle = "Sub-Category";
        $data = SubCategory::orderBy('created_at', 'desc')->paginate(getPaginate());
        return view('admin.sub_categories.list', compact('pageTitle', 'data'));
    }

    public function create() 
    {
        $categories = Category::get();
        $pageTitle = "Add Sub-Category";
        return view("admin.sub_categories.add", compact('pageTitle', 'categories'));
    }

    public function store(Request $request) 
    {
        $validator = $this->fieldValidate($request->only(['category_id', 'title', 'slug']));
        if ($validator->passes()) {
            SubCategory::create([
                'category_id' => $request->category_id,
                'name' => $request->title,
                'slug' => $request->slug,
            ]);
            return response()->json([
                'status' => true,
                'message' =>  'Sub-Category created successfully.',
                'redirect' => route('admin.subCategories.index')
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
        $pageTitle = 'Edit Sub-Category';
        $data = SubCategory::find($id);
        $categories = Category::get();
        if(!$data) {
            return redirect()->route('admin.subCategories.index')->withNotify('not found');
        }
        return view('admin.sub_categories.edit', compact('pageTitle', 'data', 'categories'));
    }

    public function update(Request $request, $id) 
    {
        $data = SubCategory::find($id);
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Sub-Category not found.',
            ]);    
        }
        $validator = $this->fieldValidate($request->only(['category_id', 'title', 'slug']), $id);
        if ($validator->passes()) {
            $data->update([
                'category_id' => $request->category_id,
                'name' => $request->title,
                'slug' => $request->slug,
            ]);
            return response()->json([
                'status' => true,
                'message' =>  'Sub-Category updated successfully.',
                'redirect' => route('admin.subCategories.index')
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
        $data = SubCategory::find($id);
        if(!$data) {
            return response()->json([
                'status' => false,
                'message' =>  'Sub-Category not found.',
            ]);    
        }
        $data->delete();
        return response()->json([
            'status' => true,
            'message' =>  'Sub-Category deleted successfully.',
        ]);
    }

    private function fieldValidate($data, $id = null)
    {
        $rules = [
            'title' => 'required',
            'category_id' => 'required|exists:categories,id',
            'slug' => [ 'required', 'unique:sub_categories,slug,' . $id . ',id' ],
        ];
        $messages = [
            'title.required' => 'The Name field is required.',
            'category_id.required' => 'The Category field is required.',
            'category_id.exists' => 'The selected category does not exist.',
            'slug.required' => 'The Slug field is required.',
            'slug.unique' => 'The Slug has already been taken.',
        ];
            return Validator::make($data, $rules, $messages);
    }

    public function getSubcategories(Request $request)
    {
        $categoryId = $request->categoryID;
        $subcategories = SubCategory::where('category_id', $categoryId)->get();
        return response()->json($subcategories);
    }
}
