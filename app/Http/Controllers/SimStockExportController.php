<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\SimStocksExport;
use Maatwebsite\Excel\Facades\Excel;

class SimStockExportController extends Controller
{
    public function export()
    {
        return Excel::download(new SimStocksExport, 'sim_stocks.xlsx');
    }
}
