<?php

namespace App\MessageHandler;

use App\Message\SendNotificationMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Successful payment notification message handler
 *
 * @package App\MessageHandler
 */
final class SendNotificationMessageHandler implements MessageHandlerInterface
{
    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function __invoke(SendNotificationMessage $message)
    {
        $this->httpClient->request('POST', $message->getUrl(), ['body' => $message->getData()]);
    }

}
