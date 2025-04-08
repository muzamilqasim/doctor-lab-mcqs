<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Subscription;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PayPalController extends Controller
{
    public function createSubscription(Request $request)
    {
        $user = Auth::user();
        
        // Check if user already has an active subscription
        if ($user->subscription && $user->subscription->status === 'active') {
            return redirect()->back()->with('error', 'You already have an active subscription.');
        }

        $packageId = $request->package_id;
        $package = \App\Models\Package::findOrFail($packageId);

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken(); 

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => config('paypal.currency'),
                        "value" => $package->price
                    ],
                    "description" => $package->title
                ]
            ],
            "application_context" => [
                "cancel_url" => route('paypal.cancel'),
                "return_url" => route('paypal.success', ['package_id' => $package->id])
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            // Redirect to PayPal for payment
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }

        return back()->with('error', 'Something went wrong with PayPal. Try again.');
    }


    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            Subscription::create([
                'user_id' => Auth::id(),
                'package_id' => $request->package_id,
                'payment_id' => $response['id'],
                'status' => 'active',
                'expires_at' => now()->addDays(\App\Models\SubscriptionPackage::find($request->package_id)->duration),
            ]);

            return redirect()->route('front.users.profile')->with('success', 'Subscription successful.');
        }

        return redirect()->route('front.users.profile')->with('error', 'Payment failed.');
    }

    public function cancel()
    {
        return redirect()->route('front.users.profile')->with('error', 'Payment was canceled.');
    }
}
