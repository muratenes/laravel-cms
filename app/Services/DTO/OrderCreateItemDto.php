<?php

namespace App\Services\DTO;

use App\Models\Product;

class OrderCreateItemDto
{
    private int $productId;
    private int $quantity;
    private float $perPrice;
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
        return $this->getPerPrice() * $this->getQuantity();
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