<?php

namespace App\Repository;

use App\Entity\Payment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Payment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Payment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Payment[]    findAll()
 * @method Payment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class PaymentRepository extends ServiceEntityRepository implements PaymentRepositoryService
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Payment::class);
    }

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
    ) {
        $qb = $this->createQueryBuilder('p')
            ->andWhere('p.createdAt > :start')
            ->andWhere('p.createdAt < :end')
            ->setParameter('start', $startsOn)
            ->setParameter('end', $endsOn);

        if (!is_null($orderBy)) {
            foreach ($orderBy as $field => $order) {
                $qb->addOrderBy($field, $order);
            }
        }

        return $qb
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Payment
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
