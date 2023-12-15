<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\PaymentService;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }


    public function createPayment(Request $request)
    {

        $token = $this->paymentService->create(5000, 1, 'http://localhost:8000/callback', $request->card_number);
        if($token)
        {
            return $response = $this->paymentService->payment($token);
        }
        
    }

    public function callback(Request $request)
    {
        $final_card_number = $request->card_number;
        $user_card_number = $record = Payment::where('ref_num', $request->ref_num)->first();
        $user_card_number = $user_card_number->user_card_number;

        $first_4_digits_of_final = substr($final_card_number, 0, 4);
        $first_4_digits_of_user = substr($user_card_number, 0, 4);

        $last_4_digits_of_final = substr($final_card_number, -4);
        $last_4_digits_of_user = substr($user_card_number, -4);

        if($first_4_digits_of_final === $first_4_digits_of_user && $last_4_digits_of_final === $last_4_digits_of_user)
        {
            if($request->status === "1")
                {
                    $record = Payment::where('ref_num', $request->ref_num)->first();

                    if($record)
                    {
                        $record->update([
                            'transaction_id' => $request->transaction_id,
                            'card_number' => $request->card_number,
                            'tracking_code' => $request->tracking_code,
                        ]);
                        $result =  $this->paymentService->verify($request->card_number, $request->tracking_code, $request->ref_num);
                        if($result)
                        {
                            return "تراکنش موفق";
                        }

                    }
                }
        }
        elseif($request->status === "-1")
        {
            return "درخواست نامعتبر";
        }
        elseif($request->status === "-2")
        {
            return "درگاه فعال نیست";
        }
        elseif($request->status === "-3")
        {
            return "توکن تکراری است";
        }
        elseif($request->status === "-4")
        {
            return "مبلغ بیشتر از سقف مجاز درگاه است";
        }
        elseif($request->status === "-5")
        {
            return "شناسه ref_num معتبر نیست";
        }
        elseif($request->status === "-6")
        {
            return "تراکنش قبلا وریفای شده است";
        }
        elseif($request->status === "-7")
        {
            return "پارامترهای ارسال شده نامعتبر است";
        }
        elseif($request->status === "-8")
        {
            return "تراکنش را نمیتوان وریفای کرد";
        }
        elseif($request->status === "-9")
        {
            return "تراکنش وریفای نشد";
        }
        elseif($request->status === "-98")
        {
            return "تراکنش ناموفق";
        }
        elseif($request->status === "-99")
        {
            return "خطای سامانه";
        }
        else
        {
            return "شماره کارت پرداختی با شماره کارت اعلامی تطابقت نداشت.";
        }
    }
}
