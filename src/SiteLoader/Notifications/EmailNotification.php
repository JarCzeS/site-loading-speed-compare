<?php
/**
 * Created by PhpStorm.
 * User: jaroslawjarczewski
 * Date: 04/11/2018
 * Time: 22:05
 */

namespace App\SiteLoader\Notifications;


use App\SiteLoader\ValueObjects\LoadResultValueObject;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class EmailNotification extends AbstractNotification implements NotificationInterface
{
    /**
     * @param LoadResultValueObject $base
     * @param LoadResultValueObject $competition
     */
    public function notify(LoadResultValueObject $base, LoadResultValueObject $competition)
    {
        $transport = (new Swift_SmtpTransport(getenv('EMAIL_SMTP'), getenv('EMAIL_PORT')))
            ->setUsername(getenv('EMAIL_LOGIN'))
            ->setPassword(getenv('EMAIL_PASS'))
        ;

        $mailer = new Swift_Mailer($transport);

        $message = (new Swift_Message('Loading speed alert'))
            ->setFrom([getenv('NOTIFY_SENDER_EMAIL') => getenv('NOTIFY_SENDER_NAME')])
            ->setTo([getenv('NOTIFY_EMAIL_RECIPIENT')])
            ->setBody($this->getBody($base, $competition))
        ;

        $mailer->send($message);
    }
}