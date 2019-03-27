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

    // This searchUser function will execute the elasticsearch query to get a list of users that match our criterias
    public function searchServer(\App\Entity\SearchServer $searchServer, string $sortField = null, string $sortOrder = null)
    {
        $boolQuery = $this->prepareQuery($searchServer);
        $query = new Query($boolQuery);
        //если ничего не пришло - сортируем по id 
        $sortField = null ?: 'id';
        $sortOrder = null ?: 'asc';
        //die ($sortOrder);
        $query->setSort(array([
             $sortField => ['order' => $sortOrder]
        ]));
        return $this->find($query, 300);
    }

    private function prepareQuery (\App\Entity\SearchServer $search)
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

        if ($search->getHddMin() != null || $search->getHddMax() != null) {
            $hddQuery = new Range('hdd', array('gte' => $search->getHddMin(), 'lte' => $search->getHddMax()));
            $bool->addMust($hddQuery);
        }

        if ($search->getName() != null  && $search->getName() != '') {
            $nameQuery = new QueryString();
            $str = "*".$search->getName()."*";
            $nameQuery->setQuery($str);
            $nameQuery->setFields(array('name', 'memo'));
            $bool->addMust($nameQuery);
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

        if ($search->getIsVm() != null  && $search->getIsVm() != '') {
            $IsVmQuery = new Match();
            $IsVmQuery->setFieldQuery('is_vm', $search->getIsVm());
            $bool->addMust($IsVmQuery);
        }

        if ($search->getOnOff() != null  && $search->getOnOff() != '') {
            $stateOnOffQuery = new Match();
            $stateOnOffQuery->setFieldQuery('state_on_off', $search->getOnOff());
            $bool->addMust($stateOnOffQuery);
        }
        if ($search->getIpAddr() != null  && $search->getIpAddr() != '') {
            $IpQuery = new QueryString();
            $str = "*".$search->getIpAddr()."*";
            $IpQuery->setQuery($str);
            $IpQuery->setFields(array('ipaddr'));
            $bool->addMust($IpQuery);
        }
        return $bool;
    }
}
