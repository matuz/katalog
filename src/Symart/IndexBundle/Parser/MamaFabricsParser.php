<?php

namespace Symart\IndexBundle\Parser;

use pQuery;
use Symart\IndexBundle\DTO\Page;
use Symart\IndexBundle\Entity\Product;

class MamaFabricsParser implements ParserInterface
{
    /**
     * {@inheritdoc}
     */
    public function parseIndexPage(Page $page) : array
    {
        $pageContent = pQuery::parseStr($page->getHtml());

        $divs = $pageContent->query('.products .product');

        $result = [];
        /** @var pQuery\DomNode $div */
        foreach ($divs as $div) {
            $result[] = (new Product())
                ->setUrl($page->getHost() . $div->query('a.prodimage')->attr('href'))
                ->setImage($page->getHost() . $div->query('img')->attr('data-src'));
        }

        return $result;
    }

    /**
     * @param Page $page
     *
     * @return bool
     */
    public function support(Page $page) : bool
    {
        return $page->getHost() === 'http://www.mamafabrics.pl';
    }
}
