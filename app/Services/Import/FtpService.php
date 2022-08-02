<?php


namespace App\Services\Import;

use App\Contracts\Import\DataSourceInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FtpService implements DataSourceInterface
{
    public function getFile ($fileName)
    {
        if (Storage::disk('ftp')->exists($fileName)) {
            $file = Storage::disk('ftp')->get($fileName);
            Storage::disk('local')->put($fileName, $file);
            return Storage::disk('local')->path($fileName);
        }
        error_log("The file {$fileName} not found on FTP server"); 
        die();
    }
}
