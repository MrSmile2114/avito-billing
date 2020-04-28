<?php

namespace App\Service\EntityServices;

use App\Entity\Payment;

interface PaymentServiceInterface
{
    const ALLOWED_OPTIONAL_RESP_FIELDS = ['notification', 'createdAt'];
    const DEFAULT_RESP_FIELDS = ['purpose', 'amount', 'orderId', 'status'];
    const DEFAULT_ORDER = '-id';
    const ORDERLY_FIELDS = ['purpose', 'amount', 'orderId', 'createdAt'];

    public function getPaymentData(string $orderId, string $optionalFields): ?array;

    public function getPaymentsCount(array $criteria = null): int;

    public function getPaymentsPageData(
        int $page,
        int $resOnPage = null,
        string $optionalFields = '',
        string $orderBy = self::DEFAULT_ORDER
    ): array;

    public function getPaymentBySessionId(string $sessionId): ?Payment;

    public function getPaymentByOrderId(string $orderId): ?Payment;

    public function sendNotification(Payment $payment, string $fields = null);

    public function getPaymentsDataFromDatetime(
        \DateTimeInterface $startsOn,
        \DateTimeInterface $endsOn,
        string $optFields = ''
    ): array;

    public function createPaymentSession(Payment $payment): ?string;
}
