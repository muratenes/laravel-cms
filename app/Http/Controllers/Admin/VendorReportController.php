<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\HttpException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PaymentCreateRequest;
use App\Models\Product;
use App\Models\Vendor;
use App\Repositories\Traits\ResponseTrait;
use App\Repositories\Traits\SiparisUrunTrait;
use App\Services\Payment\PaymentCreateService;
use App\Services\Vendor\VendorService;
use App\Utils\Enum\TransactionType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class VendorReportController extends Controller
{
    use ResponseTrait;
    use SiparisUrunTrait;

    public function __construct(
        private readonly VendorService $vendorService
    )
    {
    }


    public function vendorSalesReport(Request $request)
    {
        $startDate = null;
        $endDate = null;

        if ($request->get('date_range')) {
            [$start, $end] = explode(' - ', $request->get('date_range'));
            $startDate = Carbon::parse($start);
            $endDate = Carbon::parse($end);
        }

        $vendorId = $request->get('vendor_id');
        $diffDays = (!empty($startDate) && !empty($endDate)) ? $startDate->diffInDays($endDate) : 0;

        if (empty($vendorId)) {
            return view('admin.vendor.reports', [
                'chartLabels' => json_encode([]),
                'productNames' => json_encode(array_keys([])),
                'chartData' => json_encode([]),
            ]);
        }

        $vendor = Vendor::find($vendorId);

        return view('admin.vendor.reports', [
            'selectedVendor' => $vendor,
            'summary' => $this->vendorService->summary($vendorId, $startDate, $endDate),
        ]);
    }


    public function vendorDailySales(Request $request)
    {
        $vendorId = $request->input('vendor_id');

        $dateRange = $request->input('date_range');

        if ($dateRange && str_contains($dateRange, ' - ')) {
            [$startDate, $endDate] = explode(' - ', str_replace('+', '', $dateRange));
        } else {
            $endDate = Carbon::now()->toDateString();
            $startDate = Carbon::parse($endDate)->subDays(29)->toDateString();
        }

        if (empty($vendorId) || empty($startDate) || empty($endDate)) {
            throw new HttpException("Esnaf,başlangıç tarihi ve end date seçili olmalı");
        };


        $results = DB::table('transactions')
            ->selectRaw('DATE(due_date) as date, products.name as product, SUM(quantity) as total_quantity')
            ->join('products', 'transactions.product_id', '=', 'products.id')
            ->where('transactions.vendor_id', $vendorId)
            ->where('transactions.type', TransactionType::PURCHASE->value)
            ->whereBetween('due_date', [$startDate, $endDate])
            ->groupBy('date', 'products.name')
            ->orderBy('date')
            ->get();

        // Verileri gruplama
        $labels = collect(range(0, 29))->map(fn($i) => Carbon::parse($endDate)->subDays(29 - $i)->format('Y-m-d'));
        $productGroups = $results->groupBy('product');

        $datasets = [];

        foreach ($productGroups as $product => $items) {
            $quantitiesByDate = $items->keyBy('date')->map(fn($item) => $item->total_quantity);
            $datasets[] = [
                'label' => $product,
                'data' => $labels->map(fn($d) => $quantitiesByDate->get($d, 0)),
                'fill' => true,
            ];
        }

        return response()->json([
            'labels' => $labels,
            'datasets' => $datasets
        ]);
    }


}
