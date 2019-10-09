<?php

namespace App\Repository;

use App\Entity\EntityTransfert;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EntityTransfert|null find($id, $lockMode = null, $lockVersion = null)
 * @method EntityTransfert|null findOneBy(array $criteria, array $orderBy = null)
 * @method EntityTransfert[]    findAll()
 * @method EntityTransfert[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntityTransfertRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EntityTransfert::class);
    }

    // /**
    //  * @return EntityTransfert[] Returns an array of EntityTransfert objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EntityTransfert
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
