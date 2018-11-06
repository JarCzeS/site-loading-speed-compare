<?php
/**
 * Created by PhpStorm.
 * User: jaroslawjarczewski
 * Date: 03/11/2018
 * Time: 23:10
 */

namespace App\SiteLoader\Reports;


use App\SiteLoader\ValueObjects\ResultsValueObject;

interface ReportInterface
{
    public function make(ResultsValueObject $result);
}