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

class OrderCreateService
{
    private OrderCreateDto $orderCreateDto;
    private ?Order $order = null;
    private ?Vendor $vendor = null;

    public function create(OrderCreateDto $orderCreateDto): array
    {
        $this->orderCreateDto = $orderCreateDto;

        $this->validations();

        DB::transaction(function () {
            $dueDate = $this->orderCreateDto->getDueDate() ? Carbon::parse($this->orderCreateDto->getDueDate()) : now();
            $this->orderCreateDto->setDueDate($dueDate);

            $this->createOrder();
            $this->createTransactions();
            $this->decreaseStock();
        });

        return [
            'total_amount' => $this->orderCreateDto->getItemsTotalAmount(),
            'vendor' => $this->vendor,
        ];
    }

    private function validations()
    {
        $productIds = [];
        $this->vendor = Vendor::find($this->orderCreateDto->getVendorId());
        throw_if(empty($this->vendor),new HttpException("Göndeirilen bilgilerle esnaf bulunamadı"));

        foreach ($this->orderCreateDto->getItems() as $item) {
            $productId = $item->getProductId();

            $product = Product::find($productId);
            throw_if(empty($product), new HttpException("Ürün bulunamadı. {$productId}"));

            if (in_array($productId, $productIds)) {
                throw new HttpException("Aynı ürünü birden fazla kez ekleyemezsiniz. Ürün : {$product->name}");
            }
            $productIds[] = $productId;

            throw_if($product->stock_follow && ($product->stock < $item->getQuantity() || $product->stock == 0),
                new HttpException("Ürün stoğu yeterli değil. Ürün: {$product->name}, Mevcut Stok: {$product->stock}.Ürüne stok ekledikten sonra siparişi oluşturabilirsiniz.")
            );

            throw_if(($item->getPerPrice() < $priceByVendor = $product->getPriceForVendor($this->vendor)),
                new HttpException("Ürünün satış fiyatı {$priceByVendor} ₺'den daha küçük olamaz,Ürün :{$product->name}")
            );

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
            'due_date' => $this->orderCreateDto->getDueDate(),
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
                'due_date' => $this->orderCreateDto->getDueDate(),
            ]);
        }
    }

    private function decreaseStock(): void
    {
        foreach ($this->orderCreateDto->getItems() as $item) {
            if ($item->getProduct()->stock_follow){
                $item->getProduct()->decrement('stock', $item->getQuantity());
            }
        }
    }
}