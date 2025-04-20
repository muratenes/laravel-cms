<?php

namespace App\Utils\Enum;

use function Laravel\Prompts\select;

enum TransactionType: int
{
    case PURCHASE = 1;
    case PAYMENT = 2;

    public function label()
    {
        return match ($this) {
            self::PURCHASE => "Satın Alım",
            self::PAYMENT => "Ödeme",
        };
    }
}