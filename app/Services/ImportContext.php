<?php

namespace App\Services;

use App\Services\Import\FtpService;
use App\Services\Import\LocalService;

class ImportContext {

    private $source;

    public function __construct (string $sourceType) {
        switch ($sourceType) {
            case "ftp":
                $this->source = new FtpService();
                break;
            case "local":
                $this->source = new LocalService();
                break;
            default:
                error_log("source {$sourceType} is not supported"); die();
        }
    }

    public function getFile (string $fileName) {
        return $this->source->getFile($fileName);
    }
}