<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    public function checkout()
    {
        return view('checkout.index');
    }
}
