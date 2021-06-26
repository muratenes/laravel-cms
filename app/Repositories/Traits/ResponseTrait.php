<?php

namespace App\Repositories\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ResponseTrait
{
    public function response($status = true, $message = null, $data = null)
    {
        return [
            'status'  => $status,
            'message' => $message ? $message : ($status ? __('messages.success') : __('messages.error')),
            'alert'   => true === $status ? 'success' : 'danger',
            'data'    => $data,
        ];
    }

    /**
     * success.
     *
     * @param array       $data
     * @param null|string $message
     *
     * @apiDefine ApiSuccess
     * @apiSuccess (Success 200) {bool} status Status.
     * @apiSuccess (Success 200) {string} message Message.
     * @apiSuccess (Success 200) {object} data Data.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function success(array $data = [], ?string $message = null): JsonResponse
    {
        return new JsonResponse([
            'status'  => true,
            'message' => $message ?? 'Success',
            'data'    => $data,
        ], 200);
    }

    /**
     * error.
     *
     * @param null|string $message
     * @param array       $data
     * @param int         $status
     *
     * @apiDefine ApiError
     * @apiError (Error 400) {bool} status Status.
     * @apiError (Error 400) {string} message Message.
     * @apiError (Error 400) {object} data Data.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function error(?string $message = null, array $data = [], int $status = Response::HTTP_BAD_REQUEST)
    {
        return new JsonResponse([
            'status'  => false,
            'message' => $message ?? 'Error',
            'data'    => $data,
        ], $status);
    }
}
