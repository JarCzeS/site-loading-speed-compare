<?php
/**
 * Created by PhpStorm.
 * User: jaroslawjarczewski
 * Date: 03/11/2018
 * Time: 22:18
 */

namespace App\SiteLoader\ValueObjects;


class ResultsValueObject
{
    /**
     * @var \DateTime
     */
    private $date;
    /**
     * @var LoadResultValueObject
     */
    private $base;
    /**
     * @var LoadResultValueObject[]
     */
    private $competition;

    public function __construct()
    {
        $this->date = new \DateTime('now');
    }

    /**
     * @return LoadResultValueObject
     */
    public function getBase(): LoadResultValueObject
    {
        return $this->base;
    }

    /**
     * @param LoadResultValueObject $base
     */
    public function setBase(LoadResultValueObject $base): void
    {
        $this->base = $base;
    }

    /**
     * @return LoadResultValueObject[]
     */
    public function getCompetition(): array
    {
        return $this->competition;
    }

    /**
     * @param LoadResultValueObject[] $competition
     */
    public function setCompetition(array $competition): void
    {
        $this->competition = $competition;
    }

    public function addCompetition(LoadResultValueObject $competition): void
    {
        $this->competition[] = $competition;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }
}