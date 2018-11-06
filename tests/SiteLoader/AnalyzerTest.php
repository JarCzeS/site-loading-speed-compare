<?php
/**
 * Created by PhpStorm.
 * User: jaroslawjarczewski
 * Date: 05/11/2018
 * Time: 22:45
 */

namespace App\Tests\SiteLoader;


use App\SiteLoader\Analyzer;
use App\SiteLoader\ValueObjects\LoadResultValueObject;
use App\SiteLoader\ValueObjects\ResultsValueObject;
use PHPUnit\Framework\TestCase;

class AnalyzerTest extends TestCase
{
    /**
     * @var ResultsValueObject
     */
    private $result;

    public function setUp()
    {
        $this->result = new ResultsValueObject();
        $this->result->setBase(new LoadResultValueObject('http://wp.pl',1000.45,1004.45,2.3));
        $this->result->addCompetition(new LoadResultValueObject('http://onet.pl',1000.45,1004.45,2.53));
        $this->result->addCompetition(new LoadResultValueObject('http://interia.pl',1000.45,1004.45,0.555));
        parent::setUp();
    }

    public function testCompare() {
        $analyzer = new Analyzer($this->result);
        $analyzer->compare();

        /** @var LoadResultValueObject[] $competition */
        $competition = $this->result->getCompetition();

        $this->assertEquals(0, $this->result->getBase()->getCompareLoadingTime());
        $this->assertEquals(0.23, $competition[0]->getCompareLoadingTime());
        $this->assertEquals(-1.745, $competition[1]->getCompareLoadingTime());
    }
}