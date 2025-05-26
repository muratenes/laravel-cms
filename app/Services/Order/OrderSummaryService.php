<?php

namespace App\Services\Order;

use App\Exceptions\HttpException;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Vendor;
use App\Services\DTO\OrderCreateDto;
use App\Services\DTO\OrderCreateItemDto;
use App\Utils\Enum\TransactionType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderSummaryService
{
    public function productView()
    {

    }
}