<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\SimStockImport;
use Maatwebsite\Excel\Facades\Excel;

class SimStockImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new SimStockImport, $request->file('import_file'));

        return back()->with('success', 'SIM stock imported successfully.');
    }
}
