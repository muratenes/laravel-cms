<?php

namespace App\Utils\Enum;

use function Laravel\Prompts\select;

enum TransactionType: int
{
    case PURCHASE = 1;
    case PAYMENT_CASH = 2;
    case PAYMENT_CREDIT_CART = 3;

    public function label()
    {
        return match ($this) {
            self::PURCHASE => "Satın Alım",
            self::PAYMENT_CASH => "Nakit Ödeme",
            self::PAYMENT_CREDIT_CART => "Kart ile Ödeme",
        };
    }
}