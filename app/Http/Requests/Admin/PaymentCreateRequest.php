<?php

namespace App\Http\Requests\Admin;

use App\Services\DTO\OrderCreateDto;
use App\Services\DTO\OrderCreateItemDto;
use App\Services\DTO\PaymentCreateDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PaymentCreateRequest extends FormRequest
{
    private ?PaymentCreateDto $paymentCreateDto = null;

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
            'cash_amount' => 'required|numeric',
            'credit_cart_amount' => 'required|numeric',
            'description' => 'nullable|string',
        ];
    }

    public function getOrderCreateDto(): ?PaymentCreateDto
    {
        return $this->paymentCreateDto;
    }

    /**
     * Prepare the data for validation.
     */
    protected function passedValidation(): void
    {
        $this->paymentCreateDto = (new PaymentCreateDto(
            $this->user('admin')->id,
            $this->get('vendor_id'),
            $this->get('due_date'),
            $this->get('cash_amount'),
            $this->get('credit_cart_amount'),
        ))->setDescription($this->get('description'));
    }

}
