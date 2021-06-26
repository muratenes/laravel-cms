<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IyzicoFails extends Model
{
    protected $table = 'iyzico_order_fails';
    protected $guarded = [];

    public static function addLog(string $level, string $errorMessage, string $paymentId, string $conversationId, int $basketId, string $fullName, $orderPrice, $paymentTransactionId, string $errorCode = null, int $user_id = null)
    {
        self::create([
            'user_id'              => null === $user_id ? Auth::user() ? Auth::user()->id : 0 : $user_id,
            'status'               => mb_substr($level, 0, 15),
            'errorCode'            => $errorCode,
            'errorMessage'         => mb_substr($errorMessage, 0, 250),
            'conversationId'       => mb_substr($conversationId, 0, 20),
            'basket_id'            => $basketId,
            'full_name'            => $fullName,
            'orderPrice'           => $orderPrice,
            'paymentId'            => $paymentId,
            'paymentTransactionId' => $paymentTransactionId,
        ]);
    }
}
