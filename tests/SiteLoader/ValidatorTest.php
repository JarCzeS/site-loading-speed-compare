<?php
/**
 * Created by PhpStorm.
 * User: jaroslawjarczewski
 * Date: 05/11/2018
 * Time: 23:24
 */

namespace App\Tests\SiteLoader;


use App\SiteLoader\Validator;
use App\SiteLoader\ValueObjects\LoadResultValueObject;
use App\SiteLoader\ValueObjects\ResultsValueObject;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    /**
     * @var ResultsValueObject
     */
    private $result;
    /**
     * @var Validator
     */
    private $validator;
    /**
     * @var ResultsValueObject
     */
    private $resultNoNotify;

    public function setUp()
    {
        $this->validator = $this->getMockBuilder(Validator::class)
            ->setMethods(array('sendSmsNotification','sendEmailNotification'))
            ->getMock();

        $this->validator->method('sendSmsNotification')->willReturn(true);
        $this->validator->method('sendEmailNotification')->willReturn(true);

        $this->result = new ResultsValueObject();
        $this->result->setBase(new LoadResultValueObject('http://wp.pl',1000.45,1004.45,2.3));
        $this->result->addCompetition(new LoadResultValueObject('http://onet.pl',1000.45,1004.45,2.53));
        $this->result->addCompetition(new LoadResultValueObject('http://interia.pl',1000.45,1004.45,0.555));

        $this->resultNoNotify = new ResultsValueObject();
        $this->resultNoNotify->setBase(new LoadResultValueObject('http://wp.pl',1000.45,1004.45,1));
        $this->resultNoNotify->addCompetition(new LoadResultValueObject('http://onet.pl',1000.45,1004.45,1.2));
        $this->resultNoNotify->addCompetition(new LoadResultValueObject('http://interia.pl',1000.45,1004.45,3));
        parent::setUp();
    }

    public function testSendNotification() {
        $this->validator->validLoadingTimes($this->result);

        $this->assertSame(true, $this->validator->isEmailNotificationSent());
        $this->assertSame(true, $this->validator->isSmsNotificationsSent());
    }

    public function testSendNotificationNoNotify() {
        $this->validator->validLoadingTimes($this->resultNoNotify);

        $this->assertSame(false, $this->validator->isEmailNotificationSent());
        $this->assertSame(false, $this->validator->isSmsNotificationsSent());
    }
}