<?php

namespace App\Repository;

use App\Entity\Server;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Server|null find($id, $lockMode = null, $lockVersion = null)
 * @method Server|null findOneBy(array $criteria, array $orderBy = null)
 * @method Server[]    findAll()
 * @method Server[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Server::class);
    }



    // /**
    //  * @return Server[] Returns an array of Server objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Server
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findCountFields($field, $value): ?string
    {
        //находит количество записей в таблице, где поле $field = $value
        return $this->createQueryBuilder('u')
                     ->select('count(u.id)')
                     ->andWhere("u.$field = $value")
//                     ->setParameter('val', $value)
//                     ->setParameter('field', $field)
                     ->getQuery()
                     ->getSingleScalarResult();

    }

    public function findCount(): ?int
    {
        //находит количество записей в таблице
        return $this->createQueryBuilder('u')
                     ->select('count(u.id)')
                     ->getQuery()
                     ->getSingleScalarResult();
        //return $stmt->fetch();
    }

    public function findDistinctValuesInField($field): ?array
    {
        //находит уникальные значения поля $field
        return $this->createQueryBuilder('u')
                     ->select("Distinct (u.$field)")
                     ->getQuery()
                     ->getResult()
                     ;
    }

}
