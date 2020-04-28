<?php


namespace App\Repository;


use App\Entity\Payment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * @method Payment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Payment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Payment[]    findAll()
 * @method Payment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface PaymentRepositoryService extends ObjectRepository
{
    /**
     * @param \DateTimeInterface $startsOn
     * @param \DateTimeInterface $endsOn
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     * @return Payment[] Returns an array of Payment objects
     */
    public function findByPeriod(
        \DateTimeInterface $startsOn,
        \DateTimeInterface $endsOn,
        array $orderBy = null,
        $limit = null,
        $offset = null
    );

}