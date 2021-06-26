<?php

namespace App\Console\Commands;

use App\Utils\Excel\Imports\ProductsImports;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:import-excel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ürünleri excel ile import eder.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Excel::import(new ProductsImports(), storage_path('app/excel/products/products.ods'));

        return 0;
    }
}
