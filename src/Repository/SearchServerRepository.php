<?php

namespace App\Repository;

use App\Entity\SearchServer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/*use FOS\ElasticaBundle\Repository;
use Elastica\Query\BoolQuery;
use Elastica\Query\Match;
use Elastica\Query\QueryString;
use Elastica\Query\Range;
use Elastica\Query\Nested;

use Elastica\Query\Terms;
use Elastica\Query;
*/

/**
 * @method SearchServer|null find($id, $lockMode = null, $lockVersion = null)
 * @method SearchServer|null findOneBy(array $criteria, array $orderBy = null)
 * @method SearchServer[]    findAll()
 * @method SearchServer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class SearchServerRepository extends ServiceEntityRepository

{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SearchServer::class);
    }

/*    
    public function searchServer(SearchServer $search)
    {

        $bool = new BoolQuery();
    
        if ($search->getMemMin() != null || $search->getMemMax() != null) {
            $memQuery = new Range('mem', array('gte' => $search->getMemMin(), 'lte' => $search->getMemMax()));
            $bool->addMust($memQuery);
        }

        if ($search->getCpuMin() != null || $search->getCpuMax() != null) {
            $cpuQuery = new Range('cpu', array('gte' => $search->getCpuMin(), 'lte' => $search->getCpuMax()));
            $bool->addMust($cpuQuery);
        }

        if ($search->getName() != null  && $search->getName() != '') {
            $nameQuery = new QueryString();
            $str = "*".$search->getName()."*";
            $nameQuery->setQuery($str);
            $nameQuery->setFields(array('name', 'memo'));
            
            $bool->addMust($nameQuery);
        
        } else {
            $query = new \Elastica\Query\MatchAll();
        }
    
        if ($search->getOsId() != null  && $search->getOsId() != '') {
            $osIdQuery = new Match();
            $osIdQuery->setFieldQuery('os_id.id', $search->getOsId()->getId());
            $bool->addMust($osIdQuery);
        }

        if ($search->getClusterId() != null  && $search->getClusterId() != '') {
            $clusterIdQuery = new Match();
            $clusterIdQuery->setFieldQuery('cluster_id.id', $search->getClusterId()->getId());
            $bool->addMust($clusterIdQuery);
        }

    
//    die(print_r(json_encode($bool->toArray())));
    return $this->find($bool, 3000);
    }
*/


    // /**
    //  * @return SearchServer[] Returns an array of SearchServer objects
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
    public function findOneBySomeField($value): ?SearchServer
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
