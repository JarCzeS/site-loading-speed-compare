<?php
/**
 * Created by PhpStorm.
 * User: jaroslawjarczewski
 * Date: 04/11/2018
 * Time: 21:24
 */

namespace App\SiteLoader\Reports;


use App\SiteLoader\ValueObjects\ResultsValueObject;

class LogReport implements ReportInterface
{
    public function make(ResultsValueObject $result)
    {
        $log  = "[".$result->getDate()->format("Y-m-d H:i:s")."]".PHP_EOL.
            "Base site: ".$result->getBase()->__toString().PHP_EOL;

        foreach($result->getCompetition() as $competition) {
            $log .= "Competition: ".$competition->__toString().PHP_EOL;
        }

        $log .= "---------------------------------------------------------------------------".PHP_EOL;

        file_put_contents(__DIR__.'/../../../var/log/log.txt', $log, FILE_APPEND);
    }
}