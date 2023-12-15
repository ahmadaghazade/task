<?php

namespace App\Http\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\Http;

class PaymentService {

    protected $token;

    public function create($fee_free_amount, $order_id, $callback, $card_number)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . config('payment.GatewayId'),
                ])->post('https://core.paystar.ir/api/pardakht/create', [
            'amount' => $fee_free_amount,
            'order_id' => $order_id,
            'callback' => 'http://localhost:8000/callback',
            'sign' => hash_hmac(
                "SHA512",
                $fee_free_amount . '#' . $order_id . '#' . $callback,
                config('payment.Sign')
            )
        ]);
        $this->token = $response['data']['token'];
        if($response['status'] === 1)
        {
            $status = $response['status'];
            $token = $this->token;
            $amount = $response['data']['payment_amount'];
            $ref_num = $response['data']['ref_num'];
            $order_id = $response['data']['order_id'];
            Payment::create([
                'token' => $token,
                'status_code' => $status,
                'fee_free_amount' => $fee_free_amount,
                'amount' => $amount,
                'user_id' => 1,
                'ref_num' => $ref_num,
                'order_id' => $order_id,
                'user_card_number' => $card_number
            ]);
            return $this->token;
        }
        else
        {
            return response()->json(['message' => 'Payment failed.']);
        }
        // return null;
        // return response()->json($response->json(), $response->status());
        
    }

    public function payment($token)
    {
        return $response = Http::post('https://core.paystar.ir/api/pardakht/payment/',[
            'token' => $token
        ]);
    }

    public function verify($card_number, $tracking_code , $ref_num) : bool
    {
        $data = Payment::where('ref_num', $ref_num)->first();
        $amount = $data->fee_free_amount;
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . config('payment.GatewayId'),
        ])->post("https://core.paystar.ir/api/pardakht/verify", [
            'ref_num' => $ref_num,
            'amount' => $amount,
            'sign' => hash_hmac(
                "SHA512",
                $amount . '#' . $ref_num . '#' . $card_number . '#' . $tracking_code,
                config('payment.Sign')
            )
        ]);
        return true;
    }

}