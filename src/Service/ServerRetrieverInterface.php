<?php

namespace App\Service;

use App\Entity\SearchServer;

interface ServerRetrieverInterface
{
    /**
     * @param SearchServer $request
     * @return mixed
     */
    public function getByRequest(SearchServer $request);
}