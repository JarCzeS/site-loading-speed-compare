<?php
/**
 * Created by PhpStorm.
 * User: jaroslawjarczewski
 * Date: 03/11/2018
 * Time: 22:15
 */

namespace App\SiteLoader\ValueObjects;


class LoadResultValueObject
{
    /**
     * @var string
     */
    private $url;
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
    private $loadingTime;
    /**
     * @var float
     */
    private $compareLoadingTime;

    public function __construct(string $url, float $start, float $end, float $loadingTime, float $compareLoadingTime = 0)
    {
        $this->url = $url;
        $this->start = $start;
        $this->end = $end;
        $this->loadingTime = $loadingTime;
        $this->compareLoadingTime = $compareLoadingTime;
    }

    public function __toString()
    {
        return "Site: ".$this->getUrl().". Loading time: ".$this->loadingTime."s. Compare to base: ".$this->getCompareTimeString().".";
    }

    /**
     * @return float
     */
    public function getLoadingTime(): float
    {
        return $this->loadingTime;
    }

    /**
     * @param float $loadingTime
     */
    public function setLoadingTime(float $loadingTime): void
    {
        $this->loadingTime = $loadingTime;
    }

    /**
     * @return int
     */
    public function getEnd(): int
    {
        return $this->end;
    }

    /**
     * @param int $end
     */
    public function setEnd(int $end): void
    {
        $this->end = $end;
    }

    /**
     * @return int
     */
    public function getStart(): int
    {
        return $this->start;
    }

    /**
     * @param int $start
     */
    public function setStart(int $start): void
    {
        $this->start = $start;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return float
     */
    public function getCompareLoadingTime(): float
    {
        return $this->compareLoadingTime;
    }

    /**
     * @param float $compareLoadingTime
     */
    public function setCompareLoadingTime(float $compareLoadingTime): void
    {
        $this->compareLoadingTime = $compareLoadingTime;
    }

    /**
     * @return string
     */
    protected function getCompareTimeString(): string
    {
        $compare = abs($this->compareLoadingTime);

        if ($this->compareLoadingTime < 0) {
            $compare .= ' faster';
        } else if ($this->compareLoadingTime > 0) {
            $compare .= ' slower';
        }

        return $compare;
    }
}