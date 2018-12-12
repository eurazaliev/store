<?php

namespace App\Repository;

use App\Entity\Clustertype;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Clustertype|null find($id, $lockMode = null, $lockVersion = null)
 * @method Clustertype|null findOneBy(array $criteria, array $orderBy = null)
 * @method Clustertype[]    findAll()
 * @method Clustertype[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClustertypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Clustertype::class);
    }

    // /**
    //  * @return Clustertype[] Returns an array of Clustertype objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Clustertype
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
