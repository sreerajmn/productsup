<?php


namespace App\Services\Import;

use App\Contracts\Import\DataSourceInterface;
use Illuminate\Support\Facades\Storage;

class LocalService implements DataSourceInterface
{
    public function getFile ($fileName)
    {
        if (Storage::disk('local')->exists($fileName)) {
            return Storage::disk('local')->path($fileName);
        }
        error_log("The file {$fileName} not found on local server"); 
        die();
    }
}
