<?php

namespace Symart\IndexBundle\Parser;

use Symart\IndexBundle\DTO\Page;

class ParserResolver implements ParserResolverInterface
{
    /**
     * @var array | ParserInterface[]
     */
    private $parsers;

    public function registerParser(ParserInterface $parser)
    {
        $this->parsers[] = $parser;
    }

    /**
     * @param Page $page
     *
     * @return ParserInterface
     */
    public function getParser(Page $page)
    {
        foreach ($this->parsers as $parser) {
            if ($parser->support($page)) {
                return $parser;
            }
        }
    }
}
