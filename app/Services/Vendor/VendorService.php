<?php

namespace App\Services\Vendor;

use App\Exceptions\HttpException;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\Vendor;
use App\Utils\Enum\TransactionType;
use Illuminate\Support\Facades\DB;

class VendorService
{

    public static function vendors(): \Illuminate\Database\Eloquent\Collection
    {
        return Vendor::orderBy('title')->get();
    }

    public function summary(int $vendorId, string $startDate = null, string $endDate = null): array
    {
        $vendor = Vendor::find($vendorId);
        throw_if(empty($vendor), new HttpException("Esnaf bulunamadı"));

        return [
            'balance' => $this->balance($vendorId),
            'payment_total_amount' => $this->paymentAmount($vendorId, $startDate, $endDate),
            'order_total_amount' => $this->orderAmount($vendorId, $startDate, $endDate),
            'orders_by_product' => $this->productTotals($vendorId, $startDate, $endDate),
        ];
    }

    public function balance(int $vendorId)
    {
        return Transaction::where('vendor_id', $vendorId)
            ->sum('amount');
    }

    public function paymentAmount(int $vendorId, ?string $startDate = null, ?string $endDate = null)
    {
        $query = Payment::where('vendor_id', $vendorId);

        if ($startDate && $endDate) {
            $query->whereBetween('due_date', [$startDate, $endDate]);
        }

        return $query->sum('amount');
    }

    public function orderAmount(int $vendorId, ?string $startDate = null, ?string $endDate = null)
    {
        $query = Order::where('vendor_id', $vendorId);

        if ($startDate && $endDate) {
            $query->whereBetween('due_date', [$startDate, $endDate]);
        }

        return $query->sum('amount');
    }

    public function productTotals(int $vendorId, ?string $startDate = null, ?string $endDate = null)
    {
        $query = Transaction::with('product')
            ->select('product_id', DB::raw('SUM(amount) as total_amount'))
            ->where('vendor_id', $vendorId)
            ->whereNotNull('product_id')
            ->where('type', TransactionType::PURCHASE->value);

        if ($startDate && $endDate) {
            $query->whereBetween('due_date', [$startDate, $endDate]);
        }

        $query->groupBy('product_id');

        return $query->get();
    }

}