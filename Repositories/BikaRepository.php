<?php

namespace Ignite\Evaluation\Repositories;

interface BikaRepository
{
    /**
     * Proxy the JSON Api to fetch attunuative data
     * @param $url
     * @return mixed
     */
    public function execute($url);
}
