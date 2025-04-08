<?php

namespace App\Http\Controllers\Admin;

use App\Models\Option;
use App\Models\Question;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Explanation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    public function index() 
    {
        $pageTitle = "Questions";
        $data = Question::orderBy('created_at', 'desc')->paginate(getPaginate());
        return view('admin.questions.list', compact('pageTitle', 'data'));
    }

    public function create() 
    {
        $pageTitle = "Add Question";
        $categories = Category::get();
        $subCategories = SubCategory::get();
        return view('admin.questions.add', compact('pageTitle', 'categories', 'subCategories')); 
    }

    public function store(Request $request) 
    {
        $validator = $this->fieldValidate($request->only(['title', 'question_text', 'question_image', 'categories', 'option', 'explaination_title', 'subCategories', 'description']));
        if ($validator->passes()) {
            if ($request->hasFile('question_image')) {               
                $imagePath = fileUploader($request->question_image, getFilePath('questionImage'));
            }
            $question = Question::create([
                'title' => $request->title,
                'question_text' => $request->question_text,
                'category_id' => $request->categories,
                'sub_category_id' => $request->subCategories,
                'question_image' => $imagePath ?? null,
            ]);
            foreach ($request->options as $option) {
                Option::create([
                    'question_id' => $question->id,
                    'option_text' => $option['option_text'],
                    'is_correct' => $option['is_correct'],
                ]);
            }
            Explanation::create([
                'question_id' => $question->id,
                'title' => $request->explaination_title,
                'description' => $request->description,
            ]);
            return response()->json([
                'status' => true,
                'message' =>  'Question created successfully.',
                'redirect' => route('admin.questions.index')
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
        $data = Question::find($id);
        $categories = Category::get();
        $subCategories = SubCategory::where('category_id', $data->category_id)->get();
        $options = Option::where('question_id', $id)->get();
        $explanation = Explanation::where('question_id' ,$id)->first();
        if(!$data) {
            return redirect()->route('admin.questions.index')->withNotify('not found');
        }
        return view('admin.questions.edit', compact('pageTitle', 'data', 'categories', 'subCategories', 'options', 'explanation'));
    }

    public function update(Request $request, $id) 
    {
        $validator = $this->fieldValidate($request->only(['title', 'question_text', 'question_image', 'categories', 'subCategories', 'option', 'explaination_title', 'description']), $id);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Please fill the required input field',
                'errors' => $validator->errors()
            ]);
        }

        $question = Question::findOrFail($id);

        if ($request->hasFile('question_image')) {
            $imagePath = fileUploader($request->question_image, getFilePath('questionImage'));

            // Delete old image if it exists
            if ($question->question_image) {
                fileRemover($question->question_image);
            }

            $question->question_image = $imagePath;
        }

        $question->update([
            'title' => $request->title,
            'question_text' => $request->question_text,
            'category_id' => $request->categories,
            'sub_category_id' => $request->subCategories,
        ]);

     
        if (!empty($request->options)) {
            $question->options()->delete();
        
            foreach ($request->options as $option) {
                Option::create([
                    'question_id' => $question->id,
                    'option_text' => $option['option_text'],
                    'is_correct' => $option['is_correct'] ?? false, // Default to false if not set
                ]);
            }
        }
        $question->explanation()->updateOrCreate(
            ['question_id' => $question->id],
            [
                'title' => $request->explaination_title,
                'description' => $request->description,
            ]
        );
        return response()->json([
            'status' => true,
            'message' => 'Question updated successfully.',
            'redirect' => route('admin.questions.index')
        ]);
    }

    public function destroy($id) 
    {
        $data = Question::find($id);
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Question not found.',
            ]);    
        }
        if ($data->image) { 
            $filePath = getFilePath('questionImage') . '/' . $data->image;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        $data->delete();
        return response()->json([
            'status' => true,
            'message' => 'Question deleted successfully.',
        ]);
    }

    private function fieldValidate($data, $id = null)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'question_text' => 'required|string',
            'question_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'categories' => 'required|exists:categories,id',
            'options.*.id' => 'nullable|exists:options,id', 
            'options.*.option_text' => 'required|string|max:255',
            'options.*.is_correct' => 'required|boolean',
            'explaination_title' => 'required|string|max:255',
            'description' => 'required|string',
            'subCategories' => 'required|exists:sub_categories,id' 
        ];

        $messages = [
            'title.required' => 'The title field is required.',
            'question_text.required' => 'The question text field is required.',
            'question_image.image' => 'The uploaded file must be an image.',
            'categories.required' => 'The category field is required.',
            'categories.exists' => 'The selected category is invalid.',
            'options.*.option_text.required' => 'Each option must have text.',
            'options.*.is_correct.required' => 'Each option must specify if it is correct.',
            'explaination_title.required' => 'The explanation title is required.',
            'description.required' => 'The description is required.',
            'subCategories.required' => 'The sub category field is required.',
            'subCategories.exists' => 'The selected sub-category is invalid.', // Added message for subCategories
        ];

        return Validator::make($data, $rules, $messages);
    }

}
