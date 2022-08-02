<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Services\ImportContext;
use App\Services\ExportContext;

class ImportCoffeeFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:coffee_feed 
                                {source : Source from which the file is to be fetched (ftp,local)} 
                                {filename : Name of the XML file} 
                                {export_format : Output file format (csv, json)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import XML data and convert to csv or other formats';

    /**
     * @var int
     */
    public $batchSize = 10; 

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle ()
    {
        $source = $this->argument('source');
        $fileName = $this->argument('filename');
        $exportFormat = $this->argument('export_format');

        $importService = new ImportContext($source);
        $exportService = new ExportContext($exportFormat);
        $filePath = $importService->getFile($fileName);
        $this->info("Processing {$fileName} from {$source}");
        $streamer = \Prewk\XmlStringStreamer::createStringWalkerParser($filePath);
        $batchData = [];
        $this->info("Exporting to {$exportFormat}");
        while ($node = $streamer->getNode()) {
            $simpleXmlNode = simplexml_load_string($node, "SimpleXMLElement", LIBXML_NOCDATA);
            $batchData[] = $simpleXmlNode;
            if (count($batchData) == $this->batchSize) {
                $exportService->writeContent($fileName, $batchData);
                $batchData = [];
            }
        }
        if (count($batchData)) {
            $exportService->writeContent($fileName, $batchData);
        }
        $this->info("Exporting to {$exportFormat} completed");
    }
}
