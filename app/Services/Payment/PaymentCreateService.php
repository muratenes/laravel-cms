<?php

namespace App\Services\Payment;

use App\Exceptions\HttpException;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Vendor;
use App\Services\DTO\PaymentCreateDto;
use App\Utils\Enum\TransactionType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PaymentCreateService
{
    private PaymentCreateDto $paymentCreateDto;
    private ?Payment $payment = null;
    private ?Vendor $vendor = null;

    public function create(PaymentCreateDto $paymentCreateDto): array
    {
        $this->paymentCreateDto = $paymentCreateDto;

        $this->validations();

        DB::transaction(function () {
            $this->paymentCreateDto->setDueDate(Carbon::parse($this->paymentCreateDto->getDueDate()));

            $this->createPayment();
            $this->createTransactions();
        });

        return [
            'total_amount' => $this->paymentCreateDto->getTotalAmount(),
            'cash_amount' => $this->paymentCreateDto->getCashAmount(),
            'credit_cart_amount' => $this->paymentCreateDto->getCreditCartAmount(),
            'vendor' => $this->vendor,
        ];
    }

    private function validations()
    {
        $this->vendor = Vendor::find($this->paymentCreateDto->getVendorId());
        throw_if(empty($this->vendor), new HttpException("gönderilen bilgilerle esnaf bulunamadı"));

        throw_if($this->paymentCreateDto->getCashAmount() < 0, new HttpException("Nakit ile ödenen tutar eksi olamaz."));
        throw_if($this->paymentCreateDto->getCreditCartAmount() < 0, new HttpException("Kart ile ödenen tutar eksi olamaz."));
        throw_if($this->paymentCreateDto->getTotalAmount() == 0, new HttpException("Ödeme girmek için toplam tutar 0'dan büyük olmalı"));
    }


    private function createPayment(): void
    {
        $this->payment = Payment::create([
            'amount' => $this->paymentCreateDto->getTotalAmount(),
            'credit_cart_amount' => $this->paymentCreateDto->getCreditCartAmount(),
            'cash_amount' => $this->paymentCreateDto->getCashAmount(),
            'user_id' => $this->paymentCreateDto->getActionUserId(),
            'due_date' => $this->paymentCreateDto->getDueDate(),
            'description' => $this->paymentCreateDto->getDescription(),
            'vendor_id' => $this->paymentCreateDto->getVendorId(),
        ]);
    }

    private function createTransactions(): void
    {
        if ($this->paymentCreateDto->getCashAmount() > 0) {
            Transaction::create([
                'vendor_id' => $this->paymentCreateDto->getVendorId(),
                'user_id' => $this->paymentCreateDto->getActionUserId(),
                'per_price_purchase' => $this->paymentCreateDto->getCashAmount(),
                'per_price' => $this->paymentCreateDto->getCashAmount(),
                'quantity' => 1,
                'amount' => (-1 * $this->paymentCreateDto->getCashAmount()),
                'type' => TransactionType::PAYMENT_CASH->value,
                'payment_id' => $this->payment->id,
                'due_date' => $this->paymentCreateDto->getDueDate(),
            ]);
        }

        if ($this->paymentCreateDto->getCreditCartAmount() > 0) {
            Transaction::create([
                'vendor_id' => $this->paymentCreateDto->getVendorId(),
                'user_id' => $this->paymentCreateDto->getActionUserId(),
                'per_price_purchase' => $this->paymentCreateDto->getCreditCartAmount(),
                'per_price' => $this->paymentCreateDto->getCreditCartAmount(),
                'quantity' => 1,
                'amount' => (-1 * $this->paymentCreateDto->getCreditCartAmount()),
                'type' => TransactionType::PAYMENT_CASH->value,
                'payment_id' => $this->payment->id,
                'due_date' => $this->paymentCreateDto->getDueDate(),
            ]);
        }
    }
}