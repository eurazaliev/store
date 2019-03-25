<?php

namespace App\Repository;

use App\Entity\Server;

use FOS\ElasticaBundle\Repository;
use Elastica\Query\BoolQuery;
use Elastica\Query\Match;
use Elastica\Query\QueryString;
use Elastica\Query\Range;
use Elastica\Query\Nested;

use Elastica\Query\Terms;
use Elastica\Query;


class ServerSearchRepository extends Repository
{

    // This searchUser function will build the elasticsearch query to get a list of users that match our criterias
/*
    public function searchServer(Server $search)
    {


        $query = new BoolQuery();

        if ($search->getName() != null && $search->getName() != '') {
            $query->addMust(new Terms('name', [$search->getName()]));
        }

        if ($search->getMem() != null && $search->getMem() != '') {
            $query->addMust(new Terms('mem', [$search->getMem()]));
        }
        $query1 = Query::create($query);

        die(print_r(json_encode($query1->toArray())));

        return $this->find($query1, 3000);
     $bool = new BoolQuery();
          $text = new Match();
               $text->setField('text', $search);
                    $bool->addMust($text);
                         return $bool;

*/
    public function searchServer(\App\Entity\SearchServer $search)
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
}
