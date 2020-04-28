<?php


namespace App\Service\EntityServices;


use App\Entity\Payment;
use App\Repository\PaymentRepositoryService;
use App\Service\PaymentSessionServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class PaymentEntityService extends AbstractEntityService implements PaymentServiceInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var PaymentSessionServiceInterface
     */
    private $paymentSessionService;

    /**
     * @var PaymentRepositoryService
     */
    protected $objectRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        LoggerInterface $logger,
        PaymentRepositoryService $repositoryService,
        PaymentSessionServiceInterface $paymentSessionService
    ) {
        $this->paymentSessionService = $paymentSessionService;
        $this->logger = $logger;
        parent::__construct($entityManager, $repositoryService, $serializer);
    }

    public function getPaymentData(string $orderId, string $optionalFields): ?array
    {
        $payment = $this->objectRepository->findOneBy(['orderId' => $orderId]);

        return (is_null($payment))
            ? null
            : $this->normalizeEntity(
                $payment,
                $optionalFields,
                self::ALLOWED_OPTIONAL_RESP_FIELDS,
                self::DEFAULT_RESP_FIELDS
            );
    }

    public function getPaymentsPageData(
        int $page,
        int $resOnPage = null,
        string $optionalFields = '',
        string $orderBy = self::DEFAULT_ORDER
    ): array {
        return $this->getEntitiesPageData(
            $page,
            $resOnPage,
            $optionalFields,
            self::ALLOWED_OPTIONAL_RESP_FIELDS,
            self::DEFAULT_RESP_FIELDS,
            $orderBy,
            self::ORDERLY_FIELDS
        );
    }

    public function getPaymentsDataFromDatetime(
        \DateTimeInterface $startsOn,
        \DateTimeInterface $endsOn,
        string $optFields = ''
    ): array {
        $itemsData = [];
        $payments = $this->objectRepository->findByPeriod($startsOn, $endsOn);

        foreach ($payments as $payment) {
            $itemsData[] = $this->normalizeEntity(
                $payment,
                $optFields,
                self::ALLOWED_OPTIONAL_RESP_FIELDS,
                self::DEFAULT_RESP_FIELDS
            );
        }

        return $itemsData;
    }

    public function getPaymentsCount(array $criteria = null): int
    {
        return $this->count($criteria);
    }

    public function getPaymentByOrderId(string $orderId): ?Payment
    {
        return $this->objectRepository->findOneBy(['orderId' => $orderId]);
    }

    public function sendNotification(Payment $payment, string $fields = null)
    {
        $fields = $fields ?? '';
        if (!is_null($payment->getNotification())) {
            $client = HttpClient::create();
            $data = $this->normalizeEntity(
                $payment,
                $fields,
                self::ALLOWED_OPTIONAL_RESP_FIELDS,
                self::DEFAULT_RESP_FIELDS
            );
            try {
                //Responses are always asynchronous, so that the call to the method returns immediately
                // instead of waiting to receive the response
                $client->request('GET', $payment->getNotification(), ['query' => $data]);
            } catch (TransportExceptionInterface $e) {
                $this->logger->warning('Error sending notification: '.$e->getMessage());
            }
        }
    }

    public function createPaymentSession(Payment $payment): ?string
    {
        return $this->paymentSessionService->createPaymentSession($payment->getId());
    }

    public function getPaymentBySessionId(string $sessionId): ?Payment
    {
        $paymentId = $this->paymentSessionService->getPaymentId($sessionId);

        return (is_null($paymentId)) ? null : $this->objectRepository->find($paymentId);
    }
}