<?php

namespace App\Http\Requests\Admin;

use App\Services\DTO\OrderCreateDto;
use App\Services\DTO\OrderCreateItemDto;
use Illuminate\Foundation\Http\FormRequest;

class OrderCreateRequest extends FormRequest
{
    private ?OrderCreateDto $orderCreateDto = null;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'vendor_id' => 'required|exists:vendors,id',
            'due_date' => 'required|date',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric',
            'items.*.per_price' => 'required|numeric',
        ];
    }

    public function getOrderCreateDto(): ?OrderCreateDto
    {
        return $this->orderCreateDto;
    }

    /**
     * Prepare the data for validation.
     */
    protected function passedValidation(): void
    {
        $items = [];
        foreach ($this->get('items') as $item) {
            $items = (new OrderCreateItemDto(
                $item['product_id'],
                $item['quantity'],
                $item['per_price'],
            ));
        }
        $this->orderCreateDto = (new OrderCreateDto(
            $this->user()->id,
            $this->get('vendor_id'),
            $items
        ));
    }
}
