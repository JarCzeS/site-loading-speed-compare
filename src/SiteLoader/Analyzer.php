<?php
/**
 * Created by PhpStorm.
 * User: jaroslawjarczewski
 * Date: 04/11/2018
 * Time: 21:41
 */

namespace App\SiteLoader;


use App\SiteLoader\ValueObjects\ResultsValueObject;

/**
 * Measure loading time of competitors in compare to base loading results
 * Class Analyzer
 * @package App\SiteLoader
 */
class Analyzer
{
    /**
     * @var ResultsValueObject
     */
    private $result;

    public function __construct(ResultsValueObject $result)
    {
        $this->result = $result;
    }

    public function compare() {
        $base = $this->result->getBase();
        foreach($this->result->getCompetition() as $competition) {
            $competition->setCompareLoadingTime($competition->getLoadingTime()-$base->getLoadingTime());
        }
    }

}