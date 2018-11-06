<?php
/**
 * Created by PhpStorm.
 * User: jaroslawjarczewski
 * Date: 03/11/2018
 * Time: 23:11
 */

namespace App\SiteLoader\Reports;


use App\SiteLoader\ValueObjects\ResultsValueObject;
use Symfony\Component\Console\Output\ConsoleOutput;

class ConsoleReport implements ReportInterface
{
    public function make(ResultsValueObject $result)
    {
        $output = new ConsoleOutput();
        $output->writeln('<question>['.$result->getDate()->format("Y-m-d H:i:s").'] Base site loading info</question>');
        $output->writeln('<comment>'.$result->getBase()->__toString().'</comment>');
        $output->writeln('<question>Competition info</question>');

        foreach($result->getCompetition() as $competition) {
            $output->writeln('<comment>'.$competition->__toString().'</comment>');
        }
    }
}