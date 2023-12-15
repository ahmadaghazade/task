<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'tracking_code',
        'user_card_number',
        'card_number',
        'transaction_id',
        'ref_num',
        'status_code',
        'token',
        'fee_free_amount',
        'amount'
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
