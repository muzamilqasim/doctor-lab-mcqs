<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function index() 
    {
        $pageTitle = 'Notification';
        $data = Notification::get();
        return view('admin.notification.list', compact('pageTitle', 'data'));
    }

    public function read($id) 
    {
        $data = Notification::find($id);

        if (!$data) {
            return redirect()->back()->with('error', 'Notification not found.');
        }

        $data->is_read = 1;
        $data->save();

        return redirect($data->click_url);
    }

    public function markAll() 
    {
        Notification::where('is_read', 0)->update(['is_read' => 1]);
        return back();
    }

    public function destroy($id) 
    {
        $data = Notification::find($id);
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Notification not found.',
            ]);    
        }
        $data->delete();
        return response()->json([
            'status' => true,
            'message' => 'Notification deleted successfully.',
        ]);
    }
}
