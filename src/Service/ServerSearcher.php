<?php

namespace App\Service;

use App\Entity\SearchServer;
use Doctrine\ORM\EntityManagerInterface;

class ServerSearcher
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var ServerRetrieverInterface
     */
    private $retriever;

    /**
     * ServerSearcher constructor.
     * @param EntityManagerInterface $em
     * @param ServerRetrieverInterface $retriever
     */
    public function __construct(EntityManagerInterface $em, ServerRetrieverInterface $retriever)
    {
        $this->em = $em;
        $this->retriever = $retriever;
    }

    /**
     * @param SearchServer $request
     * @return bool
     * @throws
     */
    public function search(SearchServer $request)
    {
        try {
            $this->em->persist($request);
            $this->em->flush();
            $results = $this->retriever->getByRequest($request);
            array_map([$this->em, 'persist'], $results);
            $request->setStatus(SearchServer::STATUS_COMPLETE);
            $this->em->flush();
        } catch (\Exception $exception) {
            $request->setStatus(SearchServer::STATUS_ERROR);
            $this->em->flush();
            throw $exception;
        }
        return $request->getStatus() == SearchServer::STATUS_COMPLETE;
    }
}