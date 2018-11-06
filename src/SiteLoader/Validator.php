<?php
/**
 * Created by PhpStorm.
 * User: jaroslawjarczewski
 * Date: 04/11/2018
 * Time: 22:02
 */

namespace App\SiteLoader;


use App\SiteLoader\Notifications\NotificationFactory;
use App\SiteLoader\ValueObjects\LoadResultValueObject;
use App\SiteLoader\ValueObjects\ResultsValueObject;

/**
 * Valid loading times of sites and send notification when conditions are met
 * Class Validator
 * @package App\SiteLoader
 */
class Validator
{
    private $smsNotificationsSent = false;
    private $emailNotificationSent = false;

    /**
     * @var NotificationFactory
     */
    private $notificationFactory;

    public function validLoadingTimes(ResultsValueObject $results) {
        $baseLoadingTime = $results->getBase()->getLoadingTime();

        $this->notificationFactory = new NotificationFactory();

        foreach($results->getCompetition() as $competition)
        {
            /*
             * Base loading time twice bigger than competition
             */
            if($this->loadingTimeTwiceBigger($baseLoadingTime, $competition->getLoadingTime()) && !$this->smsNotificationsSent) {
                $this->sendSmsNotification($results->getBase(), $competition);

                $this->smsNotificationsSent = true;
            }

            /*
             * Base loading time bigger than competition
             */
            if($baseLoadingTime > $competition->getLoadingTime() && !$this->emailNotificationSent) {
                $this->sendEmailNotification($results->getBase(), $competition);

                $this->emailNotificationSent = true;
            }
        }
    }

    private function loadingTimeTwiceBigger(float $baseLoadingTime, float $competitionLoadingTime): bool
    {
        if($competitionLoadingTime == 0) {
            return 0;
        }

        return (($baseLoadingTime/$competitionLoadingTime) > 2);
    }

    /**
     * @return bool
     */
    public function isSmsNotificationsSent(): bool
    {
        return $this->smsNotificationsSent;
    }

    /**
     * @return bool
     */
    public function isEmailNotificationSent(): bool
    {
        return $this->emailNotificationSent;
    }

    /**
     * @param LoadResultValueObject $base
     * @param LoadResultValueObject $competition
     */
    public function sendSmsNotification(LoadResultValueObject $base, LoadResultValueObject $competition): void
    {
        $smsNotification = $this->notificationFactory->getSmsNotification();
        $smsNotification->notify($base, $competition);
    }
    /**
     * @param LoadResultValueObject $base
     * @param LoadResultValueObject $competition
     */
    public function sendEmailNotification(LoadResultValueObject $base, LoadResultValueObject $competition): void
    {
        $emailNotification = $this->notificationFactory->getEmailNotification();
        $emailNotification->notify($base, $competition);
    }
}