<?php

namespace App\Services\Export;

use App\Contracts\Export\DataExportInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class JsonService implements DataExportInterface
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

        $dataArray = [];
        if ($this->fileExists($fileName)) {
            $currentData = file_get_contents($filePath);
            $dataArray = json_decode($currentData);
        }
        unset($currentData);
        foreach ($content as $item) {
            $dataArray[] = json_decode(json_encode($item));
        }
        unset($content);
        $jsonData = json_encode($dataArray);
        file_put_contents($filePath, $jsonData);
    }

    public function generateOutputFileName ($sourceFileName) {
        $info = pathinfo($sourceFileName);
        return $info['filename'] . '.json';
    }

}
