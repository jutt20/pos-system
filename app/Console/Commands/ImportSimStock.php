<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SimStock;
use Illuminate\Support\Facades\File;

class ImportSimStock extends Command
{
    protected $signature = 'import:simstock {file}';
    protected $description = 'Import SIM stock from a CSV file';

    public function handle()
    {
        $filePath = storage_path('app/' . $this->argument('file'));

        if (!File::exists($filePath)) {
            $this->error("File not found: $filePath");
            return;
        }

        $rows = array_map('str_getcsv', file($filePath));
        $headersRaw = array_shift($rows);

        // Normalize headers: remove spaces, lowercase, convert to snake_case
        $headers = array_map(function ($h) {
            return strtolower(str_replace([' ', '-'], '_', trim($h)));
        }, $headersRaw);

        foreach ($rows as $row) {
            if (count($row) !== count($headers)) {
                $this->warn('Skipping row due to column mismatch: ' . implode(',', $row));
                continue;
            }

            $data = array_combine($headers, $row);

            SimStock::updateOrCreate(
                ['iccid' => $data['iccid']],
                [
                    'sim_type'           => $data['sim_type'] ?? null,
                    'vendor'             => $data['vendor'] ?? null,
                    'brand'              => $data['brand'] ?? null,
                    'cost'               => $data['cost'] ?? 0,
                    'status'             => strtolower($data['used'] ?? 'available') === 'yes' ? 'used' : 'available',
                    'pin1'               => $data['pin_1'] ?? null,
                    'puk1'               => $data['puk_1'] ?? null,
                    'pin2'               => $data['pin_2'] ?? null,
                    'puk2'               => $data['puk_2'] ?? null,
                    'qr_activation_code' => $data['qr_activation_code'] ?? null,
                    'batch_id'           => $data['batch_id'] ?? null,
                ]
            );
        }

        $this->info('SIM stock imported successfully!');
    }
}
