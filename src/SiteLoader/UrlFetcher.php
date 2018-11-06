<?php
/**
 * Created by PhpStorm.
 * User: jaroslawjarczewski
 * Date: 03/11/2018
 * Time: 22:50
 */

namespace App\SiteLoader;


use App\SiteLoader\Exceptions\InvalidUrlException;

/**
 * Loads site by url and map result to LoadingTimeValueObject
 * Class UrlFetcher
 * @package App\SiteLoader
 */
class UrlFetcher
{
    /**
     * @var float
     */
    private $start;
    /**
     * @var float
     */
    private $end;
    /**
     * @var float
     */
    private $loading;

    /**
     * @param string $url
     * @return UrlFetcher
     * @throws InvalidUrlException
     */
    public function fetch(string $url): self {
        $this->start = microtime( true );
        try {
            $this->loadUrl($url);
        }
        catch (\Exception $e) {
            throw new InvalidUrlException('Cant measure url (be sure its url with http):'.$url);
        }
        $this->end = microtime( true );
        $this->loading = round($this->end - $this->start,3);

        return $this;
    }

    private function loadUrl(string $url) {
        //TODO: curl, guzzle, more detailed loading
        return file_get_contents($url);
    }

    /**
     * @return float
     */
    public function getLoading(): float
    {
        return $this->loading;
    }

    /**
     * @return float
     */
    public function getEnd(): float
    {
        return $this->end;
    }

    /**
     * @return float
     */
    public function getStart(): float
    {
        return $this->start;
    }

    /**
     * @param float $start
     */
    public function setStart(float $start): void
    {
        $this->start = $start;
    }

    /**
     * @param float $end
     */
    public function setEnd(float $end): void
    {
        $this->end = $end;
    }

    /**
     * @param float $loading
     */
    public function setLoading(float $loading): void
    {
        $this->loading = $loading;
    }
}