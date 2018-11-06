<?php
/**
 * Created by PhpStorm.
 * User: jaroslawjarczewski
 * Date: 05/11/2018
 * Time: 15:24
 */

namespace App\Tests\SiteLoader;


use App\SiteLoader\Loader;
use App\SiteLoader\UrlFetcher;
use App\SiteLoader\ValueObjects\LoadResultValueObject;
use App\SiteLoader\ValueObjects\ResultsValueObject;
use PHPUnit\Framework\TestCase;

class LoaderTest extends TestCase
{
    /**
     * @var UrlFetcher
     */
    private $urlFetcher;
    /**
     * @var Loader
     */
    private $loader;

    public function setUp()
    {
        $this->urlFetcher = new UrlFetcher();
        $this->urlFetcher->setStart(1000.45);
        $this->urlFetcher->setEnd(1003.45);
        $this->urlFetcher->setLoading(3);

        $this->loader = new Loader('https://wp.pl', 'https://onet.pl,http://interia.pl');

        parent::setUp();
    }

    protected function tearDown()
    {
        $this->loader = null;
        $this->urlFetcher = null;
    }

    public function testLoadInitialization() {
        $this->assertSame('https://wp.pl', $this->loader->getUrl());
        $this->assertSame('https://onet.pl,http://interia.pl', $this->loader->getCompetitionUrls());
        $this->assertArrayHasKey(0, $this->loader->getCompetition());
        $this->assertArrayHasKey(1, $this->loader->getCompetition());
    }

    public function testCompetitionMapper() {
        $this->assertEquals(['a','b'],$this->loader->mapCompetition('a,b'));
        $this->assertEquals(['http://wp.pl'],$this->loader->mapCompetition('http://wp.pl'));
    }

    public function testLoad() {
        $result = $this->loader->load('https://wp.pl');
        $this->assertInstanceOf(LoadResultValueObject::class, $result);
        $this->assertGreaterThan(0, $result->getStart());
        $this->assertGreaterThan(0, $result->getEnd());
        $this->assertGreaterThan(0, $result->getLoadingTime());
    }

    public function testGetResults() {

        $loader = $this->getMockBuilder(Loader::class)
            ->setConstructorArgs(['https://wp.pl', 'https://wp.pl,https://wp.pl'])
            ->setMethods(array('fetchUrl'))
            ->getMock();
        $loader->method('fetchUrl')->willReturn($this->urlFetcher);


        $expected = new ResultsValueObject();
        $expected->setBase($this->getExpectedLoadingResult());
        $expected->addCompetition($this->getExpectedLoadingResult());
        $expected->addCompetition($this->getExpectedLoadingResult());

        $actual = $loader->getResults();

        $this->assertEquals($expected->getBase(), $actual->getBase());
        $this->assertEquals($expected->getCompetition(), $actual->getCompetition());
    }

    /**
     * @return LoadResultValueObject
     */
    private function getExpectedLoadingResult(): LoadResultValueObject
    {
        $expected = new LoadResultValueObject('https://wp.pl', 1000.45, 1003.45, 3);
        return $expected;
    }

}