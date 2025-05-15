<?php

namespace App\Http\Controllers\Admin;

use App\Models\Extension;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExtensionController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.only');
    }

    public function index()
    {
        $pageTitle = 'Extensions';
        $extensions = Extension::orderBy('name')->get();
        return view('admin.extension.list', compact('pageTitle', 'extensions'));
    }

    public function update(Request $request, $id)
    {
        $extension = Extension::findOrFail($id);
        $validation_rule = [];
        foreach ($extension->shortcode as $key => $val) {
            $validation_rule = array_merge($validation_rule,[$key => 'required']);
        }
        $request->validate($validation_rule);

        $shortcode = json_decode(json_encode($extension->shortcode), true);
        foreach ($shortcode as $key => $value) {
            $shortcode[$key]['value'] = $request->$key;
        }

        $extension->shortcode = $shortcode;
        $extension->save();
        $notify[] = ['success', $extension->name . ' Updated Successfully'];
        return back()->withNotify($notify);
    }

    public function status($id)
    {
        return Extension::changeStatus($id);
    }
}
