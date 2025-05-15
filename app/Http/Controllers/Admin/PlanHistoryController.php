<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.only');
    }
    
    public function index() 
    {
        $pageTitle = 'Plan History';
        $subscriptions = Subscription::paginate(getPaginate());
        foreach ($subscriptions as $subscription) {
            if ($subscription->expires_at && now()->gt($subscription->expires_at) && $subscription->status !== 'expired') {
                $subscription->update(['status' => 'expired']);
            }
        }
        return view('admin.history.list', compact('pageTitle', 'subscriptions'));
    }

}
