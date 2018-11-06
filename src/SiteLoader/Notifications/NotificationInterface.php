<?php
/**
 * Created by PhpStorm.
 * User: jaroslawjarczewski
 * Date: 04/11/2018
 * Time: 22:04
 */

namespace App\SiteLoader\Notifications;


use App\SiteLoader\ValueObjects\LoadResultValueObject;

interface NotificationInterface
{
    public function notify(LoadResultValueObject $base, LoadResultValueObject $competition);
}