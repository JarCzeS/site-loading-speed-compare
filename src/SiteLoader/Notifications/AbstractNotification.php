<?php
/**
 * Created by PhpStorm.
 * User: jaroslawjarczewski
 * Date: 05/11/2018
 * Time: 12:46
 */

namespace App\SiteLoader\Notifications;


use App\SiteLoader\ValueObjects\LoadResultValueObject;

abstract class AbstractNotification
{
    public function getBody(LoadResultValueObject $base, LoadResultValueObject $competition)
    {
        return "Your site: ".$base->getUrl()." (".$base->getLoadingTime()."s) has loaded slower than: ".$competition->getUrl()." (".$competition->getLoadingTime()."s).";
    }
}