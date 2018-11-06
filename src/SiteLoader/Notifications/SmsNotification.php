<?php
/**
 * Created by PhpStorm.
 * User: jaroslawjarczewski
 * Date: 04/11/2018
 * Time: 22:05
 */

namespace App\SiteLoader\Notifications;


use App\SiteLoader\ValueObjects\LoadResultValueObject;

class SmsNotification extends AbstractNotification implements NotificationInterface
{
    public function notify(LoadResultValueObject $base, LoadResultValueObject $competition)
    {
        $smsAPI = new Textlocal(getenv('NOTIFY_SMS_LOGIN'),getenv('NOTIFY_SMS_HASH'));
        try {
            $smsAPI->sendSms(('NOTIFY_SMS_RECIPIENT'), $this->getBody($base, $competition), 'Ban alert');
        }
        catch (\Exception $e) {
            //low credit free api
        }
    }
}