<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class İyzicoFailsJson extends Model
{
    protected $table = 'iyzico_order_fails_json';
    protected $guarded = [];

    public static function addLog($userId, string $fullName, string $basketId, $jsonResponse)
    {
        self::create([
            'user_id'       => null === $userId ? Auth::user() ? Auth::user()->id : 0 : $userId,
            'full_name'     => $fullName,
            'basket_id'     => $basketId,
            'json_response' => $jsonResponse,
        ]);
    }
}
