<?php

namespace Symart\IndexBundle\Parser;

use Symart\IndexBundle\DTO\Page;
use Symart\IndexBundle\Entity\Product;

interface ParserInterface
{
    /**
     * @param Page $page
     * 
     * @return array|Product[]
     */
    public function parseIndexPage(Page $page);

    /**
     * @param Page $page
     *
     * @return bool
     */
    public function support(Page $page);
}
