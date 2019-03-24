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
    public function searchServer(Server $search)
    {

/*
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
    $bool = new BoolQuery();

      $query = new Query();
    
    if ($search->getMem() != null && $search->getMem() != 0) {
        $memQuery = new \Elastica\Query\Range('mem', array('gt' => 0, 'lte' => $search->getMem()));
        $bool->addMust($memQuery);
        //$result= $this->finder->find($boolQuery));
    }

    if ($search->getName() != null  && $search->getName() != '') {
        $query = new \Elastica\Query\QueryString();
        $str = "*".$search->getName()."*";
        $query->setQuery($str);
        $query->setFields(array('name', 'memo'));
        
        $bool->addMust($query);
        
        //$query->setFieldQuery('name', $str);
        //$query->setField('name'  , array('query' => $str));//$search->getName()));
    } else {
        $query = new \Elastica\Query\MatchAll();
    }
    
    if ($search->getOsId() != null  && $search->getOsId() != '') {
        
        $osIdQuery = new Match();
        $osIdQuery->setFieldQuery('os_id.id', $search->getOsId()->getId());
        
//        $osQuery = new Match ();
//        $osQuery->setPath('os_id.id');
//        $osQuery->setQuery($osIdQuery);
        $bool->addMust($osIdQuery);

    }

    
//    die(print_r(json_encode($bool->toArray())));
    return $this->find($bool, 3000);
    }
}
