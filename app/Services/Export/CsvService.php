<?php

namespace App\Services\Export;

use App\Contracts\Export\DataExportInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CsvService implements DataExportInterface
{
    public function fileExists ($fileName) {
        return Storage::disk('local')->exists($fileName);
    }

    public function getFilePath ($fileName) {
        return Storage::disk('local')->path($fileName);
    }

    public function writeContent ($sourceFileName, $content) {
        $fileName = $this->generateOutputFileName($sourceFileName);
        $filePath = $this->getFilePath($fileName);

        if (!$this->fileExists($fileName)) {
            $headers = array_keys(get_object_vars($content[0]));
            $file = fopen($filePath, 'a');
            fputcsv($file, $headers);
        } else {
            $file = fopen($filePath, 'a');
        }

        foreach ($content as $item) {
            $line = array_values(get_object_vars($item));
            fputcsv($file, $line);
        }
        
        fclose($file);

    }

    public function generateOutputFileName ($sourceFileName) {
        $info = pathinfo($sourceFileName);
        return $info['filename'] . '.csv';
    }

}
