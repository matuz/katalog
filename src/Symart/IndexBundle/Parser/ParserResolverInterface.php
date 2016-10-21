<?php

namespace Symart\IndexBundle\Parser;

use Symart\IndexBundle\DTO\Page;

interface ParserResolverInterface
{
    /**
     * @param Page $page
     *
     * @return ParserInterface
     */
    public function getParser(Page $page) : ParserInterface;
}
