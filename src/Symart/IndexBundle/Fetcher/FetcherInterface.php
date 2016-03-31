<?php

namespace Symart\IndexBundle\Fetcher;

use Symart\IndexBundle\DTO\Page;

interface FetcherInterface
{
    /**
     * @param array|string[] $pageList
     *
     * @return array|Page[]
     */
    public function fetchPages(array $pageList = array());
}
