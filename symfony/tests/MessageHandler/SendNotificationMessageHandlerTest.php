<?php

namespace App\Tests\MessageHandler;

use App\Message\SendNotificationMessage;
use App\MessageHandler\SendNotificationMessageHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SendNotificationMessageHandlerTest extends TestCase
{
    /**
     * @var SendNotificationMessageHandler
     */
    private $messageHandler;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject | HttpClientInterface
     */
    private $mockClient;


    protected function setUp()
    {
        $this->mockClient = $this->getMockBuilder(HttpClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->messageHandler = new SendNotificationMessageHandler($this->mockClient);
        parent::setUp();
    }

    public function testSendNotification()
    {
        $url = "http://example.com";
        $data = ['purpose' => 'TEST TEST', 'amount' => 1235.5, 'orderId' => 'TestId'];
        $sendData = ['body' => $data];
        $message = new SendNotificationMessage($url, $data);
        $handler = $this->messageHandler;
        $this->mockClient->expects($this->once())
            ->method('request')
            ->with("POST", $url, $sendData);
        $handler($message);
    }

}
