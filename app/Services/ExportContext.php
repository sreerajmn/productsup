<?php

namespace App\Services;

use App\Services\Export\CsvService;
use App\Services\Export\JsonService;

class ExportContext {

    private $formatter;

    public function __construct (string $outputType) {
        switch ($outputType) {
            case "csv":
                $this->formatter = new CsvService();
                break;
            case "json":
                $this->formatter = new JsonService();
                break;
            default:
                 error_log("export_format {$outputType} is not supported"); die();
        }
    }

    public function writeContent (string $fileName, array $data) {
        return $this->formatter->writeContent($fileName, $data);
    }
}