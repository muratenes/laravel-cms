<?php

namespace App\Repositories\Traits;

use Illuminate\Http\Request;

trait IyzicoTrait
{
    /** iyzico 3d response değerlerini gönderir.
     * @param $paymentJson
     *
     * @return array
     */
    protected function getIyzico3DSecurityDetailsFromIyzicoResponseData(array $paymentJson)
    {
        return [
            'status'             => $paymentJson['status'],
            'conversationId'     => $paymentJson['conversationId'],
            'threeDSHtmlContent' => $paymentJson['threeDSHtmlContent'],
        ];
    }

    /**
     * @param array $paymentArray
     *
     * @return mixed
     */
    protected function getIyzicoDetailsFromIyzicoResponseData(array $paymentArray)
    {
        return [
            'status'         => $paymentArray['status'],
            'transaction_id' => $paymentArray['conversationId'],
            'price'          => $paymentArray['price'],
            'paidPrice'      => $paymentArray['paidPrice'],
        ];
        $paymentData['status'] = $paymentArray['status'];
        $paymentData['transaction_id'] = $paymentArray['conversationId'];
        $paymentData['price'] = $paymentArray['price'];
        $paymentData['paidPrice'] = $paymentArray['paidPrice'];
        $paymentData['installment'] = $paymentArray['installment'];
        $paymentData['paymentId'] = $paymentArray['paymentId'];
        $paymentData['basketId'] = $paymentArray['basketId'];

        return $paymentData;
    }

    /**
     * iyzico taksit bilgisini gönderir.
     *
     * @param Request $request
     *
     * @return mixed
     */
    protected function getIyzicoInstallmentCount(Request $request)
    {
        $validated = $request->validate([
            'totalPrice'       => 'required|numeric|between:0,3000',
            'creditCartNumber' => 'required|numeric',
        ]);
        $creditCartNumber = mb_substr($validated['creditCartNumber'], 0, 6);
        $totalPrice = $validated['totalPrice'];
        $data = $this->paymentService->getIyzicoInstallmentCount($creditCartNumber, $totalPrice);

        return $data->getRawResult();
    }
}
