<?php

namespace App\Message;

/**
 * Class SendNotificationMessage
 * @package App\Message
 */
final class SendNotificationMessage
{
    /**
     * URL to which the notification should be sent
     * @var string
     */
    private $url;

    /**
     * Payment data to send
     * @var array
     */
    private $data;

    public function __construct(string $url, array $data)
    {
        $this->url = $url;
        $this->data = $data;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
