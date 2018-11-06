<?php
/**
 * Created by PhpStorm.
 * User: jaroslawjarczewski
 * Date: 04/11/2018
 * Time: 22:04
 */

namespace App\SiteLoader\Notifications;


class NotificationFactory
{
    public function getEmailNotification(): EmailNotification {
        return new EmailNotification();
    }

    public function getSmsNotification(): SmsNotification {
        return new SmsNotification();
    }
}