<?php

namespace App\Services\DTO;

use App\Models\Product;

class PaymentCreateDto
{
    private int $actionUserId;
    private int $vendorId;
    private string $dueDate;
    private float $cashAmount;
    private float $creditCartAmount;

    private ?string $description = null;


    public function __construct(
        int    $actionUserId,
        int    $vendorId,
        string $dueDate,
        string $cashAmount,
        string $creditCartAmount,
    )
    {
        $this->actionUserId = $actionUserId;
        $this->vendorId = $vendorId;
        $this->dueDate = $dueDate;
        $this->cashAmount = $cashAmount;
        $this->creditCartAmount = $creditCartAmount;
    }

    public function getActionUserId(): int
    {
        return $this->actionUserId;
    }

    public function setActionUserId(int $actionUserId): PaymentCreateDto
    {
        $this->actionUserId = $actionUserId;
        return $this;
    }

    public function getVendorId(): int
    {
        return $this->vendorId;
    }

    public function setVendorId(int $vendorId): PaymentCreateDto
    {
        $this->vendorId = $vendorId;
        return $this;
    }

    public function getDueDate(): string
    {
        return $this->dueDate;
    }

    public function setDueDate(string $dueDate): PaymentCreateDto
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    public function getCashAmount(): float
    {
        return $this->cashAmount;
    }

    public function getTotalAmount(): float
    {
        return $this->cashAmount + $this->creditCartAmount;
    }

    public function setCashAmount(float $cashAmount): PaymentCreateDto
    {
        $this->cashAmount = $cashAmount;
        return $this;
    }

    public function getCreditCartAmount(): float
    {
        return $this->creditCartAmount;
    }

    public function setCreditCartAmount(float $creditCartAmount): PaymentCreateDto
    {
        $this->creditCartAmount = $creditCartAmount;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): PaymentCreateDto
    {
        $this->description = $description;
        return $this;
    }
}


