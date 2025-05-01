<?php

namespace App\Services\DTO;

use App\Models\Product;

class OrderCreateDto
{
    private int $actionUserId;
    private int $vendorId;

    /** @var OrderCreateItemDto[] $items */
    private array $items = [];

    private ?string $description = null;
    private ?string $dueDate = null;

    public function __construct(
        int   $actionUserId,
        int   $vendorId,
        array $items,
    )
    {
        $this->actionUserId = $actionUserId;
        $this->vendorId = $vendorId;
        $this->items = $items;
    }

    public function getActionUserId(): int
    {
        return $this->actionUserId;
    }

    public function getVendorId(): int
    {
        return $this->vendorId;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getItemsTotalAmount()
    {
        return collect($this->getItems())->sum(fn(OrderCreateItemDto $item) => abs($item->getAmount()));
    }

    public function addItem(OrderCreateItemDto $item): static
    {
        $this->items[] = $item;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getDueDate(): ?string
    {
        return $this->dueDate;
    }

    public function setDueDate(?string $dueDate = null): self
    {
        $this->dueDate = $dueDate;
        return $this;
    }
}


class OrderCreateItemDto
{
    private int $productId;
    private int $quantity;
    private float $perPrice;
    private float $amount;

    private ?Product $product = null;

    public function __construct(
        int $productId,
        int $quantity,
        int $perPrice,
    )
    {
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->perPrice = $perPrice;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function setProductId(int $productId): OrderCreateItemDto
    {
        $this->productId = $productId;
        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getItemTotalAmount(): float
    {
        return $this->getPerPrice() * $this->getQuantity();
    }

    public function setQuantity(int $quantity): OrderCreateItemDto
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getPerPrice(): float
    {
        return $this->perPrice;
    }

    public function setPerPrice(float $perPrice): OrderCreateItemDto
    {
        $this->perPrice = $perPrice;
        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): OrderCreateItemDto
    {
        $this->amount = $amount;
        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;
        return $this;
    }

}