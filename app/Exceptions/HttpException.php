<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Throwable;

class HttpException extends \Exception
{
    private array $data;
    private ?string $errorCode = null;

    public function __construct(string $message = "", int $code = 400, ?Throwable $previous = null, $data = [], string $errorCode = null)
    {
        $this->data = $data;
        $this->errorCode = $errorCode;

        parent::__construct($message, $code, $previous);
    }

//    public function render(): JsonResponse
//    {
//        return response()->json([
//            'message' => $this->message,
//            'status' => 'error',
//        ], 422);
//    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }
}