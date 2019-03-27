<?php

namespace App\Service;

use App\Entity\SearchServer;
use App\Entity\Server;

use Doctrine\ORM\EntityManagerInterface;
use FOS\ElasticaBundle\Doctrine\RepositoryManager;

class ServerRetriever implements ServerRetrieverInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var RepositoryManager
     */
    private $elasticaManager;

    /**
     * ServerRetriever constructor.
     * @param EntityManagerInterface $em
     * @param RepositoryManager $elasticaManager
     */
    public function __construct(EntityManagerInterface $em, RepositoryManager $elasticaManager)
    {
        $this->em = $em;
        $this->elasticaManager = $elasticaManager;
    }

    /**
     * @param SearchServer $request
     * @return SearchResult[]|array|mixed
     */
    public function getByRequest(SearchServer $request)
    {
        $SearchResult = $this->elasticaManager->getRepository(Server::class)->searchServer($request);
        return $SearchResult;
    }

}