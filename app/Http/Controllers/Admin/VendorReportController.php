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

        $isWeekly = $diffDays > 15;

        $vendor = Vendor::find($vendorId);
        // Veriyi çek
        $rawData = $this->getTransactionData($vendorId, $startDate, $endDate, $isWeekly);

        // Ürün isimlerini al
        $productIds = collect($rawData)->pluck('product_id')->unique()->toArray();
        $products = Product::whereIn('id', $productIds)->pluck('name', 'id')->toArray();

        // Label ve veri matrisini hazırla
        if ($isWeekly) {
            $labels = $this->getWeekLabels($rawData);
            $groupKey = 'year_week';
        } else {
            $labels = collect($rawData)->pluck('due_date')->unique()->toArray();
            $groupKey = 'due_date';
        }

        $chartData = $this->buildChartData($rawData, $products, $labels, $groupKey);

        return view('admin.vendor.reports', [
            'selectedVendor' => $vendor,
            'chartLabels' => json_encode(array_values($labels)),
            'productNames' => json_encode(array_keys($chartData)),
            'chartData' => json_encode($chartData),
            'summary' => $this->vendorService->summary($vendorId, $startDate, $endDate),
        ]);
    }

    private function getTransactionData(int $vendorId, string $startDate, string $endDate, bool $weekly)
    {
        if ($weekly) {
            return DB::table('transactions')
                ->select(
                    DB::raw("YEARWEEK(due_date, 1) as year_week"),
                    'product_id',
                    DB::raw('SUM(quantity) as total_quantity'),
                    DB::raw('SUM(amount) as total_amount')
                )
                ->where('vendor_id', $vendorId)
                ->where('type', TransactionType::PURCHASE->value)
                ->whereBetween('due_date', [$startDate, $endDate])
                ->groupBy('year_week', 'product_id')
                ->orderBy('year_week')
                ->get();
        }

        return DB::table('transactions')
            ->select(
                'due_date',
                'product_id',
                DB::raw('SUM(quantity) as total_quantity'),
                DB::raw('SUM(amount) as total_amount')
            )
            ->where('vendor_id', $vendorId)
            ->where('type', TransactionType::PURCHASE->value)
            ->whereBetween('due_date', [$startDate, $endDate])
            ->groupBy('due_date', 'product_id')
            ->orderBy('due_date')
            ->get();
    }

    private function getWeekLabels($rawData)
    {
        $weeks = collect($rawData)->pluck('year_week')->unique()->values();

        return $weeks->map(function ($yw) {
            $year = substr($yw, 0, 4);
            $week = substr($yw, 4, 2);
            $startOfWeek = Carbon::now()->setISODate($year, $week)->startOfWeek(Carbon::MONDAY);
            $endOfWeek = (clone $startOfWeek)->endOfWeek(Carbon::SUNDAY);
            return $startOfWeek->format('d.m.Y') . ' - ' . $endOfWeek->format('d.m.Y');
        })->toArray();
    }

    private function buildChartData($rawData, $products, $labels, $groupKey)
    {
        $chartData = [];

        // Ürün başlıkları için sıfırlarla dolu array hazırla
        foreach ($products as $id => $title) {
            $chartData[$title] = array_fill(0, count($labels), 0);
        }

        // Verileri uygun index'e yerleştir
        $labelIndexes = array_flip($labels);
        foreach ($rawData as $row) {
            $productName = $products[$row->product_id] ?? 'Bilinmeyen Ürün';
            $key = $groupKey === 'year_week'
                ? $this->formatYearWeek($row->$groupKey)
                : $row->$groupKey;

            if (!isset($labelIndexes[$key])) continue;

            $index = $labelIndexes[$key];
            $chartData[$productName][$index] = round($row->total_amount, 2);
        }

        return $chartData;
    }

    private function formatYearWeek($yearWeek)
    {
        $year = substr($yearWeek, 0, 4);
        $week = substr($yearWeek, 4, 2);
        $startOfWeek = Carbon::now()->setISODate($year, $week)->startOfWeek(Carbon::MONDAY);
        $endOfWeek = (clone $startOfWeek)->endOfWeek(Carbon::SUNDAY);
        return $startOfWeek->format('d.m.Y') . ' - ' . $endOfWeek->format('d.m.Y');
    }
}
