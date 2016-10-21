<?php

namespace Symart\IndexBundle\Parser;

use Symart\IndexBundle\DTO\Page;
use Symart\IndexBundle\Exception\MissingParserException;

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
     *
     * @throws MissingParserException
     */
    public function getParser(Page $page) : ParserInterface
    {
        foreach ($this->parsers as $parser) {
            if ($parser->support($page)) {
                return $parser;
            }
        }

        throw new MissingParserException(sprintf('There is no parser for page: %s', $page->getHost()));
    }
}
