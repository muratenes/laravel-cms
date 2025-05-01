<?php

namespace App\Services\Order;

use App\Exceptions\HttpException;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use App\Services\DTO\OrderCreateDto;
use App\Services\DTO\OrderCreateItemDto;
use App\Utils\Enum\TransactionType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderCreateService
{
    private OrderCreateDto $orderCreateDto;
    private ?Order $order = null;

    public function create(OrderCreateDto $orderCreateDto)
    {
        $this->orderCreateDto = $orderCreateDto;

        $this->validations();

        DB::transaction(function () {
            $this->createOrder();
            $this->createTransactions();
        });
    }

    private function validations()
    {
        foreach ($this->orderCreateDto->getItems() as $item) {
            $product = Product::find($item->getProductId());
            throw_if(empty($product), new HttpException("Ürün bulunamadı. {$item->getProductId()}"));
            throw_if(($item->getPerPrice() < $product->purchase_price), new HttpException("Ürünün satış fiyatı alış fiyatından küçük olamaz.Ürün : {$product->title}"));
            $item->setProduct($product);
        }
    }

    private function createOrder(): void
    {
        $this->order = Order::create([
            'description' => $this->orderCreateDto->getDescription(),
            'vendor_id' => $this->orderCreateDto->getVendorId(),
            'user_id' => $this->orderCreateDto->getActionUserId(),
            'amount' => $this->orderCreateDto->getItemsTotalAmount(),
        ]);
    }

    private function createTransactions(): void
    {
        foreach ($this->orderCreateDto->getItems() as $item) {
            Transaction::create([
                'vendor_id' => $this->orderCreateDto->getVendorId(),
                'user_id' => $this->orderCreateDto->getActionUserId(),
                'per_price_purchase' => $item->getProduct()->purchase_price,
                'per_price' => $item->getPerPrice(),
                'quantity' => $item->getQuantity(),
                'amount' => $item->getItemTotalAmount(),
                'type' => TransactionType::PURCHASE->value,
                'order_id' => $this->order->id,
                'product_id' => $item->getProductId(),
                'due_date' => $this->orderCreateDto->getDueDate() ? Carbon::parse($this->orderCreateDto->getDueDate()) : now(),
            ]);
        }
    }
}