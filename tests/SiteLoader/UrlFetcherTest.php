<?php
/**
 * Created by PhpStorm.
 * User: jaroslawjarczewski
 * Date: 05/11/2018
 * Time: 13:53
 */

namespace App\Tests;


use App\SiteLoader\Exceptions\InvalidUrlException;
use App\SiteLoader\UrlFetcher;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class UrlFetcherTest extends TestCase
{
    /**
     * @var UrlFetcher
     */
    private $urlFetcher;

    public function setUp()
    {
        $this->urlFetcher = new UrlFetcher();
        parent::setUp();
    }
    protected function tearDown()
    {
        $this->urlFetcher = null;
    }

    public function testFetchNotExistingUrl()
    {
        $this->expectException(InvalidUrlException::class);
        $this->urlFetcher->fetch('http://www.xxxaaa.pl');
    }

    public function testFetchInvalidUrl()
    {
        $this->expectException(InvalidUrlException::class);
        $this->urlFetcher->fetch('www.wp.pl');
    }

    public function testFetchEmptyUrl()
    {
        $this->expectException(InvalidUrlException::class);
        $this->urlFetcher->fetch('');
    }

    /**
     * @dataProvider urlDataProvider
     * @param $url
     * @throws InvalidUrlException
     */
    public function testFetchUrl($url) {
        $this->urlFetcher->fetch($url);
        $this->assertInternalType('float', $this->urlFetcher->getStart());
        $this->assertInternalType('float', $this->urlFetcher->getEnd());
        $this->assertInternalType('float', $this->urlFetcher->getLoading());

        $this->assertGreaterThan(0, $this->urlFetcher->getLoading());
    }

    public function urlDataProvider() {
        return [
            ['http://wp.pl'],
            ['http://onet.pl'],
            ['http://google.com'],
            ['https://www.progress.com'],
        ];
    }
}
