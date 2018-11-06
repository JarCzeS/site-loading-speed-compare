<?php
/**
 * Created by PhpStorm.
 * User: jaroslawjarczewski
 * Date: 03/11/2018
 * Time: 22:13
 */

namespace App\SiteLoader;


use App\SiteLoader\ValueObjects\LoadResultValueObject;
use App\SiteLoader\ValueObjects\ResultsValueObject;

/**
 * Loads base and competition sites and map data to ResultValueObject
 * Class Loader
 * @package App\SiteLoader
 */
class Loader
{
    /**
     * @var string
     */
    private $url;
    /**
     * @var string
     */
    private $competitionUrls;

    /**
     * @var array
     */
    private $competition;
    /**
     * @var UrlFetcher
     */
    private $urlFetcher;

    public function __construct(string $url, string $competitionUrls)
    {
        $this->url = $url;
        $this->competitionUrls = $competitionUrls;
        $this->competition = $this->mapCompetition($this->competitionUrls);
        $this->urlFetcher = new UrlFetcher();
    }

    /**
     * @return ResultsValueObject
     * @throws Exceptions\InvalidUrlException
     */
    public function getResults(): ResultsValueObject {
        $result = new ResultsValueObject();

        $result->setBase($this->load($this->url));

        foreach($this->competition as $competitionUrl) {
            $result->addCompetition($this->load($competitionUrl));
        }

        return $result;
    }

    /**
     * @param string $url
     * @return LoadResultValueObject
     * @throws Exceptions\InvalidUrlException
     */
    public function load(string $url): LoadResultValueObject {
        $loadResult = $this->fetchUrl($url);

        $loadingResult = new LoadResultValueObject($url, $loadResult->getStart(), $loadResult->getEnd(), $loadResult->getLoading());

        return $loadingResult;
    }

    public function mapCompetition(string $competition) {
        return explode(',',$competition);
    }

    /**
     * @param string $url
     * @return UrlFetcher
     * @throws Exceptions\InvalidUrlException
     */
    public function fetchUrl(string $url): UrlFetcher
    {
        return $this->urlFetcher->fetch($url);
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getCompetitionUrls(): string
    {
        return $this->competitionUrls;
    }

    /**
     * @param string $competitionUrls
     */
    public function setCompetitionUrls(string $competitionUrls): void
    {
        $this->competitionUrls = $competitionUrls;
    }

    /**
     * @return array
     */
    public function getCompetition(): array
    {
        return $this->competition;
    }

    /**
     * @param array $competition
     */
    public function setCompetition(array $competition): void
    {
        $this->competition = $competition;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }
}