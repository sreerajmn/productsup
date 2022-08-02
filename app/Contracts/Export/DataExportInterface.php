<?php


namespace App\Contracts\Export;


interface DataExportInterface
{
    public function fileExists ($fileName);

    public function getFilePath ($fileName);

    public function writeContent ($sourceFileName, $content);

    public function generateOutputFileName ($sourceFileName);

}
