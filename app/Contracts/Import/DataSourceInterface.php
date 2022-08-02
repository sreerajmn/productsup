<?php


namespace App\Contracts\Import;


interface DataSourceInterface
{
    public function getFile ($fileName);
}
