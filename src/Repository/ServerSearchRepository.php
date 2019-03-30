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
        $notEmpty = function(){ 
             $properties = func_get_args();
             foreach ($properties as $property) {
                 if (!empty($property)) { return true; }
             }
        };
        $getRange = function($field, $min, $max) {
             return new Range($field, array ('gte' => $min, 'lte' => $max));
        };
        $getMatch = function($field, $value) {
             $query = new Match();
             $query->setFieldQuery($field, $value);
             return $query;
        };
        $getQueryString = function(array $fields, $value) {
            $query = new QueryString();
            $query->setQuery("*".$value."*");
            $query->setFields($fields);
            return $query;
        };
        
        $bool = new BoolQuery();
        $notEmpty($search->getMemMin(), $search->getMemMax()) ? $bool->addMust($getRange('mem', $search->getMemMin(), $search->getMemMax())) : null;
        $notEmpty($search->getCpuMin(), $search->getCpuMax()) ? $bool->addMust($getRange('cpu', $search->getCpuMin(), $search->getCpuMax())) : null;
        $notEmpty($search->getHddMin(), $search->getHddMax()) ? $bool->addMust($getRange('hdd', $search->getHddMin(), $search->getHddMax())) : null;

        $notEmpty($search->getOsId()) ? $bool->addMust($getMatch('os_id.id', $search->getOsId()->getId())) : null;
        $notEmpty($search->getClusterId()) ? $bool->addMust($getMatch('cluster_id.id', $search->getClusterId()->getId())) : null;
        $notEmpty($search->getIsVm()) ? $bool->addMust($getMatch('is_vm', $search->getIsVm())) : null;
        $notEmpty($search->getOnOff()) ? $bool->addMust($getMatch('state_on_off', $search->getOnOff())) : null;

        $notEmpty($search->getName()) ? $bool->addMust($getQueryString(array('name', 'memo'), $search->getName())) : null;
        $notEmpty($search->getIpAddr()) ? $bool->addMust($getQueryString(array('ipaddr'), $search->getIpAddr())) : null;

        return $bool;
    }
}
