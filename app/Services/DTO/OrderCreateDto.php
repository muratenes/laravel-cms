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


