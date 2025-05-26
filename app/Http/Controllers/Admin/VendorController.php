<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\HttpException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PaymentCreateRequest;
use App\Models\Vendor;
use App\Repositories\Traits\ResponseTrait;
use App\Repositories\Traits\SiparisUrunTrait;
use App\Services\Payment\PaymentCreateService;
use App\Services\Vendor\VendorService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class VendorController extends Controller
{
    use ResponseTrait;
    use SiparisUrunTrait;

    public function __construct(
        private readonly VendorService $vendorService
    )
    {
    }


    public function list()
    {
        return view('admin.vendor.index');
    }


    public function show(?int $vendorId)
    {
        $vendor = Vendor::find($vendorId);
        throw_if(empty($vendor) && $vendorId != 0, new HttpException("Esnaf ID hatalı bulunamadı"));

        $summary = null;
        if ($vendor) {
            $summary = $this->vendorService->summary($vendorId);
        }

        return view('admin.vendor.edit', ['vendor' => $vendor, 'summary' => $summary]);
    }

    public function summary(Request $request, Vendor $vendor)
    {
        return $this->vendorService->summary($vendor->id, $request->get('startDate'), $request->get('endDate'));
    }

    public function createVendor(PaymentCreateRequest $request): \Illuminate\Http\JsonResponse
    {
        $result = $this->createService->create($request->getCreateDto());
        return response()->json($result);
    }

    public function ajax()
    {
        return DataTables::of(
            Vendor::with(['user'])
        )->make(true);
    }
}
