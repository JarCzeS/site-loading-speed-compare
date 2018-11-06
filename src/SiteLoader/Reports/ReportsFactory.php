<?php
/**
 * Created by PhpStorm.
 * User: jaroslawjarczewski
 * Date: 04/11/2018
 * Time: 21:02
 */

namespace App\SiteLoader\Reports;


class ReportsFactory
{
    public function consoleReport(): ConsoleReport {
        return new ConsoleReport();
    }

    public function logReport(): LogReport {
        return new LogReport();
    }
}