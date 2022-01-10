<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Stripe;

class MoneyController extends Controller
{
    public function pay(Request $request)
    {
        $validation = $request->validate([
            'card_no' => 'required',
            'ccExpiryMonth' => 'required',
            'ccExpiryYear' => 'required',
            'cvvNumber' => 'required',
        ]);

        $stripe = Stripe::setApiKey(env('STRIPE_SECRET'));
        try {
        $token = $stripe->tokens()->create([
        'card' => [
        'number' => $request->get('card_no'),
        'exp_month' => $request->get('ccExpiryMonth'),
        'exp_year' => $request->get('ccExpiryYear'),
        'cvc' => $request->get('cvvNumber'),
        ],
        ]);
        print_r($token);
    if (!isset($token['id'])) {
        return redirect()->route('addmoney.paymentstripe');
        }
        $charge = $stripe->charges()->create([
        'card' => $token['id'],
        'currency' => 'USD',
        'amount' => 20.49,
        'description' => 'wallet',
        ]);

        if($charge['status'] == 'succeeded') {
            return response()->json([
                "status" => 1,
                "message" => "Payment successfull!",
            ],200);
        } else {
            return response()->json([
                "status" => 0,
                "message" => "Payment Faild!",
            ],404);
        }
        } catch (Exception $e) {
            return response()->json([
                "status" => 0,
                "message" => $e,
            ],404);
        } catch(Exception $e) {
            return response()->json([
                "status" => 0,
                "message" => $e,
            ],404);
        } catch(Exception $e) {
            return response()->json([
                "status" => 0,
                "message" => $e,
            ],404);
        }
    }
}
